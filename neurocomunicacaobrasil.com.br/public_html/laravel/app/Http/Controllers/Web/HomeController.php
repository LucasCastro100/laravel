<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $dados = [
            'title' => 'Home - Pnl',            
        ];

        return view('web.home', $dados);
    }
}
