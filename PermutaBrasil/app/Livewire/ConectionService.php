<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\DesiredProspectingr;
use App\Models\TypeService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ConectionService extends Component
{
    use WithPagination;

    public $typeProspecction, $nameProspecction, $idClient, $message, $status;
    public $searchService = '', $warningMessage = '';    
    public $selectedServices = [];
    public $openModal = false, $isProcessing = false;

    public function mount()
    {
        if (session()->has('selectedServices')) {
            $this->selectedServices = session('selectedServices');
        } else {
            $this->selectedServices = TypeService::whereIn('id', Auth::user()->client->connected_type_services ?? [])->pluck('id')->toArray();
            session()->put('selectedServices', $this->selectedServices);
        }
    }

    public function updatedSelectedServices()
    {
        $roleValue = Auth::user()->role->value;

        $maxSelection = ($roleValue == 1) ? 3 : (($roleValue == 2) ? 6 : 0);

        if (count($this->selectedServices) > $maxSelection) {
            $this->selectedServices = array_slice($this->selectedServices, 0, $maxSelection);
            $this->warningMessage = "Você pode selecionar no máximo {$maxSelection} serviços.";
        } else {
            $this->warningMessage = '';
        }

        session()->put('selectedServices', $this->selectedServices);
    }

    public function updatingSearchService()
    {
        $this->resetPage();
    }

    public function newProspecction()
    {
        $this->reset();    
        $this->openModal = true;        
    }

    public function closeModal()
    {
        $this->openModal = false;
    }

    public function createProspecction(){ 
        $this->idClient = Auth::user()->client->id;
        $prospecting = $this->typeProspecction == 0 ? $this->nameProspecction : null;
        $company = $this->typeProspecction == 1 ? $this->nameProspecction : null;

        $query = DesiredProspectingr::create([
            'client_id' => $this->idClient,
            'prospecting' => $prospecting,
            'company' => $company
        ]);
        
        if ($query) {            
            $this->message = 'Prospecção cadastrada com sucesso!';
            $this->status = 'success';
        } else {
            $this->message = 'Ops... tente novamente';
            $this->status = 'error';
        }

        $this->openModal = false;        
        $this->resetPage();
        $this->reset(['typeProspecction', 'nameProspecction']);
    }

    public function render()
    {
        $conections = TypeService::where('type_service', 'like', '%' . $this->searchService . '%')->orderBy('type_service', 'asc')->get();


        return view('livewire.conection-service', [
            'conections' => $conections,
            'warningMessage' => $this->warningMessage,
            'selectedServices' => $this->selectedServices
        ]);
    }
}

