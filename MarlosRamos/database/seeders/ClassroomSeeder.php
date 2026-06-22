<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classroom;
use App\Services\YoutubeService;

class ClassroomSeeder extends Seeder
{
    public function run(): void
    {
        $youtube = new YoutubeService();

        $aulas = [
            [
                'module_id'   => 1,
                'title'       => 'Formação PNL Nível 1 - Aula 1',
                'description' => 'Primeira aula da Formação PNL, introdução e fundamentos essenciais.',
                'video'       => 'https://www.youtube.com/watch?v=s7pNxaNi8U0&t=1s',
            ],
            [
                'module_id'   => 1,
                'title'       => 'Formação PNL Nível 1 - Aula 2',
                'description' => 'Segunda aula da Formação PNL, aprofundando os conceitos.',
                'video'       => 'https://www.youtube.com/watch?v=HiCFhO1-4Vs',
            ],
            [
                'module_id'   => 1,
                'title'       => 'Formação PNL Nível 1 - Aula 3',
                'description' => 'Terceira aula da Formação PNL, avançando nos pilares principais.',
                'video'       => 'https://www.youtube.com/watch?v=iD_TGJW012A',
            ],
        ];

        foreach ($aulas as $aula) {

            $videoId = $youtube->extractVideoId($aula['video']);
            $duration = $videoId ? $youtube->getDuration($videoId) : '00:00:00';

            Classroom::create([
                'module_id'  => $aula['module_id'],
                'title'      => $aula['title'],
                'description'=> $aula['description'],
                'video'      => $aula['video'],
                'duration'   => $duration,
            ]);
        }
    }
}
