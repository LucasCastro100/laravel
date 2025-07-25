<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Extract;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContractController extends Controller
{
    public function index(Request $request)
    {
        $exchange = new Extract();
        $extratcs = $exchange->addExtractsAllClients();

        $dados = [
            'titlePage' => 'Permuta - Permuta Brasil',
            'bodyId' => 'dashboard',
            'bodyClass' => '',        
            'theads' => ['#', 'CLIENTE', 'Nº NEGOCIAÇÕES', 'DÉBITO', 'CRÉDITO', 'SALDO', 'AÇÃO'],
            'tbodys' => $extratcs['exchanges'],
            'values' => $extratcs['values'],
        ];

        return view('pages.auth.dashboard.list.contract', $dados);
    }

    public function pdf(string $partnerID)
    {
        $newParnerId = $partnerID === 'null' ? 'null' : intval($partnerID);        
        $newNamePartner = $partnerID == 'null' ? 'Sem Registro' : User::find($newParnerId)->client->name;

        $extratc = new Extract();
        $extratcs = $extratc->pdf(Auth::user()->id, $newParnerId);
        $partners = [(Auth::user()->client->name), $newNamePartner];
        $userData = ['id' => Auth::user()->id, 'dados' => Auth::user()->client];

        $valueDebito = 0;
        $valueCredito = 0;        

        foreach($extratcs as  $extratc){
            $valueDebito +=  $extratc->service_provider_id == Auth::user()->id ? 0 : $extratc->value_exchange;
            $valueCredito += $extratc->service_provider_id == Auth::user()->id ? $extratc->value_exchange : 0;
        }

        $valueSaldo = $valueCredito - $valueDebito;

        $arrayPDF = [
            'extratcs' => $extratcs,
            'partners' => $partners,
            'userData' => $userData, 
            'values' => [
                'credito' => $valueCredito,
                'debito' => $valueDebito,
                'saldo' => $valueSaldo,
            ]
        ];                

        $pdf = Pdf::loadView('pages.auth.dashboard.pdf.contract', $arrayPDF)->setPaper('a4', 'landscape');

        return $pdf->download('contract.pdf');
    }
}
