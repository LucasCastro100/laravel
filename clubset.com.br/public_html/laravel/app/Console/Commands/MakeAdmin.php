<?php

namespace App\Console\Commands;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Console\Command;

class MakeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-admin {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign the administrator role to a user';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $user = User::query()->where('email', $this->argument('email'))->first();

        if (! $user) {
            $this->error("User with email [{$this->argument('email')}] not found.");

            return self::FAILURE;
        }

        $user->assignRole(UserRole::Administrator);

        $this->info("User {$user->email} is now an administrator.");

        return self::SUCCESS;
    }
}
