<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $dados = [
            'titlePage' => 'Plano - Permuta Brasil',
            'bodyId' => 'dashboard',
            'bodyClass' => '',        
        ];

        return view('pages.auth.dashboard.list.plan', $dados);
    }
}
