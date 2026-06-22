<?php

namespace App\Livewire\Page;

use Livewire\Component;
use App\Models\Client;
use Laravel\Jetstream\InteractsWithBanner;

class ClientesClients extends Component
{
    use InteractsWithBanner;

    public $showModal = false;
    public $clientId = null;
    public $name = '';
    public $email = '';
    public $phone = '';
    public $document = '';
    public $address = '';
    public $notes = '';

    public $clients;

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'document' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function mount()
    {
        $this->loadClients();
    }

    public function loadClients()
    {
        $this->clients = Client::where('user_id', auth()->id())
            ->withSum(['accounts as total_revenue' => function ($q) {
                $q->where('paid', true);
            }], 'value')
            ->orderBy('active', 'desc')
            ->orderBy('name')
            ->get();
    }

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit($id)
    {
        $client = Client::where('user_id', auth()->id())->findOrFail($id);
        $this->clientId = $client->id;
        $this->name = $client->name;
        $this->email = $client->email;
        $this->phone = $client->phone;
        $this->document = $client->document;
        $this->address = $client->address;
        $this->notes = $client->notes;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        Client::updateOrCreate(
            ['id' => $this->clientId],
            [
                'user_id' => auth()->id(),
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'document' => $this->document,
                'address' => $this->address,
                'notes' => $this->notes,
            ]
        );

        $this->banner($this->clientId ? 'Cliente atualizado!' : 'Cliente cadastrado!');
        $this->showModal = false;
        $this->resetForm();
        $this->loadClients();
    }

    public function deactivate($id)
    {
        $client = Client::where('user_id', auth()->id())->findOrFail($id);

        \DB::transaction(function () use ($client) {
            $client->update(['active' => false]);

            $client->plans()->wherePivot('active', true)->update(['active' => false]);

            $client->accounts()->where('paid', false)->whereNull('cancelled_at')->update([
                'cancelled_at' => now(),
            ]);
        });

        $this->banner('Cliente desativado!');
        $this->loadClients();
    }

    public function activate($id)
    {
        Client::where('user_id', auth()->id())->findOrFail($id)->update(['active' => true]);
        $this->banner('Cliente ativado!');
        $this->loadClients();
    }

    public function delete($id)
    {
        Client::where('user_id', auth()->id())->findOrFail($id)->delete();
        $this->banner('Cliente excluído!');
        $this->loadClients();
    }

    public function resetForm()
    {
        $this->clientId = null;
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->document = '';
        $this->address = '';
        $this->notes = '';
    }

    public function render()
    {
        return view('livewire.page.clientes-clients')
            ->layout('layouts.app-sidebar', [
                'showSidebar' => true,
                'title' => 'Clientes',
            ]);
    }
}
