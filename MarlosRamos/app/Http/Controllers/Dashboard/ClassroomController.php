<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\ClassroomUser;
use Illuminate\Http\Request;
use App\Services\YoutubeService;
use Illuminate\Support\Facades\Auth;

class ClassroomController extends Controller
{
    public function show(Request $request)
    {
        $user = Auth::user();

        $classroom = Classroom::with('module.course.modules.classrooms', 'comments.replies.user', 'comments.user')
            ->where('uuid', $request->uuid_classroom)
            ->firstOrFail();

        // Verifica se o usuário concluiu essa aula
        $completedAt = $classroom->users()
            ->where('user_id', $user->id)
            ->first()
            ?->pivot
            ?->completed_at;

        // Flag de aula concluída
        $isCompleted = !is_null($completedAt);

        // Todas as aulas do módulo atual, ordenadas
        $allClassrooms = $classroom->module->course->modules
            ->sortBy('id') // Ordena módulos por ID (ou 'order', se existir)
            ->flatMap(function ($module) {
                return $module->classrooms->sortBy('id'); // Ordena aulas por ID (ou 'order')
            })->values(); // Flatten e reindexa a coleção

        // Identifica próxima aula
        $currentIndex = $allClassrooms->search(function ($item) use ($classroom) {
            return $item->id === $classroom->id;
        });

        $previousClassroom = $allClassrooms->get($currentIndex - 1);
        $nextClassroom = $allClassrooms->get($currentIndex + 1);

        // Verifica se o usuário já completou outras aulas
        $classroomCompletions = $user->classrooms()
        ->wherePivot('completed_at', '!=', null)  // Filtrando para verificar se 'completed_at' não é null
        ->pluck('classroom_id') // Pega apenas os IDs das classrooms completadas
        ->toArray();

        // Parse da URL do vídeo
        $videoUrl = $classroom->video;
        parse_str(parse_url($videoUrl, PHP_URL_QUERY), $queryParams);
        $videoId = $queryParams['v'] ?? null;

        // Dados enviados à view
        $dados = [
            'title' => $classroom->title,
            'classroom_current' => $classroom,
            'module_current' => $classroom->module,
            'course' => $classroom->module->course,
            'modules' => $classroom->module->course->modules,
            'videoId' => $videoId,
            'comments' => $classroom->comments,
            'completedAt' => $completedAt,
            'isCompleted' => $isCompleted,
            'previousClassroom' => $previousClassroom,
            'nextClassroom' => $nextClassroom,
            'classroomCompletions' => $classroomCompletions,
        ];

        // dd($classroom);

        return view('dashboard.student.classroom.classroom_show', $dados);
    }

    public function store(Request $request, YoutubeService $youtube)
    {
        try {
            // Validação dos dados recebidos
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable',
                'video' => 'required|url',
                'module_id' => 'required|exists:modules,id',
            ], [
                'title.required' => 'O campo título é obrigatório.',
                'title.string' => 'O título deve ser uma string.',
                'title.max' => 'O título não pode ter mais de 255 caracteres.',                
                'video.required' => 'O campo vídeo é obrigatório.',
                'video.url' => 'Por favor, insira uma URL válida para o vídeo.',
                'module_id.required' => 'O módulo é obrigatório.',
                'module_id.exists' => 'O módulo selecionado não existe.',
            ]);

            // Extraindo o ID do vídeo a partir da URL
            $videoId = $youtube->extractVideoId($request->input('video'));

            if ($videoId) {
                // Extraindo a duração do vídeo
                $isoDuration = $youtube->getDuration($videoId);
            } else {
                return redirect()->back()->with('error', 'Não foi possível extrair o ID do vídeo.');
            }

            // Adicionando a duração ao array de dados validados
            $validated['duration'] = $isoDuration;

            // Criando a aula no banco de dados
            Classroom::create($validated);

            return redirect()->back()->with('success', 'Aula criada com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro!' . $e->getMessage());
        }
    }

    public function update(Request $request, string $uuid_classroom, YoutubeService $youtube)
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

            // Extraindo o ID do vídeo a partir da URL
            $videoId = $youtube->extractVideoId($request->input('video'));

            if ($videoId) {
                // Extraindo a duração do vídeo
                $isoDuration = $youtube->getDuration($videoId);
            } else {
                return redirect()->back()->with('error', 'Não foi possível extrair o ID do vídeo.');
            }

            // Adicionando a duração ao array de dados validados
            $validated['duration'] = $isoDuration;

            $classroom->update($validated);
            return redirect()->back()->with('success', 'Aula atualizada com sucesso!');
        } catch (\Exception $e) {
            // return redirect()->back()->with('error', 'Aula não encontrada!');
            return redirect()->back()->with('error', 'Erro ao atualziar a aula!');
        }
    }

    public function completeClassroom(Request $request, string $classroom_uuid)
    {
        try {
            $user = Auth::user();
            $classroom = Classroom::where('uuid', $classroom_uuid)->firstOrFail();

            // Verifica se a relação entre o usuário e a aula já existe
            $classroomUser = ClassroomUser::firstOrNew([
                'user_id' => $user->id,
                'classroom_id' => $classroom->id
            ]);

            // Marca a aula como concluída
            $classroomUser->completed_at = $classroomUser->completed_at ? null : now();
            $classroomUser->save();

            // Retorna sucesso para o front-end
            return redirect()->back()->with('success', 'Aula concluida com sucesso!');
        } catch (\Exception $e) {
            // Em caso de erro, retorna erro para o front-end
            return redirect()->back()->with('error', 'Erro ao concluir a aula!');
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
