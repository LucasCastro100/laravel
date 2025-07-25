<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoticeRequest;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {

        $dados = [
            'titlePage' => 'Avisos - Permuta Brasil',
            'bodyId' => 'dashboard',
            'bodyClass' => '',
        ];

        return view('pages.auth.dashboard.list.notice', $dados);
    }

    public function create()
    { {

            $dados = [
                'titlePage' => 'Avisos - Permuta Brasil',
                'bodyId' => 'dashboard',
                'bodyClass' => '',
            ];

            return view('pages.auth.dashboard.create.message', $dados);
        }
    }

    public function store(NoticeRequest $request)
    {
        $data = $request->except('_token');
        $query = Message::create($data);

        if ($query) {
            return redirect()->route('dashboard.message.index')->with('message', 'Aviso enviada com sucesso')->with('status', 'success');
        } else {
            return redirect()->route('dashboard.message.index')->with('message', 'Opss..., não foi possivel enviar o aviso!')->with('status', 'erro');
        }
    }

    public function show(Message $message)
    {
        //
    }

    public function edit(Message $message)
    {
        //
    }

    public function update(Request $request, Message $message)
    {
        //
    }

    public function destroy(Message $message)
    {
        //
    }
}
