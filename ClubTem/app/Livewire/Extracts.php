<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Extract;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Str;

class Extracts extends Component
{
    use WithPagination;
    
    public $message, $status, $searchDataStart, $searchDataEnd;
    public $searchClient = '', $searchService = '';
    public $openModal = false;
    public $values = [];

    public function mount()
    {
        $this->searchDataStart = null;
        $this->searchDataEnd = null;
    }


    public function generateReport()
    {
        $extractQuery = $this->buildQuery()->get();
        $userID = Auth::user()->id;
        $userData = ['id' => $userID, 'dados' => Auth::user()->client];

        // Formatar as datas
        $formattedSearchDataStart = $this->searchDataStart ? Carbon::parse($this->searchDataStart)->format('d-m-Y') : null;
        $formattedSearchDataEnd = $this->searchDataEnd ? Carbon::parse($this->searchDataEnd)->format('d-m-Y') : null;

        $arrayPDF = [
            'extracts' => $extractQuery,
            'searchDataStart' => $formattedSearchDataStart,
            'searchDataEnd' => $formattedSearchDataEnd,
            'user' => $userData,       
        ];

        $pdf = PDF::loadView('pages.auth.dashboard.pdf.extracts', $arrayPDF)->setPaper('a4', 'landscape');

        // return $pdf->download('extract.pdf');
        $name_user = strtolower(str_replace(' ', '_', Str::ascii($userData['dados']->name)));
        $file_name = 'extrato_' . $name_user . '_' . date('d_m_Y') . '.pdf';
        
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $file_name);
    }

    private function buildQuery()
    {
        $query = Extract::query();        

        // Filtrar por data_servico
        if ($this->searchDataStart && $this->searchDataEnd) {
            $query->whereBetween('date_service', [$this->searchDataStart, $this->searchDataEnd]);
        } elseif ($this->searchDataStart) {
            $query->where('date_service', '>=', $this->searchDataStart);
        } elseif ($this->searchDataEnd) {
            $query->where('date_service', '<=', $this->searchDataEnd);
        }
        
        // Filtrar por descrição do serviço
        if ($this->searchService) {
            $query->where('description', 'like', '%' . $this->searchService . '%');
        }

        // Filtrar por cliente (service_taker_id ou service_provider_id)
        if ($this->searchClient) {
            $clientIds = Client::where('name', 'like', '%' . $this->searchClient . '%')->pluck('user_id');
            $query->where(function($q) use ($clientIds) {
                $q->whereIn('service_taker_id', $clientIds)
                  ->orWhereIn('service_provider_id', $clientIds);
            });
        }       
        
        if (Auth::check() && Auth::user()->role->value < 3) {
            $userId = Auth::user()->id;
            $query->where(function($q) use ($userId) {
                $q->where('service_provider_id', $userId)
                ->orWhere('service_taker_id', $userId);
            });
        }

        // Adicionar os relacionamentos e a ordenação
        $query->with(['profileProvider', 'profileTaker'])
              ->orderBy('date_service', 'desc');

        return $query;
    }

    public function render()
    {
        $extractQuery = $this->buildQuery()->paginate(10);

        $exchange = new Extract();
        $valuesExchange = $exchange->addExtractsAllClients();
        $this->values = $valuesExchange['values'];

        $userID = Auth::user()->id;
        $userData = ['id' => $userID, 'dados' => Auth::user()->client];

        return view('livewire.extracts', [
            'extractQuery' => $extractQuery,
            'values' => $this->values,
            'user' => $userData,
        ]);        
    }
}
?>