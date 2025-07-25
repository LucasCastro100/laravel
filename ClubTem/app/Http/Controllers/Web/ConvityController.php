<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConvityRequest;
use App\Mail\Convity;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class ConvityController extends Controller
{
    public function index()
    {
        $dados = [
            'titlePage' => 'Convite - Permuta Brasil',
            'bodyId' => 'web',
            'bodyClass' => 'convity',
            'fields' => [
                ['name' => 'name', 'label' => 'NOME', 'type' => 'text', 'formGroup' => 'col-lg-6'],
                ['name' => 'enterprise', 'label' => 'EMPRESA', 'type' => 'text', 'formGroup' => 'col-lg-6', 'extract' => 'valueExchange'],
                ['name' => 'email', 'label' => 'E-MAIL', 'type' => 'text', 'formGroup' => 'col-lg-6'],
                ['name' => 'document', 'label' => 'CNPJ', 'type' => 'text', 'formGroup' => 'col-lg-3 col-md-6', 'mask' => 'cnpj'],                
                ['name' => 'whats', 'label' => 'WHATSAPP', 'type' => 'text', 'formGroup' => 'col-lg-3 col-md-6', 'mask' => 'tel'],
                ['name' => 'indication', 'label' => 'ONDE CONHECEU A PLATAFORMA', 'type' => 'text', 'formGroup' => 'col-lg-12'],
            ]
        ];

        return view('pages.web.convity', $dados);
    }

    public function store(ConvityRequest $request)
    {        
        $data = $request->except('_token');

        $detalhes = [
            'name' => $data['name'],
            'enterprise' => $data['enterprise'],
            'document' => $data['document'],
            'email' => $data['email'],
            'whats' => $data['whats'],
            'indication' => $data['indication']
        ];

        try {
            Mail::mailer('smtp')->to('plataformapermutabrasil@gmail.com')->send(new Convity($detalhes));
            return redirect()->route('convity.index')->with('message', 'E-mail enviado com sucesso!')->with('status', 'success');
        } catch (\Exception $e) {
            return redirect()->route('convity.index')->with('message', 'Falha ao enviar o e-mail. Por favor, tente novamente.')->with('status', 'erro');
        }
    }
}
