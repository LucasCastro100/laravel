<?php

namespace App\Livewire;

use App\Models\DesiredProspectingr as ModelsDesiredProspectingr;
use Livewire\Component;
use Livewire\WithPagination;

class DesiredProspectingr extends Component
{
    use WithPagination;

    public $message, $status;

    public function deleteProspecction(int $prospectId){
        $query = ModelsDesiredProspectingr::find($prospectId);
        $query->delete();

        if ($query) {            
            $this->message = 'Prospecção excluída com sucesso!';
            $this->status = 'success';
        } else {
            $this->message = 'Prospecção não encontrado.';
            $this->status = 'error';
        }
        
        $this->resetPage();
    }
    
    public function render()
    {
        $prospectingr = ModelsDesiredProspectingr::paginate(10);
        return view('livewire.desired-prospectingr', ['prospectingr' => $prospectingr]);
    }
}
