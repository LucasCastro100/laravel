<?php

namespace App\Http\Controllers;

use App\Enums\EquipmentCategory;
use App\Enums\EquipmentCondition;
use App\Enums\ListingIntent;
use App\Enums\ListingStatus;
use App\Enums\ListingType;
use App\Enums\TradeType;
use App\Http\Requests\StoreListingRequest;
use App\Http\Requests\UpdateListingRequest;
use App\Models\Listing;
use App\Models\Municipality;
use App\Models\Setting;
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
            ->with(['owner', 'state', 'municipality', 'images'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('title', 'like', '%'.$request->string('search').'%');
            })
            ->when($request->filled('category'), fn ($query) => $query->where('category', $request->string('category')))
            ->when($request->filled('condition'), fn ($query) => $query->where('condition', $request->string('condition')))
            ->when($request->filled('intent'), fn ($query) => $query->where('intent', $request->string('intent')))
            ->when($request->filled('type'), fn ($query) => $query->where('type', $request->string('type')))
            ->when($request->filled('state_id'), fn ($query) => $query->where('state_id', $request->integer('state_id')))
            ->when($request->filled('region') && ! $request->filled('state_id'), function ($query) use ($request) {
                $stateIds = State::where('region', $request->string('region'))->pluck('id');
                $query->whereIn('state_id', $stateIds);
            })
            ->when($request->filled('municipality_id'), fn ($query) => $query->where('municipality_id', $request->integer('municipality_id')))
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
                'imageUrl' => $listing->images->sortBy('sort_order')->first()?->url,
                'createdAt' => $listing->created_at?->diffForHumans(),
            ]);

        $states = State::query()->orderBy('name')->get(['id', 'name', 'uf', 'region']);
        $regions = $states->pluck('region')->unique()->sort()->values()->all();
        $selectedStateId = $request->integer('state_id');
        $municipalities = $selectedStateId
            ? Municipality::where('state_id', $selectedStateId)->orderBy('name')->get(['id', 'name'])
            : collect();

        return Inertia::render('listings/index', [
            'listings' => $listings,
            'filters' => $request->only(['search', 'category', 'condition', 'intent', 'type', 'region', 'state_id', 'municipality_id', 'mine']),
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
            'regions' => $regions,
            'states' => $states,
            'municipalities' => $municipalities,
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
        $requireModeration = Setting::get('require_moderation', 'true', 'listings') === 'true';

        $listing = $request->user()->listings()->create(array_merge(
            $request->validated(),
            ['status' => $requireModeration ? ListingStatus::Pending : ListingStatus::Active],
        ));

        if ($request->hasFile('images')) {
            $max = (int) Setting::get('max_images', '6');
            $files = array_slice($request->file('images'), 0, $max);
            foreach ($files as $index => $file) {
                $path = $file->store('listings', 'web');
                $listing->images()->create([
                    'path' => $path,
                    'sort_order' => $index,
                ]);
            }
        }

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => $requireModeration
                ? 'Anúncio enviado para moderação. Ele será publicado após aprovação.'
                : 'Anúncio publicado com sucesso!',
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

        $listing->load(['owner', 'state', 'municipality', 'images']);

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
                'images' => $listing->images->map(fn ($img) => [
                    'id' => $img->id,
                    'url' => $img->url,
                    'sort_order' => $img->sort_order,
                ]),
                'createdAt' => $listing->created_at?->format('d/m/Y \à\s H:i'),
            ],
            'isOwner' => $listing->user_id === $user->id,
            'canModerate' => $user->isAdmin(),
            'existingMatch' => $existingMatch ? [
                'id' => $existingMatch->id,
                'status' => $existingMatch->status->value,
                'statusLabel' => $existingMatch->status->label(),
            ] : null,
            'tradeTypes' => collect(TradeType::cases())->map(fn ($case) => [
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
        $requireModeration = Setting::get('require_moderation', 'true', 'listings') === 'true';

        $listing->fill($request->validated());
        $listing->status = $requireModeration ? ListingStatus::Pending : ListingStatus::Active;
        $listing->moderation_reason = null;
        $listing->save();

        $max = (int) Setting::get('max_images', '6');

        if ($request->has('removed_images') && is_array($request->input('removed_images'))) {
            $removedIds = $request->input('removed_images');
            $imagesToDelete = $listing->images()->whereIn('id', $removedIds)->get();
            foreach ($imagesToDelete as $img) {
                $diskPath = storage_path('app/public/'.$img->path);
                if (file_exists($diskPath)) {
                    @unlink($diskPath);
                }
                $webPath = public_path('storage/'.$img->path);
                if (file_exists($webPath)) {
                    @unlink($webPath);
                }
                $img->delete();
            }
        }

        $currentCount = $listing->images()->count();

        if ($request->hasFile('images') && $currentCount < $max) {
            $files = $request->file('images');
            $allowed = $max - $currentCount;
            foreach (array_slice($files, 0, $allowed) as $index => $file) {
                $path = $file->store('listings', 'web');
                $listing->images()->create([
                    'path' => $path,
                    'sort_order' => $currentCount + $index,
                ]);
            }
        }

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => $requireModeration
                ? 'Anúncio atualizado e reenviado para moderação.'
                : 'Anúncio atualizado com sucesso!',
        ]);

        return to_route('listings.show', ['listing' => $listing]);
    }

    /**
     * Remove the specified listing from storage.
     */
    public function destroy(Listing $listing): RedirectResponse
    {
        abort_unless($listing->user_id === request()->user()->id || request()->user()->isAdmin(), 403);

        foreach ($listing->images as $img) {
            $webPath = public_path('storage/'.$img->path);
            if (file_exists($webPath)) {
                @unlink($webPath);
            }
        }

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

        $stateId = $listing?->state_id ?? $user->state_id;
        $municipalities = $stateId
            ? Municipality::where('state_id', $stateId)->orderBy('name')->get(['id', 'name'])
            : collect();

        $states = State::query()->orderBy('name')->get(['id', 'name', 'uf', 'region']);
        $regions = $states->pluck('region')->unique()->sort()->values()->all();

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
                'images' => $listing->images()->orderBy('sort_order')->get()->map(fn ($img) => [
                    'id' => $img->id,
                    'url' => $img->url,
                ]),
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
            'regions' => $regions,
            'states' => $states,
            'municipalities' => $municipalities,
            'maxImagesPerListing' => (int) Setting::get('max_images', '6'),
            'defaultStateId' => $user->state_id,
            'defaultMunicipalityId' => $user->municipality_id,
        ]);
    }
}
