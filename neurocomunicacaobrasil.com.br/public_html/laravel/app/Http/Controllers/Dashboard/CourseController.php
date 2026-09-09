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
        $this->authorize('create', Course::class);
        return view('dashboard.teacher.course.create', ['title' => 'Novo Curso']);
    }

    public function edit(string $uuid)
    {
        $course = Course::where('uuid', $uuid)->firstOrFail();
        $this->authorize('update', $course);
        return view('dashboard.teacher.course.edit', ['title' => 'Editar Curso', 'course' => $course]);
    }

    public function store(CourseRequest $request)
    {
        try {
            $data = $request->validated();
            $data['user_id'] = Auth::id();
            $data['certificate_enabled'] = $request->has('certificate_enabled');
            $data['price'] = $request->input('price') ?? 0;
            $data['payment_link'] = $request->input('payment_link') ?? '';

            foreach (['image_cover', 'image_banner', 'certificate_background'] as $field) {
                if ($request->hasFile($field)) {
                    $data[$field] = $this->uploadImage($request->file($field), $field);
                }
            }

            Course::create($data);

            return redirect()->route('course.index')->with('success', 'Curso criado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('course.index')->with('error', 'Erro ao criar o curso! ' . $e->getMessage());
        }
    }

    public function show(string $uuid)
    {
        $course = Course::where('uuid', $uuid)
            ->withCount('users')
            ->withCount('modules')
            ->with('modules.classrooms')
            ->with(['modules' => function ($query) {
                $query->withCount('classrooms')
                    ->with('classrooms');
            }])
            ->first();

        $this->authorize('view', $course);

        $enrolledStudents = User::whereHas('courses', function ($q) use ($course) {
            $q->where('course_id', $course->id);
        })->with('student')->get();

        $availableStudents = Student::with('user')
            ->whereDoesntHave('user.courses', function ($q) use ($course) {
                $q->where('course_id', $course->id);
            })
            ->get();

        return view('dashboard.teacher.course.course_show', [
            'title' => $course->title,
            'course' => $course,
            'enrolledStudents' => $enrolledStudents,
            'availableStudents' => $availableStudents,
        ]);
    }

    public function update(CourseRequest $request, string $uuid)
    {
        try {
            $course = Course::where('uuid', $uuid)->firstOrFail();
            $this->authorize('update', $course);

            $data = $request->validated();
            $data['certificate_enabled'] = $request->has('certificate_enabled');
            $data['price'] = $request->input('price') ?? 0;
            $data['payment_link'] = $request->input('payment_link') ?? '';

            foreach (['image_cover', 'image_banner', 'certificate_background'] as $field) {
                if ($request->hasFile($field)) {
                    $data[$field] = $this->uploadImage($request->file($field), $field);
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
            $this->authorize('delete', $course);

            foreach (['image_cover', 'image_banner', 'certificate_background'] as $field) {
                if (!empty($course->{$field}) && file_exists(public_path('storage/' . $course->{$field}))) {
                    unlink(public_path('storage/' . $course->{$field}));
                }
            }

            $course->delete();
            return redirect()->route('course.index')->with('success', 'Curso excluído com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('course.index')->with('error', 'Erro ao excluir o curso.');
        }
    }

    private function uploadImage($imageFile, $field)
    {
        $filename = $imageFile->hashName();
        $path = public_path('storage/courses');
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        $image = Image::read($imageFile);

        switch ($field) {
            case 'image_cover':
                $image->resize(600, 600);
                break;
            case 'image_banner':
                $image->resize(1920, 500);
                break;
            default:
                $image->resize(1200, 900);
                break;
        }

        $image->save($path . '/' . $filename);
        return 'courses/' . $filename;
    }
}
