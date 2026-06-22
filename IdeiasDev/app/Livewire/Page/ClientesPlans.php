<?php

namespace App\Livewire\Page;

use Livewire\Component;
use App\Models\Plan;
use Laravel\Jetstream\InteractsWithBanner;

class ClientesPlans extends Component
{
    use InteractsWithBanner;

    public $showModal = false;
    public $planId = null;
    public $name = '';
    public $description = '';
    public $value = '';
    public $active = true;

    public $plans;

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'value' => ['required', 'numeric', 'min:0'],
            'active' => ['boolean'],
        ];
    }

    public function mount()
    {
        $this->loadPlans();
    }

    public function loadPlans()
    {
        $this->plans = Plan::orderBy('active', 'desc')->orderBy('name')->get();
    }

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit($id)
    {
        $plan = Plan::findOrFail($id);
        $this->planId = $plan->id;
        $this->name = $plan->name;
        $this->description = $plan->description;
        $this->value = $plan->value;
        $this->active = $plan->active;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        Plan::updateOrCreate(
            ['id' => $this->planId],
            [
                'user_id' => auth()->id(),
                'name' => $this->name,
                'description' => $this->description,
                'value' => $this->value,
                'active' => $this->active,
            ]
        );

        $this->banner($this->planId ? 'Plano atualizado!' : 'Plano cadastrado!');
        $this->showModal = false;
        $this->resetForm();
        $this->loadPlans();
    }

    public function delete($id)
    {
        Plan::findOrFail($id)->delete();
        $this->banner('Plano excluído!');
        $this->loadPlans();
    }

    public function resetForm()
    {
        $this->planId = null;
        $this->name = '';
        $this->description = '';
        $this->value = '';
        $this->active = true;
    }

    public function render()
    {
        return view('livewire.page.clientes-plans')
            ->layout('layouts.app-sidebar', [
                'showSidebar' => true,
                'title' => 'Planos',
            ]);
    }
}
