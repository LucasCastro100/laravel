<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function create(Request $request, $uuid_course)
    {
        $course = Course::where('uuid', $uuid_course)->firstOrFail();
        return view('dashboard.teacher.module.create', ['title' => 'Novo Módulo', 'course' => $course]);
    }

    public function edit(Request $request, $uuid_module)
    {
        $module = Module::with('course')->where('uuid', $uuid_module)->firstOrFail();
        return view('dashboard.teacher.module.edit', ['title' => 'Editar Módulo', 'module' => $module]);
    }

    public function store(Request $request, $courseUuid)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ], [
            'title.required' => 'O título é obrigatório.',
            'title.max' => 'O título não pode ter mais de 255 caracteres.',
        ]);

        $course = Course::where('uuid', $courseUuid)->firstOrFail();
        $course->modules()->create($validated);

        return redirect()->route('course.show', ['uuid' => $courseUuid])->with('success', 'Módulo criado com sucesso!');
    }

    public function update(Request $request, $moduleUuid)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ], [
            'title.required' => 'O título é obrigatório.',
            'title.max' => 'O título não pode ter mais de 255 caracteres.',
        ]);

        $module = Module::with('course')->where('uuid', $moduleUuid)->firstOrFail();
        $module->update($validated);

        return redirect()->route('course.show', ['uuid' => $module->course->uuid])->with('success', 'Módulo atualizado com sucesso!');
    }

    public function destroy($moduleUuid)
    {
        try {
            $module = Module::where('uuid', $moduleUuid)->firstOrFail();
            $module->delete();
            return redirect()->back()->with('success', 'Módulo deletado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir o modulo.');
        }
    }
}
