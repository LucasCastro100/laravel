<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QrCodeController extends Controller
{
    public function index()
    {
        $dados = [
            'titlePage' => 'Permuta - Permuta Brasil',
            'bodyId' => 'dashboard',
            'bodyClass' => ''
        ];

        return view('pages.auth.dashboard.list.qrCode', $dados);
    }
}
