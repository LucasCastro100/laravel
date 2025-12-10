<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StripeLayout extends Component
{
    public ?string $title;

    public function __construct(string $title = null)
    {
        $this->title = $title;
    }
    
    public function render(): View|Closure|string
    {
        return view('layouts.stripe');
    }
}
