<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ListingStatus;
use App\Enums\MatchStatus;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\CreditTransaction;
use App\Models\DiagnosticoResposta;
use App\Models\Dispute;
use App\Models\Listing;
use App\Models\TradeMatch;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminController extends Controller
{
    /**
     * Show the administrator dashboard with platform metrics.
     */
    public function index(): Response
    {
        return Inertia::render('admin/index', [
            'metrics' => [
                'users' => [
                    'total' => User::query()->count(),
                    'videomakers' => User::query()->whereHas('roles', fn ($query) => $query->where('slug', 'videomaker'))->count(),
                    'clients' => User::query()->whereHas('roles', fn ($query) => $query->where('slug', 'cliente'))->count(),
                    'companies' => User::query()->whereHas('roles', fn ($query) => $query->where('slug', 'empresa'))->count(),
                    'unverified' => User::query()->whereNull('admin_verified_at')->count(),
                ],
                'listings' => [
                    'total' => Listing::query()->count(),
                    'pending' => Listing::query()->where('status', ListingStatus::Pending->value)->count(),
                    'active' => Listing::query()->where('status', ListingStatus::Active->value)->count(),
                ],
                'matches' => [
                    'total' => TradeMatch::query()->count(),
                    'pending' => TradeMatch::query()->where('status', MatchStatus::Pending->value)->count(),
                    'completed' => TradeMatch::query()->where('status', MatchStatus::Completed->value)->count(),
                ],
                'disputes' => [
                    'open' => Dispute::query()->where('status', 'open')->count(),
                ],
                'credits' => [
                    'in_circulation' => (float) CreditTransaction::query()
                        ->where('type', 'credit')
                        ->sum('amount'),
                ],
            ],
            'pendingListings' => Listing::query()
                ->pending()
                ->with(['owner', 'state'])
                ->latest()
                ->limit(5)
                ->get()
                ->map(fn (Listing $listing) => [
                    'id' => $listing->id,
                    'title' => $listing->title,
                    'region' => $listing->region,
                    'ownerName' => $listing->owner->name,
                    'createdAt' => $listing->created_at?->diffForHumans(),
                ]),
            'openDisputes' => Dispute::query()
                ->where('status', 'open')
                ->with('match')
                ->latest()
                ->limit(5)
                ->get()
                ->map(fn (Dispute $dispute) => [
                    'id' => $dispute->id,
                    'reason' => $dispute->reason->label(),
                    'createdAt' => $dispute->created_at?->diffForHumans(),
                ]),
        ]);
    }

    /**
     * List user registrations with filters (name, city and role).
     */
    public function registrations(Request $request): Response
    {
        return Inertia::render('admin/registrations', [
            'users' => User::query()
                ->with(['state', 'municipality', 'roles'])
                ->when(
                    $request->filled('nome'),
                    fn ($query) => $query->where('name', 'like', '%'.$request->string('nome').'%')
                )
                ->when(
                    $request->filled('cidade'),
                    fn ($query) => $query->whereHas('municipality', fn ($municipality) => $municipality->where('name', 'like', '%'.$request->string('cidade').'%'))
                )
                ->when(
                    $request->filled('role'),
                    fn ($query) => $query->whereHas('roles', fn (Builder $roles) => $roles->where('slug', $request->string('role')))
                )
                ->when(
                    $request->boolean('pending'),
                    fn ($query) => $query->whereNull('admin_verified_at')
                )
                ->latest('id')
                ->get()
                ->map(fn (User $user) => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'region' => $user->region,
                    'city' => $user->city,
                    'role' => $user->roles->first()?->slug,
                    'verifiedAt' => $user->admin_verified_at?->toIso8601String(),
                    'createdAt' => $user->created_at?->diffForHumans(),
                ]),
            'roles' => collect(UserRole::assignable())
                ->map(fn (UserRole $role) => ['value' => $role->value, 'label' => $role->label()])
                ->values(),
            'filters' => [
                'nome' => $request->string('nome')->toString(),
                'cidade' => $request->string('cidade')->toString(),
                'role' => $request->string('role')->toString(),
                'pending' => $request->boolean('pending'),
            ],
        ]);
    }

    /**
     * Mark a user registration as validated.
     */
    public function verify(User $user): RedirectResponse
    {
        $user->forceFill(['admin_verified_at' => now()])->save();

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => "Cadastro de {$user->name} validado.",
        ]);

        return back();
    }

    /**
     * Revert a user registration to pending (deactivate) so it can be
     * reactivated later with the verify action.
     */
    public function deactivate(User $user): RedirectResponse
    {
        $user->forceFill(['admin_verified_at' => null])->save();

        Inertia::flash('toast', [
            'type' => 'warning',
            'message' => "Cadastro de {$user->name} desativado.",
        ]);

        return back();
    }

    /**
     * Permanently remove a user and all their cascaded content.
     */
    public function destroy(User $user): RedirectResponse
    {
        $name = $user->name;

        $user->delete();

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => "Cadastro de {$name} excluído.",
        ]);

        return back();
    }

    /**
     * List all business diagnostics with their contact data and overall score.
     */
    public function diagnosticos(): Response
    {
        return Inertia::render('admin/diagnosticos', [
            'diagnosticos' => DiagnosticoResposta::query()
                ->with(['state', 'municipality'])
                ->latest()
                ->get()
                ->map(fn (DiagnosticoResposta $registro) => [
                    'uuid' => $registro->uuid,
                    'nome' => $registro->nome,
                    'instagram' => $registro->instagram,
                    'celular' => $registro->celular,
                    'estado' => $registro->state->uf ?? null,
                    'municipio' => $registro->municipality->name ?? null,
                    'participaGrupo' => $registro->participa_grupo_whatsapp,
                    'grupoQual' => $registro->grupo_whatsapp_qual,
                    'renda' => $registro->renda,
                    'geral' => $registro->resultado['geral'] ?? null,
                    'faixaGeral' => $registro->resultado['faixa_geral'] ?? null,
                    'faixaGeralLabel' => $registro->resultado['faixa_geral_label'] ?? null,
                    'resultadoLiberado' => $registro->resultado_liberado_em !== null,
                    'criadoEm' => $registro->created_at?->diffForHumans(),
                ]),
        ]);
    }

    /**
     * Show a single diagnostic with its contact data, answers and result.
     */
    public function diagnosticoShow(string $uuid): Response
    {
        $registro = DiagnosticoResposta::query()
            ->with(['state', 'municipality'])
            ->where('uuid', $uuid)
            ->firstOrFail();

        $resultado = $registro->resultadoComTextos($registro->resultado);
        $resultado['criticos'] = array_slice($resultado['criticos'] ?? [], 0, 2);

        return Inertia::render('admin/diagnostico-show', [
            'diagnostico' => [
                'uuid' => $registro->uuid,
                'nome' => $registro->nome,
                'instagram' => $registro->instagram,
                'celular' => $registro->celular,
                'estado' => $registro->state,
                'municipio' => $registro->municipality,
                'participaGrupo' => $registro->participa_grupo_whatsapp,
                'grupoQual' => $registro->grupo_whatsapp_qual,
                'renda' => $registro->renda,
                'resultadoLiberado' => $registro->resultado_liberado_em !== null,
                'criadoEm' => $registro->created_at?->toIso8601String(),
            ],
            'resultado' => $resultado,
        ]);
    }

    /**
     * Release the detailed diagnostic result so the respondent can see it.
     */
    public function liberarResultado(string $uuid): RedirectResponse
    {
        $registro = DiagnosticoResposta::where('uuid', $uuid)->firstOrFail();

        $registro->forceFill(['resultado_liberado_em' => now()])->save();

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => "Resultado detalhado de {$registro->nome} liberado.",
        ]);

        return back();
    }

    /**
     * Delete a diagnostic submission.
     */
    public function destroyDiagnostico(string $uuid): RedirectResponse
    {
        $registro = DiagnosticoResposta::where('uuid', $uuid)->firstOrFail();

        $registro->delete();

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => "Diagnóstico de {$registro->nome} excluído.",
        ]);

        return to_route('admin.diagnosticos');
    }
}
