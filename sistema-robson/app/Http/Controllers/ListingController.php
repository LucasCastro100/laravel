<?php

namespace App\Http\Controllers;

use App\Enums\EquipmentCategory;
use App\Enums\EquipmentCondition;
use App\Enums\ListingIntent;
use App\Enums\ListingStatus;
use App\Enums\ListingType;
use App\Http\Requests\StoreListingRequest;
use App\Http\Requests\UpdateListingRequest;
use App\Models\Listing;
use App\Models\State;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ListingController extends Controller
{
    /**
     * Browse active listings (marketplace) with filters.
     */
    public function index(Request $request): Response
    {
        $user = $request->user();

        $listings = Listing::query()
            ->with(['owner', 'state', 'municipality'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('title', 'like', '%'.$request->string('search').'%');
            })
            ->when($request->filled('category'), fn ($query) => $query->where('category', $request->string('category')))
            ->when($request->filled('intent'), fn ($query) => $query->where('intent', $request->string('intent')))
            ->when($request->filled('state_id'), fn ($query) => $query->where('state_id', $request->integer('state_id')))
            ->when($request->boolean('mine'), fn ($query) => $query->where('user_id', $user->id))
            ->when(! $request->boolean('mine'), fn ($query) => $query->active())
            ->latest()
            ->paginate(12)
            ->withQueryString()
            ->through(fn (Listing $listing) => [
                'id' => $listing->id,
                'title' => $listing->title,
                'category' => $listing->category->label(),
                'condition' => $listing->condition?->label(),
                'intent' => $listing->intent->label(),
                'type' => $listing->type->label(),
                'price' => $listing->formatted_price,
                'region' => $listing->region,
                'city' => $listing->city,
                'status' => $listing->status->label(),
                'ownerName' => $listing->owner->name,
                'createdAt' => $listing->created_at?->diffForHumans(),
            ]);

        return Inertia::render('listings/index', [
            'listings' => $listings,
            'filters' => $request->only(['search', 'category', 'intent', 'state_id', 'mine']),
            'categories' => collect(EquipmentCategory::cases())->map(fn ($case) => [
                'value' => $case->value,
                'label' => $case->label(),
            ]),
            'intents' => collect(ListingIntent::cases())->map(fn ($case) => [
                'value' => $case->value,
                'label' => $case->label(),
            ]),
            'states' => State::query()->orderBy('name')->get(['id', 'name', 'uf']),
        ]);
    }

    /**
     * Show the form for creating a new listing.
     */
    public function create(): Response
    {
        return $this->form();
    }

    /**
     * Store a newly created listing in storage.
     */
    public function store(StoreListingRequest $request): RedirectResponse
    {
        $listing = $request->user()->listings()->create($request->validated());

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Anúncio enviado para moderação. Ele será publicado após aprovação.',
        ]);

        return to_route('listings.show', ['listing' => $listing]);
    }

    /**
     * Display the specified listing.
     */
    public function show(Listing $listing, Request $request): Response
    {
        $user = $request->user();

        abort_if(
            ! $listing->isOpen() && $listing->user_id !== $user->id && ! $user->isAdmin(),
            404,
        );

        $existingMatch = null;
        if ($listing->isOpen() && $listing->user_id !== $user->id) {
            $existingMatch = $listing->matches()
                ->where('seeker_id', $user->id)
                ->whereNotIn('status', ['declined', 'cancelled'])
                ->first();
        }

        $listing->load(['owner', 'state', 'municipality']);

        return Inertia::render('listings/show', [
            'listing' => [
                'id' => $listing->id,
                'title' => $listing->title,
                'description' => $listing->description,
                'category' => $listing->category->label(),
                'condition' => $listing->condition?->label(),
                'intent' => $listing->intent->label(),
                'type' => $listing->type->label(),
                'price' => $listing->formatted_price,
                'region' => $listing->region,
                'city' => $listing->city,
                'status' => $listing->status->label(),
                'statusCode' => $listing->status->value,
                'moderationReason' => $listing->moderation_reason,
                'owner' => [
                    'id' => $listing->owner->id,
                    'name' => $listing->owner->name,
                    'region' => $listing->owner->region,
                    'city' => $listing->owner->city,
                ],
                'createdAt' => $listing->created_at?->toIso8601String(),
            ],
            'isOwner' => $listing->user_id === $user->id,
            'canModerate' => $user->isAdmin(),
            'existingMatch' => $existingMatch ? [
                'id' => $existingMatch->id,
                'status' => $existingMatch->status->value,
                'statusLabel' => $existingMatch->status->label(),
            ] : null,
            'tradeTypes' => collect(\App\Enums\TradeType::cases())->map(fn ($case) => [
                'value' => $case->value,
                'label' => $case->label(),
            ]),
            'conditions' => collect(EquipmentCondition::cases())->map(fn ($case) => [
                'value' => $case->value,
                'label' => $case->label(),
            ]),
        ]);
    }

    /**
     * Show the form for editing the specified listing.
     */
    public function edit(Listing $listing): Response
    {
        abort_unless($listing->user_id === request()->user()->id, 403);

        return $this->form($listing);
    }

    /**
     * Update the specified listing in storage.
     */
    public function update(UpdateListingRequest $request, Listing $listing): RedirectResponse
    {
        $listing->fill($request->validated());
        $listing->status = ListingStatus::Pending;
        $listing->moderation_reason = null;
        $listing->save();

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Anúncio atualizado e reenviado para moderação.',
        ]);

        return to_route('listings.show', ['listing' => $listing]);
    }

    /**
     * Remove the specified listing from storage.
     */
    public function destroy(Listing $listing): RedirectResponse
    {
        abort_unless($listing->user_id === request()->user()->id || request()->user()->isAdmin(), 403);

        $listing->delete();

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Anúncio excluído.',
        ]);

        return to_route('listings.index');
    }

    /**
     * Shared data for the create/edit forms.
     */
    private function form(?Listing $listing = null): Response
    {
        $user = request()->user();

        return Inertia::render('listings/form', [
            'listing' => $listing ? [
                'id' => $listing->id,
                'title' => $listing->title,
                'description' => $listing->description,
                'category' => $listing->category->value,
                'condition' => $listing->condition?->value,
                'intent' => $listing->intent->value,
                'type' => $listing->type->value,
                'price' => $listing->price,
                'state_id' => $listing->state_id,
                'municipality_id' => $listing->municipality_id,
            ] : null,
            'categories' => collect(EquipmentCategory::cases())->map(fn ($case) => [
                'value' => $case->value,
                'label' => $case->label(),
            ]),
            'conditions' => collect(EquipmentCondition::cases())->map(fn ($case) => [
                'value' => $case->value,
                'label' => $case->label(),
            ]),
            'intents' => collect(ListingIntent::cases())->map(fn ($case) => [
                'value' => $case->value,
                'label' => $case->label(),
            ]),
            'types' => collect(ListingType::cases())->map(fn ($case) => [
                'value' => $case->value,
                'label' => $case->label(),
            ]),
            'states' => State::query()->orderBy('name')->get(['id', 'name', 'uf']),
            'defaultStateId' => $user->state_id,
            'defaultMunicipalityId' => $user->municipality_id,
        ]);
    }
}
