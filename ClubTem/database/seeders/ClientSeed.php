<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Client::create([
            'user_id' => 1,
            'name' => 'Suporte Permuta Brasil',
            'cnpj' => '00.000.000/0001-00',            
            'whatsapp' => '(34) 90000-0000',                        
            'state_id' => 13,
            'city_id' => 2387,
            'type_service_id' => null,
            'associate' => 0,                                    
        ]);

        Client::create([
            'user_id' => 2,
            'name' => 'Lucas Henrique de Castro Oliveira',
            'cnpj' => '00.000.000/0001-01',            
            'whatsapp' => '(34) 99153-5839',      
            'state_id' => 13,
            'city_id' => 2387,
            'type_service_id' => 14,
            'associate' => 1,                           
        ]);

        Client::create([
            'user_id' => 3,
            'name' => 'Kathelin Alves Lobato',
            'cnpj' => '00.000.000/0001-02',            
            'whatsapp' => '(34) 98856-1044',
            'state_id' => 13,
            'city_id' => 2387,
            'type_service_id' => 9,
            'associate' => 1,                                 
        ]);
    }
}
