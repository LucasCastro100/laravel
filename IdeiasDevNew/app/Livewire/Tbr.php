<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Laravel\Jetstream\InteractsWithBanner;

class Tbr extends Component
{
    use InteractsWithBanner;

    public bool $navigate = false;

    public $numTeams = 1;
    public $teams = [
        ['name' => '', 'category' => 'kids1'],
    ];

    public $categories = ['kids1', 'kids2', 'middle1', 'middle2', 'high'];

    public function mount()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->numTeams = 1;
        $this->teams = [
            [
                'name' => '',
                'category' => 'kids1',
                'mc' => 0,
                'om' => 0,
                'te' => 0,
                'dp' => 0,
            ],
        ];
    }

    public function clearStorage()
{
    // Apaga o JSON (salva um array vazio)
    Storage::disk('local')->put('equipes.json', json_encode([]));

    // Opcional: resetar o formulário também
    $this->resetForm();
        
    $this->banner('Dados do JSON apagados e formulário resetado!', 'success');
}

    // Quando o número de equipes mudar, ajusta o array de times
    public function updatedNumTeams($value)
    {
        $value = (int) $value;
        if ($value < 1) $value = 1;

        $count = count($this->teams);

        if ($value > $count) {
            for ($i = $count; $i < $value; $i++) {
                $this->teams[] =  [
                    'name' => '',
                    'category' => 'kids1',
                    'mc' => 0,
                    'om' => 0,
                    'te' => 0,
                    'dp' => 0
                ];
            }
        } elseif ($value < $count) {
            $this->teams = array_slice($this->teams, 0, $value);
        }
    }

    public function saveTeams()
    {
        $this->validate([
            'teams.*.name' => 'required|min:2',
            'teams.*.category' => 'required|in:' . implode(',', $this->categories),
        ]);

        // Ler equipes antigas
        if (Storage::disk('local')->exists('equipes.json')) {
            $jsonOld = Storage::disk('local')->get('equipes.json');
            $oldTeams = json_decode($jsonOld, true);
        } else {
            $oldTeams = [];
        }

        // Mesclar equipes antigas com as novas
        $newTeams = $this->teams;

        // Aqui você pode evitar duplicados, se quiser, por exemplo, pelo nome:
        // Para simplicidade, vou só juntar os arrays
        $mergedTeams = array_merge($oldTeams, $newTeams);

        // Salvar tudo junto
        $json = json_encode($mergedTeams, JSON_PRETTY_PRINT);
        Storage::disk('local')->put('equipes.json', $json);

        $this->resetForm();
        
        $this->banner('Equipes cadastradas com sucesso!', 'success');
    }

    public function render()
    {
        return view('livewire.tbr')
            ->layout('layouts.app', [
                'navigate' => $this->navigate
            ]);
    }
}
