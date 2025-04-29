<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Matriculation;
use App\Models\User;
use Illuminate\Http\Request;

class MatriculationController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request, string $course_uuid, string $user_uuid)
    {
        $course = Course::where('uuid', $course_uuid)->first();
        $user = User::where('uuid', $user_uuid)->first();

        try {
            Matriculation::create([
                'course_id' => $course->id,
                'user_id' => $user->id,
            ]);

            return redirect()->back()->with('success', 'Matricula realizada com sucesso!');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Erro ao realizar a matricula!');
        }
    }


    public function show(Matriculation $matriculation)
    {
        //
    }

    public function edit(Matriculation $matriculation)
    {
        //
    }

    public function update(Request $request, Matriculation $matriculation)
    {
        //
    }

    public function destroy(Matriculation $matriculation)
    {
        //
    }
}
