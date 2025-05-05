<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function dashBoard()
    {
        $user = Auth::user();
        $courses = Course::paginate(10);
        $tests = Test::paginate(10);

        // IDs de cursos e testes que o usuário está matriculado
        $userCourseIds = $user->enrolledCourses->pluck('id')->toArray();
        $userTestIds = $user->enrolledTests->pluck('id')->toArray();

        $dados = [
            'title' => 'Painel do Aluno',
            'courses' => $courses,
            'tests' => $tests,
            'userCourseIds' => $userCourseIds,
            'userTestIds' => $userTestIds,
        ];

        return view('dashboard.student.dashboard', $dados);
    }

    public function myCourses()
    {
        $courses = Course::whereHas('matriculations', function ($query) {
            $query->where('user_id', Auth::id());
        })->paginate(10);

        $dados = [
            'title' => 'Meus cursos',
            'courses' => $courses,
        ];

        return view('dashboard.student.course.courses_my', $dados);
    }

    public function courseShow(Request $request)
    {
        $user = Auth::user();

        $course = Course::where('uuid', $request->uuid)
            ->withCount('users')
            ->withCount('modules')
            ->with(['modules.classrooms.users']) // carrega aulas e usuários que completaram
            ->firstOrFail();

        // Total de aulas
        $totalClasses = $course->modules->sum(fn($m) => $m->classrooms->count());

        // Aulas concluídas pelo usuário
        $completedClasses = $course->modules->flatMap->classrooms->filter(function ($aula) use ($user) {
            return $aula->users->contains($user->id);
        })->count();

        // Progresso percentual
        $progress = $totalClasses > 0 ? round(($completedClasses / $totalClasses) * 100) : 0;

        // Lista de módulos com duração individual
        $modulesWithDuration = $course->modules->map(function ($module) {
            $durationInSeconds = $module->classrooms->sum(function ($aula) {
                $duracao = $aula->duration ?? '00:00:00';
                [$h, $m, $s] = array_pad(explode(':', $duracao), 3, 0);
                return ($h * 3600) + ($m * 60) + $s;
            });

            $horas = floor($durationInSeconds / 3600);
            $minutos = floor(($durationInSeconds % 3600) / 60);
            $segundos = $durationInSeconds % 60;

            $module->total_duration = sprintf('%02d:%02d:%02d', $horas, $minutos, $segundos);
            $module->duration_seconds = $durationInSeconds;

            return $module;
        });

        // Total geral em segundos a partir dos módulos
        $durationTotalSegundos = $modulesWithDuration->sum('duration_seconds');

        $horas = floor($durationTotalSegundos / 3600);
        $minutos = floor(($durationTotalSegundos % 3600) / 60);
        $segundos = $durationTotalSegundos % 60;

        $durationFormatada = sprintf('%02d:%02d:%02d', $horas, $minutos, $segundos);

        $dados = [
            'title' => $course->title,
            'course' => $course,
            'completedClasses' => $completedClasses,
            'totalClasses' => $totalClasses,
            'progress' => $progress,
            'durationTotal' => $durationFormatada,
            'modulesWithDuration' => $modulesWithDuration,
        ];

        return view('dashboard.student.course.course_show', $dados);
    }
}
