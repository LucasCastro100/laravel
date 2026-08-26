<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Create (or update) the platform administrator account.
     *
     * Credenciais iniciais: lucascastro121295@gmail.com / mudar123.
     * Altere a senha após o primeiro acesso.
     */
    public function run(): void
    {
        $user = User::query()->updateOrCreate(
            ['email' => 'lucascastro121295@gmail.com'],
            [
                'name' => 'Lucas Castro',
                'password' => Hash::make('mudar123'),
                'email_verified_at' => now(),
            ],
        );

        $user->assignRole(UserRole::Administrator);

        $this->command?->info('Admin user lucascastro121295@gmail.com created.');
    }
}
