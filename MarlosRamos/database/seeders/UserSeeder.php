<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Teacher;
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
                'name' => 'Administrador',
                'email' => 'administrador@gmail.com',
                'password' => 'mudar123',
                'cpf' => '000.000.000-00',
                'phone' => '(34) 90000-0000',
                'role_id' => '3'
            ],
            [
                'name' => 'Professor',
                'email' => 'professor@gmail.com',
                'password' => 'mudar123',
                'cpf' => '111.111.111-11',
                'phone' => '(34) 91111-1111',
                'role_id' => '2'
            ],
            [
                'name' => 'Estudante',
                'email' => 'estudante@gmail.com',
                'password' => 'mudar123',
                'cpf' => '222.222.222-22',
                'phone' => '(34) 92222-2222',
                'role_id' => '1'
            ]
        ];

        foreach ($users as $data) {
            $user = User::create($data);

            if($data['role_id'] == 1){
                Student::create(['user_id' => $user->id]);
            } elseif($data['role_id'] == 2){
                Teacher::create(['user_id' => $user->id, 'specialty' => 'Teste']);
            }
        }
    }
}
