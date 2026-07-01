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
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mb-8">
            <div class="lg:col-span-1 flex flex-col gap-2">
                <x-dashboard-card label="Eventos" color="text-cyan-400" :value="$totalEvents" />
                <x-dashboard-card label="Equipes" color="text-indigo-400" :value="$totalTeams" />
                <x-dashboard-card label="Ativos" color="text-green-400" :value="$events ? $events->where('status', false)->count() : 0" />
                <x-dashboard-card label="Média" color="text-indigo-400" :value="$totalEvents > 0 ? round($totalTeams / $totalEvents, 1) : 0" />
            </div>

            <div class="lg:col-span-3 bg-gray-900 border border-gray-800 rounded-lg p-4 flex flex-col">
                <h3 class="text-xs font-semibold text-gray-300 mb-3 uppercase tracking-wide">Equipes por Categoria</h3>
                @if (count($teamsByCategory) > 0)
                    <div class="flex-1 min-h-[220px]">
                        <canvas id="tbrCategoryChart" x-data="{}" x-init="new Chart($el, {
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
                        })"></canvas>
                    </div>
                @else
                    <p class="text-gray-500 text-sm text-center mt-6">Nenhuma categoria com equipes.</p>
                @endif
            </div>
        </div>

        @if ($events && $events->isNotEmpty())
            <div>
                <h3 class="text-sm font-semibold text-gray-300 mb-3 uppercase tracking-wide">Últimos Eventos</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
                    @foreach ($events->take(4) as $event)
                        <a href="{{ route('tbr.event-detail', $event->id) }}" wire:navigate
                            class="block group bg-gray-900/80 border border-gray-800 rounded-xl hover:border-gray-600 hover:bg-gray-900 transition-all duration-300">
                            <div class="px-4 pt-4 pb-2">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-base font-bold text-gray-100 truncate">{{ $event->name }}</h4>
                                    @php
                                        $isConcluded = !empty($event->status);
                                        $tipo = $event->tipo_evento ?? 'interno';
                                        $tipoBadgeColors = ['interno' => 'bg-gray-600', 'regional' => 'bg-blue-600', 'nacional' => 'bg-green-600'];
                                        $tipoColor = $tipoBadgeColors[$tipo] ?? 'bg-gray-600';
                                    @endphp
                                    <div class="flex gap-1 shrink-0 ml-2">
                                        <span class="text-xs font-bold uppercase tracking-wide px-2 py-0.5 rounded {{ $tipoColor }} text-white">{{ ucfirst($tipo) }}</span>
                                        <span class="text-xs font-bold uppercase tracking-wide px-2 py-0.5 rounded {{ $isConcluded ? 'bg-green-600' : 'bg-yellow-600' }} text-white">
                                            {{ $isConcluded ? 'Concluído' : 'Em Andamento' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="border-t border-gray-800"></div>
                            <div class="px-4 py-3 space-y-2 text-sm text-gray-400">
                                @if (!empty($event->date))
                                    <div class="flex items-center gap-3">
                                        <div class="flex items-center justify-center w-7 h-7 rounded-lg bg-gray-800/80 shrink-0">
                                            <i class="fas fa-calendar-alt text-blue-400 text-xs"></i>
                                        </div>
                                        <span>{{ $event->date->format('d/m/Y') }}</span>
                                    </div>
                                @endif
                                @if (isset($event->teams_count))
                                    <div class="flex items-center gap-3">
                                        <div class="flex items-center justify-center w-7 h-7 rounded-lg bg-gray-800/80 shrink-0">
                                            <i class="fas fa-users text-gray-500 text-xs"></i>
                                        </div>
                                        <span>{{ $event->teams_count }} equipes</span>
                                    </div>
                                @endif
                                @if (!empty($event->location['municipio']) && !empty($event->location['estado']))
                                    <div class="flex items-center gap-3">
                                        <div class="flex items-center justify-center w-7 h-7 rounded-lg bg-gray-800/80 shrink-0">
                                            <i class="fas fa-map-marker-alt text-red-400 text-xs"></i>
                                        </div>
                                        <span>{{ $event->location['municipio']['nome'] }} - {{ $event->location['estado']['sigla'] }}</span>
                                    </div>
                                @endif
                            </div>
                        </a>
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
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mb-8">
            <div class="lg:col-span-1 flex flex-col gap-2">
                <x-dashboard-card label="Receitas" color="text-green-400" value="R$ {{ number_format($totalIncome, 2, ',', '.') }}" />
                <x-dashboard-card label="Despesas" color="text-red-400" value="R$ {{ number_format($totalExpense, 2, ',', '.') }}" />
                <x-dashboard-card label="Pago mês" color="text-blue-400" value="R$ {{ number_format($paidThisMonth, 2, ',', '.') }}" />
                <x-dashboard-card label="Pendentes" color="text-yellow-400" :value="$pendingBills" />
            </div>

            <div class="lg:col-span-3 bg-gray-900 border border-gray-800 rounded-lg p-4 flex flex-col">
                <h3 class="text-xs font-semibold text-gray-300 mb-3 uppercase tracking-wide">Tendência Mensal</h3>
                <div class="flex-1 min-h-[220px]">
                    <canvas id="finTrendChart" x-data="{}" x-init="new Chart($el, {
                        type: 'line',
                        data: {
                            labels: {{ $monthlyTrendJson }}.map(d => d.month),
                            datasets: [{
                                    label: 'Receitas',
                                    data: {{ $monthlyTrendJson }}.map(d => d.receitas),
                                    borderColor: '#34d399',
                                    backgroundColor: 'rgba(52, 211, 153, 0.1)',
                                    fill: true,
                                    tension: 0.3,
                                    pointRadius: 3,
                                },
                                {
                                    label: 'Despesas',
                                    data: {{ $monthlyTrendJson }}.map(d => d.despesas),
                                    borderColor: '#f87171',
                                    backgroundColor: 'rgba(248, 113, 113, 0.1)',
                                    fill: true,
                                    tension: 0.3,
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
                                y: { ticks: { color: '#6b7280', font: { size: 10 }, callback: v => 'R$ ' + v.toFixed(0) }, grid: { color: '#1f2937' } }
                            }
                        }
                    })"></canvas>
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
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mb-8">
            <div class="lg:col-span-1 flex flex-col gap-2">
                <x-dashboard-card label="Receita Prevista" color="text-cyan-400" value="R$ {{ number_format($expectedRevenue, 2, ',', '.') }}" />
                <x-dashboard-card label="Receita Arrecadada" color="text-blue-400" value="R$ {{ number_format($arrecadado, 2, ',', '.') }}" />
                <x-dashboard-card label="Gasto" color="text-red-400" value="R$ {{ number_format($monthlyExpenses, 2, ',', '.') }}" />
                <x-dashboard-card label="Total Líquido" color="{{ $netTotal >= 0 ? 'text-emerald-400' : 'text-red-400' }}" value="R$ {{ number_format($netTotal, 2, ',', '.') }}" />
            </div>

            <div class="lg:col-span-3 bg-gray-900 border border-gray-800 rounded-lg p-4 flex flex-col">
                <h3 class="text-xs font-semibold text-gray-300 mb-3 uppercase tracking-wide">Receitas vs Gastos</h3>
                <div class="flex-1 min-h-[220px]">
                    <canvas id="clientesTrendChart" x-data="{}" x-init="new Chart($el, {
                        type: 'line',
                        data: {
                            labels: {{ $clientesTrendJson }}.map(d => d.month),
                            datasets: [{
                                label: 'Receitas',
                                data: {{ $clientesTrendJson }}.map(d => d.receitas),
                                borderColor: '#3b82f6',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                fill: true,
                                tension: 0.3,
                                pointRadius: 3,
                            }, {
                                label: 'Gastos',
                                data: {{ $clientesTrendJson }}.map(d => d.despesas),
                                borderColor: '#ef4444',
                                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                                fill: true,
                                tension: 0.3,
                                pointRadius: 3,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { labels: { color: '#9ca3af', boxWidth: 12, padding: 8 } }
                            },
                            scales: {
                                x: { ticks: { color: '#6b7280', font: { size: 10 } }, grid: { color: '#1f2937' } },
                                y: { beginAtZero: true, ticks: { color: '#6b7280', font: { size: 10 }, callback: v => 'R$ ' + v.toFixed(0) }, grid: { color: '#1f2937' } }
                            }
                        }
                    })"></canvas>
                </div>
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('clientes.dashboard') }}" wire:navigate
                class="inline-block px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition">
                Ver dashboard completo
            </a>
        </div>
    @endif
</div>
