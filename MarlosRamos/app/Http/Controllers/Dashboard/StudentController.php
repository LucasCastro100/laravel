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
        $courses = Course::paginate(10);
        $message = 'Mais cursos em breve!';

        $dados = [
            'title' => 'Todos os cursos',
            'courses' => $courses,
            'message' => $message,
        ];

        return view('dashboard.user.course.courses_all', $dados);
    }

    public function myCourses()
    {
        $courses = Course::whereHas('matriculations', function ($query) {
            $query->where('user_id', Auth::id());
        })->paginate(10);

        $message = 'Você não possui nehum curso!';

        $dados = [
            'title' => 'Meus cursos',
            'courses' => $courses,
            'message' => $message,
        ];

        return view('dashboard.user.course.courses_my', $dados);
    }
}
