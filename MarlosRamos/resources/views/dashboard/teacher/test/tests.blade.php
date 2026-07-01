<x-app-layout :title="$title">
    <x-slot name="header">
        <x-page-title title="Gerenciamento dos Testes" />
    </x-slot>

    <div class="py-8">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-900 rounded-2xl border border-gray-800 shadow-xl p-6">

                <div x-data="{ tab: '{{ request('tab', 'testYesLogin') }}' }">

                    {{-- Controles: tabs + per_page --}}
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
                        <div class="flex gap-1 p-1 bg-gray-800 rounded-xl w-full sm:w-fit">
                            <button @click="tab = 'testYesLogin'"
                                :class="tab === 'testYesLogin' ? 'bg-gray-700 text-gray-100 shadow-sm' : 'text-gray-400 hover:text-gray-200'"
                                class="flex items-center gap-2 px-4 py-1.5 rounded-lg text-sm font-medium transition whitespace-nowrap">
                                <i class="fa-solid fa-users text-xs"></i>
                                Alunos
                                <span class="text-xs opacity-70">({{ $testsWithLogin->total() }})</span>
                            </button>
                            <button @click="tab = 'testNotLogin'"
                                :class="tab === 'testNotLogin' ? 'bg-gray-700 text-gray-100 shadow-sm' : 'text-gray-400 hover:text-gray-200'"
                                class="flex items-center gap-2 px-4 py-1.5 rounded-lg text-sm font-medium transition whitespace-nowrap">
                                <i class="fa-solid fa-calendar-days text-xs"></i>
                                Eventos
                                <span class="text-xs opacity-70">({{ $testsNotLogin->total() }})</span>
                            </button>
                        </div>

                        {{-- Per-page selector --}}
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-500 whitespace-nowrap">Exibir</span>
                            <div class="flex gap-1 p-1 bg-gray-800 rounded-lg">
                                @foreach ([10, 20, 50, 100] as $opt)
                                    <a href="{{ request()->fullUrlWithQuery(['per_page' => $opt, 'tab' => request('tab', 'testYesLogin')]) }}"
                                       class="px-2.5 py-1 rounded-md text-xs font-medium transition {{ $perPage == $opt ? 'bg-blue-600 text-white' : 'text-gray-400 hover:text-gray-200 hover:bg-gray-700' }}">
                                        {{ $opt }}
                                    </a>
                                @endforeach
                            </div>
                            <span class="text-xs text-gray-500 whitespace-nowrap">por página</span>
                        </div>
                    </div>

                    {{-- ALUNOS --}}
                    <div x-show="tab === 'testYesLogin'">
                        @if ($testsWithLogin->isEmpty())
                            <p class="py-8 text-center text-sm text-gray-500">Nenhum resultado encontrado</p>
                        @else
                            <div class="overflow-x-auto rounded-xl border border-gray-800">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="border-b border-gray-800 bg-gray-950/60">
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Nome</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Telefone</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Percentual</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Primário</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Secundário</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Data</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-800">
                                        @foreach ($testsWithLogin as $yesLogin)
                                            @php
                                                $percent = $yesLogin->percentual ?? [];
                                                if (!is_array($percent)) {
                                                    $percent = json_decode($percent, true) ?? [];
                                                }
                                            @endphp
                                            <tr class="hover:bg-gray-800/40 transition">
                                                <td class="px-4 py-3.5 text-gray-200 font-medium whitespace-nowrap">
                                                    {{ mb_strtoupper($yesLogin->user->name ?? 'SEM NOME', 'UTF-8') }}
                                                </td>
                                                <td class="px-4 py-3.5 text-gray-400 whitespace-nowrap">{{ $yesLogin->user->phone ?? '—' }}</td>
                                                <td class="px-4 py-3.5">
                                                    <div class="flex flex-wrap gap-2">
                                                        @foreach ($percent as $letra => $valor)
                                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-gray-800 text-gray-300 ring-1 ring-gray-700">
                                                                <span class="font-bold text-gray-100">{{ $letra }}</span>{{ $valor }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3.5">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-green-500/10 text-green-400">{{ $yesLogin?->primary ?? 0 }}</span>
                                                </td>
                                                <td class="px-4 py-3.5">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-orange-500/10 text-orange-400">{{ $yesLogin?->secondary ?? 0 }}</span>
                                                </td>
                                                <td class="px-4 py-3.5 text-gray-500 whitespace-nowrap text-xs">{{ $yesLogin?->created_at->format('d/m/y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="pt-4">
                                {{ $testsWithLogin->appends(['tab' => 'testYesLogin', 'per_page' => $perPage])->links() }}
                            </div>
                        @endif
                    </div>

                    {{-- EVENTOS --}}
                    <div x-show="tab === 'testNotLogin'">
                        <div class="flex justify-end mb-4">
                            <form method="GET" action="{{ route('teacher.report') }}" class="flex items-center gap-2">
                                <input type="date" name="date"
                                    class="bg-white text-gray-900 border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    value="{{ request('date') ?? now()->format('Y-m-d') }}">
                                <button type="submit"
                                    class="flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-500 text-white text-sm rounded-lg transition">
                                    <i class="fas fa-search text-xs"></i>
                                    Filtrar
                                </button>
                            </form>
                        </div>

                        @if ($testsNotLogin->isEmpty())
                            <p class="py-8 text-center text-sm text-gray-500">Nenhum resultado para esta data</p>
                        @else
                            <div class="overflow-x-auto rounded-xl border border-gray-800">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr class="border-b border-gray-800 bg-gray-950/60">
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Nome</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Telefone</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Percentual</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Primário</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Secundário</th>
                                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Data</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-800">
                                        @foreach ($testsNotLogin as $notLogin)
                                            @php
                                                $percent = $notLogin->percentual ?? [];
                                                if (!is_array($percent)) {
                                                    $percent = json_decode($percent, true) ?? [];
                                                }
                                            @endphp
                                            <tr class="hover:bg-gray-800/40 transition">
                                                <td class="px-4 py-3.5 text-gray-200 font-medium whitespace-nowrap">{{ mb_strtoupper($notLogin->name, 'UTF-8') }}</td>
                                                <td class="px-4 py-3.5 text-gray-400 whitespace-nowrap">{{ $notLogin?->phone ?? '—' }}</td>
                                                <td class="px-4 py-3.5">
                                                    <div class="flex flex-wrap gap-2">
                                                        @foreach ($percent as $letra => $valor)
                                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-gray-800 text-gray-300 ring-1 ring-gray-700">
                                                                <span class="font-bold text-gray-100">{{ $letra }}</span>{{ $valor }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3.5">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-green-500/10 text-green-400">{{ $notLogin?->primary ?? 0 }}</span>
                                                </td>
                                                <td class="px-4 py-3.5">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-orange-500/10 text-orange-400">{{ $notLogin?->secondary ?? 0 }}</span>
                                                </td>
                                                <td class="px-4 py-3.5 text-gray-500 whitespace-nowrap text-xs">{{ $notLogin?->created_at->format('d/m/y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="pt-4">
                                {{ $testsNotLogin->appends(['tab' => 'testNotLogin', 'per_page' => $perPage])->links() }}
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
