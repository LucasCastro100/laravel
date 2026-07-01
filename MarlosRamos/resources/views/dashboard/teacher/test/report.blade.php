<x-app-layout title="Relatório de Testes">
    <x-slot name="header">
        <x-page-title title="Relatório de Testes" />
    </x-slot>

    <div class="py-8">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Distribuição Total --}}
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider mb-3">Distribuição Total de Percentuais</p>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    @foreach ($totalPercent as $letra => $valor)
                        <div class="bg-gray-900 rounded-2xl border border-gray-800 p-5">
                            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Canal {{ $letra }}</p>
                            <p class="text-3xl font-extrabold text-gray-100">{{ $valor }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Preferências --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-gray-900 rounded-2xl border border-gray-800 p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-1 h-5 bg-green-500 rounded-full"></div>
                        <h3 class="text-sm font-semibold text-gray-100">Preferência Primária</h3>
                    </div>
                    <ul class="space-y-2">
                        @foreach ($primaryCount as $letra => $count)
                            <li class="flex items-center justify-between py-2 border-b border-gray-800 last:border-0">
                                <span class="text-lg font-bold text-gray-100">{{ $letra }}</span>
                                <span class="text-sm text-gray-400">{{ $count }} aluno(s)</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="bg-gray-900 rounded-2xl border border-gray-800 p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-1 h-5 bg-orange-500 rounded-full"></div>
                        <h3 class="text-sm font-semibold text-gray-100">Preferência Secundária</h3>
                    </div>
                    <ul class="space-y-2">
                        @foreach ($secondaryCount as $letra => $count)
                            <li class="flex items-center justify-between py-2 border-b border-gray-800 last:border-0">
                                <span class="text-lg font-bold text-gray-100">{{ $letra }}</span>
                                <span class="text-sm text-gray-400">{{ $count }} aluno(s)</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Listagem Completa --}}
            <div class="bg-gray-900 rounded-2xl border border-gray-800 shadow-xl p-6">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-1 h-6 bg-blue-500 rounded-full"></div>
                    <h3 class="text-base font-semibold text-gray-100">Resultados Individuais</h3>
                </div>

                @if ($testsNotLogin->isEmpty())
                    <p class="py-8 text-center text-sm text-gray-500">Nenhum teste encontrado para esta data.</p>
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
                                @foreach ($testsNotLogin as $test)
                                    @php
                                        $percent = is_array($test->percentual)
                                            ? $test->percentual
                                            : json_decode($test->percentual, true);
                                    @endphp
                                    <tr class="hover:bg-gray-800/40 transition">
                                        <td class="px-4 py-3.5 text-gray-200 font-medium whitespace-nowrap">{{ mb_strtoupper($test->name) }}</td>
                                        <td class="px-4 py-3.5 text-gray-400 whitespace-nowrap">{{ $test->phone ?? '—' }}</td>
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
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-green-500/10 text-green-400">{{ $test->primary }}</span>
                                        </td>
                                        <td class="px-4 py-3.5">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-orange-500/10 text-orange-400">{{ $test->secondary }}</span>
                                        </td>
                                        <td class="px-4 py-3.5 text-gray-500 whitespace-nowrap text-xs">{{ $test->created_at->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>

