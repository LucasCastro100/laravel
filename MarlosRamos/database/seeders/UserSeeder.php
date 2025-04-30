<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Lucas Henrique de Castro Oliveira',
                'email' => 'lucascastro121295@gmail.com',
                'password' => 'mudar123',
                'cpf' => '084.832.526-51',
                'phone' => '(34) 99153-5839',
                'role' => '1'
            ],
            [
                'name' => 'Lucas',
                'email' => 'lucas@gmail.com',
                'password' => 'mudar123',
                'cpf' => '123.456.789-00',
                'phone' => '(34) 91234-5678',
                'role' => '0'
            ]
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
