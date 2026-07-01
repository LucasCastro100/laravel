<x-app-layout :title="$title">
    <x-slot name="header">
        <x-page-title title="Testes Representacionais" />
    </x-slot>

    <div class="py-8">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl space-y-6">

            {{-- Header info --}}
            <div class="bg-gray-900 rounded-2xl border border-gray-800 p-6">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-500/10 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-brain text-purple-400 text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-100">Teste do Sistema Representacional</h2>
                        <p class="text-sm text-gray-400 mt-1">Ned Herrmann — Este é o teste disponível para os alunos da plataforma. Abaixo está a visualização completa de todas as {{ count($questions) }} questões.</p>
                        <div class="flex items-center gap-4 mt-3">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-500/10 border border-purple-500/20 text-purple-300">
                                {{ count($questions) }} questões
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-500/10 border border-blue-500/20 text-blue-300">
                                Canais: V · A · C · D
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Legenda --}}
            <div class="bg-gray-900 rounded-2xl border border-gray-800 p-5">
                <p class="text-xs text-gray-500 uppercase tracking-wider mb-3">Legenda de Pontuação</p>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <div class="bg-gray-800/50 rounded-xl p-3 text-center">
                        <p class="text-2xl font-bold text-gray-100">4</p>
                        <p class="text-xs text-gray-400 mt-1">A que melhor descreve você</p>
                    </div>
                    <div class="bg-gray-800/50 rounded-xl p-3 text-center">
                        <p class="text-2xl font-bold text-gray-100">3</p>
                        <p class="text-xs text-gray-400 mt-1">A próxima melhor descrição</p>
                    </div>
                    <div class="bg-gray-800/50 rounded-xl p-3 text-center">
                        <p class="text-2xl font-bold text-gray-100">2</p>
                        <p class="text-xs text-gray-400 mt-1">A próxima melhor</p>
                    </div>
                    <div class="bg-gray-800/50 rounded-xl p-3 text-center">
                        <p class="text-2xl font-bold text-gray-100">1</p>
                        <p class="text-xs text-gray-400 mt-1">A que menos descreve você</p>
                    </div>
                </div>
            </div>

            {{-- Questões --}}
            <div class="bg-gray-900 rounded-2xl border border-gray-800 p-6 space-y-6">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-1 h-6 bg-purple-500 rounded-full"></div>
                    <h3 class="text-base font-semibold text-gray-100">Questões do Teste</h3>
                </div>

                @foreach ($questions as $key => $question)
                    <div class="rounded-xl border border-gray-800 bg-gray-800/30 p-5">
                        <p class="text-sm font-semibold text-gray-200 mb-4">
                            <span class="text-purple-400 font-bold mr-1">{{ $key + 1 }}.</span>
                            {{ $question['text'] }}
                        </p>

                        <div class="space-y-2">
                            @foreach ($question['options'] as $option)
                                <div class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-gray-900/60 border border-gray-800">
                                    <div class="w-6 h-6 rounded-md bg-gray-800 border border-gray-700 flex items-center justify-center shrink-0">
                                        <span class="text-xs font-bold
                                            @if($option['channel'] === 'V') text-blue-400
                                            @elseif($option['channel'] === 'A') text-green-400
                                            @elseif($option['channel'] === 'C') text-orange-400
                                            @else text-purple-400
                                            @endif">
                                            {{ $option['channel'] }}
                                        </span>
                                    </div>
                                    <span class="text-sm text-gray-300">{{ $option['text'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>
