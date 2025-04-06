<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class HomeController extends Controller
{
    public function index()
    {
        $dados = [
            'title' => 'Cursos',
            'courses' => Course::withCount('users')->get()
        ];

        return view('dashboard.admin.courses', $dados);
    }
}
