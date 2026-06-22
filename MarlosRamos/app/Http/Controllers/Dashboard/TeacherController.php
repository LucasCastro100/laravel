<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\DateHelper;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\User;
use App\Models\MatriculationCourse;
use App\Models\Test;
use App\Models\TesteRepresentacional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{

    public function dashBoard()
    {
        $testWithLogin = Test::count();
        $testNotLogin = TesteRepresentacional::count();
        $courses = Course::where('user_id', Auth::user()->id)->count();
        $saudacao = DateHelper::greeting();
        $usuario = Auth::user()->name;

        $dados = [
            'title' => 'Painel do Professor',
            'testsWithLogin' => $testWithLogin,
            'testsNotLogin' => $testNotLogin,
            'couses' => $courses,
            'saudacao' => $saudacao,
            'usuario' => $usuario,
        ];

        return view('dashboard.teacher.dashboard', $dados);
    }

    public function myCourses()
    {
        $courses = Course::withCount('users')->where('user_id', Auth::user()->id)->get();

        $dados = [
            'title' => 'Meus Cursos',
            'courses' => $courses,
        ];

        return view('dashboard.teacher.course.courses', $dados);
    }

    public function myTests()
    {
        // $tests = Test::withCount('users')->where('user_id', Auth::user()->id)->get();
        $testWithLogin = Test::with('user')->orderBy('created_at', 'desc')->get();
        $testNotLogin = TesteRepresentacional::orderBy('created_at', 'desc')->get();

        $dados = [
            'title' => 'Meus testes',
            'testsWithLogin' => $testWithLogin,
            'testsNotLogin' => $testNotLogin,
        ];

        return view('dashboard.teacher.test.tests', $dados);
    }

    public function report(Request $request)
    {
        $query = TesteRepresentacional::orderBy('created_at', 'desc');
    
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }
    
        $testsNotLogin = $query->get();
    
        // Totais
        $totalPercent = [
            'V' => 0,
            'A' => 0,
            'C' => 0,
            'D' => 0,
        ];
    
        foreach ($testsNotLogin as $test) {
            $percent = $test->percentual;
    
            // Se banco for string antiga → converte
            if (!is_array($percent)) {
                $percent = json_decode($percent, true) ?? [];
            }
    
            foreach ($percent as $l => $v) {
                if (isset($totalPercent[$l])) {
                    $totalPercent[$l] += intval($v);
                }
            }
        }
    
        // Frequência PRIMARY
        $primaryCount = $testsNotLogin
            ->groupBy('primary')
            ->map->count()
            ->sortDesc();
    
        // Frequência SECONDARY
        $secondaryCount = $testsNotLogin
            ->groupBy('secondary')
            ->map->count()
            ->sortDesc();
    
        return view('dashboard.teacher.test.report', [
            'title'          => 'Relatório de testes do Professor',
            'date'           => $request->date,
            'testsNotLogin'  => $testsNotLogin,
            'totalPercent'   => $totalPercent,
            'primaryCount'   => $primaryCount,
            'secondaryCount' => $secondaryCount,
        ]);
    }

    public function students()
    {
        $teacherId = Auth::user()->id;

        $students = Student::with('user')
            ->addSelect(['matriculation_courses_count' => MatriculationCourse::selectRaw('count(*)')
                ->whereColumn('matriculation_courses.user_id', 'students.user_id')
                ->whereHas('course', function ($q) use ($teacherId) {
                    $q->where('user_id', $teacherId);
                })
            ])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $dados = [
            'title' => 'Gerenciar Alunos',
            'students' => $students,
        ];

        return view('dashboard.teacher.student.index', $dados);
    }

    public function createStudent()
    {
        $dados = [
            'title' => 'Cadastrar Aluno',
        ];

        return view('dashboard.teacher.student.create', $dados);
    }

    public function storeStudent(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'cpf' => ['required', 'string', 'max:14', 'unique:' . User::class],
            'password' => ['required', 'confirmed', 'min:8'],
        ], [
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'email.unique' => 'Já existe uma conta com esse e-mail.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.unique' => 'Já existe uma conta com esse CPF.',
            'password.required' => 'A senha é obrigatória.',
            'password.confirmed' => 'As senhas não coincidem.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'cpf' => $request->cpf,
            'password' => Hash::make($request->password),
            'role_id' => 1,
        ]);

        Student::create(['user_id' => $user->id]);

        return redirect()->route('teacher.students')->with('success', 'Aluno cadastrado com sucesso!');
    }

    public function linkCourse($uuid)
    {
        $course = Course::where('uuid', $uuid)->where('user_id', Auth::user()->id)->firstOrFail();

        $students = Student::with('user')
            ->whereDoesntHave('user.courses', function ($q) use ($course) {
                $q->where('course_id', $course->id);
            })
            ->get();

        $enrolledStudents = Student::with('user')
            ->whereHas('user.courses', function ($q) use ($course) {
                $q->where('course_id', $course->id);
            })
            ->get();

        $dados = [
            'title' => 'Vincular Alunos - ' . $course->title,
            'course' => $course,
            'students' => $students,
            'enrolledStudents' => $enrolledStudents,
        ];

        return view('dashboard.teacher.course.students', $dados);
    }

    public function storeLinkCourse(Request $request, $uuid)
    {
        $course = Course::where('uuid', $uuid)->where('user_id', Auth::user()->id)->firstOrFail();

        $request->validate([
            'students' => ['required', 'array'],
            'students.*' => ['exists:users,uuid'],
        ]);

        foreach ($request->students as $userUuid) {
            $user = User::where('uuid', $userUuid)->first();
            if ($user && !$course->users->contains($user->id)) {
                MatriculationCourse::create([
                    'course_id' => $course->id,
                    'user_id' => $user->id,
                ]);
            }
        }

        return redirect()->route('teacher.linkCourse', $uuid)->with('success', 'Alunos vinculados com sucesso!');
    }

    public function destroyLinkCourse($courseUuid, $userUuid)
    {
        $course = Course::where('uuid', $courseUuid)->where('user_id', Auth::user()->id)->firstOrFail();
        $user = User::where('uuid', $userUuid)->first();

        if ($user) {
            MatriculationCourse::where('course_id', $course->id)
                ->where('user_id', $user->id)
                ->delete();
        }

        return redirect()->route('teacher.linkCourse', $courseUuid)->with('success', 'Aluno removido do curso!');
    }
}
