<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function dashBoard(){
        $dados = [
            'title' => 'Painel do Professor',            
        ];

        return view('dashboard.teacher.dashboard', $dados);
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Teacher $teacher)
    {
        //
    }

    public function edit(Teacher $teacher)
    {
        //
    }

    public function update(Request $request, Teacher $teacher)
    {
        //
    }

    public function destroy(Teacher $teacher)
    {
        //
    }
}
