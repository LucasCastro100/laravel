<x-app-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Painel do professor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="text-gray-900">
                <h2 class="text-gray-900 text-2xl font-bold mb-4">
                    {{ $saudacao }}, {{ $usuario }}!
                </h2>

                <h2 class="text-lg font-medium text-gray-900 mb-4">
                    {{ __('Indicadores de Cadastro') }}
                </h2>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 w-full">
                    <div
                        class="bg-white p-4 rounded-lg shadow-lg flex flex-col sm:flex-row sm:justify-between items-center sm:items-center text-center sm:text-left">
                        <div class="flex flex-col sm:flex-row sm:items-center">
                            <i class="fas fa-clipboard-check text-4xl text-indigo-500"></i>
                            <h3 class="text-lg font-medium m-0 sm:ml-4">Testes com alunos</h3>
                        </div>
                        <div class="mt-2 sm:mt-0">
                            <p class="text-2xl font-bold">{{ $testsWithLogin }}</p>
                        </div>
                    </div>

                    <div
                        class="bg-white p-4 rounded-lg shadow-lg flex flex-col sm:flex-row sm:justify-between items-center sm:items-center text-center sm:text-left">
                        <div class="flex flex-col sm:flex-row sm:items-center">
                            <i class="fas fa-clipboard-check text-4xl text-indigo-500"></i>
                            <h3 class="text-lg font-medium m-0 sm:ml-4">Testes em eventos</h3>
                        </div>
                        <div class="mt-2 sm:mt-0">
                            <p class="text-2xl font-bold">{{ $testsNotLogin }}</p>
                        </div>
                    </div>

                    <div
                        class="bg-white p-4 rounded-lg shadow-lg flex flex-col sm:flex-row sm:justify-between items-center sm:items-center text-center sm:text-left">
                        <div class="flex flex-col sm:flex-row sm:items-center">
                            <i class="fas fa-book text-4xl text-indigo-500"></i>
                            <h3 class="text-lg font-medium m-0 sm:ml-4">Cursos</h3>
                        </div>
                        <div class="mt-2 sm:mt-0">
                            <p class="text-2xl font-bold">{{ $couses }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
