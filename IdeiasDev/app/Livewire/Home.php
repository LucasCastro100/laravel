<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Laravel\Jetstream\InteractsWithBanner;
use Illuminate\Support\Facades\Mail;

class Home extends Component
{
    use InteractsWithBanner, WithFileUploads;

    public bool $navigate = false;
    public $title = 'Ideias Dev';

    public $name = '';
    public $email = '';
    public $phone = '';
    public $domain = '';
    public $url = '';
    public $desc = '';
    public $file;

    protected function rules()
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'min:9'],
            'domain' => ['required'],
            'url' => ['nullable', 'url'],
            'desc' => ['required', 'min:10'],
            'file' => ['nullable', 'file', 'max:2048', 'mimes:pdf,doc,docx,png,jpg,jpeg'],
        ];
    }

    protected function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'phone.required' => 'O telefone é obrigatório.',
            'phone.min' => 'O telefone deve ter no mínimo 9 caracteres.',
            'domain.required' => 'O domínio é obrigatório.',
            'url.url' => 'Informe uma URL válida.',
            'desc.required' => 'A descrição é obrigatória.',
            'desc.min' => 'A descrição deve ter no mínimo 10 caracteres.',
            'file.mimes' => 'Formato de arquivo inválido.',
            'file.max' => 'O arquivo não pode passar de 2MB.',
        ];
    }

    public function submit_form()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'domain' => $this->domain,
            'url' => $this->url,
            'desc' => $this->desc,
        ];

        try {
            Mail::send('mails.form_ideias', $data, function ($message) {
                $message->to('suporte@ideias.dev.br')
                    ->from('suporte@ideias.dev.br', 'Lucas Oliveira | Ideias Dev')
                    ->subject('Novo formulário de contato');

                if ($this->file) {
                    $message->attach($this->file->getRealPath(), [
                        'as' => $this->file->getClientOriginalName(),
                        'mime' => $this->file->getMimeType(),
                    ]);
                }
            });

            $this->banner('Formulário enviado com sucesso!');
            $this->reset();
        } catch (\Exception $e) {
            $this->dangerBanner('Erro ao enviar o formulário: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.home')
            ->layout('layouts.app-navigate', [
                'navigate' => $this->navigate,
                'title' => $this->title,
            ]);
    }
}
