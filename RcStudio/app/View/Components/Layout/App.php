<?php

namespace App\View\Components\Layout;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class App extends Component
{
    public $title;
    public $description;
    public $keywords;

    public function __construct($title = null, $description = null, $keywords = null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->keywords = $keywords;
    }
    
    public function render(): View|Closure|string
    {
        return view('components.layout.app');
    }
}
