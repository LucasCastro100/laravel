<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
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
            'title' => 'Cursos',
            'courses' => $courses,
        ];

        return view('dashboard.admin.courses', $dados);
    }

    public function store(Request $request)
    {
        try {
            // Validação
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'image.image' => 'O arquivo enviado não é uma imagem válida.',
                'image.mimes' => 'A imagem deve ser do tipo jpeg, png, jpg ou gif.',
                'image.max' => 'A imagem não pode ter mais de 2MB.',
            ]);

            // Coleta os dados
            $data = $request->only(['title', 'description']);

            if ($request->hasFile('image')) {
                // Recupera o arquivo da imagem
                $imageFile = $request->file('image');

                // Gera o nome do arquivo baseado no título do curso (sem espaços, minúsculo, e sem caracteres especiais)
                $filename = Str::slug(strtolower($request->title), '_') . '.' . $imageFile->getClientOriginalExtension();

                // Caminho para salvar a imagem
                $path = 'app/public/courses/';

                // Cria o redimensionamento da imagem e a salva
                $image = Image::read($imageFile)->resize(300, 200);
                $image->save(storage_path($path . $filename));
                // Storage::put($path . $filename, (string) $image->encode());

                // Salva o caminho da imagem no banco de dados
                $data['image'] = 'courses/' . $filename;
            }

            // Cria o curso no banco de dados
            Course::create($data);

            // Retorna com sucesso
            return redirect()->route('course.index')->with('success', 'Curso criado com sucesso!');
        } catch (\Exception $e) {
            // Em caso de erro, exibe a mensagem
            return redirect()->route('course.index')->with('error', 'Erro ao criar o curso: ' . $e->getMessage());
        }
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

        return view('dashboard.admin.course_show', $dados);
    }

    public function update(Request $request, Course $course)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'image.image' => 'O arquivo enviado não é uma imagem válida.',
                'image.mimes' => 'A imagem deve ser do tipo jpeg, png, jpg ou gif.',
                'image.max' => 'A imagem não pode ter mais de 2MB.',
            ]);

            // Coleta os dados
            $course = Course::where('uuid', $request->uuid)->firstOrFail();
            $data = $request->only(['title', 'description']);

            if ($request->hasFile('image')) {
                // Recupera o arquivo da imagem
                $imageFile = $request->file('image');

                // Gera o nome do arquivo baseado no título do curso (sem espaços, minúsculo, e sem caracteres especiais)
                $filename = Str::slug(strtolower($request->title), '_') . '.' . $imageFile->getClientOriginalExtension();

                // Caminho para salvar a imagem
                $path = 'app/public/courses/';

                // Cria o redimensionamento da imagem e a salva
                $image = Image::read($imageFile)->resize(300, 200);
                $image->save(storage_path($path . $filename));
                // Storage::put($path . $filename, (string) $image->encode());

                // Salva o caminho da imagem no banco de dados
                $data['image'] = 'courses/' . $filename;
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
