<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ListingStatus;
use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ListingModerationController extends Controller
{
    /**
     * List listings awaiting moderation.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('admin/moderation', [
            'listings' => Listing::query()
                ->pending()
                ->with(['owner', 'state', 'municipality'])
                ->latest()
                ->paginate(15)
                ->through(fn (Listing $listing) => [
                    'id' => $listing->id,
                    'title' => $listing->title,
                    'description' => $listing->description,
                    'category' => $listing->category->label(),
                    'intent' => $listing->intent->label(),
                    'region' => $listing->region,
                    'city' => $listing->city,
                    'price' => $listing->formatted_price,
                    'ownerName' => $listing->owner->name,
                    'ownerEmail' => $listing->owner->email,
                    'createdAt' => $listing->created_at?->diffForHumans(),
                ]),
        ]);
    }

    /**
     * Approve or reject a pending listing.
     */
    public function moderate(Listing $listing, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'action' => ['required', 'in:approve,reject'],
            'reason' => ['nullable', 'required_if:action,reject', 'string', 'max:1000'],
        ]);

        $listing->forceFill([
            'status' => $validated['action'] === 'approve'
                ? ListingStatus::Active
                : ListingStatus::Rejected,
            'moderation_reason' => $validated['reason'] ?? null,
        ])->save();

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => $validated['action'] === 'approve'
                ? 'Anúncio aprovado e publicado.'
                : 'Anúncio recusado.',
        ]);

        return back();
    }
}
