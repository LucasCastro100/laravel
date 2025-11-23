<x-app-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gerencimanto dos testes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if (session('success'))
                    <x-alert-component type="success" :message="session('success')" />
                @endif

                @if (session('error'))
                    <x-alert-component type="error" :message="session('error')" />
                @endif

                <div class="p-6 text-gray-900">
                    <div x-data="{ tab: 'testYesLogin' }">
                        <!-- Tabs -->
                        <div class="flex flex-col sm:flex-row flex-wrap border-b border-gray-200 mb-4">
                            <button @click="tab = 'testYesLogin'"
                                :class="tab === 'testYesLogin' ? 'border-b-2 border-indigo-600 text-indigo-600' :
                                    'text-gray-600'"
                                class="py-2 px-4 font-medium text-sm hover:text-gray-600 hover:border-b-2 hover:border-gray-300 flex flex-row gap-1">
                                <p>Teste com alunos -</p>
                                <p>{{ $testsWithLogin->count() }}</p>

                            </button>
                            <button @click="tab = 'testNotLogin'"
                                :class="tab === 'testNotLogin' ? 'border-b-2 border-indigo-600 text-indigo-600' :
                                    'text-gray-600'"
                                class="py-2 px-4 font-medium text-sm hover:text-gray-600 hover:border-b-2 hover:border-gray-300 flex flex-row gap-1">
                                <p>Teste em eventos -</p>
                                <p>{{ $testsNotLogin->count() }}</p>
                            </button>
                        </div>

                        {{-- ALUNOS --}}
                        <div x-show="tab === 'testYesLogin'" class="overflow-x-auto">
                            @if ($testsWithLogin->isEmpty())
                                <p class="p-4 text-gray-500">Nenhum aluno cadastrado</p>
                            @else
                                <table class="w-full text-left border">
                                    <thead class="bg-gray-100 text-sm font-semibold text-gray-700">
                                        <tr class="text-center">
                                            <th class="p-2">Nome</th>
                                            <th class="p-2">Telefone</th>
                                            <th class="p-2">Percentual</th>
                                            <th class="p-2">Primário</th>
                                            <th class="p-2">Secundário</th>
                                            <th class="p-2">Data</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($testsWithLogin as $yesLogin)
                                            <tr class="border-t text-center">
                                                <td class="p-2 text-start">
                                                    {{ mb_strtoupper($yesLogin->user->name ?? 'SEM NOME', 'UTF-8') }}
                                                </td>

                                                <td class="p-2">
                                                    {{ $yesLogin->user->phone ?? '—' }}
                                                </td>
                                                <td class="p-2">
                                                    @php
                                                        // Garante que sempre será array
                                                        $percent = $yesLogin->percentual ?? [];

                                                        if (!is_array($percent)) {
                                                            $percent = json_decode($percent, true) ?? [];
                                                        }
                                                    @endphp

                                                    <div class="flex flex-row gap-4 items-center justify-center">
                                                        @foreach ($percent as $letra => $valor)
                                                            <div>
                                                                <span class="font-semibold">{{ $letra }}:</span>
                                                                {{ $valor }} <br>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </td>
                                                <td class="p-2">{{ $yesLogin?->primary ?? 0 }}</td>
                                                <td class="p-2">{{ $yesLogin?->secondary ?? 0 }}</td>
                                                <td class="p-2">{{ $yesLogin?->created_at->format('d/m/y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>

                        <div x-show="tab === 'testNotLogin'" class="overflow-x-auto">
                            @if ($testsNotLogin->isEmpty())
                                <p class="p-4 text-gray-500">Nenhum aluno cadastrado</p>
                            @else
                                <table class="w-full text-left border">
                                    <thead class="bg-gray-100 text-sm font-semibold text-gray-700">
                                        <tr class="text-center">
                                            <th class="p-2">Nome</th>
                                            <th class="p-2">Telefone</th>
                                            <th class="p-2">Percentual</th>
                                            <th class="p-2">Primário</th>
                                            <th class="p-2">Secundário</th>
                                            <th class="p-2">Data</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($testsNotLogin as $notLogin)
                                            <tr class="border-t text-center">
                                                <td class="p-2 text-start">
                                                    {{ mb_strtoupper($notLogin->name, 'UTF-8') }}</td>
                                                <td class="p-2">{{ $notLogin?->phone }}</td>
                                                <td class="p-2">
                                                    @php
                                                        // Garante que sempre será array
                                                        $percent = $notLogin->percentual ?? [];

                                                        if (!is_array($percent)) {
                                                            $percent = json_decode($percent, true) ?? [];
                                                        }
                                                    @endphp

                                                    <div class="flex flex-row gap-4 items-center justify-center">
                                                        @foreach ($percent as $letra => $valor)
                                                            <div>
                                                                <span class="font-semibold">{{ $letra }}:</span>
                                                                {{ $valor }} <br>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </td>
                                                <td class="p-2">{{ $notLogin?->primary ?? 0 }}</td>
                                                <td class="p-2">{{ $notLogin?->secondary ?? 0 }}</td>
                                                <td class="p-2">{{ $notLogin?->created_at->format('d/m/y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
