<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $dados = [
            'title' => 'Testes Representacionais',
            'questions' => config('questionsTest'),
        ];

        dd($dados['questions']);

        return view('dashboard.admin.tests', $dados);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Test $test)
    {
        //
    }

    public function edit(Test $test)
    {
        //
    }

    public function update(Request $request, Test $test)
    {
        //
    }

    public function destroy(Test $test)
    {
        //
    }
}
