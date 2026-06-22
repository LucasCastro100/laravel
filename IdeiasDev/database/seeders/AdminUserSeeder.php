<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\System;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $systems = System::pluck('id', 'slug');

        $users = [
            ['email' => 'lucascastro121295@gmail.com', 'name' => 'Lucas Castro',     'role_id' => 1, 'system_id' => null],
            ['email' => 'admin_tbr@gmail.com',          'name' => 'Admin TBR',       'role_id' => 2, 'system_id' => $systems['tbr'] ?? null],
            ['email' => 'admin_financeiro@gmail.com',    'name' => 'Admin Financeiro','role_id' => 2, 'system_id' => $systems['financeiro'] ?? null],
            ['email' => 'admin_cliente@gmail.com',       'name' => 'Admin Cliente',  'role_id' => 2, 'system_id' => $systems['clientes'] ?? null],
            ['email' => 'user_tbr@gmail.com',                'name' => 'Usuário TBR',      'role_id' => 3, 'system_id' => $systems['tbr'] ?? null],
            ['email' => 'user_financeiro@gmail.com',          'name' => 'Usuário Financeiro','role_id' => 3, 'system_id' => $systems['financeiro'] ?? null],
            ['email' => 'user_cliente@gmail.com',            'name' => 'Usuário Cliente', 'role_id' => 3, 'system_id' => $systems['clientes'] ?? null],
        ];

        foreach ($users as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => 'mudar123',
                    'role_id' => $data['role_id'],
                    'system_id' => $data['system_id'],
                ]
            );

            $user->markEmailAsVerified();

            $role = match ($data['role_id']) {
                1 => 'super_admin',
                2 => 'admin',
                3 => 'user',
            };
            $systemLabel = $data['system_id'] ? System::find($data['system_id'])?->name : 'todos';
            $this->command?->info("User '{$user->email}' ({$role}) - Sistema: {$systemLabel} created/updated successfully.");
        }
    }
}
