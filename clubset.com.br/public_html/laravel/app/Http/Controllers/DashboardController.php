<?php

namespace App\Http\Controllers;

use App\Enums\ListingStatus;
use App\Enums\MatchStatus;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $user = $request->user();

        $user->loadCount([
            'listings',
            'services',
            'matchesAsSeeker',
            'matchesAsProvider',
        ]);

        $listingsByStatus = $user->listings()
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $matchesByStatus = $user->matchesAsSeeker()
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return Inertia::render('dashboard', [
            'metrics' => [
                'listings' => [
                    'total' => $user->listings_count,
                    'active' => (int) $listingsByStatus->get(ListingStatus::Active->value, 0),
                    'pending' => (int) $listingsByStatus->get(ListingStatus::Pending->value, 0),
                ],
                'services' => [
                    'total' => $user->services_count,
                ],
                'matches' => [
                    'total' => $user->matchesAsSeeker_count + $user->matchesAsProvider_count,
                    'pending' => (int) $matchesByStatus->get(MatchStatus::Pending->value, 0),
                    'completed' => (int) $matchesByStatus->get(MatchStatus::Completed->value, 0),
                ],
                'credits' => [
                    'balance' => $user->availableBalance(),
                ],
            ],
            'recentListings' => $user->listings()
                ->with('state')
                ->latest()
                ->limit(5)
                ->get()
                ->map(fn ($listing) => [
                    'id' => $listing->id,
                    'title' => $listing->title,
                    'status' => $listing->status->value,
                    'statusLabel' => $listing->status->label(),
                    'region' => $listing->region,
                    'createdAt' => $listing->created_at?->diffForHumans(),
                ]),
            'recentMatches' => $user->matchesAsSeeker()
                ->with(['provider', 'listing'])
                ->latest()
                ->limit(5)
                ->get()
                ->map(fn ($match) => [
                    'id' => $match->id,
                    'status' => $match->status->value,
                    'statusLabel' => $match->status->label(),
                    'providerName' => $match->provider?->name,
                    'listingTitle' => $match->listing?->title,
                    'createdAt' => $match->created_at?->diffForHumans(),
                ]),
        ]);
    }
}
