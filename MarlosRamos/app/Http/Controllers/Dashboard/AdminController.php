<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function allUsers(){
        {
           $users = User::where('role', '<', 1)->withCount('matriculations')->paginate(10);
    
            $dados = [
                'title' => 'Usuários',
                'users' => $users,
            ];
                
            return view('dashboard.admin.list_users', $dados);
        }
    }
}
