<x-app-layout :title="$title">
    <x-slot name="header">
        <x-page-title title="Dúvidas e Contatos" />
    </x-slot>

    <div class="py-8">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 space-y-4">

            @if ($contacts->isEmpty())
                <div class="bg-gray-900 rounded-2xl border border-gray-800 p-12 text-center">
                    <i class="fa-solid fa-inbox text-3xl text-gray-700 mb-3"></i>
                    <p class="text-sm text-gray-500">Nenhuma mensagem recebida ainda.</p>
                </div>
            @else
                @foreach ($contacts as $contact)
                    <div class="bg-gray-900 rounded-2xl border border-gray-800 overflow-hidden"
                         x-data="{ replyOpen: false }">

                        {{-- Cabeçalho --}}
                        <div class="flex flex-wrap items-start justify-between gap-4 p-5 border-b border-gray-800">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-gray-700 flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-user text-gray-400 text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-200">{{ $contact->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $contact->user->email }} · {{ $contact->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $contact->type === 'platform' ? 'bg-teal-500/15 text-teal-300 border border-teal-500/20' : 'bg-blue-500/15 text-blue-300 border border-blue-500/20' }}">
                                    {{ $contact->type === 'platform' ? 'Plataforma' : 'Curso' }}
                                </span>
                                @if ($contact->course)
                                    <span class="px-2.5 py-0.5 rounded-full text-xs bg-gray-800 border border-gray-700 text-gray-400">
                                        {{ $contact->course->title }}
                                    </span>
                                @endif
                                <span class="px-2.5 py-0.5 rounded-full text-xs
                                    {{ $contact->replies->isNotEmpty() ? 'bg-green-500/10 border border-green-500/20 text-green-400' : 'bg-yellow-500/10 border border-yellow-500/20 text-yellow-400' }}">
                                    {{ $contact->replies->isNotEmpty() ? 'Respondido' : 'Pendente' }}
                                </span>
                            </div>
                        </div>

                        {{-- Mensagem --}}
                        <div class="p-5">
                            <p class="text-sm text-gray-300 leading-relaxed">{{ $contact->message }}</p>
                        </div>

                        {{-- Respostas existentes --}}
                        @if ($contact->replies->isNotEmpty())
                            <div class="border-t border-gray-800 divide-y divide-gray-800">
                                @foreach ($contact->replies as $reply)
                                    <div class="flex gap-3 px-5 py-4 bg-gray-800/30">
                                        <div class="w-7 h-7 rounded-full bg-blue-600/20 border border-blue-500/30 flex items-center justify-center shrink-0 mt-0.5">
                                            <i class="fa-solid fa-user-tie text-blue-400 text-xs"></i>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="text-xs font-medium text-gray-300">{{ $reply->user->name }}</span>
                                                <span class="text-xs text-gray-600">{{ $reply->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-sm text-gray-300 leading-relaxed">{{ $reply->reply }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- Área de resposta --}}
                        <div class="border-t border-gray-800 p-5">
                            <button @click="replyOpen = !replyOpen"
                                    class="flex items-center gap-2 text-xs text-blue-400 hover:text-blue-300 transition mb-3">
                                <i class="fa-solid fa-reply"></i>
                                <span x-text="replyOpen ? 'Cancelar' : 'Responder'"></span>
                            </button>

                            <div x-show="replyOpen" x-transition>
                                @php
                                    $replyRoute = Auth::user()->role_id === 3 ? 'admin.contacts.reply' : 'teacher.contacts.reply';
                                @endphp
                                <form action="{{ route($replyRoute, $contact->uuid) }}" method="POST" class="space-y-3">
                                    @csrf
                                    <textarea name="reply" rows="3"
                                        class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 resize-none transition"
                                        placeholder="Escreva sua resposta..."></textarea>
                                    <div class="flex justify-end">
                                        <button type="submit"
                                                class="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium rounded-lg transition">
                                            <i class="fa-solid fa-paper-plane text-xs"></i>
                                            Enviar Resposta
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="pt-2">
                    {{ $contacts->links() }}
                </div>
            @endif

        </div>
    </div>

</x-app-layout>

