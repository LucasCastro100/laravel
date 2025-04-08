<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SalesBooth as ModelsSalesBooth;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SalesBooth extends Component
{   
    use WithPagination;

    public $searchSaleBooth = '';
    public $message;
    public $status;  
    public $images = [];
    public $showViewModal = false;
    public $selectedItem;

    public function updatingSearchSaleBooth()
    {
        $this->resetPage();
    }   

    public function openViewModal($itemId)
    {
        $this->selectedItem = ModelsSalesBooth::find($itemId);
        $this->showViewModal = true;
    }

    public function closeViewModal()
    {
        $this->showViewModal = false;
    }

    public function render()
    {
        $sales = ModelsSalesBooth::where('user_id', Auth::id())
            ->where('name', 'like', '%' . $this->searchSaleBooth . '%')
            ->where('created_at', '>=', Carbon::now()->subDays(31))
            ->paginate(10);

        return view('livewire.sales-booth', ['sales' => $sales]);
    }
}