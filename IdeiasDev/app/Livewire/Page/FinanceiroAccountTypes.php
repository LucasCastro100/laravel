<?php

namespace App\Livewire\Page;

use Livewire\Component;
use App\Models\AccountType;
use Laravel\Jetstream\InteractsWithBanner;

class FinanceiroAccountTypes extends Component
{
    use InteractsWithBanner;

    public $showModal = false;
    public $typeId = null;
    public $name = '';
    public $description = '';
    public $types;

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function mount()
    {
        $this->loadTypes();
    }

    public function loadTypes()
    {
        $this->types = AccountType::orderBy('name')->get();
    }

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit($id)
    {
        $type = AccountType::findOrFail($id);
        $this->typeId = $type->id;
        $this->name = $type->name;
        $this->description = $type->description;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        AccountType::updateOrCreate(
            ['id' => $this->typeId],
            ['name' => $this->name, 'description' => $this->description]
        );

        $this->banner($this->typeId ? 'Tipo de conta atualizado!' : 'Tipo de conta cadastrado!');
        $this->showModal = false;
        $this->resetForm();
        $this->loadTypes();
    }

    public function delete($id)
    {
        AccountType::findOrFail($id)->delete();
        $this->banner('Tipo de conta excluído!');
        $this->loadTypes();
    }

    public function resetForm()
    {
        $this->typeId = null;
        $this->name = '';
        $this->description = '';
    }

    public function render()
    {
        return view('livewire.page.financeiro-account-types')
            ->layout('layouts.app-sidebar', [
                'showSidebar' => true,
                'title' => 'Tipos de Conta',
            ]);
    }
}
