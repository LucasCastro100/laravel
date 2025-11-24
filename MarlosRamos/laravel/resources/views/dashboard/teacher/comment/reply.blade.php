<x-app-layout title="Teste Representacional">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Respondendo comentário') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                @if (session('success'))
                    <x-alert-component type="success" :message="session('success')" />
                @endif

                @if (session('error'))
                    <x-alert-component type="error" :message="session('error')" />
                @endif

                <div class="flex flex-col gap-4">
                    <h2 class="font-bold">Comentário</h2>
                    {{ $commentReply->comment }}
                </div>

                <div class="mt-8">
                    <textarea name="reply" id="" cols="30" rows="10" placeholder="Digite sua resposta..." class="w-full rounded-md"></textarea>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
