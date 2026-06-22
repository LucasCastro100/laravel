<?php

namespace App\Livewire\Page;

use Livewire\Component;
use App\Models\FinancialCategory;
use Laravel\Jetstream\InteractsWithBanner;

class FinanceiroCategories extends Component
{
    use InteractsWithBanner;

    public $showModal = false;
    public $catId = null;
    public $name = '';
    public $type = 'expense';
    public $description = '';
    public $color = '#6b7280';
    public $categories;

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:income,expense'],
            'description' => ['nullable', 'string'],
            'color' => ['nullable', 'string', 'max:9'],
        ];
    }

    public function mount()
    {
        $this->loadCategories();
    }

    public function loadCategories()
    {
        $this->categories = FinancialCategory::orderBy('name')->get();
    }

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit($id)
    {
        $cat = FinancialCategory::findOrFail($id);
        $this->catId = $cat->id;
        $this->name = $cat->name;
        $this->type = $cat->type;
        $this->description = $cat->description;
        $this->color = $cat->color ?? '#6b7280';
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        FinancialCategory::updateOrCreate(
            ['id' => $this->catId],
            ['name' => $this->name, 'type' => $this->type, 'description' => $this->description, 'color' => $this->color]
        );

        $this->banner($this->catId ? 'Categoria atualizada!' : 'Categoria cadastrada!');
        $this->showModal = false;
        $this->resetForm();
        $this->loadCategories();
    }

    public function delete($id)
    {
        FinancialCategory::findOrFail($id)->delete();
        $this->banner('Categoria excluída!');
        $this->loadCategories();
    }

    public function resetForm()
    {
        $this->catId = null;
        $this->name = '';
        $this->type = 'expense';
        $this->description = '';
        $this->color = '#6b7280';
    }

    public function render()
    {
        return view('livewire.page.financeiro-categories')
            ->layout('layouts.app-sidebar', [
                'showSidebar' => true,
                'title' => 'Categorias Financeiras',
            ]);
    }
}
