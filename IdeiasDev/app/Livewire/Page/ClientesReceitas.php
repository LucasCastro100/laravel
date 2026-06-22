<?php

namespace App\Livewire\Page;

use Livewire\Component;
use App\Models\Client;
use App\Models\ClientAccount;
use App\Models\Plan;
use Laravel\Jetstream\InteractsWithBanner;

class ClientesReceitas extends Component
{
    use InteractsWithBanner;

    public $showModal = false;
    public $receitaId = null;
    public $client_id = '';
    public $plan_id = '';
    public $value = '';
    public $month = '';
    public $year = '';
    public $due_date = '';

    public $receitas;
    public $clients;
    public $plans;

    public function mount()
    {
        $this->clients = Client::where('user_id', auth()->id())->where('active', true)->orderBy('name')->get();
        $this->plans = Plan::where('active', true)->orderBy('name')->get();
        $this->month = now()->month;
        $this->year = now()->year;
        $this->loadReceitas();
    }

    public function loadReceitas()
    {
        $this->receitas = ClientAccount::where('user_id', auth()->id())
            ->whereNotNull('client_id')
            ->with('client')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();
    }

    public function updatedPlanId($id)
    {
        if ($id) {
            $plan = Plan::find($id);
            if ($plan) {
                $this->value = $plan->value;
            }
        } else {
            $this->value = '';
        }
    }

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit($id)
    {
        $receita = ClientAccount::where('user_id', auth()->id())->whereNotNull('client_id')->findOrFail($id);
        $this->receitaId = $receita->id;
        $this->client_id = $receita->client_id;
        $this->plan_id = $receita->plan_id;
        $this->value = $receita->value;
        $this->month = $receita->month;
        $this->year = $receita->year;
        $this->due_date = $receita->due_date?->format('Y-m-d');
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'value' => ['required', 'numeric', 'min:0'],
            'month' => ['required', 'integer', 'min:1', 'max:12'],
            'year' => ['required', 'integer', 'min:2020'],
            'due_date' => ['nullable', 'date'],
        ]);

        $client = Client::where('user_id', auth()->id())->find($this->client_id);
        if (!$client) abort(403);

        $dueDate = $this->due_date ?: now()->createFromDate($this->year, $this->month, 1)->endOfMonth()->format('Y-m-d');

        ClientAccount::updateOrCreate(
            ['id' => $this->receitaId],
            [
                'user_id' => auth()->id(),
                'client_id' => $this->client_id,
                'plan_id' => $this->plan_id ?: null,
                'value' => $this->value,
                'month' => $this->month,
                'year' => $this->year,
                'due_date' => $dueDate,
                'paid_date' => $dueDate,
                'paid' => true,
                'description' => 'Recebimento - ' . $client->name,
            ]
        );

        $this->banner($this->receitaId ? 'Receita atualizada!' : 'Receita cadastrada!');
        $this->showModal = false;
        $this->resetForm();
        $this->loadReceitas();
    }

    public function delete($id)
    {
        ClientAccount::where('user_id', auth()->id())->whereNotNull('client_id')->findOrFail($id)->delete();
        $this->banner('Receita excluída!');
        $this->loadReceitas();
    }

    public function resetForm()
    {
        $this->receitaId = null;
        $this->client_id = '';
        $this->plan_id = '';
        $this->value = '';
        $this->month = now()->month;
        $this->year = now()->year;
        $this->due_date = '';
    }

    public function render()
    {
        return view('livewire.page.clientes-receitas')
            ->layout('layouts.app-sidebar', [
                'showSidebar' => true,
                'title' => 'Receitas',
            ]);
    }
}