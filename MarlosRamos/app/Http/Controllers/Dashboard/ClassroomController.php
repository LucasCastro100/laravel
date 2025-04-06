<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function store(Request $request)
    {        
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'nullable|string',
                'video' => 'required|url',
                'module_id' => 'required|exists:modules,id',
            ], [
                'title.required' => 'O campo título é obrigatório.',
                'title.string' => 'O título deve ser uma string.',
                'title.max' => 'O título não pode ter mais de 255 caracteres.',
                
                'content.string' => 'A descrição deve ser uma string.',
                
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

    public function update(Request $request, string $classroomUuid)
    {
        try {
            $classroom = Classroom::where('uuid', $classroomUuid)->firstOrFail();

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'nullable|string',
                'video' => 'required|url',
                'module_id' => 'required|exists:modules,id',
            ]);

            $classroom->update($validated);
            return redirect()->rback()->with('success', 'Aula atualizada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Aula não encontrada!');
        }
    }
    
    public function destroy(Request $request, string $classroomUuid)
    {
        try {
            $classroom = Classroom::where('uuid', $classroomUuid)->firstOrFail();
            $classroom->delete();
            return redirect()->back()->with('success', 'Aula deletada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Aula não encontrada!');
        }
    }
}
