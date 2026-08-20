<?php

use App\Enums\ListingStatus;
use App\Enums\MatchStatus;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Middleware\EnsureAccountNotBlocked;
use App\Models\Listing;
use App\Models\TradeMatch;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

Route::get('/', function () {
    return inertia('welcome', [
        'stats' => [
            'listings' => Schema::hasTable('listings')
                ? Listing::where('status', ListingStatus::Active)->count()
                : 0,
            'users' => User::count(),
            'matches' => Schema::hasTable('matches')
                ? TradeMatch::where('status', MatchStatus::Completed)->count()
                : 0,
        ],
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
    });

// Team invitation routes commented out per request
// Route::middleware(['auth'])->group(function () {
//     Route::post('invitations/{invitation}/accept', [TeamInvitationController::class, 'accept'])->name('invitations.accept');
//     Route::delete('invitations/{invitation}', [TeamInvitationController::class, 'decline'])->name('invitations.decline');
// });

require __DIR__.'/settings.php';
