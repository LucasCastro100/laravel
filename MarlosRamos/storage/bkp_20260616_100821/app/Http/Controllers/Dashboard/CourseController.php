<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::withCount('users')->get();

        $dados = [
            'title' => 'Gerencimanto dos cursos',
            'courses' => $courses,
        ];

        return view('dashboard.teacher.course.courses', $dados);
    }

    public function store(CourseRequest $request)
    {
        try {       
            $data = $request->except(['_token']);
            $data['user_id'] = Auth::user()->id;

            foreach (['image_cover', 'image_banner'] as $field) {
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
        $path = 'app/public/courses/';
        $image = Image::read($imageFile)->resize(300, 200);
        $image->save(storage_path($path . $filename));
        return 'courses/' . $filename;
    }

    public function show(Request $request)
    {
        $course = Course::where('uuid', $request->uuid)
            ->withCount('users')  // Contagem de usuários
            ->withCount('modules')  // Contagem de módulos
            ->with('modules.classrooms') // Carrega os módulos e as aulas associadas
            ->with(['modules' => function ($query) {
                $query->withCount('classrooms')  // Conta as aulas de cada módulo
                    ->with('classrooms');  // Carrega as aulas de cada módulo
            }])
            ->first();

        $dados = [
            'title' => $course->title,
            'course' => $course
        ];

        return view('dashboard.teacher.course.course_show', $dados);
    }

    public function update(CourseRequest $request, Course $course)
    {
        try {                    
            $course = Course::where('uuid', $request->uuid)->firstOrFail();
            $data = $request->except(['_token']);

            foreach (['image_cover', 'image_banner'] as $field) {
                if ($request->hasFile($field)) {
                    $data[$field] = $this->uploadImage($request->file($field), $request->title);
                }
            }

            $course->update($data);
            return redirect()->back()->with('success', 'Curso atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar o curso.');
        }
    }

    public function destroy(Request $request, Course $course)
    {
        try {
            $course = Course::where('uuid', $request->uuid)->first();
            $course->delete();
            return redirect()->route('course.index')->with('success', 'Curso excluído com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('course.index')->with('error', 'Erro ao excluir o curso.');
        }
    }
}
