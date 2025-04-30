<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function allCourses()
    {
        $user = Auth::user();
        $courses = Course::with('users')->paginate(10);
        $userCourseIds = $user->courses->pluck('id')->toArray();

        $dados = [
            'title' => 'Todos os cursos',
            'courses' => $courses,
            'userCourseIds' => $userCourseIds,
        ];

        return view('dashboard.user.course.courses_all', $dados);
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

        return view('dashboard.user.course.courses_my', $dados);
    }

    public function courseShow(Request $request)
    {
        $user = Auth::user();

        $course = Course::where('uuid', $request->uuid)
            ->withCount('users')
            ->withCount('modules')
            ->with(['modules.classrooms.completedByUsers']) // carrega aulas e usuários que completaram
            ->firstOrFail();

        // Total de aulas
        $totalClasses = $course->modules->sum(fn($m) => $m->classrooms->count());

        // Aulas concluídas pelo usuário
        $completedClasses = $course->modules->flatMap->classrooms->filter(function ($aula) use ($user) {
            return $aula->completedByUsers->contains($user->id);
        })->count();

        // Progresso percentual
        $progress = $totalClasses > 0 ? round(($completedClasses / $totalClasses) * 100) : 0;

        // Soma da duração em segundos
        $durationTotalSegundos = $course->modules->flatMap->classrooms->sum(function ($aula) {
            $duracao = $aula->duration ?? '00:00:00';
            [$h, $m, $s] = array_pad(explode(':', $duracao), 3, 0);
            return ($h * 3600) + ($m * 60) + $s;
        });

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
        ];

        return view('dashboard.user.course.course_show', $dados);
    }
}
