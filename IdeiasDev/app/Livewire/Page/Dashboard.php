<?php

namespace App\Livewire\Page;

use Livewire\Component;
use App\Models\Event;
use App\Models\FinancialTransaction;
use App\Models\FinancialCategory;
use App\Models\Client;
use App\Models\Plan;
use App\Models\Team;
use App\Models\Category;
use App\Models\ClientAccount;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public $activeTab = 'tbr';

    public $events;
    public $totalEvents = 0;
    public $totalTeams = 0;
    public $teamsByCategory = [];

    public $totalIncome = 0;
    public $totalExpense = 0;
    public $pendingBills = 0;
    public $paidThisMonth = 0;
    public $paidLastMonth = 0;
    public $monthlyTrend = [];

    public $totalClients = 0;
    public $totalPlans = 0;
    public $totalClientRevenue = 0;
    public $potentialRevenue = 0;
    public $currentMonthRevenue = 0;
    public $projectedExpense = 0;
    public $projectedBalance = 0;

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $user = auth()->user();

        if ($user->isSuperAdmin() || !$user->system_id) {
            $this->loadTbrStats();
            $this->loadFinanceiroStats();
            $this->loadClientesStats();
            return;
        }

        match ($user->system->slug) {
            'tbr' => $this->loadTbrStats(),
            'financeiro' => $this->loadFinanceiroStats(),
            'clientes' => $this->loadClientesStats(),
            default => null,
        };
    }

    public function loadTbrStats()
    {
        $this->events = Event::withCount('teams')
            ->orderBy('date', 'desc')
            ->get();

        $this->totalEvents = $this->events->count();
        $this->totalTeams = $this->events->sum('teams_count');

        $this->teamsByCategory = Category::orderBy('sort_order')
            ->get()
            ->map(fn($cat) => [
                'label' => $cat->label,
                'count' => Team::where('category_slug', $cat->slug)->count(),
            ])
            ->filter(fn($i) => $i['count'] > 0)
            ->values()
            ->toArray();
    }

    public function loadFinanceiroStats()
    {
        $userId = auth()->id();

        $this->totalIncome = FinancialTransaction::where('user_id', $userId)
            ->where('paid', true)->where('value', '>', 0)->sum('value');

        $this->totalExpense = FinancialTransaction::where('user_id', $userId)
            ->where('paid', true)->where('value', '<', 0)->sum('value');

        $this->pendingBills = FinancialTransaction::where('user_id', $userId)
            ->where('paid', false)->count();

        $this->paidThisMonth = FinancialTransaction::where('user_id', $userId)
            ->where('paid', true)
            ->where('month', now()->month)->where('year', now()->year)
            ->sum('value');

        $this->paidLastMonth = FinancialTransaction::where('user_id', $userId)
            ->where('paid', true)
            ->where('month', now()->subMonth()->month)->where('year', now()->subMonth()->year)
            ->sum('value');

        $now = now();
        $trend = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = $now->copy()->subMonths($i);
            $rec = FinancialTransaction::where('user_id', $userId)
                ->where('paid', true)->where('value', '>', 0)
                ->where('month', $date->month)->where('year', $date->year)->sum('value');
            $desp = FinancialTransaction::where('user_id', $userId)
                ->where('paid', true)->where('value', '<', 0)
                ->where('month', $date->month)->where('year', $date->year)->sum('value');
            $trend[] = [
                'month' => $date->format('M/Y'),
                'receitas' => (float) $rec,
                'despesas' => (float) abs($desp),
            ];
        }
        $this->monthlyTrend = $trend;
    }

    public function loadClientesStats()
    {
        $userId = auth()->id();

        $this->totalClients = Client::where('user_id', $userId)->where('active', true)->count();
        $this->totalPlans = Plan::where('user_id', $userId)->count();

        $this->totalClientRevenue = ClientAccount::whereHas('client', fn($q) => $q->where('user_id', $userId))
            ->where('paid', true)->sum('value');

        $this->potentialRevenue = Plan::where('user_id', $userId)->where('active', true)->sum('value');

        $this->currentMonthRevenue = ClientAccount::whereHas('client', fn($q) => $q->where('user_id', $userId))
            ->where('paid', true)
            ->where('month', now()->month)->where('year', now()->year)
            ->sum('value');

        // Average monthly gastos (last 3 months)
        $expensesLast3 = ClientAccount::where('user_id', $userId)
            ->whereNull('client_id')
            ->where('created_at', '>=', now()->subMonths(3)->startOfMonth())
            ->sum('value');

        $this->projectedExpense = $expensesLast3 > 0 ? round($expensesLast3 / 3, 2) : 0;
        $this->projectedBalance = $this->potentialRevenue - $this->projectedExpense;
    }

    public function render()
    {
        return view('livewire.page.dashboard', [
            'teamsByCategoryJson' => json_encode($this->teamsByCategory),
            'monthlyTrendJson' => json_encode($this->monthlyTrend),
        ])->layout('layouts.app');
    }
}
