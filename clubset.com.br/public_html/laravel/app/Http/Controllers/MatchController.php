<?php

namespace App\Http\Controllers;

use App\Enums\CreditReason;
use App\Enums\MatchStatus;
use App\Enums\TradeType;
use App\Http\Requests\StoreMatchRequest;
use App\Models\CreditTransaction;
use App\Models\Listing;
use App\Models\Service;
use App\Models\State;
use App\Models\TradeMatch;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class MatchController extends Controller
{
    /**
     * List the matches involving the current user.
     */
    public function index(Request $request): Response
    {
        $user = $request->user();

        $matches = TradeMatch::query()
            ->with(['listing', 'service', 'seeker', 'provider', 'dispute'])
            ->where(function ($query) use ($user) {
                $query->where('seeker_id', $user->id)->orWhere('provider_id', $user->id);
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest()
            ->paginate(15)
            ->withQueryString()
            ->through(fn (TradeMatch $match) => $this->serialize($match, $user));

        $users = User::query()
            ->where('id', '!=', $user->id)
            ->whereNull('blocked_at')
            ->with(['state', 'municipality', 'services' => fn ($q) => $q->active()])
            ->whereHas('roles', fn ($q) => $q->where('slug', '!=', 'administrator'))
            ->orWhereDoesntHave('roles')
            ->latest()
            ->paginate(12)
            ->withQueryString()
            ->through(fn (User $u) => [
                'id' => $u->id,
                'name' => $u->name,
                'region' => $u->state?->uf,
                'city' => $u->municipality?->name,
                'services' => $u->services->map(fn ($s) => [
                    'id' => $s->id,
                    'title' => $s->title,
                    'specialty' => $s->specialty,
                    'rate' => $s->formatted_rate,
                ]),
            ]);

        return Inertia::render('matches/index', [
            'matches' => $matches,
            'users' => $users,
            'filters' => $request->only(['status']),
            'states' => State::query()->orderBy('name')->get(['id', 'name', 'uf']),
        ]);
    }

    /**
     * Express interest in a listing or service, creating a match.
     */
    public function store(StoreMatchRequest $request): RedirectResponse
    {
        $user = $request->user();

        $target = $request->filled('listing_id')
            ? Listing::query()->findOrFail($request->integer('listing_id'))
            : Service::query()->findOrFail($request->integer('service_id'));

        if ($target->user_id === $user->id) {
            return back()->withErrors(['message' => 'Você não pode criar um match com o próprio anúncio.']);
        }

        if (! $this->targetIsAvailable($target)) {
            return back()->withErrors(['message' => 'Este anúncio/serviço não está disponível para match.']);
        }

        $column = $request->filled('listing_id') ? 'listing_id' : 'service_id';
        $exists = $target->matches()
            ->where('seeker_id', $user->id)
            ->whereNotIn('status', [MatchStatus::Declined->value, MatchStatus::Cancelled->value])
            ->exists();

        if ($exists) {
            return back()->withErrors(['message' => 'Você já tem um match ativo para este anúncio.']);
        }

        TradeMatch::query()->create([
            ...$request->validated(),
            'seeker_id' => $user->id,
            'provider_id' => $target->user_id,
            'status' => MatchStatus::Pending,
        ]);

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Interesse enviado! O anúncio foi notificado sobre o seu match.',
        ]);

        return to_route('matches.index');
    }

    /**
     * Transition a match: accept, decline, cancel or complete.
     */
    public function update(Request $request, TradeMatch $match): RedirectResponse
    {
        $user = $request->user();

        abort_unless($match->involvesUser($user->id), 403);

        $action = $request->string('action')->toString();

        abort_unless(in_array($action, ['accept', 'decline', 'cancel', 'complete'], true), 422);

        return match ($action) {
            'accept' => $this->accept($match, $user),
            'decline' => $this->decline($match, $user),
            'cancel' => $this->cancel($match, $user),
            'complete' => $this->complete($match, $user),
        };
    }

    /**
     * The provider accepts a pending match.
     */
    private function accept(TradeMatch $match, $user): RedirectResponse
    {
        abort_unless((int) $match->provider_id === (int) $user->id, 403);
        abort_unless($match->status === MatchStatus::Pending, 422);

        $match->update(['status' => MatchStatus::Accepted]);

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Match aceito.']);

        return back();
    }

    /**
     * The provider declines a pending match.
     */
    private function decline(TradeMatch $match, $user): RedirectResponse
    {
        abort_unless((int) $match->provider_id === (int) $user->id, 403);
        abort_unless($match->status === MatchStatus::Pending, 422);

        $match->update(['status' => MatchStatus::Declined]);

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Match recusado.']);

        return back();
    }

    /**
     * Either participant cancels a pending/accepted match.
     */
    private function cancel(TradeMatch $match, $user): RedirectResponse
    {
        abort_unless(in_array($match->status, [MatchStatus::Pending, MatchStatus::Accepted], true), 422);

        $match->update(['status' => MatchStatus::Cancelled]);

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Match cancelado.']);

        return back();
    }

    /**
     * The provider marks an accepted match as completed, settling credits.
     */
    private function complete(TradeMatch $match, $user): RedirectResponse
    {
        abort_unless((int) $match->provider_id === (int) $user->id, 403);
        abort_unless($match->status === MatchStatus::Accepted, 422);

        if ($match->trade_type === TradeType::Credito) {
            $seeker = $match->seeker;
            $price = (float) $match->price;

            if ($seeker->availableBalance() < $price) {
                Inertia::flash('toast', [
                    'type' => 'error',
                    'message' => 'O interessado não possui saldo suficiente em créditos.',
                ]);

                return back();
            }

            DB::transaction(function () use ($match, $seeker, $price) {
                $this->recordCredit($match->provider, $match, 'credit', $price, 'Serviço/item entregue via permuta por crédito');
                $this->recordCredit($seeker, $match, 'debit', $price, 'Pagamento em créditos da permuta');

                $match->update([
                    'status' => MatchStatus::Completed,
                    'completed_at' => now(),
                ]);
            });

            Inertia::flash('toast', [
                'type' => 'success',
                'message' => 'Match concluído. Créditos transferidos.',
            ]);
        } else {
            $match->update([
                'status' => MatchStatus::Completed,
                'completed_at' => now(),
            ]);

            Inertia::flash('toast', [
                'type' => 'success',
                'message' => 'Match concluído.',
            ]);
        }

        return back();
    }

    /**
     * Append a credit ledger entry, updating the running balance.
     */
    private function recordCredit($user, TradeMatch $match, string $type, float $amount, string $description): void
    {
        $balance = $type === 'credit' ? $user->availableBalance() + $amount : $user->availableBalance() - $amount;

        CreditTransaction::query()->create([
            'user_id' => $user->id,
            'match_id' => $match->id,
            'type' => $type,
            'amount' => $amount,
            'reason' => CreditReason::TradeCompletion,
            'description' => $description,
            'balance_after' => $balance,
        ]);
    }

    /**
     * Whether the given listing/service can receive new matches.
     */
    private function targetIsAvailable(Listing|Service $target): bool
    {
        return $target instanceof Listing
            ? $target->isOpen()
            : $target->is_active;
    }

    /**
     * Map a match to the shape consumed by the frontend.
     *
     * @return array<string, mixed>
     */
    private function serialize(TradeMatch $match, $user): array
    {
        $isProvider = (int) $match->provider_id === (int) $user->id;

        return [
            'id' => $match->id,
            'status' => $match->status->value,
            'statusLabel' => $match->status->label(),
            'tradeType' => $match->trade_type->label(),
            'price' => $match->formatted_price,
            'message' => $match->message,
            'completedAt' => $match->completed_at?->toIso8601String(),
            'createdAt' => $match->created_at?->diffForHumans(),
            'isProvider' => $isProvider,
            'counterpart' => [
                'id' => $match->counterpart($user->id)->id,
                'name' => $match->counterpart($user->id)->name,
                'region' => $match->counterpart($user->id)->region,
                'city' => $match->counterpart($user->id)->city,
            ],
            'item' => $match->listing ? [
                'kind' => 'anúncio',
                'title' => $match->listing->title,
                'url' => route('listings.show', $match->listing),
            ] : ($match->service ? [
                'kind' => 'serviço',
                'title' => $match->service->title,
                'url' => route('services.show', $match->service),
            ] : null),
            'dispute' => $match->dispute ? [
                'id' => $match->dispute->id,
                'status' => $match->dispute->status->value,
            ] : null,
        ];
    }
}
