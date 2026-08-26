<?php

use App\Enums\ListingStatus;
use App\Enums\MatchStatus;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ListingModerationController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Middleware\EnsureAccountNotBlocked;
use App\Models\Listing;
use App\Models\TradeMatch;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

Route::get('/', function () {
    $hasListingsTable = Schema::hasTable('listings');

    return inertia('welcome', [
        'stats' => [
            'listings' => $hasListingsTable
                ? Listing::where('status', ListingStatus::Active)->count()
                : 0,
            'users' => User::count(),
            'matches' => Schema::hasTable('matches')
                ? TradeMatch::where('status', MatchStatus::Completed)->count()
                : 0,
        ],
        'recentListings' => $hasListingsTable
            ? Listing::with(['owner', 'state', 'municipality'])
                ->where('status', ListingStatus::Active)
                ->latest()
                ->take(6)
                ->get()
                ->map(fn (Listing $listing) => [
                    'id' => $listing->id,
                    'title' => $listing->title,
                    'description' => $listing->description,
                    'category' => $listing->category->value,
                    'categoryLabel' => $listing->category->label(),
                    'condition' => $listing->condition?->value,
                    'conditionLabel' => $listing->condition?->label(),
                    'intent' => $listing->intent->value,
                    'intentLabel' => $listing->intent->label(),
                    'type' => $listing->type->value,
                    'typeLabel' => $listing->type->label(),
                    'price' => $listing->price,
                    'formattedPrice' => $listing->formatted_price,
                    'region' => $listing->region,
                    'city' => $listing->city,
                    'owner' => [
                        'id' => $listing->owner->id,
                        'name' => $listing->owner->name,
                    ],
                    'createdAt' => $listing->created_at->toISOString(),
                ])
            : [],
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])
    ->prefix('assinatura')
    ->name('assinatura.')
    ->group(function () {
        Route::get('/', [SubscriptionController::class, 'index'])->name('index');
        Route::post('/checkout/{plan}', [SubscriptionController::class, 'checkout'])->name('checkout');
        Route::post('/cancel', [SubscriptionController::class, 'cancel'])->name('cancel');
        Route::post('/resume', [SubscriptionController::class, 'resume'])->name('resume');
    });

Route::middleware([
    'auth',
    'verified',
    EnsureAccountNotBlocked::class,
])
    ->group(function () {
        Route::get('dashboard', DashboardController::class)->name('dashboard');

        Route::get('municipalities', [MunicipalityController::class, 'index'])->name('municipalities.index');

        Route::resource('listings', ListingController::class)
            ->except(['show']);
        Route::get('listings/{listing}', [ListingController::class, 'show'])->name('listings.show');

        Route::resource('services', ServiceController::class)
            ->except(['show']);
        Route::get('services/{service}', [ServiceController::class, 'show'])->name('services.show');

        Route::post('matches', [MatchController::class, 'store'])->name('matches.store');
        Route::patch('matches/{match}', [MatchController::class, 'update'])->name('matches.update');
        Route::get('matches', [MatchController::class, 'index'])->name('matches.index');
    });

Route::middleware(['auth', 'verified', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/cadastros', [AdminController::class, 'registrations'])->name('registrations');
        Route::post('/cadastros/{user}/verificar', [AdminController::class, 'verify'])->name('verify');
        Route::get('/moderacao', [ListingModerationController::class, 'index'])->name('moderation');
        Route::post('/moderacao/{listing}', [ListingModerationController::class, 'moderate'])->name('moderation.moderate');
        Route::get('/configuracoes', [SettingsController::class, 'index'])->name('settings');
        Route::patch('/configuracoes', [SettingsController::class, 'update'])->name('settings.update');
    });

// Team invitation routes commented out per request
// Route::middleware(['auth'])->group(function () {
//     Route::post('invitations/{invitation}/accept', [TeamInvitationController::class, 'accept'])->name('invitations.accept');
//     Route::delete('invitations/{invitation}', [TeamInvitationController::class, 'decline'])->name('invitations.decline');
// });

require __DIR__.'/settings.php';
