<x-app-layout title="Teste Representacional">
    <x-slot name="header">
        <x-page-title title="Curso" />
    </x-slot>


    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-100">
                @if (session('success'))
                    <x-alert-component type="success" :message="session('success')" />
                @endif

                @if (session('error'))
                    <x-alert-component type="error" :message="session('error')" />
                @endif

                {{-- CONTEUDO --}}
            </div>
        </div>
    </div>
</x-app-layout>
