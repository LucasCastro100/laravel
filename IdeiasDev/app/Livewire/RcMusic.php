<?php

namespace App\Livewire;

use Livewire\Component;

class RcMusic extends Component
{
    public bool $navigate = false;
    public $title = 'Rc - Packs';

    public function render()
    {
        return view('livewire.rc-music')
            ->layout('layouts.app', [
                'navigate' => $this->navigate,
                'title' => $this->title
            ]);
    }
}
