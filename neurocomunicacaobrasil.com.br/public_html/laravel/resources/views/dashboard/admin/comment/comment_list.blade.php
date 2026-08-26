<x-app-layout title="Comentários">
    <x-slot name="header">
        <x-page-title title="Comentários" />
    </x-slot>

    <div class="py-12">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6">
                    <x-alert-component type="success" :message="session('success')" />
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6">
                    <x-alert-component type="error" :message="session('error')" />
                </div>
            @endif

            <div class="space-y-4">
                @forelse ($courses as $course)
                    <div x-data="{ openCourse: false }" class="bg-gray-900 rounded-xl border border-gray-800 overflow-hidden min-h-[80px]">
                        {{-- Curso --}}
                        <button @click="openCourse = !openCourse"
                            class="w-full flex items-center justify-between px-6 py-4 hover:bg-gray-800/40 transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-500/10 flex items-center justify-center">
                                    <i class="fa-solid fa-book text-blue-400 text-sm"></i>
                                </div>
                                <span class="text-base font-semibold text-gray-100">{{ $course->title }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-xs text-gray-500">{{ $course->modules->pluck('classrooms')->flatten()->pluck('comments')->flatten()->count() }} comentário(s)</span>
                                <i class="fa-solid fa-chevron-down text-gray-500 text-xs transition-transform duration-200" :class="openCourse && 'rotate-180'"></i>
                            </div>
                        </button>

                        {{-- Módulos --}}
                        <div x-show="openCourse" x-collapse class="border-t border-gray-800">
                            @forelse ($course->modules as $module)
                                <div x-data="{ openModule: false }">
                                    <button @click="openModule = !openModule"
                                        class="w-full flex items-center justify-between px-6 pl-10 py-3 hover:bg-gray-800/40 transition-colors duration-200">
                                        <div class="flex items-center gap-3">
                                            <div class="w-6 h-6 rounded bg-purple-500/10 flex items-center justify-center">
                                                <i class="fa-solid fa-layer-group text-purple-400 text-xs"></i>
                                            </div>
                                            <span class="text-sm font-medium text-gray-300">{{ $module->title }}</span>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <span class="text-xs text-gray-500">{{ $module->classrooms->pluck('comments')->flatten()->count() }}</span>
                                            <i class="fa-solid fa-chevron-down text-gray-600 text-xs transition-transform duration-200" :class="openModule && 'rotate-180'"></i>
                                        </div>
                                    </button>

                                    {{-- Aulas --}}
                                    <div x-show="openModule" x-collapse class="border-t border-gray-800/50">
                                        @forelse ($module->classrooms as $classroom)
                                            <div x-data="{ openClass: false }">
                                                <button @click="openClass = !openClass"
                                                    class="w-full flex items-center justify-between px-6 pl-16 py-3 hover:bg-gray-800/40 transition-colors duration-200">
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-5 h-5 rounded bg-green-500/10 flex items-center justify-center">
                                                            <i class="fa-solid fa-play text-green-400 text-[10px]"></i>
                                                        </div>
                                                        <span class="text-sm text-gray-400">{{ $classroom->title }}</span>
                                                    </div>
                                                    <div class="flex items-center gap-3">
                                                        @if ($classroom->comments->count() > 0)
                                                            <span class="text-xs bg-gray-800 text-gray-400 px-2 py-0.5 rounded-full">{{ $classroom->comments->count() }}</span>
                                                        @else
                                                            <span class="text-xs text-gray-600">0</span>
                                                        @endif
                                                        <i class="fa-solid fa-chevron-down text-gray-600 text-[10px] transition-transform duration-200" :class="openClass && 'rotate-180'"></i>
                                                    </div>
                                                </button>

                                                {{-- Comentários --}}
                                                <div x-show="openClass" x-collapse class="border-t border-gray-800/50 bg-gray-800/20">
                                                    <div class="px-6 py-4 space-y-4 pl-20">
                                                        @forelse ($classroom->comments as $comment)
                                                            <div class="bg-gray-800 rounded-lg p-4 border border-gray-700/50">
                                                                <div class="flex items-start gap-3">
                                                                    <div class="w-8 h-8 rounded-full bg-blue-500/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                                                                        <span class="text-blue-400 text-xs font-bold">{{ strtoupper(substr($comment->user->name, 0, 1)) }}</span>
                                                                    </div>
                                                                    <div class="flex-1 min-w-0">
                                                                        <div class="flex items-center gap-2">
                                                                            <span class="text-sm font-medium text-gray-200">{{ $comment->user->name }}</span>
                                                                            <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                                                        </div>
                                                                        <p class="text-sm text-gray-400 mt-1">{{ $comment->comment }}</p>

                                                                        {{-- Respostas --}}
                                                                        @foreach ($comment->replies as $reply)
                                                                            <div class="mt-3 ml-4 pl-3 border-l-2 border-gray-700">
                                                                                <div class="flex items-center gap-2">
                                                                                    <div class="w-6 h-6 rounded-full bg-green-500/10 flex items-center justify-center flex-shrink-0">
                                                                                        <span class="text-green-400 text-[10px] font-bold">{{ strtoupper(substr($reply->user->name, 0, 1)) }}</span>
                                                                                    </div>
                                                                                    <span class="text-xs font-medium text-gray-300">{{ $reply->user->name }}</span>
                                                                                    <span class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</span>
                                                                                </div>
                                                                                <p class="text-sm text-gray-400 mt-1 ml-8">{{ $reply->reply }}</p>
                                                                            </div>
                                                                        @endforeach

                                                                        {{-- Formulário de resposta --}}
                                                                        @php
                                                                            $adminReplied = $comment->replies->contains('user_id', Auth::id());
                                                                        @endphp

                                                                        @if (!$adminReplied)
                                                                            <form action="{{ route('admin.responderComentario', $comment->uuid) }}" method="POST" class="mt-3 flex gap-2">
                                                                                @csrf
                                                                                <input type="text" name="reply" placeholder="Responder..." required maxlength="1000"
                                                                                    class="flex-1 bg-gray-700 text-gray-100 border border-gray-600 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent placeholder-gray-500">
                                                                                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white text-sm rounded-lg transition-colors duration-200 flex-shrink-0">
                                                                                    <i class="fa-solid fa-paper-plane"></i>
                                                                                </button>
                                                                            </form>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @empty
                                                            <div class="text-center py-6">
                                                                <p class="text-gray-500 text-sm">Nenhum comentário nesta aula.</p>
                                                            </div>
                                                        @endforelse
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <p class="text-gray-500 text-sm text-center py-4 pl-16">Nenhuma aula neste módulo.</p>
                                        @endforelse
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-sm text-center py-4 pl-10">Nenhum módulo neste curso.</p>
                            @endforelse
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16 bg-gray-900 rounded-xl border border-gray-800">
                        <i class="fa-solid fa-comments text-4xl text-gray-600 mb-4"></i>
                        <p class="text-gray-400">Nenhum comentário encontrado.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
