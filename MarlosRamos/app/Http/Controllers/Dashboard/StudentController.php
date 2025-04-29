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
}
