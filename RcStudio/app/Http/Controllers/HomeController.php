<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $data = [
            'title' => 'Home',
            'description' => 'Welcome to the home page of our application.',
            'keywords' => 'home, welcome, application',
            'content' => 'This is the content of the home page. Here you can find various resources and information about our application.'
        ];

        return view('pages.home_index', $data);
    }
}
