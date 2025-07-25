<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Connection;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $connection = new Connection();
        $limits = $connection->createConnection();
        
        $notices = Auth::user()->role->value < 3 ? Message::whereJsonContains('permission_level', (string)Auth::user()->role->value)->paginate(10) : Message::paginate(10);

        $interests = Client::whereJsonContains('connected_type_services', (string)Auth::user()->client->type_service_id)->where('user_id', '<>', Auth::user()->id)->orderBy('name', 'asc')->paginate(10);

        $usersConnections = $connection->usersConections();

        $getAllclients = new Client();
        $clients = $getAllclients->getAll();

        $dados = [
            'titlePage' => 'DashBoard - Permuta Brasil',
            'bodyId' => 'dashboard',
            'bodyClass' => '',
            'connection' => $limits,
            'interests' => $interests,
            'notices' => $notices,
            'connectionUsers' => $usersConnections,
            'clients' => $clients,
        ];

        return view('pages.auth.dashboard.list.home', $dados);
    }

    public function usersActivy()
    {
        $dados = [
            'titlePage' => 'DashBoard - Permuta Brasil',
            'bodyId' => 'dashboard',
            'bodyClass' => '',
        ];

        return view('pages.auth.dashboard.list.usersActivy', $dados);
    }

    public function notPermission()
    {
        $dados = [
            'titlePage' => 'Sem Permissão - Permuta Brasil',
            'bodyId' => 'dashboard',
            'bodyClass' => '',
        ];

        return view('pages.auth.dashboard.error.notPermission', $dados);
    }

    public function notProfile()
    {
        $dados = [
            'titlePage' => 'Sem Perfil - Permuta Brasil',
            'bodyId' => 'dashboard',
            'bodyClass' => '',
        ];

        return view('pages.auth.dashboard.error.notProfile', $dados);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
