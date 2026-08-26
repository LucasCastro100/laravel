<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MatriculationCourse;

class MatriculationCourseSeeder extends Seeder
{
    public function run(): void
    {
        MatriculationCourse::create([
            'user_id' => 3,
            'course_id' => 1,
        ]);
    }
}
