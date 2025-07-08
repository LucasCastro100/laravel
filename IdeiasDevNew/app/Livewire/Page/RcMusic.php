<?php

namespace App\Livewire\Page;

use Livewire\Component;

class RcMusic extends Component
{
    public bool $navigate = false;

    public function render()
    {
        return view('livewire.page.rc-music')->layout('layouts.app-navigate', ['navigate' => $this->navigate]);;
    }
}
