<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ConectionTypeServiceController extends Controller
{
    public function index(){
        $dados = [
            'titlePage' => 'Conexões - Permuta Brasil',
            'bodyId' => 'dashboard',
            'bodyClass' => 'conectionsService',        
        ];

        return view('pages.auth.dashboard.list.conectionService', $dados);
    }

    public function update(Request $request, $uuid){
        $userUUID = $uuid;
        $data = $request->except('_token', '_method', 'conections');
        
        $user = Client::where('uuid', $userUUID)->first();

        $data['connected_type_services'] = json_decode($data['connected_type_services'], true);
        sort($data['connected_type_services']);

        $user->update($data);

        if($user){
            return redirect()->back()->with('message', 'Prospecção atualizada com sucesso')->with('status', 'success');
        } else {
            return redirect()->back()->with('message', 'Opss..., não foi possivel atualizar a prospecção!')->with('status', 'erro');
        }
    }
}
