<?php

namespace App\Livewire\Page;

use Livewire\Component;
use App\Models\Event;
use App\Models\Team;
use App\Models\Category;

class TbrDashboard extends Component
{
    public $title = 'TBR - Dashboard';
    public $events = [];
    public $totalTeams = 0;
    public $teamsByCategory = [];

    protected $listeners = ['eventCreated' => 'loadEvents'];

    public function mount()
    {
        $this->loadStats();
        $this->loadEvents();
    }

    public function loadStats(): void
    {
        $this->totalTeams = Team::count();

        $this->teamsByCategory = Category::orderBy('sort_order')
            ->get()
            ->map(function ($cat) {
                return [
                    'label' => $cat->label,
                    'slug' => $cat->slug,
                    'count' => Team::where('category_slug', $cat->slug)->count(),
                ];
            })
            ->filter(fn($item) => $item['count'] > 0)
            ->values()
            ->toArray();
    }

    public function loadEvents(): void
    {
        $this->events = Event::orderBy('date', 'desc')->get()->toArray();
    }

    public function render()
    {
        return view('livewire.page.tbr-dashboard', [
            'events' => $this->events ?? [],
            'teamsByCategoryJson' => json_encode($this->teamsByCategory),
        ])->layout('layouts.app-sidebar', [
            'showSidebar' => true,
            'title' => $this->title,
        ]);
    }
}
