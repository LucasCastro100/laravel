<?php

namespace App\Http\Controllers\Web;

use App\Models\TesteRepresentacional;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TesteRepresentacionalController extends Controller
{
    public function index()
    {
        $dados = [
            'title' => 'Testes Representacionais',
            'questions' => config('questionsTest'),
        ];

        return view('web.teste', $dados);
    }

    // public function store(Request $request)
    // {
    //     try {
    //         // 1️⃣ Validação dos campos obrigatórios
    //         $validated = $request->validate([
    //             'name'  => 'required|string|max:255',
    //             'email' => 'required|email|max:255',
    //             'phone' => 'required|string|max:20',
    //         ], [
    //             'name.required'  => 'O nome é obrigatório.',
    //             'email.required' => 'O e-mail é obrigatório.',
    //             'email.email'    => 'Informe um e-mail válido.',
    //             'phone.required' => 'O telefone é obrigatório.',
    //         ]);

    //         // 2️⃣ Separa dados pessoais
    //         $name = $validated['name'];
    //         $email = $validated['email'];
    //         $phone = $validated['phone'];

    //         // 3️⃣ Remove esses campos e tokens do resto dos dados (as respostas)
    //         $data = $request->except(['_token', '_method', 'name', 'email', 'phone']);

    //         // 4️⃣ Inicializa pontuação por canal
    //         $scores = ['V' => 0, 'A' => 0, 'C' => 0, 'D' => 0];

    //         // 5️⃣ Calcula pontuação
    //         foreach ($data as $key => $value) {
    //             $channel = substr($key, -1); // Ex: Q1_V -> 'V'
    //             if (isset($scores[$channel])) {
    //                 $scores[$channel] += (int)$value;
    //             }
    //         }

    //         // 6️⃣ Calcula percentuais
    //         $total = array_sum($scores);
    //         $percentual = [];
    //         foreach ($scores as $ch => $pontos) {
    //             $percentual[$ch] = $total > 0 ? round(($pontos / $total) * 100, 1) : 0;
    //         }

    //         // 7️⃣ Identifica perfis
    //         arsort($scores);
    //         $primary = array_key_first($scores);
    //         $secondary = array_keys($scores)[1] ?? null;

    //         // 8️⃣ Salva no banco
    //         $test = new TesteRepresentacional();
    //         $test->name = $name;
    //         $test->email = $email;
    //         $test->phone = $phone;
    //         $test->answers = $data;
    //         $test->scores = $scores;
    //         $test->percentual = $percentual;
    //         $test->primary = $primary;
    //         $test->secondary = $secondary;
    //         $test->save();

    //         // 9️⃣ Redireciona
    //         return redirect()
    //             ->route('teste.representacional.show', $test->uuid)
    //             ->with([
    //                 'alert.type' => 'success',
    //                 'alert.message' => 'Teste salvo com sucesso!'
    //             ]);
    //     } catch (\Illuminate\Validation\ValidationException $e) {
    //         // Captura erro de validação e retorna com mensagens
    //         return redirect()->back()
    //             ->withErrors($e->validator)
    //             ->withInput();
    //     } catch (\Exception $e) {
    //         // Captura outros erros
    //         return redirect()->back()
    //             ->with('error', 'Erro ao salvar o teste: ' . $e->getMessage());
    //     }
    // }

    public function store(Request $request)
    {
        try {
            // 1️⃣ Validação dos campos obrigatórios (dados pessoais)
            $validated = $request->validate([
                'name'  => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
            ], [
                'name.required'  => 'O nome é obrigatório.',
                'email.required' => 'O e-mail é obrigatório.',
                'email.email'    => 'Informe um e-mail válido.',
                'phone.required' => 'O telefone é obrigatório.',
            ]);

            // 2️⃣ Separa dados pessoais
            $name = $validated['name'];
            $email = $validated['email'];
            $phone = $validated['phone'];

            // 3️⃣ Remove esses campos e tokens do resto dos dados (as respostas)
            $data = $request->except(['_token', '_method', 'name', 'email', 'phone']);

            // 4️⃣ Valida se todas as perguntas foram respondidas
            foreach ($data as $key => $value) {
                if ($value === null || $value === '') {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', "Você precisa preencher todas as respostas antes de enviar o teste.");
                }
            }

            // 5️⃣ Inicializa pontuação por canal
            $scores = ['V' => 0, 'A' => 0, 'C' => 0, 'D' => 0];

            // 6️⃣ Calcula pontuação
            foreach ($data as $key => $value) {
                $channel = substr($key, -1); // Ex: Q1_V -> 'V'
                if (isset($scores[$channel])) {
                    $scores[$channel] += (int)$value;
                }
            }

            // 7️⃣ Calcula percentuais
            $total = array_sum($scores);
            $percentual = [];
            foreach ($scores as $ch => $pontos) {
                $percentual[$ch] = $total > 0 ? round(($pontos / $total) * 100, 1) : 0;
            }

            // 8️⃣ Identifica perfis
            arsort($scores);
            $primary = array_key_first($scores);
            $secondary = array_keys($scores)[1] ?? null;

            // 9️⃣ Salva no banco
            $test = new TesteRepresentacional();
            $test->name = $name;
            $test->email = $email;
            $test->phone = $phone;
            $test->answers = $data;
            $test->scores = $scores;
            $test->percentual = $percentual;
            $test->primary = $primary;
            $test->secondary = $secondary;
            $test->save();

            // 🔟 Redireciona com sucesso
            return redirect()
                ->route('teste.representacional.show', $test->uuid)
                ->with([
                    'alert.type' => 'success',
                    'alert.message' => 'Teste salvo com sucesso!'
                ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Captura erro de validação e retorna com mensagens
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            // Captura outros erros
            return redirect()->back()
                ->with('error', 'Erro ao salvar o teste: ' . $e->getMessage());
        }
    }

    public function show(Request $request)
    {

        $test = TesteRepresentacional::where('uuid', $request->uuid)
            ->latest()
            ->first();

        $perfil = config('relatorios');

        $perfilUsuario = [
            $perfil[$test->primary] ?? null,
            $perfil[$test->secondary] ?? null,
        ];

        $dados = [
            'title' => 'Relatório de Perfil Representacional',
            'test' => $test,
            'perfilUsuario' => $perfilUsuario,
            'answers' => $test->answers,
        ];

        return view('web.result', $dados);
    }
}
