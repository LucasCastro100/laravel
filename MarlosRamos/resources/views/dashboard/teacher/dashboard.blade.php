<x-app-layout :title="$title">
    <x-slot name="header">
        <x-page-title title="Painel do professor" />
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <h2 class="text-gray-100 text-2xl font-bold mb-4">
                        {{ $saudacao }}, {{ $usuario }}!
                    </h2>

                    <h2 class="text-lg font-medium text-gray-100 mb-4">
                        {{ __('Indicadores de Cadastro') }}
                    </h2>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 w-full">
                        <x-stat-card icon="fas fa-clipboard-check" title="Testes com alunos" value="{{ $testsWithLogin }}" />
                        <x-stat-card icon="fas fa-clipboard-check" title="Testes em eventos" value="{{ $testsNotLogin }}" />
                        <x-stat-card icon="fas fa-book" title="Cursos" value="{{ $couses }}" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
