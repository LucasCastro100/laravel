<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\MatriculationCourse;
use App\Models\User;
use Illuminate\Http\Request;

class MatriculationCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $course_uuid, string $user_uuid)
    {
        $course = Course::where('uuid', $course_uuid)->first();
        $user = User::where('uuid', $user_uuid)->first();

        try {
            MatriculationCourse::create([
                'course_id' => $course->id,
                'user_id' => $user->id,
            ]);

            return redirect()->back()->with('success', 'Matricula realizada com sucesso!');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Erro ao realizar a matricula!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
