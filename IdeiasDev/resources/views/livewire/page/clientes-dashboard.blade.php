<div>
    <div class="bg-gray-900 border border-gray-800 p-6 rounded-xl mb-6">
        <h1 class="text-2xl font-semibold text-gray-100">Dashboard</h1>
    </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-gray-900 border border-gray-800 rounded-lg p-5">
                <p class="text-xs text-gray-500 uppercase tracking-wide">Receita do Mês</p>
                <p class="text-xl font-bold text-blue-400 mt-1">R$ {{ number_format($monthlyRevenue, 2, ',', '.') }}</p>
            </div>
            <div class="bg-gray-900 border border-gray-800 rounded-lg p-5">
                <p class="text-xs text-gray-500 uppercase tracking-wide">Gastos do Mês</p>
                <p class="text-xl font-bold text-red-400 mt-1">R$ {{ number_format($monthlyExpenses, 2, ',', '.') }}</p>
            </div>
            <div class="bg-gray-900 border border-gray-800 rounded-lg p-5">
                <p class="text-xs text-gray-500 uppercase tracking-wide">Planos</p>
                <p class="text-xl font-bold text-purple-400 mt-1">{{ $totalPlans }}</p>
            </div>
            <div class="bg-gray-900 border border-gray-800 rounded-lg p-5">
                <p class="text-xs text-gray-500 uppercase tracking-wide">Clientes no Mês</p>
                <p class="text-xl font-bold text-white mt-1">{{ $monthlyClients }}</p>
            </div>
        </div>

        {{-- Gráfico mensal --}}
        @php $trendJson = json_encode($monthlyTrend); @endphp
        <div class="bg-gray-900 border border-gray-800 rounded-lg p-6 mb-8">
            <h3 class="text-lg font-semibold text-white mb-4">Total por Mês</h3>
            <div style="height: 250px;">
                <canvas id="clientesTrendChart"
                        x-data="{ trend: {{ $trendJson }} }"
                        x-init="
                            let t = trend;
                            setTimeout(() => {
                                new Chart($el, {
                                    type: 'line',
                                    data: {
                                        labels: t.map(d => d.month),
                                        datasets: [
                                            {
                                                label: 'Receitas',
                                                data: t.map(d => d.receitas),
                                                borderColor: '#3b82f6',
                                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                                fill: true, tension: 0.3,
                                                pointRadius: 3,
                                            },
                                            {
                                                label: 'Gastos',
                                                data: t.map(d => d.despesas),
                                                borderColor: '#ef4444',
                                                backgroundColor: 'rgba(239, 68, 68, 0.1)',
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
                                            y: { beginAtZero: true, ticks: { color: '#6b7280', font: { size: 10 }, callback: v => 'R$ ' + v.toFixed(0) }, grid: { color: '#1f2937' } }
                                        }
                                    }
                                })
                            }, 100);
                        "></canvas>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold text-white mb-4">Clientes Recentes</h3>
                <div class="bg-gray-900 border border-gray-800 rounded-lg divide-y divide-gray-800">
                    @forelse ($recentClients as $client)
                        <div class="p-4 flex justify-between items-center">
                            <div>
                                <p class="text-white font-medium">{{ $client->name }}</p>
                                <p class="text-xs text-gray-500">{{ $client->email ?? 'Sem email' }}</p>
                            </div>
                            <span class="text-xs text-gray-500">{{ $client->created_at->format('d/m/Y') }}</span>
                        </div>
                    @empty
                        <div class="p-6 text-center text-gray-500">Nenhum cliente cadastrado.</div>
                    @endforelse
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold text-white mb-4">Ações Rápidas</h3>
                <div class="space-y-3">
                    <a href="{{ route('clientes.clients') }}" wire:navigate
                       class="block bg-gray-900 border border-gray-800 rounded-lg p-4 hover:bg-gray-800 transition">
                        <p class="text-white font-medium">Clientes</p>
                        <p class="text-sm text-gray-400">Gerenciar clientes</p>
                    </a>
                    <a href="{{ route('clientes.plans') }}" wire:navigate
                       class="block bg-gray-900 border border-gray-800 rounded-lg p-4 hover:bg-gray-800 transition">
                        <p class="text-white font-medium">Planos</p>
                        <p class="text-sm text-gray-400">Gerenciar planos e valores</p>
                    </a>
                    <a href="{{ route('clientes.receitas') }}" wire:navigate
                        class="block bg-gray-900 border border-gray-800 rounded-lg p-4 hover:bg-gray-800 transition">
                        <p class="text-white font-medium">Receitas</p>
                        <p class="text-sm text-gray-400">Registrar recebimentos dos clientes</p>
                    </a>
                    <a href="{{ route('clientes.accounts') }}" wire:navigate
                       class="block bg-gray-900 border border-gray-800 rounded-lg p-4 hover:bg-gray-800 transition">
                        <p class="text-white font-medium">Gastos</p>
                        <p class="text-sm text-gray-400">Gastos operacionais do estabelecimento</p>
                    </a>
            </div>
        </div>
    </div>
</div>