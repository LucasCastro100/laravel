<?php

namespace App\Livewire\Page;

use Livewire\Component;
use App\Models\Client;
use App\Models\ClientPlan;
use App\Models\Plan;
use Laravel\Jetstream\InteractsWithBanner;

class ClientesClientPlans extends Component
{
    use InteractsWithBanner;

    public $showModal = false;
    public $linkId = null;
    public $client_id = '';
    public $plan_id = '';
    public $start_date = '';
    public $end_date = '';
    public $adjusted_value = '';
    public $active = true;

    public $links;
    public $clients;
    public $plans;

    protected function rules()
    {
        return [
            'client_id' => ['required', 'exists:clients,id'],
            'plan_id' => ['required', 'exists:plans,id'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'adjusted_value' => ['nullable', 'numeric', 'min:0'],
            'active' => ['boolean'],
        ];
    }

    public function mount()
    {
        $this->clients = Client::where('user_id', auth()->id())->where('active', true)->orderBy('name')->get();
        $this->plans = Plan::where('active', true)->orderBy('name')->get();
        $this->loadLinks();
    }

    public function loadLinks()
    {
        $this->links = ClientPlan::where('clients.user_id', auth()->id())
            ->join('clients', 'client_plan.client_id', '=', 'clients.id')
            ->join('plans', 'client_plan.plan_id', '=', 'plans.id')
            ->select('client_plan.*', 'clients.name as client_name', 'plans.name as plan_name', 'plans.value as plan_value')
            ->orderBy('client_plan.active', 'desc')
            ->orderBy('client_plan.created_at', 'desc')
            ->get();
    }

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit($id)
    {
        $link = ClientPlan::findOrFail($id);
        $client = Client::where('user_id', auth()->id())->find($link->client_id);
        if (!$client) abort(403);

        $this->linkId = $link->id;
        $this->client_id = $link->client_id;
        $this->plan_id = $link->plan_id;
        $this->start_date = $link->start_date?->format('Y-m-d');
        $this->end_date = $link->end_date?->format('Y-m-d');
        $this->adjusted_value = $link->adjusted_value;
        $this->active = $link->active;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $client = Client::where('user_id', auth()->id())->find($this->client_id);
        if (!$client) abort(403);

        $data = [
            'user_id' => auth()->id(),
            'client_id' => $this->client_id,
            'plan_id' => $this->plan_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'adjusted_value' => $this->adjusted_value ?: null,
            'active' => $this->active,
        ];

        if ($this->linkId) {
            ClientPlan::where('id', $this->linkId)->update($data);
        } else {
            ClientPlan::create($data);
        }

        $this->banner($this->linkId ? 'Vinculo atualizado!' : 'Plano vinculado ao cliente!');
        $this->showModal = false;
        $this->resetForm();
        $this->loadLinks();
    }

    public function delete($id)
    {
        $link = ClientPlan::findOrFail($id);
        $client = Client::where('user_id', auth()->id())->find($link->client_id);
        if (!$client) abort(403);

        $link->delete();
        $this->banner('Vinculo removido!');
        $this->loadLinks();
    }

    public function resetForm()
    {
        $this->linkId = null;
        $this->client_id = '';
        $this->plan_id = '';
        $this->start_date = now()->format('Y-m-d');
        $this->end_date = '';
        $this->adjusted_value = '';
        $this->active = true;
    }

    public function render()
    {
        return view('livewire.page.clientes-client-plans')
            ->layout('layouts.app-sidebar', [
                'showSidebar' => true,
                'title' => 'Vincular Planos',
            ]);
    }
}