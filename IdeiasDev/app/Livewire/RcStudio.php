<?php

namespace App\Livewire;

use Livewire\Component;

class RcStudio extends Component
{
    public $titlePage;
    public $title;
    public $description;
    public $image;
    public $url;

    public function mount()
    {
        $this->titlePage = "RcStudio";
        $this->title = "";
        $this->description = "";
        $this->image = "";
        $this->url = "";
    }

    public function render()
    {
        return view('livewire.rc-studio')
            ->layout('layouts.app-navigate', [
                'nav' => 'false',
                'titlePage' => $this->titlePage,
                'title' => $this->title,
                'description' => $this->description,
                'image' => $this->image,
                'url' => $this->url
            ]);
    }
}
