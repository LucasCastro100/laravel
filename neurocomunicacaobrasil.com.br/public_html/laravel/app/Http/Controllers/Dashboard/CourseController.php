<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::withCount('users')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('dashboard.teacher.course.courses', [
            'title'   => 'Gerenciamento dos Cursos',
            'courses' => $courses,
        ]);
    }

    public function create()
    {
        return view('dashboard.teacher.course.create', ['title' => 'Novo Curso']);
    }

    public function edit(string $uuid)
    {
        $course = Course::where('uuid', $uuid)->firstOrFail();
        return view('dashboard.teacher.course.edit', ['title' => 'Editar Curso', 'course' => $course]);
    }

    public function store(CourseRequest $request)
    {
        try {       
            $data = $request->except(['_token']);
            $data['user_id'] = Auth::user()->id;
            $data['certificate_enabled'] = $request->has('certificate_enabled');
            $data['price'] = $request->input('price') ?? 0;
            $data['payment_link'] = $request->input('payment_link') ?? '';

            foreach (['image_cover', 'image_banner', 'certificate_background'] as $field) {
                if ($request->hasFile($field)) {
                    $data[$field] = $this->uploadImage($request->file($field), $request->title);
                }
            }

            Course::create($data);

            return redirect()->route('course.index')->with('success', 'Curso criado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('course.index')->with('error', 'Erro ao criar o curso!'. $e->getMessage());
        }
    }

    private function uploadImage($imageFile, $title)
    {
        $filename = Str::slug(strtolower($title), '_') . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
        $path = storage_path('app/public/courses');
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
        $image = Image::read($imageFile)->resize(300, 200);
        $image->save($path . '/' . $filename);
        return 'courses/' . $filename;
    }

    public function show(string $uuid)
    {
        $course = Course::where('uuid', $uuid)
            ->withCount('users')  // Contagem de usuários
            ->withCount('modules')  // Contagem de módulos
            ->with('modules.classrooms') // Carrega os módulos e as aulas associadas
            ->with(['modules' => function ($query) {
                $query->withCount('classrooms')  // Conta as aulas de cada módulo
                    ->with('classrooms');  // Carrega as aulas de cada módulo
            }])
            ->first();

        // Alunos matriculados
        $enrolledStudents = User::whereHas('courses', function ($q) use ($course) {
            $q->where('course_id', $course->id);
        })->with('student')->get();

        // Alunos disponíveis (não matriculados neste curso)
        $availableStudents = Student::with('user')
            ->whereDoesntHave('user.courses', function ($q) use ($course) {
                $q->where('course_id', $course->id);
            })
            ->get();

        $dados = [
            'title' => $course->title,
            'course' => $course,
            'enrolledStudents' => $enrolledStudents,
            'availableStudents' => $availableStudents,
        ];

        return view('dashboard.teacher.course.course_show', $dados);
    }

    public function update(CourseRequest $request, string $uuid)
    {
        try {
            $course = Course::where('uuid', $uuid)->firstOrFail();
            $data = $request->except(['_token']);
            $data['certificate_enabled'] = $request->has('certificate_enabled');
            $data['price'] = $request->input('price') ?? 0;
            $data['payment_link'] = $request->input('payment_link') ?? '';

            foreach (['image_cover', 'image_banner', 'certificate_background'] as $field) {
                if ($request->hasFile($field)) {
                    $data[$field] = $this->uploadImage($request->file($field), $request->title);
                }
            }

            $course->update($data);
            return redirect()->route('course.show', ['uuid' => $course->uuid])->with('success', 'Curso atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar o curso.');
        }
    }

    public function destroy(Request $request, string $uuid)
    {
        try {
            $course = Course::where('uuid', $uuid)->first();
            $course->delete();
            return redirect()->route('course.index')->with('success', 'Curso excluído com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('course.index')->with('error', 'Erro ao excluir o curso.');
        }
    }
}
