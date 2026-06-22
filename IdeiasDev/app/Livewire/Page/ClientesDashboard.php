<?php

namespace App\Livewire\Page;

use Livewire\Component;
use App\Models\Client;
use App\Models\Plan;
use App\Models\ClientAccount;
use App\Models\FinancialTransaction;
use Illuminate\Support\Facades\DB;

class ClientesDashboard extends Component
{
    public $totalClients = 0;
    public $totalPlans = 0;
    public $totalRevenue = 0;
    public $totalExpenses = 0;
    public $monthlyTrend = [];
    public $recentClients;

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $userId = auth()->id();

        $this->totalClients = Client::where('user_id', $userId)->where('active', true)->count();
        $this->totalPlans = Plan::where('user_id', $userId)->count();
        $this->totalRevenue = ClientAccount::where('user_id', $userId)->whereNotNull('client_id')->sum('value');
        $this->totalExpenses = ClientAccount::where('user_id', $userId)->whereNull('client_id')->sum('value');

        $now = now();
        $trend = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = $now->copy()->subMonths($i);
            $receitas = ClientAccount::where('user_id', $userId)
                ->whereNotNull('client_id')
                ->where('month', $date->month)->where('year', $date->year)
                ->sum('value');
            $despesas = ClientAccount::where('user_id', $userId)
                ->whereNull('client_id')
                ->where('month', $date->month)->where('year', $date->year)
                ->sum('value');
            $trend[] = [
                'month' => $date->format('M/Y'),
                'receitas' => (float) $receitas,
                'despesas' => (float) $despesas,
            ];
        }
        $this->monthlyTrend = $trend;

        $this->recentClients = Client::where('user_id', $userId)
            ->where('active', true)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.page.clientes-dashboard')
            ->layout('layouts.app-sidebar', [
                'showSidebar' => true,
                'title' => 'Dashboard Clientes',
            ]);
    }
}
