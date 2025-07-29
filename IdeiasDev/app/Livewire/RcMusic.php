<?php

namespace App\Livewire;

use Livewire\Component;

class RcMusic extends Component
{    
    public $title = 'Rc - Packs';

    public function render()
    {
        return view('livewire.rc-music')
            ->layout('layouts.app-navigate', [
                'navigate' => 'false',
                'title' => $this->title
            ]);
    }
}
