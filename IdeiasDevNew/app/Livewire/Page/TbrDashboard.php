<?php

namespace App\Livewire\Page;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Laravel\Jetstream\InteractsWithBanner;

class TbrDashboard extends Component
{
    use InteractsWithBanner;

    public function render()
    {
        return view('livewire.page.tbr-dashboard')->layout('layouts.app-sidebar');
    }
}
