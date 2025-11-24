<x-app-layout title="Teste Representacional">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Comentários') }}
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

                {{-- CONTEUDO --}}
            </div>
        </div>
    </div>
</x-app-layout>
