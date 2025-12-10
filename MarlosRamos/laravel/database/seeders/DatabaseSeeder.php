<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,                        
            TesteRepresentacionalEventosSeeder::class,
            TesteSeeder::class,
            CourseSeeder::class,
            ModuloSeeder::class,
            ClassroomSeeder::class,
            // MatriculationCourseSeeder::class,
            // CommentSeeder::class,
        ]);
    }
}
