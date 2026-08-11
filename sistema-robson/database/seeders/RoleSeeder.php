<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Seed the platform's user types.
     */
    public function run(): void
    {
        foreach (UserRole::cases() as $role) {
            Role::query()->updateOrCreate(
                ['slug' => $role->value],
                ['name' => $role->label()],
            );
        }
    }
}
