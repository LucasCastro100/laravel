<?php

namespace App\Livewire;

use App\Models\SalesBooth;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class MySalesBooth extends Component
{
    use WithFileUploads, WithPagination;

    public $name, $description, $price, $images = [];
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;
    public $editId;
    public $deleteId = null;    
    public $searchName = '';
    public $searchDate = '';
    public $message;
    public $status;
    public $isProcessing = false;


    public function openCreateModal()
    {
        $this->resetInputFields();
        $this->showCreateModal = true;
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
    }

    public function openEditModal($id)
    {
        $sale = SalesBooth::findOrFail($id);
        $this->editId = $sale->id;
        $this->name = $sale->name;
        $this->description = $sale->description;
        $this->price = $sale->price;
        $this->images = $sale->images;
        $this->showEditModal = true;        
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
    }

    public function submit()
    {
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'images.*' => 'image|max:1024', // 1MB Max
        ]);        

        $images = [];
        if ($this->images) {
            foreach ($this->images as $image) {
                $images[] = $image->store('sales', 'public');
            }
        }

        // dd($this->name, $this->description, $this->price, $images);

        $sales = SalesBooth::create([
            'user_id' => Auth::id(),
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'images' => $images,
        ]);

        if($sales) {            
            $this->message = 'Produto adicioando com sucesso!';
            $this->status = 'success';
        } else {
            $this->message = 'Ops..., não foi possível adicionar o produto, tente novamente!';
            $this->status = 'error';
        }

        $this->closeCreateModal();
        $this->resetPage(); // Refresh the list
    }

    public function update()
    {
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'images.*' => 'image|max:1024', // 1MB Max
        ]);

        $sale = SalesBooth::findOrFail($this->editId);
        $sale->update([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
        ]);

        if ($this->images) {
            $images = [];
            foreach ($this->images as $image) {
                $images[] = $image->store('sales', 'public');
            }
            $sale->update(['images' => $images]);
        }

        if($sale) {            
            $this->message = 'Produto atualizado com sucesso!';
            $this->status = 'success';
        } else {
            $this->message = 'Ops..., não foi possível atualizar o produto, tente novamente!';
            $this->status = 'error';
        }
        
        $this->closeEditModal();
        $this->resetPage(); // Refresh the list
    }

    public function confirmDelete($id)
    {
        $this->showDeleteModal = true;
        $this->deleteId = $id;
    }

    public function delete()
    {
        $sale = SalesBooth::findOrFail($this->deleteId)->delete();

        if($sale) {            
            $this->message = 'Produto excluido com sucesso!';
            $this->status = 'success';
        } else {
            $this->message = 'Ops..., não foi possível excluir o produto, tente novamente!';
            $this->status = 'error';
        }
        
        $this->showDeleteModal = false;
        $this->resetPage(); // Refresh the list
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->price = '';
        $this->images = [];
    }

    public function render()
    {
        $query = SalesBooth::query();

        if ($this->searchName) {
            $query->where('name', 'like', '%' . $this->searchName . '%');
        }

        if ($this->searchDate) {
            $query->whereDate('created_at', $this->searchDate);
        }

        $sales = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.my-sales-booth', [
            'sales' => $sales,
        ]);
    }
}