<x-app-layout title="Teste Representacional">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Respondendo comentário') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 space-y-4">
                @if (session('success'))
                    <x-alert-component type="success" :message="session('success')" />
                @endif

                @if (session('error'))
                    <x-alert-component type="error" :message="session('error')" />
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 w-full">
                    <div
                        class="bg-white p-4 rounded-lg shadow-lg flex flex-col md:flex-row md:justify-between items-center md:items-center text-center md:text-left">
                        <div class="flex flex-col md:flex-row md:items-center gap-6">
                            <h2 class="font-bold">Curso</h2>
                            {{ $commentReply->classroom->module->course->title }}
                        </div>
                    </div>

                    <div
                        class="bg-white p-4 rounded-lg shadow-lg flex flex-col md:flex-row md:justify-between items-center md:items-center text-center md:text-left">
                        <div class="flex flex-col md:flex-row md:items-center gap-6">
                            <h2 class="font-bold">Módulo</h2>
                            {{ $commentReply->classroom->module->title }}
                        </div>
                    </div>

                    <div
                        class="bg-white p-4 rounded-lg shadow-lg flex flex-col md:flex-row md:justify-between items-center md:items-center text-center md:text-left">
                        <div class="flex flex-col md:flex-row md:items-center gap-6">
                            <h2 class="font-bold">Aula</h2>
                            {{ $commentReply->classroom->title }}
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-2">
                        <h2 class="font-bold">Comentário</h2>

                        {{ $commentReply->comment }}

                        <small class="text-gray-500">
                            {{ $commentReply->user->name }} - {{ $commentReply->created_at->diffForHumans() }}
                        </small>
                    </div>

                </div>

                <form action="{{ route('comments.reply.store', $commentReply->id) }}" method="POST">
                    @csrf
                    <div class="mt-8">
                        <textarea name="reply" cols="30" rows="10" placeholder="Digite sua resposta..." class="w-full rounded-md">{{ $commentReply->replies[0]->reply ?? ""}}</textarea>
                    </div>

                    <div class="flex justify-end items-center">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-800 rounded-md px-4 py-2 text-white mt-4">Responder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
