<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function store(Request $request, $courseUuid)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $course = Course::where('uuid', $courseUuid)->firstOrFail();
            $module = $course->modules()->create($validated);

            return redirect()->back()->with('success', 'Módulo criado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao criar o modulo!');
        }
    }

    public function update(Request $request, $moduleUuid)
    {
        try {
            $module = Module::where('uuid', $moduleUuid)->firstOrFail();
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $module->update($validated);
            return redirect()->back()->with('success', 'Módulo atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar o modulo.');
        }
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
