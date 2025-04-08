<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExchangeRequest;
use App\Models\Client;
use App\Models\Extract;
use App\Models\User;
use App\Models\Connection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ExtractController extends Controller
{
    public function index()
    {
        $dados = [
            'titlePage' => 'Permuta - Permuta Brasil',
            'bodyId' => 'dashboard',
            'bodyClass' => ''
        ];

        return view('pages.auth.dashboard.list.extracts', $dados);
    }

    public function create()
    {
        $clients = new Client();
        $clientsFromExtract = $clients->getAllClientsFromExtracts(Auth::user()->id, Auth::user()->role->value);
        
        $dados = [
            'titlePage' => 'Permuta - Permuta Brasil',
            'bodyId' => 'dashboard',
            'bodyClass' => '',
            'fields' => [
                ['name' => 'date_service', 'label' => 'Data', 'type' => 'date', 'formGroup' => 'col-xl-4 col-sm-6'],
                ['name' => 'value_exchange', 'label' => 'Valor permuta', 'type' => 'text', 'formGroup' => 'col-xl-4 col-sm-6', 'extract' => 'valueExchange'],
                ['name' => 'service_product', 'label' => 'Serviço | Produto', 'type' => 'text', 'formGroup' => 'col-xl-4 col-sm-6'],
                // ['name' => 'taker_email', 'label' => 'Comprador', 'type' => 'text', 'formGroup' => 'col-xl-4 col-sm-6'],
                ['name' => 'taker_name', 'label' => 'Comprador', 'dataList' => true, 'typeDataList' => 'text', 'optionDataList' => $clientsFromExtract, 'list' => 'searchName', 'formGroup' => 'col-xl-4 col-sm-6'],
                ['name' => 'description', 'label' => 'Descrição', 'textarea' => true, 'formGroup' => '']
            ]
        ];

        return view('pages.auth.dashboard.create.extracts', $dados);
    }

    public function store(ExchangeRequest $request)
    {

        $clientnName = Client::where('name', $request->taker_name)->first();
        $service_taker = $clientnName != null ? $clientnName->user->id : null;               
        
        $transaction_financial = $request->value_total - $request->value_exchange;

        $userID = Auth::user()->id;
        $data = array_merge($request->except('_token'), ['service_provider_id' => $userID, 'service_taker_id' => $service_taker, 'transaction_financial' => $transaction_financial]);

        $connection = new Connection();
        $chek = $connection->createConnection($service_taker);

        $query = Extract::create($data);

        if ($chek['check']) {
            $queryConecction = Connection::create([
                'user_id' => $userID,
                'connected_user_id' => $service_taker,
            ]);

            if ($queryConecction) {
                if ($query) {
                    return redirect()->route('dashboard.extract.index')->with('message', 'Permuta criada com sucesso')->with('status', 'success');
                } else {
                    return redirect()->route('dashboard.extract.create')->with('message', 'Opss..., não foi possivel criar a permuta, tente novamente!')->with('status', 'erro');
                }
            } else {
                return redirect()->back()->with('message', 'OPSSS... Falha ao realizar a conexão!')->with('status', 'erro');
            }
        } else {
            return redirect()->back()->with('message', 'Limite de conexões únicas atingido.')->with('status', 'erro');
        }
    }

    public function show(string $uuid)
    {
        $exchange = new Extract();
        $data = $exchange->getExchange($uuid);

        $dados = [
            'titlePage' => 'Permuta - Permuta Brasil',
            'bodyId' => 'dashboard',
            'bodyClass' => '',
            'list' => $data,
            'fields' => [
                ['name' => 'date_service', 'label' => 'Data', 'type' => 'date', 'formGroup' => 'col-xl-4 col-sm-6', 'value' => isset($data->date_service) ? date_format(date_create($data->date_service), 'Y-m-d') : '', 'readonly' => true],
                ['name' => 'value_exchange', 'label' => 'Valor permuta', 'type' => 'text', 'formGroup' => 'col-xl-4 col-sm-6', 'value' => $data->value_exchange, 'readonly' => true],
                ['name' => 'service_product', 'label' => 'Serviço | Produto', 'type' => 'text', 'formGroup' => 'col-xl-4 col-sm-6', 'value' => $data->service_product, 'readonly' => true],
                ['name' => 'taker_name', 'label' => 'Comprador', 'type' => 'text', 'formGroup' => 'col-xl-4 col-sm-6', 'value' => isset($data->serviceTaker) ? $data->serviceTaker->name : '', 'readonly' => true],
                ['name' => 'description', 'label' => 'Descrição', 'textarea' => true, 'formGroup' => '', 'areatext' => $data->description, 'readonly' => true,]
            ]
        ];

        return view('pages.auth.dashboard.show.extracts', $dados);
    }

    public function edit(string $uuid)
    {
        $exchange = new Extract();
        $data = $exchange->getExchange($uuid);

        $dados = [
            'titlePage' => 'Permuta - Permuta Brasil',
            'bodyId' => 'dashboard',
            'bodyClass' => '',
            'list' => $data,
            'uuid' => $data->uuid,
            'fields' => [
                ['name' => 'date_service', 'label' => 'Data', 'type' => 'date', 'formGroup' => 'col-xl-4 col-sm-6', 'value' => isset($data->date_service) ? date_format(date_create($data->date_service), 'Y-m-d') : '', 'readonly' => true],
                ['name' => 'value_exchange', 'label' => 'Valor permuta', 'type' => 'text', 'formGroup' => 'col-xl-4 col-sm-6', 'value' => $data->value_exchange, 'readonly' => true],
                ['name' => 'service_product', 'label' => 'Serviço | Produto', 'type' => 'text', 'formGroup' => 'col-xl-4 col-sm-6', 'value' => $data->service_product, 'readonly' => false],
                ['name' => 'taker_email', 'label' => 'Comprador', 'type' => 'text', 'formGroup' => 'col-xl-4 col-sm-6', 'value' => isset($data->serviceTaker) ? $data->serviceTaker->email : '', 'readonly' => true],
                ['name' => 'description', 'label' => 'Descrição', 'textarea' => true, 'formGroup' => '', 'areatext' => $data->description, 'readonly' => false,]
            ]
        ];

        return view('pages.auth.dashboard.update.extracts', $dados);
    }

    public function update(Request $request, string $uuid)
    {
        $emailtaker = User::where('email', $request->taker_email)->first();
        $service_taker = $emailtaker != null ? $emailtaker->id : null;

        $userID = Auth::user()->id;
        $data = array_merge($request->except('_token', '_method', 'taker_email'), ['service_taker_id' => $service_taker]);
        $query = Extract::where('uuid', $uuid);
        $query->update($data);

        if ($query) {
            return redirect()->back()->with('message', 'Permuta atualizada com sucesso')->with('status', 'success');
        } else {
            return redirect()->back()->with('message', 'Opss..., não foi possivel atualizar a permuta!')->with('status', 'erro');
        }
    }

    public function active(Request $request, string $uuid)
    {

        $query = Extract::where('uuid', $uuid)->first();

        if ($query && $query->trashed()) {
            $query->restore();
            return redirect()->back()->with('message', 'Permuta ativada com sucesso')->with('status', 'success');
        } else {
            return redirect()->back()->with('message', 'Opss..., não foi possivel ativar a permuta!')->with('status', 'erro');
        }
    }

    public function destroy(string $uuid)
    {
        $query = Extract::where('uuid', $uuid)->first();
        if ($query->delete()) {
            return redirect()->route('dashboard.extract.index')->with('message', 'Permuta desativada com sucesso')->with('status', 'success');
        } else {
            return redirect()->route('dashboard.extract.index')->with('message', 'Ops..., não foi possivel ativar a permuta, tente novamente!')->with('status', 'erro');
        }
    }

    public function pdf(string $uuid)
    {
        $extratc = new Extract();
        $extratcs = $extratc->getExchange($uuid);

        $partners = [$extratcs->profileProvider->name, $extratcs->profileTaker->name];

        $valueDebito =  $extratcs->service_provider_id == Auth::user()->id ? 0 : $extratcs->value_exchange;
        $valueCredito = $extratcs->service_provider_id == Auth::user()->id ? $extratcs->value_exchange : 0;

        $valueSaldo = $valueCredito - $valueDebito;

        $arrayPDF = [
            'extratcs' => $extratcs,
            'partners' => $partners,
            'values' => [
                'credito' => $valueCredito,
                'debito' => $valueDebito,
                'saldo' => $valueSaldo,
            ]
        ];

        $pdf = Pdf::loadView('pages.auth.dashboard.pdf.extract', $arrayPDF)->setPaper('a4', 'landscape');

        return $pdf->download('extract.pdf');
    }
}
