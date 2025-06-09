<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Course;
use App\Models\Test;
use App\Models\MatriculationCourse;
use App\Models\MatriculationTest;

class AdminController extends Controller
{
    public function dashBoard()
    {
        // Totais para o dashboard
        $total_courses_created = Course::count();
        $total_tests_created = Test::count();
        $total_students = Student::count();
        $total_teachers = Teacher::count();

        // Professores com total de cursos e testes criados
        $teachersList = Teacher::select('teachers.*')
            ->addSelect([
                'total_courses' => Course::selectRaw('count(*)')
                    ->whereColumn('courses.user_id', 'teachers.user_id'),
                'total_tests' => Test::selectRaw('count(*)')
                    ->whereColumn('tests.user_id', 'teachers.user_id'),
            ])
            ->with('user')
            ->paginate(10);

        // Alunos com total de cursos e testes matriculados
        $studentsList = Student::select('students.*')
            ->addSelect([
                'total_courses' => MatriculationCourse::selectRaw('count(*)')
                    ->whereColumn('matriculation_courses.user_id', 'students.user_id'),
                'total_tests' => MatriculationTest::selectRaw('count(*)')
                    ->whereColumn('matriculation_tests.user_id', 'students.user_id'),
            ])
            ->with('user')
            ->paginate(10);

        // Cursos com total de alunos matriculados
        $coursesList = Course::select('courses.*')
            ->addSelect([
                'total_students' => MatriculationCourse::selectRaw('count(*)')
                    ->whereColumn('matriculation_courses.course_id', 'courses.id'),
            ])
            ->paginate(10);

        // Testes com total de alunos matriculados
        $testsList = Test::select('tests.*')
            ->addSelect([
                'total_students' => MatriculationTest::selectRaw('count(*)')
                    ->whereColumn('matriculation_tests.test_id', 'tests.id'),
            ])
            ->paginate(10);

        $dados = [
            'title' => 'Painel do Administrador',
            'teachersList' => $teachersList,
            'studentsList' => $studentsList,
            'coursesList' => $coursesList,
            'testsList' => $testsList,
            'total_courses_created' => $total_courses_created,
            'total_tests_created' => $total_tests_created,
            'total_students' => $total_students,
            'total_teachers' => $total_teachers,
        ];

        return view('dashboard.admin.dashboard', $dados);
    }

    public function allUsers()
    {
        $teachers = Teacher::with('user')->paginate(10);
        $students = Student::with('user')->paginate(10);

        $dados = [
            'title' => 'Usuários',
            'teachers' => $teachers,
            'students' => $students,
        ];

        return view('dashboard.admin.list_users', $dados);
    }
}
