<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use function Laravel\Prompts\password;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create(
            [
                'email' => 'suporte@permutabrasil.com.br',
                'password' => 'RAL002024',
                'role' => '3',
                'actived' => '1'
            ]
        );

        User::create(
            [
                'email' => 'lucascastro121295@gmail.com',
                'password' => 'mudar123',
                'role' => '2',
                'actived' => '1'
            ]
        );

        User::create(
            [
                'email' => 'okiafilmes@gmail.com',
                'password' => 'mudar123',
                'role' => '2',
                'actived' => '1'
            ]
        );
    }
}
