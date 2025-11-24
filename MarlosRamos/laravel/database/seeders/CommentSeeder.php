<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $comments = [
            [
                'comment' => 'Essa aula foi incrível! Aprendi muito e já quero colocar em prática.',
                'user_id' => 3,
                'classroom_id' => 1,
            ],
            [
                'comment' => 'Essa aula foi incrível! Aprendi muito e já quero colocar em prática.',
                'user_id' => 3,
                'classroom_id' => 2,
            ],
            [
                'comment' => 'Essa aula foi incrível! Aprendi muito e já quero colocar em prática.',
                'user_id' => 3,
                'classroom_id' => 3,
            ],
        ];

        foreach ($comments as $c) {
            Comment::create($c);
        }
    }
}
