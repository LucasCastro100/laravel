<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Middleware\EnsureAccountNotBlocked;
use App\Http\Middleware\EnsureTeamMembership;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])
    ->prefix('assinatura')
    ->name('assinatura.')
    ->group(function () {
        Route::get('/', [SubscriptionController::class, 'index'])->name('index');
        Route::post('/checkout/{plan}', [SubscriptionController::class, 'checkout'])->name('checkout');
        Route::post('/cancel', [SubscriptionController::class, 'cancel'])->name('cancel');
        Route::post('/resume', [SubscriptionController::class, 'resume'])->name('resume');
    });

Route::prefix('{current_team}')
    ->middleware([
        'auth',
        'verified',
        EnsureTeamMembership::class,
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
