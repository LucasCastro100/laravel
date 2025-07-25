<?php

namespace App\Livewire;

use App\Models\TypeService as ModelsTypeService;
use Livewire\Component;
use Livewire\WithPagination;


class TypeService extends Component
{
    use WithPagination;
    
    public $message,  $status;
    public $searchService = '';
    public $confirmingDelete = false;
    public $serviceIdToDelete = null;

    public function updatingSearchService()
    {
        $this->resetPage();
    }

    public function confirmDelete($serviceID)
    {
        $this->confirmingDelete = true;
        $this->serviceIdToDelete = $serviceID;
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = false;
        $this->serviceIdToDelete = null;
        $this->reset(['message', 'status']);
    }

    public function deleteService()
    {
        $service = ModelsTypeService::find($this->serviceIdToDelete);
        if ($service) {
            $service->delete();
            $this->message = 'Serviço excluído com sucesso!';
            $this->status = 'success';
        } else {
            $this->message = 'Serviço não encontrado.';
            $this->status = 'error';
        }

        $this->confirmingDelete = false;
        $this->serviceIdToDelete = null;
        $this->resetPage();
    }

    public function render()
    {
        $services = ModelsTypeService::where('type_service', 'like', '%' . $this->searchService . '%')->paginate(10);        

        return view('livewire.type-service', ['services' => $services]);
    }
}


