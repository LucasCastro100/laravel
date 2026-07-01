<?php

namespace App\Livewire\Page;

use Livewire\Component;
use App\Models\Event;
use App\Models\FinancialTransaction;
use App\Models\Client;
use App\Models\Team;
use App\Models\Category;
use App\Models\ClientAccount;

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

    public $clientesTrend = [];
    public $totalClients = 0;
    public $expectedRevenue = 0;
    public $arrecadado = 0;
    public $monthlyExpenses = 0;
    public $netTotal = 0;

    public function mount()
    {
        $user = auth()->user();

        if (!$user->isSuperAdmin() && $user->system_id) {
            $redirects = [
                'tbr' => 'tbr.dashboard',
                'financeiro' => 'financeiro.dashboard',
                'clientes' => 'clientes.dashboard',
            ];

            $slug = $user->system?->slug;
            if ($route = $redirects[$slug] ?? null) {
                $this->redirectRoute($route);
                return;
            }
        }

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
        $isSuper = auth()->user()->isSuperAdmin();

        $baseQuery = fn($query) => $isSuper ? $query : $query->where('user_id', $userId);

        $this->totalIncome = (float) $baseQuery(FinancialTransaction::query())
            ->where('paid', true)->where('value', '>', 0)->sum('value');

        $this->totalExpense = (float) $baseQuery(FinancialTransaction::query())
            ->where('paid', true)->where('value', '<', 0)->sum('value');

        $this->pendingBills = $baseQuery(FinancialTransaction::query())
            ->where('paid', false)->count();

        $this->paidThisMonth = (float) $baseQuery(FinancialTransaction::query())
            ->where('paid', true)
            ->where('month', now()->month)->where('year', now()->year)
            ->sum('value');

        $this->paidLastMonth = (float) $baseQuery(FinancialTransaction::query())
            ->where('paid', true)
            ->where('month', now()->subMonth()->month)->where('year', now()->subMonth()->year)
            ->sum('value');

        $now = now();
        $trend = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = $now->copy()->subMonths($i);
            $rec = (float) $baseQuery(FinancialTransaction::query())
                ->where('paid', true)->where('value', '>', 0)
                ->where('month', $date->month)->where('year', $date->year)->sum('value');
            $desp = (float) $baseQuery(FinancialTransaction::query())
                ->where('paid', true)->where('value', '<', 0)
                ->where('month', $date->month)->where('year', $date->year)->sum('value');
            $trend[] = [
                'month' => $date->format('M/Y'),
                'receitas' => $rec,
                'despesas' => abs($desp),
            ];
        }
        $this->monthlyTrend = $trend;
    }

    public function loadClientesStats()
    {
        $user = auth()->user();
        $isSuper = $user->isSuperAdmin();

        $teamId = null;
        if (!$isSuper) {
            $team = $user->teams()->first();
            $teamId = $team ? (int) $team->id : null;
        }

        $clientBase = $isSuper
            ? Client::query()
            : Client::where('team_id', $teamId);

        $this->totalClients = (clone $clientBase)->count();

        $accountBase = $isSuper
            ? ClientAccount::whereNotNull('client_id')
            : ClientAccount::whereHas('client', fn($q) => $q->where('team_id', $teamId));

        $expenseBase = $isSuper
            ? ClientAccount::whereNull('client_id')
            : ClientAccount::whereNull('client_id')->where('team_id', $teamId);

        $now = now();
        $month = $now->month;
        $year = $now->year;

        $this->expectedRevenue = (float) (clone $accountBase)
            ->where('month', $month)->where('year', $year)
            ->sum('value');

        $this->arrecadado = (float) (clone $accountBase)
            ->where('paid', true)
            ->where('month', $month)->where('year', $year)
            ->sum('value');

        $this->monthlyExpenses = (float) (clone $expenseBase)
            ->where('paid', true)
            ->where('month', $month)->where('year', $year)
            ->sum('value');

        $this->netTotal = $this->arrecadado - $this->monthlyExpenses;

        $trend = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = $now->copy()->subMonths($i);
            $m = $date->month;
            $y = $date->year;
            $rec = (float) (clone $accountBase)
                ->where('paid', true)->where('month', $m)->where('year', $y)->sum('value');
            $desp = (float) (clone $expenseBase)
                ->where('paid', true)->where('month', $m)->where('year', $y)->sum('value');
            $trend[] = [
                'month' => $date->format('M/Y'),
                'receitas' => $rec,
                'despesas' => $desp,
            ];
        }
        $this->clientesTrend = $trend;
    }

    public function render()
    {
        return view('livewire.page.dashboard', [
            'teamsByCategoryJson' => json_encode($this->teamsByCategory),
            'monthlyTrendJson' => json_encode($this->monthlyTrend),
            'clientesTrendJson' => json_encode($this->clientesTrend),
        ])->layout('layouts.app');
    }
}
