<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TypeServiceSeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get(public_path('json/typeServices.json'));
        $services = json_decode($json, true); 

        foreach ($services as &$service) {
            $service['uuid'] = Str::uuid()->toString(); // Adiciona um UUID único para cada item
        }
        
        DB::table('type_services')->insert($services);
    }
}
