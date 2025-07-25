<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\TypeServiceRequest;
use App\Models\TypeService;
use Illuminate\Http\Request;

class TypeServiceController extends Controller
{
    public function index()
    {
        $dados = [
            'titlePage' => 'Tipo Serviço - Permuta Brasil',
            'bodyId' => 'dashboard',
            'bodyClass' => ''
        ];

        return view('pages.auth.dashboard.list.typeService', $dados);
    }

    public function create()
    {
        $dados = [
            'titlePage' => 'Tipo Serviço - Permuta Brasil',
            'bodyId' => 'dashboard',
            'bodyClass' => '',
            'fields' => [
                ['name' => 'type_service', 'label' => 'Tipo serviço', 'type' => 'text', 'formGroup' => 'col-12'],
            ]
        ];

        return view('pages.auth.dashboard.create.typeService', $dados);
    }

    public function store(TypeServiceRequest $request)
    {
        $data = $request->except('_token');
        $query = TypeService::create($data);
        
        if ($query) {
            return redirect()->route('dashboard.typeService.index')->with('message', 'Serviço criado com sucesso')->with('status', 'success');
        } else {
            return redirect()->route('dashboard.typeService.create')->with('message', 'Opss..., não foi possivel criar o serviço, tente novamente!')->with('status', 'erro');
        }
    }

    public function edit(string $uuid){
        $data = TypeService::where('uuid', $uuid)->first();

        $dados = [
            'titlePage' => 'Tipo Serviço - Permuta Brasil',
            'bodyId' => 'dashboard',
            'bodyClass' => '',
            'uuid' => $uuid,
            'fields' => [
                ['name' => 'type_service', 'label' => 'Tipo serviço', 'type' => 'text', 'formGroup' => 'col-12', 'value' => $data->type_service],
            ]
        ];

        return view('pages.auth.dashboard.update.typeService', $dados);
    }

    public function update(TypeServiceRequest $request, string $uuid){
        $data = $request->except('_token');
        $query = TypeService::where('uuid', $uuid)->first();
        $query->update($data);
        
        if ($query) {
            return redirect()->route('dashboard.typeService.index')->with('message', 'Serviço atualizado com sucesso')->with('status', 'success');
        } else {
            return redirect()->route('dashboard.typeService.create')->with('message', 'Opss..., não foi possivel atualizar o serviço, tente novamente!')->with('status', 'erro');
        }
    }
}
