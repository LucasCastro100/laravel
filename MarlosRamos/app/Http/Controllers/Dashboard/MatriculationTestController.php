<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\MatriculationTest;
use App\Models\Test;
use App\Models\User;
use Illuminate\Http\Request;

class MatriculationTestController extends Controller
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

    public function store(Request $request, string $test_uuid, string $user_uuid)
    {
        $test = Test::where('uuid', $test_uuid)->first();
        $user = User::where('uuid', $user_uuid)->first();

        try {
            MatriculationTest::create([
                'course_id' => $test->id,
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
