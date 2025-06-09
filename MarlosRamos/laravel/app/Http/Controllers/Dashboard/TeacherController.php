<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    public function dashBoard(){
        $dados = [
            'title' => 'Painel do Professor',            
        ];

        return view('dashboard.teacher.dashboard', $dados);
    }

    public function myCourses(){
        $courses = Course::withCount('users')->where('user_id', Auth::user()->id)->get();

        $dados = [
            'title' => 'Meus Cursos',
            'courses' => $courses,
        ];

        return view('dashboard.teacher.course.courses', $dados);
    }

    public function myTests(){
        $tests = Test::withCount('users')->where('user_id', Auth::user()->id)->get();

        $dados = [
            'title' => 'Meus testes',
            'tests' => $tests,
        ];

        return view('dashboard.teacher.test.tests', $dados);
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Teacher $teacher)
    {
        //
    }

    public function edit(Teacher $teacher)
    {
        //
    }

    public function update(Request $request, Teacher $teacher)
    {
        //
    }

    public function destroy(Teacher $teacher)
    {
        //
    }
}
