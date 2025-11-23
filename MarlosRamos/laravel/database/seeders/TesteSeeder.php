<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TesteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tests')->insert([
            'user_id' => 3,
            'uuid' => 'a06c1df2-f0b0-4763-af81-0fc1f03ab6f8',
            'answers' => json_encode([
                'Q1_V' => "4",
                'Q1_A' => "3",
                'Q1_C' => "2",
                'Q1_D' => "1",
                'Q2_A' => "4",
                'Q2_V' => "3",
                'Q2_D' => "2",
                'Q2_C' => "1",
                'Q3_V' => "4",
                'Q3_C' => "3",
                'Q3_D' => "2",
                'Q3_A' => "1",
                'Q4_A' => "4",
                'Q4_D' => "3",
                'Q4_C' => "2",
                'Q4_V' => "1",
                'Q5_A' => "4",
                'Q5_D' => "3",
                'Q5_C' => "2",
                'Q5_V' => "1",
            ]),
            'scores' => json_encode([
                'A' => 16,
                'V' => 13,
                'D' => 11,
                'C' => 10,
            ]),
            'percentual' => json_encode([
                'V' => 26,
                'A' => 32,
                'C' => 20,
                'D' => 22,
            ]),

            'primary' => "A",
            'secondary' => "V",

            'created_at' => '2025-11-22 22:43:14',
            'updated_at' => '2025-11-22 22:43:14',
        ]);
    }
}
