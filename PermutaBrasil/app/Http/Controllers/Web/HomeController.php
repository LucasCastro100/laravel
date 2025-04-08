<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $dados = [
            'titlePage' => 'Inicio - Permuta Brasil',
            'bodyId' => 'web',
            'bodyClass' => 'home',
        ];

        return view('pages.web.home', $dados);
    }

    public function beAssociated()
    {
        $dados = [
            'titlePage' => 'Seja Associado - Permuta Brasil',
            'bodyId' => 'web',
            'bodyClass' => 'beAssociated',            
        ];

        return view('pages.web.beAssociated', $dados);
    }  
   
    public function howWorks()
    {
        $dados = [
            'titlePage' => 'Como funciona - Permuta Brasil',
            'bodyId' => 'web',
            'bodyClass' => 'howWorks',            
        ];

        return view('pages.web.howWorks', $dados);
    }   

    public function events()
    {
        $dados = [
            'titlePage' => 'Chamadas - Permuta Brasil',
            'bodyId' => 'web',
            'bodyClass' => 'events',            
        ];

        return view('pages.web.events', $dados);
    }

    public function contactUs()
    {
        $dados = [
            'titlePage' => 'Fale conosco - Permuta Brasil',
            'bodyId' => 'web',
            'bodyClass' => 'contactUs',            
        ];

        return view('pages.web.contactUs', $dados);
    }

    public function privacity()
    {
        $dados = [
            'titlePage' => 'Política de privacidade - Permuta Brasil',
            'bodyId' => 'web',
            'bodyClass' => 'privacity',            
        ];

        return view('pages.web.privacity', $dados);
    }    

    public function plan()
    {
        $dados = [
            'titlePage' => 'Convite - Permuta Brasil',
            'bodyId' => 'web',
            'bodyClass' => 'plan',            
        ];

        return view('pages.web.plan', $dados);
    }    


}
