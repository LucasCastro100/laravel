<?php

use App\Models\TeamInvitation;
use Illuminate\Support\Facades\Schedule;

// Schedule::call(function () {
//     TeamInvitation::query()
//         ->whereNotNull('expires_at')
//         ->where('expires_at', '<', now())
//         ->delete();
// })->daily()->description('Delete expired team invitations');

// Schedule::command('subscriptions:check-overdue')
//     ->daily()
//     ->description('Block accounts with payments overdue beyond the grace period');

Schedule::command('app:clear-all-caches')
    ->weeklyOn(1, '00:00')
    ->appendOutputTo(storage_path('logs/crons.log'))
    ->description('Clear all application caches');
