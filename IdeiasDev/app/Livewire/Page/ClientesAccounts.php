<?php

namespace App\Livewire\Page;

use Livewire\Component;
use App\Models\ClientAccount;
use Laravel\Jetstream\InteractsWithBanner;

class ClientesAccounts extends Component
{
    use InteractsWithBanner;

    public $showModal = false;
    public $accountId = null;
    public $description = '';
    public $value = '';
    public $month = '';
    public $year = '';
    public $notes = '';

    public $accounts;

    public function mount()
    {
        $this->month = now()->month;
        $this->year = now()->year;
        $this->loadAccounts();
    }

    public function loadAccounts()
    {
        $this->accounts = ClientAccount::where('user_id', auth()->id())
            ->whereNull('client_id')
            ->active()
            ->orderBy('due_date', 'desc')
            ->get();
    }

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit($id)
    {
        $account = ClientAccount::where('user_id', auth()->id())->findOrFail($id);

        $this->accountId = $account->id;
        $this->description = $account->description;
        $this->value = $account->value;
        $this->month = $account->month;
        $this->year = $account->year;
        $this->notes = $account->notes;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'description' => ['required', 'string', 'max:255'],
            'value' => ['required', 'numeric'],
            'month' => ['required', 'integer', 'min:1', 'max:12'],
            'year' => ['required', 'integer', 'min:2020'],
            'notes' => ['nullable', 'string'],
        ]);

        $dueDate = now()->createFromDate($this->year, $this->month, 1)->endOfMonth()->format('Y-m-d');

        ClientAccount::updateOrCreate(
            ['id' => $this->accountId],
            [
                'user_id' => auth()->id(),
                'client_id' => null,
                'description' => $this->description,
                'value' => $this->value,
                'due_date' => $dueDate,
                'month' => $this->month,
                'year' => $this->year,
                'paid_date' => $dueDate,
                'paid' => true,
                'notes' => $this->notes,
            ]
        );

        $this->banner($this->accountId ? 'Gasto atualizado!' : 'Gasto cadastrado!');
        $this->showModal = false;
        $this->resetForm();
        $this->loadAccounts();
    }

    public function delete($id)
    {
        ClientAccount::where('user_id', auth()->id())->findOrFail($id)->delete();

        $this->banner('Conta excluída!');
        $this->loadAccounts();
    }

    public function resetForm()
    {
        $this->accountId = null;
        $this->description = '';
        $this->value = '';
        $this->month = now()->month;
        $this->year = now()->year;
        $this->notes = '';
    }

    public function render()
    {
        return view('livewire.page.clientes-accounts')
            ->layout('layouts.app-sidebar', [
                'showSidebar' => true,
                'title' => 'Gastos Operacionais',
            ]);
    }
}
