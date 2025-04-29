<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function allUsers(){
        {
           $users = User::withCount('courses')->paginate(10);;
    
            $dados = [
                'title' => 'Cursos',
                'users' => $users,
            ];

            // dd($users, $users[1]->courses_count);
    
            return view('dashboard.admin.list_users', $dados);
        }
    }
}
