<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\StorePermutaRequest;
use App\Http\Requests\UpdatePermutaRequest;
use App\Models\Permuta;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class PermutaController extends Controller
{
    /**
     * Default password for contacts registered from a free-form person.
     */
    private const CONTATO_SENHA_PADRAO = 'Clubset123';

    /**
     * List the current user's permutas with a financial summary.
     */
    public function index(Request $request): Response
    {
        $user = $request->user();

        $permutas = Permuta::query()
            ->with(['user', 'contato'])
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhere('contato_id', $user->id);
            })
            ->orderByDesc('data')
            ->orderByDesc('created_at')
            ->get()
            ->map(fn (Permuta $permuta) => $this->serialize($permuta, $user));

        return Inertia::render('permutas/index', [
            'permutas' => $permutas,
            'summary' => $this->summary($user),
        ]);
    }

    /**
     * Show the form for creating a new permuta.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('permutas/form', [
            'permuta' => null,
            'usuarios' => $this->pickerUsers($request),
        ]);
    }

    /**
     * Store a newly created permuta.
     */
    public function store(StorePermutaRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->filled('contato_id')) {
            $data['contato_nome'] = User::find($data['contato_id'])?->name;
        } else {
            $data = $this->resolveContato($request, $data);
        }

        $permuta = $request->user()->permutas()->create($data);

        return $this->redirectTo('permutas.index', 'Permuta lançada com sucesso.');
    }

    /**
     * When the linked party is a free-form person, register them as a new
     * user (client) so the permuta shows in their own panel as an expense.
     *
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function resolveContato(Request $request, array $data): array
    {
        $email = $request->input('contato_email');

        if (! $email) {
            return $data;
        }

        $contato = User::query()->where('email', $email)->first();

        if (! $contato) {
            $contato = DB::transaction(function () use ($email, $data) {
                $user = User::create([
                    'name' => $data['contato_nome'],
                    'email' => $email,
                    'password' => self::CONTATO_SENHA_PADRAO,
                    'must_change_password' => true,
                ]);

                $user->assignRole(UserRole::Cliente);

                return $user;
            });
        }

        $data['contato_id'] = $contato->id;
        $data['contato_nome'] = $contato->name;

        return $data;
    }

    /**
     * Show the form for editing the specified permuta.
     */
    public function edit(Permuta $permuta): Response
    {
        Gate::authorize('update', $permuta);

        return Inertia::render('permutas/form', [
            'permuta' => $this->serialize($permuta, $permuta->user),
            'usuarios' => $this->pickerUsers(request()),
        ]);
    }

    /**
     * Update the specified permuta.
     */
    public function update(UpdatePermutaRequest $request, Permuta $permuta): RedirectResponse
    {
        Gate::authorize('update', $permuta);

        $data = $request->validated();

        if ($request->filled('contato_id')) {
            $data['contato_nome'] = User::find($data['contato_id'])?->name;
        }

        $permuta->update($data);

        return $this->redirectTo('permutas.index', 'Permuta atualizada com sucesso.');
    }

    /**
     * Remove the specified permuta.
     */
    public function destroy(Permuta $permuta): RedirectResponse
    {
        Gate::authorize('delete', $permuta);

        $permuta->delete();

        return $this->redirectTo('permutas.index', 'Permuta excluída.');
    }

    /**
     * Public link so a non-registered person can view a permuta.
     */
    public function share(string $uuid): Response
    {
        $permuta = Permuta::with(['user'])->where('uuid', $uuid)->firstOrFail();

        return Inertia::render('permutas/share', [
            'permuta' => $this->serialize($permuta, $permuta->user),
        ]);
    }

    /**
     * Compute the current user's profit, expense and total.
     *
     * @return array{ganhos: float, despesas: float, total: float}
     */
    private function summary(User $user): array
    {
        $canonicalStatuses = ['concluida', 'pendente'];

        $ganhos = (float) Permuta::query()
            ->where('user_id', $user->id)
            ->whereIn('status', $canonicalStatuses)
            ->sum('valor');

        $despesas = (float) Permuta::query()
            ->where('contato_id', $user->id)
            ->whereIn('status', $canonicalStatuses)
            ->sum('valor');

        return [
            'ganhos' => $ganhos,
            'despesas' => $despesas,
            'total' => $ganhos - $despesas,
        ];
    }

    /**
     * Users available to link as the permuta contact.
     *
     * @return array<int, array{id: int, name: string}>
     */
    private function pickerUsers(Request $request): array
    {
        return User::query()
            ->where('id', '!=', $request->user()->id)
            ->orderBy('name')
            ->get(['id', 'name'])
            ->map(fn (User $user) => ['id' => $user->id, 'name' => $user->name])
            ->values()
            ->all();
    }

    /**
     * Serialize a permuta for the frontend.
     *
     * @return array<string, mixed>
     */
    private function serialize(Permuta $permuta, User $viewer): array
    {
        return [
            'id' => $permuta->id,
            'uuid' => $permuta->uuid,
            'titulo' => $permuta->titulo,
            'descricao' => $permuta->descricao,
            'valor' => (float) $permuta->valor,
            'formattedValor' => $permuta->formatted_valor,
            'data' => $permuta->data?->format('d/m/Y'),
            'status' => $permuta->status->value,
            'statusLabel' => $permuta->status->label(),
            'isCreator' => $permuta->ownedBy($viewer),
            'contato' => [
                'id' => $permuta->contato_id,
                'nome' => $permuta->contato_nome ?? $permuta->contato?->name ?? 'Pessoa avulsa',
                'ehUsuario' => $permuta->contato_id !== null,
            ],
            'shareUrl' => route('permutas.share', $permuta->uuid),
        ];
    }

    /**
     * Redirect with a status message.
     */
    private function redirectTo(string $route, string $message): RedirectResponse
    {
        Inertia::flash('toast', ['type' => 'success', 'message' => $message]);

        return to_route($route);
    }
}
