<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeEmailRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ClientRequest;
use App\Mail\ChangeEmail;
use App\Mail\ChangePassword;
use App\Models\City;
use App\Models\Client;
use App\Models\Mails\Mailer;
use App\Models\State;
use App\Models\TypeService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Livewire\Livewire;

class ClientController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user['client'] = $user->client;

        $states = new State();
        $state = $states->getAll();

        $services = new TypeService();
        $service = $services->getAll();

        if (Auth::user()->role->value == 1) {
            $maxConections = 3;
        } elseif (Auth::user()->role->value == 2) {
            $maxConections = 6;
        }

        $dados = [
            'titlePage' => 'Perfil - Permuta Brasil',
            'bodyId' => 'dashboard',
            'bodyClass' => '',
            'fields' => [
                ['name' => 'name', 'label' => 'Nome', 'type' => 'text', 'formGroup' => 'col-xl-6', 'value' => $user->client->name ?? '', 'mask' => ''],
                ['name' => 'responsible', 'label' => 'Responsável', 'type' => 'text', 'formGroup' => 'col-xl-6', 'value' => $user->client->responsible ?? '', 'mask' => ''],
                ['name' => 'cnpj', 'label' => 'Cnpj', 'type' => 'text', 'formGroup' => 'col-xl-4 col-lg-6 ', 'value' => $user->client->cnpj ?? '', 'mask' => 'cnpj'],
                ['name' => 'whatsapp', 'label' => 'Whatsapp', 'type' => 'text', 'formGroup' => 'col-xl-4 col-lg-6', 'value' => $user->client->whatsapp ?? '', 'mask' => 'tel'],
                ['name' => 'instagram', 'label' => 'Instagram', 'type' => 'text', 'formGroup' => 'col-xl-4 col-lg-6', 'value' => $user->client->instagram ?? '', 'mask' => ''],
                ['name' => 'state_id', 'label' => 'Estado', 'options' => true, 'optionsGroup' => $state, 'formGroup' => 'col-xl-4 col-lg-6',  'value' => $user->client->state_id ?? ''],
                ['name' => 'city_id', 'label' => 'Cidade', 'dataList' => true, 'typeDataList' => 'text', 'list' => 'searchCity', 'formGroup' => 'col-xl-4 col-lg-6',  'value' => $user->client->city->city ?? ''],
                ['name' => 'type_service_id', 'label' => 'Serviço', 'options' => true, 'optionsGroup' => $service, 'formGroup' => 'col-xl-4 col-lg-6',  'value' => $user->client->type_service_id ?? ''],
                ['name' => 'photo', 'label' => 'Foto', 'type' => 'file', 'formGroup' => 'col-xl-4 col-lg-6', 'value' => '', 'mask' => ''],
            ],
        ];

        if (Auth::user()->role->value > 0) {
            $dados['fields'][] = ['name' => 'associate', 'label' => 'Associado', 'options' => true, 'optionsGroup' => [['value' => 0, 'name' => 'Não'], ['value' => 1, 'name' => 'Sim']], 'formGroup' => 'col-xl-4 col-lg-6',  'value' => $user->client->associate ?? 0];

            $dados['fields'][] = ['name' => 'description', 'label' => 'Descrição', 'textarea' => true, 'formGroup' => '', 'areatext' => $user->client->description ?? '', 'mask' => ''];
        }

        if ($user->client == null) {
            $view = 'pages.auth.dashboard.create.client';
        } else {
            $view = 'pages.auth.dashboard.update.client';
        }

        return view($view, $dados);
    }

    public function store(ClientRequest $request)
    {
        $userID = Auth::user()->id;

        $data = array_merge($request->except('_token', 'photo', 'city_id'), ['user_id' => $userID]);
        $cityID = City::where('city', $request->city_id)->first();

        $file = $request->file('photo');

        if ($file) {
            $user = strtolower(str_replace(' ', '_', $request->name));
            $extension = $file->getClientOriginalExtension();
            $fakeName = $user . '.' . $extension;

            if (!$file->storeAs('img/users', $fakeName, 'public')) {
                return redirect()
                    ->route('dashboard.client.index')
                    ->with('message', 'Opss..., erro ao enviar a imagem!')
                    ->with('status', 'error');
            }

            $data['photo'] = $fakeName;
            $data['city_id'] = $cityID->id;
        }

        $data['city_id'] = $cityID->id;

        $query = Client::create($data);
        if ($query) {
            return redirect()->route('dashboard.client.index')->with('message', 'Perfil criado com sucesso')->with('status', 'success');
        } else {
            return redirect()->route('dashboard.client.index')->with('message', 'Opss..., não foi possível criar o perfil, tente novamente!')->with('status', 'error');
        }
    }


    public function update(ClientRequest $request, string $uuid)
    {
        $query = Client::where('uuid', $uuid)->first();

        $user = strtolower(str_replace(' ', '_', $request->name));
        $file = $request->file('photo');

        $cityID = City::where('city', $request->city_id)->first();

        if ($file) {
            $extension =  $file->getClientOriginalExtension();
            $fakeName =  $user . '.' . $extension;
            $data = $request->except('_token', 'photo', 'city_id');
            $data['photo'] = $fakeName;
            $data['city_id'] = $cityID->id;

            if (!$file->storeAs('img/users', $fakeName, 'public')) {
                return redirect()
                    ->route('dashboard.client.index')
                    ->with('message', 'Opss..., erro ao enviar a imagem!')
                    ->with('status', 'error');
            }
        } else {
            $data = $request->except('_token', 'photo', 'city_id');
            $data['city_id'] = $cityID->id;
        }

        if ($query->update($data)) {
            return redirect()->route('dashboard.client.index')->with('message', 'Perfil atualizado com sucesso')->with('status', 'success');
        } else {
            return redirect()->route('dashboard.client.index')->with('message', 'Opss..., não foi possivel atualizar o perfil!')->with('status', 'erro');
        }
    }

    public function sendMsgChange($type)
    {
        $user = User::where('id', Auth::user()->id)->first();
        $token = Str::random(32);

        $user->update([
            'email_change_token' => $token
        ]);

        if ($type === 'email') {
            $link = URL::temporarySignedRoute(
                'dashboard.client.getChangeEmail',
                now()->addMinutes(5),
                ['token' => $token]
            );
            $mailable = new ChangeEmail($link);
        } elseif ($type === 'password') {
            $link = URL::temporarySignedRoute(
                'dashboard.client.getChangePassword',
                now()->addMinutes(5),
                ['token' => $token]
            );
            $mailable = new ChangePassword($link);
        } else {
            return redirect()->route('dashboard.client.index')->with('message', 'Tipo inválido.')->with('status', 'erro');
        }

        try {
            Mail::mailer('smtp')->to(Auth::user()->email)->send($mailable);
            return redirect()->route('dashboard.client.index')->with('message', 'E-mail enviado com sucesso!')->with('status', 'success');
        } catch (\Exception $e) {
            return redirect()->route('dashboard.client.index')->with('message', 'Falha ao enviar o e-mail. Por favor, tente novamente.')->with('status', 'erro');
        }
    }

    // Chamadas para as funções
    public function sendMsgChangeEmail()
    {
        return $this->sendMsgChange('email');
    }

    public function sendMsgChangePassword()
    {
        return $this->sendMsgChange('password');
    }

    public function getChange(Request $request, $type)
    {
        $token = $request->token;
        $user = User::where('email_change_token', $token)->first();

        $dados = [
            'token' => $token,
            'user' => '',
            'check' => false
        ];

        if ($request->hasValidSignature() && $user != null) {
            $dados['check'] = true;
            $dados['user'] = $user->client->name;
        }

        if ($type === 'email') {
            $dados['titlePage'] = 'Altera E-mail - Permuta Brasil';
            $dados['fields'] = [
                ['name' => 'email', 'label' => 'E-mail', 'type' => 'text', 'formGroup' => ''],
            ];
            $view = 'pages.auth.dashboard.update.changeEmail';
        } elseif ($type === 'password') {
            $dados['titlePage'] = 'Altera Senha - Permuta Brasil';
            $dados['fields'] = [
                ['name' => 'password', 'label' => 'Senha', 'type' => 'password', 'formGroup' => ''],
            ];
            $view = 'pages.auth.dashboard.update.changePassword';
        } else {
            return redirect()->route('dashboard.client.index')->with('message', 'Tipo de mudança inválido.')->with('status', 'erro');
        }

        return view($view, $dados);
    }

    public function getChangeEmail(Request $request)
    {
        return $this->getChange($request, 'email');
    }

    public function getChangePassword(Request $request)
    {
        return $this->getChange($request, 'password');
    }

    public function setChangeEmail(ChangeEmailRequest $request, string $token)
    {
        $user = User::where('email_change_token', $token)->first();
        $mail = $request->except('_token', '_method');

        $user->update($mail);

        if ($user) {
            return redirect()->route('login')->with('message', 'E-mail atualizado com sucesso!')->with('status', 'success');
        } else {
            return redirect()->back()->with('message', 'Opss..., não foi possivel atualizar o e-mail!')->with('status', 'erro');
        }
    }

    public function setChangePassword(ChangePasswordRequest $request, string $token)
    {
        $user = User::where('email_change_token', $token)->first();
        $password = $request->except('_token', '_method');

        $user->update($password);

        if ($user) {
            return redirect()->route('login')->with('message', 'Senha atualizada com sucesso!')->with('status', 'success');
        } else {
            return redirect()->back()->with('message', 'Opss..., não foi possivel atualizar a senha!')->with('status', 'erro');
        }
    }
}
