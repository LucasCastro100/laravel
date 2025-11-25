<?php

namespace App\Http\Controllers\Dashboard;

use App\Helpers\DateHelper;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\Test;
use App\Models\TesteRepresentacional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{

    public function dashBoard()
    {
        $testWithLogin = Test::count();
        $testNotLogin = TesteRepresentacional::count();
        $courses = Course::where('user_id', Auth::user()->id)->count();
        $saudacao = DateHelper::greeting();
        $usuario = Auth::user()->name;

        $dados = [
            'title' => 'Painel do Professor',
            'testsWithLogin' => $testWithLogin,
            'testsNotLogin' => $testNotLogin,
            'couses' => $courses,
            'saudacao' => $saudacao,
            'usuario' => $usuario,
        ];

        return view('dashboard.teacher.dashboard', $dados);
    }

    public function myCourses()
    {
        $courses = Course::withCount('users')->where('user_id', Auth::user()->id)->get();

        $dados = [
            'title' => 'Meus Cursos',
            'courses' => $courses,
        ];

        return view('dashboard.teacher.course.courses', $dados);
    }

    public function myTests()
    {
        // $tests = Test::withCount('users')->where('user_id', Auth::user()->id)->get();
        $testWithLogin = Test::with('user')->orderBy('created_at', 'desc')->get();
        $testNotLogin = TesteRepresentacional::orderBy('created_at', 'desc')->get();

        $dados = [
            'title' => 'Meus testes',
            'testsWithLogin' => $testWithLogin,
            'testsNotLogin' => $testNotLogin,
        ];

        return view('dashboard.teacher.test.tests', $dados);
    }

    public function report(Request $request)
    {
        $query = TesteRepresentacional::orderBy('created_at', 'desc');
    
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }
    
        $testsNotLogin = $query->get();
    
        // Totais
        $totalPercent = [
            'V' => 0,
            'A' => 0,
            'C' => 0,
            'D' => 0,
        ];
    
        foreach ($testsNotLogin as $test) {
            $percent = $test->percentual;
    
            // Se banco for string antiga → converte
            if (!is_array($percent)) {
                $percent = json_decode($percent, true) ?? [];
            }
    
            foreach ($percent as $l => $v) {
                if (isset($totalPercent[$l])) {
                    $totalPercent[$l] += intval($v);
                }
            }
        }
    
        // Frequência PRIMARY
        $primaryCount = $testsNotLogin
            ->groupBy('primary')
            ->map->count()
            ->sortDesc();
    
        // Frequência SECONDARY
        $secondaryCount = $testsNotLogin
            ->groupBy('secondary')
            ->map->count()
            ->sortDesc();
    
        return view('dashboard.teacher.test.report', [
            'title'          => 'Relatório de testes do Professor',
            'date'           => $request->date,
            'testsNotLogin'  => $testsNotLogin,
            'totalPercent'   => $totalPercent,
            'primaryCount'   => $primaryCount,
            'secondaryCount' => $secondaryCount,
        ]);
    }
    
}
