<div>
    <div class="bg-gray-900 border border-gray-800 p-6 rounded-xl mb-6">
        <h1 class="text-2xl font-semibold text-gray-100">Dashboard</h1>
    </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
                <p class="text-sm text-gray-400">Total Receitas</p>
                <p class="text-2xl font-bold text-green-400">R$ {{ number_format($totalReceitas, 2, ',', '.') }}</p>
            </div>
            <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
                <p class="text-sm text-gray-400">Total Despesas</p>
                <p class="text-2xl font-bold text-red-400">R$ {{ number_format(abs($totalDespesas), 2, ',', '.') }}</p>
            </div>
            <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
                <p class="text-sm text-gray-400">Saldo</p>
                <p class="text-2xl font-bold {{ $saldo >= 0 ? 'text-blue-400' : 'text-red-400' }}">R$ {{ number_format($saldo, 2, ',', '.') }}</p>
            </div>
            <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
                <p class="text-sm text-gray-400">Contas Pendentes</p>
                <p class="text-2xl font-bold text-yellow-400">{{ $pendingCount }}</p>
            </div>
        </div>

        {{-- Comparativo mensal --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
                <p class="text-sm text-gray-400">Receitas deste mês</p>
                <p class="text-2xl font-bold text-green-400">R$ {{ number_format($currentMonthReceitas, 2, ',', '.') }}</p>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-xs text-gray-500">{{ now()->format('F/Y') }}</span>
                    <span class="text-xs {{ $receitaChangePercent >= 0 ? 'text-green-500' : 'text-red-500' }}">
                        {{ $receitaChangePercent >= 0 ? '+' : '' }}{{ $receitaChangePercent }}% vs mês anterior
                    </span>
                </div>
            </div>
            <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
                <p class="text-sm text-gray-400">Despesas deste mês</p>
                <p class="text-2xl font-bold text-red-400">R$ {{ number_format(abs($currentMonthDespesas), 2, ',', '.') }}</p>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-xs text-gray-500">{{ now()->format('F/Y') }}</span>
                    <span class="text-xs {{ $despesaChangePercent <= 0 ? 'text-green-500' : 'text-red-500' }}">
                        {{ $despesaChangePercent >= 0 ? '+' : '' }}{{ $despesaChangePercent }}% vs mês anterior
                    </span>
                </div>
            </div>
        </div>

        {{-- Gráficos --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-white mb-4">Tendência Mensal</h3>
                <div class="max-h-52">
                    <canvas id="trendChart" x-data="{}" x-init="
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
                                plugins: {
                                    legend: { labels: { color: '#9ca3af', boxWidth: 12, padding: 8 } }
                                },
                                scales: {
                                    x: { ticks: { color: '#6b7280', font: { size: 10 } }, grid: { color: '#1f2937' } },
                                    y: { ticks: { color: '#6b7280', font: { size: 10 }, callback: v => 'R$ ' + v.toFixed(0) }, grid: { color: '#1f2937' } }
                                }
                            }
                        })
                    "></canvas>
                </div>
            </div>

            <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-white mb-4">Maiores Despesas por Categoria</h3>
                <div class="max-h-52">
                    <canvas id="categoryChart" x-data="{}" x-init="
                        new Chart($el, {
                            type: 'bar',
                            data: {
                                labels: {{ $topCategoriesJson }}.map(d => d.name),
                                datasets: [{
                                    label: 'Total',
                                    data: {{ $topCategoriesJson }}.map(d => d.value),
                                    backgroundColor: ['#f87171', '#fb923c', '#fbbf24', '#a78bfa', '#60a5fa'],
                                }]
                            },
                            options: {
                                indexAxis: 'y',
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: { legend: { display: false } },
                                scales: {
                                    x: { ticks: { color: '#6b7280', font: { size: 10 }, callback: v => 'R$ ' + v.toFixed(0) }, grid: { color: '#1f2937' } },
                                    y: { ticks: { color: '#9ca3af', font: { size: 10 } }, grid: { display: false } }
                                }
                            }
                        })
                    "></canvas>
                </div>
                @if (count($topCategories) === 0)
                    <p class="text-gray-500 text-sm text-center mt-4">Nenhuma despesa categorizada.</p>
                @endif
            </div>
        </div>

        {{-- Transações Recentes --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-white">Contas Recentes</h3>
                    <a href="{{ route('financeiro.transactions') }}" wire:navigate class="text-sm text-blue-500 hover:text-blue-400">Ver todas</a>
                </div>
                <div class="bg-gray-900 border border-gray-800 rounded-lg divide-y divide-gray-800">
                    @forelse ($recentTransactions as $t)
                        <div class="p-4 flex justify-between items-center">
                            <div>
                                <p class="text-white font-medium">{{ $t->description }}</p>
                                <p class="text-xs text-gray-500">{{ $t->month }}/{{ $t->year }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold {{ $t->value >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                    R$ {{ number_format($t->value, 2, ',', '.') }}
                                </p>
                                <span class="text-xs {{ $t->paid ? 'text-green-500' : 'text-yellow-500' }}">
                                    {{ $t->paid ? 'Pago' : 'Pendente' }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-center text-gray-500">Nenhuma conta registrada.</div>
                    @endforelse
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-white mb-4">Ações Rápidas</h3>
                <div class="space-y-3">
                    <a href="{{ route('financeiro.transactions') }}" wire:navigate
                       class="block bg-gray-900 border border-gray-800 rounded-lg p-4 hover:bg-gray-800 transition">
                        <p class="text-white font-medium">Nova Conta</p>
                        <p class="text-sm text-gray-400">Lançar conta do mês</p>
                    </a>
                    <a href="{{ route('financeiro.account-types') }}" wire:navigate
                       class="block bg-gray-900 border border-gray-800 rounded-lg p-4 hover:bg-gray-800 transition">
                        <p class="text-white font-medium">Tipos de Conta</p>
                        <p class="text-sm text-gray-400">Gerenciar tipos de conta</p>
                    </a>
                    <a href="{{ route('financeiro.categories') }}" wire:navigate
                       class="block bg-gray-900 border border-gray-800 rounded-lg p-4 hover:bg-gray-800 transition">
                        <p class="text-white font-medium">Categorias</p>
                        <p class="text-sm text-gray-400">Gerenciar categorias financeiras</p>
                    </a>
                </div>
            </div>
        </div>
</div>
