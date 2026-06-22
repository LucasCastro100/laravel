<x-app-layout title="Teste Representacional">
    <x-slot name="header">
        <x-page-title title="Relatório de testes do Professor" />
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- RESUMO DOS PERCENTUAIS --}}
            <div>
                <h2 class="text-xl font-bold text-gray-200 mb-4">Distribuição Total de Percentuais</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach ($totalPercent as $letra => $valor)
                        <div class="bg-gray-900 shadow rounded-lg p-5 border">
                            <p class="text-sm text-gray-200">Total {{ $letra }}</p>
                            <h3 class="text-3xl font-extrabold text-gray-100 mt-1">{{ $valor }}</h3>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- FREQUÊNCIA PRIMARY / SECONDARY --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- PRIMARY --}}
                <div class="bg-gray-800 border rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-100 mb-4">Preferência Primária</h3>
                    <ul class="space-y-2">
                        @foreach ($primaryCount as $letra => $count)
                            <li class="flex justify-between border-b pb-2">
                                <span class="font-semibold text-xl">{{ $letra }}</span>
                                <span class="text-gray-200 text-sm">{{ $count }} aluno(s)</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- SECONDARY --}}
                <div class="bg-gray-800 border rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-100 mb-4">Preferência Secundária</h3>
                    <ul class="space-y-2">
                        @foreach ($secondaryCount as $letra => $count)
                            <li class="flex justify-between border-b pb-2">
                                <span class="font-semibold text-xl">{{ $letra }}</span>
                                <span class="text-gray-200 text-sm">{{ $count }} aluno(s)</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- LISTAGEM --}}
            <div class="bg-gray-800 shadow-md border rounded-lg overflow-x-auto">
                @if ($testsNotLogin->isEmpty())
                    <p class="p-4 text-gray-200">Nenhum teste encontrado para esta data.</p>
                @else
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-950 border-b border-gray-700">
                            <tr class="text-center text-gray-200 font-semibold">
                                <th class="py-3 px-4">Nome</th>
                                <th class="py-3 px-4">Telefone</th>
                                <th class="py-3 px-4">Percentual</th>
                                <th class="py-3 px-4">Primário</th>
                                <th class="py-3 px-4">Secundário</th>
                                <th class="py-3 px-4">Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($testsNotLogin as $test)
                                @php
                                    $percent = is_array($test->percentual)
                                        ? $test->percentual
                                        : json_decode($test->percentual, true);
                                @endphp

                                <tr class="border-b border-gray-700 hover:bg-gray-800 text-center">
                                    <td class="py-3 px-4 text-left font-semibold">
                                        {{ mb_strtoupper($test->name) }}
                                    </td>

                                    <td class="py-3 px-4">{{ $test->phone }}</td>

                                    <td class="py-3 px-4">
                                        <div class="flex gap-4 justify-center">
                                            @foreach ($percent as $letra => $valor)
                                                <span class="">
                                                    <b>{{ $letra }}:</b> {{ $valor }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>

                                    <td class="py-3 px-4 font-bold text-green-600">{{ $test->primary }}</td>
                                    <td class="py-3 px-4 font-bold text-orange-600">{{ $test->secondary }}</td>
                                    <td class="py-3 px-4 text-gray-200">{{ $test->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
