<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

#[Signature('app:clear-all-caches')]
#[Description('Clear every application cache (config, routes, views, events, compiled classes and application cache)')]
class ClearAllCaches extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $commands = [
            'config:clear' => 'Configuration',
            'route:clear' => 'Routes',
            'view:clear' => 'Compiled views',
            'event:clear' => 'Events and listeners',
            'cache:clear' => 'Application cache',
            'queue:clear' => 'Failed jobs and pending jobs',
            'optimize:clear' => 'Cached bootstrap files',
        ];

        $failed = false;

        foreach ($commands as $command => $description) {
            try {
                Artisan::call($command);

                $this->line("<fg=yellow>✔</> {$description} cleared.");
            } catch (\Throwable $e) {
                $failed = true;

                $this->line("<fg=red>✘</> {$description}: {$e->getMessage()}");
            }
        }

        if ($failed) {
            $this->warn('Some caches could not be cleared.');

            return self::FAILURE;
        }

        $this->info('All caches cleared successfully.');

        return self::SUCCESS;
    }
}
