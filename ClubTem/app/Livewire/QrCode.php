<?php

namespace App\Livewire;

use App\Models\QrCodeRedirect;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class QrCode extends Component
{
    use WithPagination;

    public $url_destino;    
    public $linkGerado;
   
    public function criarQrCode()
    {
        $this->validate([
            'url_destino' => 'required|url'
        ]);

        $codigo = Str::random(8);

        QrCodeRedirect::create([
            'codigo' => $codigo,
            'url_destino' => $this->url_destino,
            'user_id' => Auth::user()->id,
        ]);

        $this->linkGerado = url("/painel/tag-pro/redirecionamento/" . $codigo);

        $this->url_destino = ''; // Limpa o campo
        $this->carregarQrCodes(); // Atualiza a lista
        session()->flash('success', 'QR Code criado com sucesso!');
    }


    public function render()
    {
        $qrCodes = QrCodeRedirect::where('user_id', Auth::user()->id)->latest()->paginate(10);

        return view('livewire.qr-code', [
            'qrCodes' => $qrCodes,
        ]);        
    }
}
