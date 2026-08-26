<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ListingStatus;
use App\Enums\MatchStatus;
use App\Http\Controllers\Controller;
use App\Models\CreditTransaction;
use App\Models\Dispute;
use App\Models\Listing;
use App\Models\TradeMatch;
use App\Models\User;
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
     * List user registrations that still need admin validation.
     */
    public function registrations(Request $request): Response
    {
        return Inertia::render('admin/registrations', [
            'users' => User::query()
                ->with(['state', 'roles'])
                ->when(! $request->boolean('pending'), fn ($query) => $query->whereNull('admin_verified_at'))
                ->latest()
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
}
