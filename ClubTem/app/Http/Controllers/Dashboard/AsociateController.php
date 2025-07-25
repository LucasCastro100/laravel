<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class AsociateController extends Controller
{
    public function index(){
        $query = new Client();
        $clients = $query->getAssociate();

        $dados = [
            'titlePage' => 'Perfil - Permuta Brasil',
            'bodyId' => 'dashboard',
            'bodyClass' => '',            
            'clients' => $clients
        ];        

        return view('pages.auth.dashboard.list.asociate', $dados);
    }
}
