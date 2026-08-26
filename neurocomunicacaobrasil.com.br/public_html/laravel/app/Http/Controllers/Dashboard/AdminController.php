<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Role;
use App\Models\User;
use App\Models\Course;
use App\Models\Test;
use App\Models\MatriculationCourse;
use App\Models\MatriculationTest;
use App\Models\TesteRepresentacional;
use App\Models\Comment;
use App\Models\CommentReply;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashBoard()
    {
        // Totais para o dashboard
        $total_courses_created = Course::count();
        $total_tests_created = Test::count() + TesteRepresentacional::count();
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

        // Testes representacionais (sem login)
        $testeRepList = TesteRepresentacional::orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'page_rep')
            ->withQueryString();

        $dados = [
            'title' => 'Painel do Administrador',
            'teachersList' => $teachersList,
            'studentsList' => $studentsList,
            'coursesList' => $coursesList,
            'testsList' => $testsList,
            'testeRepList' => $testeRepList,
            'total_courses_created' => $total_courses_created,
            'total_tests_created' => $total_tests_created,
            'total_students' => $total_students,
            'total_teachers' => $total_teachers,
        ];

        return view('dashboard.admin.dashboard', $dados);
    }

    public function users()
    {
        $users = User::with('role', 'student', 'teacher')->orderBy('created_at', 'desc')->paginate(20);

        $dados = [
            'title' => 'Gerenciar Usuários',
            'users' => $users,
        ];

        return view('dashboard.admin.user.index', $dados);
    }

    public function createUser()
    {
        $roles = Role::all();

        $dados = [
            'title' => 'Criar Usuário',
            'roles' => $roles,
        ];

        return view('dashboard.admin.user.create', $dados);
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'role_id' => ['required', 'integer', 'in:1,2,3'],
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

        if ((int) $request->role_id === 2) {
            $request->validate([
                'specialty' => ['required', 'string', 'min:3', 'max:255'],
            ], [
                'specialty.required' => 'A especialidade é obrigatória.',
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'cpf' => $request->cpf,
            'password' => Hash::make($request->password),
            'role_id' => (int) $request->role_id,
        ]);

        if ((int) $request->role_id === 1) {
            Student::create(['user_id' => $user->id]);
        } elseif ((int) $request->role_id === 2) {
            Teacher::create([
                'user_id' => $user->id,
                'specialty' => $request->specialty,
            ]);
        }

        return redirect()->route('admin.users')->with('success', 'Usuário criado com sucesso!');
    }

    public function editUser($uuid)
    {
        $user = User::where('uuid', $uuid)->with('role', 'student', 'teacher')->firstOrFail();
        $roles = Role::all();

        $dados = [
            'title' => 'Editar Usuário',
            'user' => $user,
            'roles' => $roles,
        ];

        return view('dashboard.admin.user.edit', $dados);
    }

    public function updateUser(Request $request, $uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'role_id' => ['required', 'integer', 'in:1,2,3'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class . ',email,' . $user->id],
            'cpf' => ['required', 'string', 'max:14', 'unique:' . User::class . ',cpf,' . $user->id],
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', 'min:8'],
            ]);
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'cpf' => $request->cpf,
            'role_id' => (int) $request->role_id,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        // Atualiza perfis se mudou de role
        if ((int) $request->role_id === 1 && !$user->student) {
            $user->teacher()?->delete();
            Student::create(['user_id' => $user->id]);
        } elseif ((int) $request->role_id === 2) {
            if (!$user->teacher) {
                $user->student()?->delete();
                Teacher::create(['user_id' => $user->id, 'specialty' => $request->specialty ?? '']);
            } else {
                $user->teacher()->update(['specialty' => $request->specialty ?? '']);
            }
        } elseif ((int) $request->role_id === 3) {
            $user->teacher()?->delete();
            $user->student()?->delete();
        }

        return redirect()->route('admin.users')->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroyUser($uuid)
    {
        $user = User::where('uuid', $uuid)->firstOrFail();

        $user->student()?->delete();
        $user->teacher()?->delete();
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Usuário excluído com sucesso!');
    }

    public function comentarios()
    {
        $courses = Course::with([
            'modules.classrooms.comments.user',
            'modules.classrooms.comments.replies.user'
        ])->get();

        return view('dashboard.admin.comment.comment_list', [
            'title' => 'Comentários',
            'courses' => $courses,
        ]);
    }

    public function responderComentario(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required|string|max:1000',
        ]);

        $comment = Comment::where('uuid', $id)->firstOrFail();

        CommentReply::create([
            'comment_id' => $comment->id,
            'user_id' => Auth::id(),
            'reply' => $request->reply,
        ]);

        return redirect()->route('admin.comentarios')->with('success', 'Resposta enviada com sucesso!');
    }

    public function tests(Request $request)
    {
        $perPage = in_array((int) $request->input('per_page', 10), [10, 20, 50, 100])
            ? (int) $request->input('per_page', 10)
            : 10;

        $testsWithLogin = Test::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page_alunos')
            ->withQueryString();

        $queryNotLogin = TesteRepresentacional::orderBy('created_at', 'desc');

        if ($request->filled('date')) {
            $queryNotLogin->whereDate('created_at', $request->date);
        }

        $testNotLogin = $queryNotLogin->paginate($perPage, ['*'], 'page_eventos')
            ->withQueryString();

        return view('dashboard.admin.tests', [
            'title'          => 'Testes',
            'testsWithLogin' => $testsWithLogin,
            'testsNotLogin'  => $testNotLogin,
            'perPage'        => $perPage,
        ]);
    }

    public function linkCourse(string $uuid)
    {
        $course = Course::where('uuid', $uuid)->firstOrFail();

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

        return view('dashboard.admin.course.students', [
            'title' => 'Vincular Alunos - ' . $course->title,
            'course' => $course,
            'students' => $students,
            'enrolledStudents' => $enrolledStudents,
        ]);
    }

    public function storeLinkCourse(Request $request, string $uuid)
    {
        $course = Course::where('uuid', $uuid)->firstOrFail();

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

        return redirect()->route('admin.linkCourse', $uuid)->with('success', 'Alunos vinculados com sucesso!');
    }

    public function destroyLinkCourse(string $courseUuid, string $userUuid)
    {
        $course = Course::where('uuid', $courseUuid)->firstOrFail();
        $user = User::where('uuid', $userUuid)->firstOrFail();

        MatriculationCourse::where('course_id', $course->id)->where('user_id', $user->id)->delete();

        return redirect()->route('admin.linkCourse', $courseUuid)->with('success', 'Aluno removido do curso com sucesso!');
    }
}
