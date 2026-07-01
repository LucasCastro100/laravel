<div>
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
            class="bg-green-600 text-white p-3 rounded-lg mb-4 transition duration-500">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-gray-900 border border-gray-800 p-6 rounded-xl mb-6">
        <h1 class="text-2xl font-semibold text-gray-100">Dashboard</h1>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
            <p class="text-sm text-gray-400">Total de Equipes</p>
            <p class="text-2xl font-bold text-white">{{ $totalTeams }}</p>
        </div>
        <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
            <p class="text-sm text-gray-400">Total de Eventos</p>
            <p class="text-2xl font-bold text-white">{{ count($events) }}</p>
        </div>
        <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
            <p class="text-sm text-gray-400">Média de Equipes/Evento</p>
            <p class="text-2xl font-bold text-indigo-400">{{ count($events) > 0 ? round($totalTeams / count($events), 1) : 0 }}</p>
        </div>
        <div class="bg-gray-900 border border-gray-800 rounded-lg p-6">
            <p class="text-sm text-gray-400">Categorias</p>
            <p class="text-2xl font-bold text-green-400">{{ count($teamsByCategory) }}</p>
        </div>
    </div>

    {{-- Chart: Equipes por Categoria --}}
    @if (count($teamsByCategory) > 0)
            <div class="bg-gray-900 border border-gray-800 rounded-lg p-6 mb-8">
            <h3 class="text-sm font-semibold text-gray-300 mb-3 uppercase tracking-wide">Equipes por Categoria</h3>
            <div class="max-h-48">
                <canvas id="teamsByCategoryChart" x-data="{}" x-init="
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
                                x: { ticks: { color: '#9ca3af', font: { size: 10 } }, grid: { display: false } },
                                y: { ticks: { color: '#6b7280', font: { size: 10 }, stepSize: 1 }, grid: { color: '#1f2937' } }
                            }
                        }
                    })
                "></canvas>
            </div>
        </div>
    @endif

    {{-- Eventos --}}
    @if (count($events ?? []) === 0)
        <div class="bg-gray-900 border border-red-900/50 text-red-400 px-4 py-3 rounded-xl mb-6" role="alert">
            <span class="block font-bold">Nenhum evento cadastrado.</span>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4 md:gap-6">
            @foreach ($events as $event)
                <a href="{{ route('tbr.event-detail', ['event_id' => $event['id']]) }}" wire:navigate
                    class="block group bg-gray-900/80 border border-gray-800 rounded-xl hover:border-gray-600 hover:bg-gray-900 transition-all duration-300">

                    <div class="px-5 pt-5 pb-3">
                        <h2 class="text-lg font-bold text-gray-100 truncate">{{ $event['name'] }}</h2>
                        @php
                            $tipo = $event['tipo_evento'] ?? 'interno';
                            $badgeColors = ['interno' => 'bg-gray-600', 'regional' => 'bg-blue-600', 'nacional' => 'bg-green-600'];
                            $color = $badgeColors[$tipo] ?? 'bg-gray-600';
                        @endphp
                        <span class="inline-block mt-1 text-xs font-bold uppercase tracking-wide px-2 py-0.5 rounded {{ $color }} text-white">{{ ucfirst($tipo) }}</span>
                    </div>

                    <div class="border-t border-gray-800"></div>

                    <div class="px-5 py-4 space-y-2.5 text-sm text-gray-400">
                        @if (!empty($event['date']))
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-800/80 shrink-0">
                                    <i class="fas fa-calendar-alt text-blue-400 text-xs"></i>
                                </div>
                                <span>{{ \Carbon\Carbon::parse($event['date'])->format('d/m/Y') }}</span>
                            </div>
                        @endif

                        @if (!empty($event['location']['municipio']) && !empty($event['location']['estado']))
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-800/80 shrink-0">
                                    <i class="fas fa-map-marker-alt text-red-400 text-xs"></i>
                                </div>
                                <span>{{ $event['location']['municipio']['nome'] }} - {{ $event['location']['estado']['sigla'] }}</span>
                            </div>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>
