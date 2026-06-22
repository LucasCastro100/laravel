<div>
    <div class="bg-gray-900 border border-gray-800 p-6 rounded-xl mb-6">
        <h1 class="text-2xl font-semibold text-gray-100">Dashboard</h1>
    </div>

        @php
            $user = auth()->user();
            $showTbr = $user->isSuperAdmin() || !$user->system_id || $user->system->slug === 'tbr';
            $showFinanceiro = $user->isSuperAdmin() || !$user->system_id || $user->system->slug === 'financeiro';
            $showClientes = $user->isSuperAdmin() || !$user->system_id || $user->system->slug === 'clientes';
        @endphp

        @if ($user->isSuperAdmin() || !$user->system_id)
            <div class="mb-6 border-b border-gray-800">
                <nav class="flex gap-4">
                    @if ($showTbr)
                        <button wire:click="$set('activeTab', 'tbr')"
                            class="px-4 py-2 text-sm font-medium rounded-t-lg transition
                            {{ $activeTab === 'tbr' ? 'bg-gray-900 text-white border-b-2 border-blue-500' : 'text-gray-400 hover:text-gray-200' }}">
                            TBR
                        </button>
                    @endif
                    @if ($showFinanceiro)
                        <button wire:click="$set('activeTab', 'financeiro')"
                            class="px-4 py-2 text-sm font-medium rounded-t-lg transition
                            {{ $activeTab === 'financeiro' ? 'bg-gray-900 text-white border-b-2 border-blue-500' : 'text-gray-400 hover:text-gray-200' }}">
                            Financeiro
                        </button>
                    @endif
                    @if ($showClientes)
                        <button wire:click="$set('activeTab', 'clientes')"
                            class="px-4 py-2 text-sm font-medium rounded-t-lg transition
                            {{ $activeTab === 'clientes' ? 'bg-gray-900 text-white border-b-2 border-blue-500' : 'text-gray-400 hover:text-gray-200' }}">
                            Clientes
                        </button>
                    @endif
                </nav>
            </div>
        @endif

        @php $showSection = $user->isSuperAdmin() || !$user->system_id ? $activeTab : $user->system->slug; @endphp

        {{-- TBR --}}
        @if ($showSection === 'tbr' && $showTbr)
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
                    <p class="text-sm text-gray-400">Total de Eventos</p>
                    <p class="text-2xl font-bold text-white">{{ $totalEvents }}</p>
                </div>
                <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
                    <p class="text-sm text-gray-400">Total de Equipes</p>
                    <p class="text-2xl font-bold text-white">{{ $totalTeams }}</p>
                </div>
                <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
                    <p class="text-sm text-gray-400">Eventos Ativos</p>
                    <p class="text-2xl font-bold text-green-400">{{ $events ? $events->where('status', false)->count() : 0 }}</p>
                </div>
                <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
                    <p class="text-sm text-gray-400">Média Equipes/Evento</p>
                    <p class="text-2xl font-bold text-indigo-400">{{ $totalEvents > 0 ? round($totalTeams / $totalEvents, 1) : 0 }}</p>
                </div>
            </div>

            @if (count($teamsByCategory) > 0)
                <div class="bg-gray-900 border border-gray-800 rounded-lg p-6 mb-8">
                    <h3 class="text-sm font-semibold text-gray-300 mb-3 uppercase tracking-wide">Equipes por Categoria</h3>
                    <div class="max-h-48">
                        <canvas id="tbrCategoryChart" x-data="{}" x-init="
                            new Chart($el, {
                                type: 'bar',
                                data: {
                                    labels: {{ $teamsByCategoryJson }}.map(d => d.label),
                                    datasets: [{
                                        label: 'Equipes',
                                        data: {{ $teamsByCategoryJson }}.map(d => d.count),
                                        backgroundColor: ['#60a5fa', '#34d399', '#fbbf24', '#f87171', '#a78bfa', '#fb923c'],
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: { legend: { display: false } },
                                    scales: {
                                        x: { ticks: { color: '#9ca3af' }, grid: { display: false } },
                                        y: { ticks: { color: '#6b7280', stepSize: 1 }, grid: { color: '#1f2937' } }
                                    }
                                }
                            })
                        "></canvas>
                    </div>
                </div>
            @endif

            @if ($events && $events->isNotEmpty())
                <div class="bg-gray-900 border border-gray-800 rounded-lg">
                    <div class="p-4 border-b border-gray-800">
                        <h3 class="text-base font-semibold text-white">Eventos Recentes</h3>
                    </div>
                    <div class="divide-y divide-gray-800">
                        @foreach ($events as $event)
                            <div class="p-4 flex items-center justify-between hover:bg-gray-800/50 transition">
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-white font-medium truncate">{{ $event->name }}</h4>
                                    <p class="text-xs text-gray-400 mt-0.5">
                                        {{ $event->date?->format('d/m/Y') ?? 'Sem data' }}
                                        &middot; {{ $event->teams_count }} equipes
                                    </p>
                                </div>
                                <div class="flex items-center gap-2 shrink-0 ml-4">
                                    <span class="px-2 py-0.5 text-xs rounded-full {{ $event->status ? 'bg-gray-700 text-gray-400' : 'bg-green-900 text-green-400' }}">
                                        {{ $event->status ? 'Concluído' : 'Ativo' }}
                                    </span>
                                    <a href="{{ route('tbr.event-detail', $event->id) }}" wire:navigate
                                       class="px-2.5 py-1 text-xs bg-gray-700 text-gray-300 rounded hover:bg-gray-600 transition">Gerenciar</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="bg-gray-900 border border-gray-800 rounded-lg p-6 text-center text-gray-400">
                    <p>Nenhum evento cadastrado.</p>
                </div>
            @endif
        @endif

        {{-- Financeiro --}}
        @if ($showSection === 'financeiro' && $showFinanceiro)
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
                    <p class="text-sm text-gray-400">Receitas</p>
                    <p class="text-2xl font-bold text-green-400">R$ {{ number_format($totalIncome, 2, ',', '.') }}</p>
                </div>
                <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
                    <p class="text-sm text-gray-400">Despesas</p>
                    <p class="text-2xl font-bold text-red-400">R$ {{ number_format($totalExpense, 2, ',', '.') }}</p>
                </div>
                <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
                    <p class="text-sm text-gray-400">Pago este mês</p>
                    <p class="text-2xl font-bold text-blue-400">R$ {{ number_format($paidThisMonth, 2, ',', '.') }}</p>
                </div>
                <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
                    <p class="text-sm text-gray-400">Pendentes</p>
                    <p class="text-2xl font-bold text-yellow-400">{{ $pendingBills }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
                    <h3 class="text-sm font-semibold text-gray-300 mb-3 uppercase tracking-wide">Tendência Mensal</h3>
                    <div class="max-h-44">
                        <canvas id="finTrendChart" x-data="{}" x-init="
                            new Chart($el, {
                                type: 'line',
                                data: {
                                    labels: {{ $monthlyTrendJson }}.map(d => d.month),
                                    datasets: [
                                        {
                                            label: 'Receitas',
                                            data: {{ $monthlyTrendJson }}.map(d => d.receitas),
                                            borderColor: '#34d399',
                                            backgroundColor: 'rgba(52, 211, 153, 0.1)',
                                            fill: true, tension: 0.3,
                                            pointRadius: 3,
                                        },
                                        {
                                            label: 'Despesas',
                                            data: {{ $monthlyTrendJson }}.map(d => d.despesas),
                                            borderColor: '#f87171',
                                            backgroundColor: 'rgba(248, 113, 113, 0.1)',
                                            fill: true, tension: 0.3,
                                            pointRadius: 3,
                                        }
                                    ]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: { legend: { labels: { color: '#9ca3af', boxWidth: 12, padding: 8 } } },
                                    scales: {
                                        x: { ticks: { color: '#6b7280', font: { size: 10 } }, grid: { color: '#1f2937' } },
                                        y: { ticks: { color: '#6b7280', font: { size: 10 }, callback: v => 'R$' + v.toFixed(0) }, grid: { color: '#1f2937' } }
                                    }
                                }
                            })
                        "></canvas>
                    </div>
                </div>

                <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
                    <h3 class="text-sm font-semibold text-gray-300 mb-3 uppercase tracking-wide">Resumo</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs text-gray-500">Mês Atual</p>
                            <p class="text-lg font-bold text-white">R$ {{ number_format($paidThisMonth, 2, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Mês Anterior</p>
                            <p class="text-lg font-bold text-white">R$ {{ number_format($paidLastMonth, 2, ',', '.') }}</p>
                        </div>
                        @php
                            $change = $paidThisMonth - $paidLastMonth;
                            $pct = $paidLastMonth > 0 ? round(($change / $paidLastMonth) * 100, 1) : 0;
                        @endphp
                        <div>
                            <p class="text-xs text-gray-500">Variação</p>
                            <p class="text-lg font-bold {{ $change >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                {{ $change >= 0 ? '+' : '' }}R$ {{ number_format($change, 2, ',', '.') }}
                                <span class="text-sm">({{ $pct >= 0 ? '+' : '' }}{{ $pct }}%)</span>
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Saldo Total</p>
                            <p class="text-lg font-bold {{ ($totalIncome + $totalExpense) >= 0 ? 'text-blue-400' : 'text-red-400' }}">
                                R$ {{ number_format($totalIncome + $totalExpense, 2, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <a href="{{ route('financeiro.dashboard') }}" wire:navigate
                   class="inline-block px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition">
                    Ver dashboard completo
                </a>
            </div>
        @endif

        {{-- Clientes --}}
        @if ($showSection === 'clientes' && $showClientes)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-gray-900 border border-gray-800 rounded-lg p-5">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Clientes Ativos</p>
                    <p class="text-xl font-bold text-white mt-1">{{ $totalClients }}</p>
                </div>
                <div class="bg-gray-900 border border-gray-800 rounded-lg p-5">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Total Planos</p>
                    <p class="text-xl font-bold text-green-400 mt-1">{{ $totalPlans }}</p>
                </div>

                <div class="bg-gray-900 border border-gray-800 rounded-lg p-5">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Receita deste mês</p>
                    <p class="text-xl font-bold text-blue-400 mt-1">R$ {{ number_format($currentMonthRevenue, 2, ',', '.') }}</p>
                </div>
                <div class="bg-gray-900 border border-gray-800 rounded-lg p-5">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Total Arrecadado</p>
                    <p class="text-xl font-bold text-yellow-400 mt-1">R$ {{ number_format($totalClientRevenue, 2, ',', '.') }}</p>
                </div>
            </div>

            <div class="flex gap-4">
                <a href="{{ route('clientes.clients') }}" wire:navigate
                   class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition">
                    Gerenciar Clientes
                </a>
                <a href="{{ route('clientes.plans') }}" wire:navigate
                   class="px-4 py-2 bg-purple-600 text-white text-sm rounded-lg hover:bg-purple-700 transition">
                    Gerenciar Planos
                </a>
            </div>
        @endif
</div>
