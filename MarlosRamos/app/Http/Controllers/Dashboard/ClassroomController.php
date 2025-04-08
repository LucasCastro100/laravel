<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function show(Request $request)
    {
        $classroom = Classroom::with('module.course.modules')
            ->where('uuid', $request->uuid_classroom)
            ->firstOrFail();

        // $classroom: a aula atual
        // $classroom->module: o módulo da aula
        // $classroom->module->course: o curso ao qual o módulo pertence
        // $classroom->module->course->modules: todos os módulos do curso

        $course = $classroom->module->course;
        $modules = $classroom->module->course->modules;
        $videoUrl = $classroom->video;

        // Parse a URL e extrai a query string
        parse_str(parse_url($videoUrl, PHP_URL_QUERY), $queryParams);

        // Pega o ID do vídeo (parâmetro "v")
        $videoId = $queryParams['v'] ?? null;

        $dados = [
            'title' => $classroom->title,
            'classroom' => $classroom,
            'module_current' => $classroom->module,
            'course' => $classroom->module->course,
            'modules' => $classroom->module->course->modules,
            'videoId' => $videoId,
        ];

        return view('dashboard.admin.classroom_show', $dados);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'video' => 'required|url',
                'module_id' => 'required|exists:modules,id',
            ], [
                'title.required' => 'O campo título é obrigatório.',
                'title.string' => 'O título deve ser uma string.',
                'title.max' => 'O título não pode ter mais de 255 caracteres.',

                'description.string' => 'A descrição deve ser uma string.',

                'video.required' => 'O campo vídeo é obrigatório.',
                'video.url' => 'Por favor, insira uma URL válida para o vídeo.',

                'module_id.required' => 'O módulo é obrigatório.',
                'module_id.exists' => 'O módulo selecionado não existe.',
            ]);

            Classroom::create($validated);
            return redirect()->back()->with('success', 'Aula criada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, string $uuid_classroom)
    {
        try {
            $classroom = Classroom::where('uuid', $uuid_classroom)->firstOrFail();
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'video' => 'required|url',
                'module_id' => 'required|exists:modules,id',
            ], [
                'title.required' => 'O campo título é obrigatório.',
                'title.string' => 'O título deve ser uma string.',
                'title.max' => 'O título não pode ter mais de 255 caracteres.',

                'description.string' => 'A descrição deve ser uma string.',

                'video.required' => 'O campo vídeo é obrigatório.',
                'video.url' => 'Por favor, insira uma URL válida para o vídeo.',

                'module_id.required' => 'O módulo é obrigatório.',
                'module_id.exists' => 'O módulo selecionado não existe.',
            ]);

            $classroom->update($validated);
            return redirect()->back()->with('success', 'Aula atualizada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Aula não encontrada!');
        }
    }

    public function destroy(Request $request, string $uuid_classroom)
    {
        try {
            $classroom = Classroom::where('uuid', $uuid_classroom)->firstOrFail();
            $classroom->delete();
            return redirect()->back()->with('success', 'Aula deletada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Aula não encontrada!');
        }
    }
}
