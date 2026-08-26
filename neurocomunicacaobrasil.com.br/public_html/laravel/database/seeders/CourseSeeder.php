<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        Course::create([
            'title'        => 'Formação PNL',
            'description'  => 'Formação PNL',
            'price'        => 1,
            'certificate'  => null,
            'image_cover'  => 'courses/formacao_pnl.png',
            'user_id'      => 2,
        ]);
    }
}
