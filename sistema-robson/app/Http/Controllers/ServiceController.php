<?php

namespace App\Http\Controllers;

use App\Enums\RateType;
use App\Http\Requests\StoreServiceRequest;
use App\Models\Service;
use App\Models\State;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    /**
     * Browse active services (freelancer search) with filters.
     */
    public function index(Request $request): Response
    {
        $user = $request->user();

        $services = Service::query()
            ->with(['user', 'state', 'municipality'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('title', 'like', '%'.$request->string('search').'%');
            })
            ->when($request->filled('specialty'), fn ($query) => $query->where('specialty', $request->string('specialty')))
            ->when($request->filled('state_id'), fn ($query) => $query->where('state_id', $request->integer('state_id')))
            ->when($request->boolean('mine'), fn ($query) => $query->where('user_id', $user->id))
            ->when(! $request->boolean('mine'), fn ($query) => $query->active())
            ->latest()
            ->paginate(12)
            ->withQueryString()
            ->through(fn (Service $service) => [
                'id' => $service->id,
                'title' => $service->title,
                'specialty' => $service->specialty,
                'rate' => $service->formatted_rate,
                'region' => $service->region,
                'city' => $service->city,
                'providerName' => $service->user->name,
                'createdAt' => $service->created_at?->diffForHumans(),
            ]);

        return Inertia::render('services/index', [
            'services' => $services,
            'filters' => $request->only(['search', 'specialty', 'state_id', 'mine']),
            'specialties' => [
                'Filmagem', 'Edição', 'Fotografia', 'Drone', 'Streaming', 'Áudio',
            ],
            'states' => State::query()->orderBy('name')->get(['id', 'name', 'uf']),
        ]);
    }

    /**
     * Show the form for creating a new service.
     */
    public function create(): Response
    {
        return $this->form();
    }

    /**
     * Store a newly created service in storage.
     */
    public function store(StoreServiceRequest $request): RedirectResponse
    {
        $service = $request->user()->services()->create($request->validated());

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Serviço publicado com sucesso.',
        ]);

        return to_route('services.show', ['service' => $service]);
    }

    /**
     * Display the specified service.
     */
    public function show(Service $service, Request $request): Response
    {
        $user = $request->user();

        abort_if(
            ! $service->is_active && $service->user_id !== $user->id && ! $user->isAdmin(),
            404,
        );

        $existingMatch = null;
        if ($service->is_active && $service->user_id !== $user->id) {
            $existingMatch = $service->matches()
                ->where('seeker_id', $user->id)
                ->whereNotIn('status', ['declined', 'cancelled'])
                ->first();
        }

        $service->load(['user', 'state', 'municipality']);

        return Inertia::render('services/show', [
            'service' => [
                'id' => $service->id,
                'title' => $service->title,
                'description' => $service->description,
                'specialty' => $service->specialty,
                'rate' => $service->formatted_rate,
                'region' => $service->region,
                'city' => $service->city,
                'provider' => [
                    'id' => $service->user->id,
                    'name' => $service->user->name,
                    'region' => $service->user->region,
                    'city' => $service->user->city,
                ],
                'createdAt' => $service->created_at?->toIso8601String(),
            ],
            'isOwner' => $service->user_id === $user->id,
            'existingMatch' => $existingMatch ? [
                'id' => $existingMatch->id,
                'status' => $existingMatch->status->value,
                'statusLabel' => $existingMatch->status->label(),
            ] : null,
            'tradeTypes' => collect(\App\Enums\TradeType::cases())->map(fn ($case) => [
                'value' => $case->value,
                'label' => $case->label(),
            ]),
        ]);
    }

    /**
     * Show the form for editing the specified service.
     */
    public function edit(Service $service): Response
    {
        abort_unless($service->user_id === request()->user()->id, 403);

        return $this->form($service);
    }

    /**
     * Update the specified service in storage.
     */
    public function update(\App\Http\Requests\UpdateServiceRequest $request, Service $service): RedirectResponse
    {
        $service->update($request->validated());

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Serviço atualizado com sucesso.',
        ]);

        return to_route('services.show', ['service' => $service]);
    }

    /**
     * Remove the specified service from storage.
     */
    public function destroy(Service $service): RedirectResponse
    {
        abort_unless($service->user_id === request()->user()->id, 403);

        $service->delete();

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Serviço excluído.',
        ]);

        return to_route('services.index');
    }

    /**
     * Shared data for the create/edit forms.
     */
    private function form(?Service $service = null): Response
    {
        $user = request()->user();

        return Inertia::render('services/form', [
            'service' => $service ? [
                'id' => $service->id,
                'title' => $service->title,
                'description' => $service->description,
                'specialty' => $service->specialty,
                'rate_type' => $service->rate_type->value,
                'rate' => $service->rate,
                'state_id' => $service->state_id,
                'municipality_id' => $service->municipality_id,
            ] : null,
            'rateTypes' => collect(RateType::cases())->map(fn ($case) => [
                'value' => $case->value,
                'label' => $case->label(),
            ]),
            'specialties' => [
                'Filmagem', 'Edição', 'Fotografia', 'Drone', 'Streaming', 'Áudio',
            ],
            'states' => State::query()->orderBy('name')->get(['id', 'name', 'uf']),
            'defaultStateId' => $user->state_id,
            'defaultMunicipalityId' => $user->municipality_id,
        ]);
    }
}
