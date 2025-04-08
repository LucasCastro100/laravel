<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $json = File::get(public_path('json/cities.json'));
        $cities = json_decode($json, true); 
        
        DB::table('cities')->insert($cities);
    }
}
