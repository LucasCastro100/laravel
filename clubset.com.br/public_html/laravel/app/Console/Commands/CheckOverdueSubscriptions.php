<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Laravel\Cashier\Subscription;

class CheckOverdueSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:check-overdue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Block accounts whose payment is overdue beyond the grace period';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->blockOverdueAccounts();

        $this->unblockSettledAccounts();

        $this->info('Subscriptions checked.');

        return self::SUCCESS;
    }

    /**
     * Block users whose subscription is past due beyond the grace period.
     */
    protected function blockOverdueAccounts(): void
    {
        $subscriptions = Subscription::query()
            ->whereIn('stripe_status', ['past_due', 'unpaid', 'incomplete'])
            ->with('owner')
            ->get();

        foreach ($subscriptions as $subscription) {
            $user = $subscription->owner;

            if (! $user || $user->accountIsBlocked()) {
                continue;
            }

            if (! $user->hasPaymentDue()) {
                $user->markPaymentDue();
            }

            if ($user->gracePeriodExpired()) {
                $user->blockAccount();

                $this->components->warn("Conta bloqueada por inadimplência: {$user->email}");
            }
        }
    }

    /**
     * Unblock users whose subscription is active again.
     */
    protected function unblockSettledAccounts(): void
    {
        $blocked = User::query()
            ->whereNotNull('blocked_at')
            ->get();

        foreach ($blocked as $user) {
            if ($user->hasActiveSubscription()) {
                $user->unblockAccount();

                $this->components->info("Conta reativada após pagamento: {$user->email}");
            }
        }
    }
}
