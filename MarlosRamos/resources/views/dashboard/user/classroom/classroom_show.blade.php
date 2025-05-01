<x-app-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ mb_strtoupper($course->title) }} / {{ mb_strtoupper($module_current->title) }} /
            {{ mb_strtoupper($title) }}
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

                <div class="py-12">
                    <div class="mx-auto sm:px-6 lg:px-8">
                        <div class="mb-4">
                            {{ $classroom_current->description }}
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 w-full">
                            <div class="col-span-1 lg:col-span-2" x-data @resize.window="$store.video.calcHeight()"
                                x-init="$store.video.calcHeight()">

                                {{-- VIDEO --}}
                                <div>
                                    <iframe :height="$store.video.height"
                                        src="https://www.youtube.com/embed/{{ $videoId }}"
                                        title="YouTube video player" frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen
                                        class="w-full"></iframe>
                                </div>

                                <div class="mt-4 flex flex-row justify-between items-center gap-4">
                                    {{-- Aula concluída ou botão de concluir --}}
                                    @if ($isCompleted)
                                        <div class="flex items-center text-green-600 font-medium">
                                            <i class="fa-solid fa-circle-check mr-2"></i> Aula Concluída
                                        </div>
                                    @else
                                        <form
                                            action="{{ route('classroom.completeClassroom', ['uuid_classroom' => $classroom_current->uuid]) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit"
                                                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                                <i class="fa-solid fa-check mr-2"></i> Concluir Aula
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Próxima aula --}}
                                    @if ($nextClassroom)
                                        <a href="{{ route('classroom.show', ['uuid_classroom' => $nextClassroom->uuid]) }}"
                                            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                                            <i class="fa-solid fa-forward mr-2"></i> Próxima Aula
                                        </a>
                                    @endif
                                </div>

                                {{-- COMENTARIO --}}
                                <div class="mt-8">
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Deixe sua
                                        dúvida ou comentário</h3>

                                    {{-- Formulário para deixar um comentário --}}
                                    <form method="POST"
                                        action="{{ route('comment.store', ['uuid_classroom' => $classroom_current->uuid]) }}">
                                        @csrf
                                        <textarea name="comment" rows="4"
                                            class="w-full p-4 border rounded-md focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-700"
                                            placeholder="Escreva seu comentário ou dúvida aqui...">{{ old('comment') }}</textarea>

                                        {{-- Mensagem de erro se houver --}}
                                        @error('comment')
                                            <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                                        @enderror

                                        <button type="submit"
                                            class="mt-2 px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 dark:hover:bg-indigo-500">
                                            Enviar Comentário
                                        </button>
                                    </form>

                                    {{-- Comentários existentes ou mensagem de vazio --}}
                                    <div class="mt-8">
                                        @if ($comments->isEmpty())
                                            <p class="text-gray-500 dark:text-gray-400 mt-4">Nenhum comentário ainda.
                                                Seja o primeiro a comentar!</p>
                                        @else
                                            <h4 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-4">
                                                Comentários:</h4>

                                            @foreach ($comments as $comment)
                                                <div
                                                    class="mt-4 p-4 border border-gray-200 rounded-lg dark:border-gray-700 dark:bg-gray-800">
                                                    <p class="text-gray-600 dark:text-gray-400">
                                                        {{ $comment->comment }}
                                                    </p>
                                                    <p class="text-right text-sm text-gray-500 dark:text-gray-300 mt-2">
                                                        Comentado por: {{ $comment->user->name }} -
                                                        {{ $comment->created_at->diffForHumans() }}
                                                    </p>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div x-data="{ openModule: 0 }">
                                    @foreach ($modules as $key => $module)
                                        <div class="border border-gray-200 dark:border-gray-700 rounded mb-2">
                                            <!-- Cabeçalho do Módulo -->
                                            <h2>
                                                <button
                                                    @click="openModule === {{ $key }} ? openModule = null : openModule = {{ $key }}"
                                                    class="flex items-center justify-between w-full p-4 font-medium text-left text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700">
                                                    <span>{{ mb_strtoupper($module->title) }}</span>
                                                    <svg :class="openModule === {{ $key }} ? 'rotate-180' : ''"
                                                        class="w-4 h-4 transition-transform duration-300" fill="none"
                                                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19 9l-7 7-7-7" />
                                                    </svg>
                                                </button>
                                            </h2>

                                            <!-- Conteúdo do Módulo (Aulas) -->
                                            <div x-show="openModule === {{ $key }}" x-collapse
                                                class="bg-white dark:bg-black-900">
                                                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                                                    @foreach ($module->classrooms as $classroom)
                                                        <li class="flex items-center p-2">
                                                            @php
                                                                $completed = in_array(
                                                                    $classroom->id,
                                                                    $classroomCompletions,
                                                                );
                                                            @endphp

                                                            <i
                                                                class="mr-2 text-sm {{ $completed ? 'fa-solid fa-circle-check text-green-500' : 'fa-solid fa-circle-xmark text-gray-400' }}"></i>

                                                            <a href="{{ route('classroom.show', ['uuid_classroom' => $classroom->uuid]) }}"
                                                                class="flex-1 block text-sm text-black-600 dark:text-gray-300 hover:text-indigo-500 dark:hover:text-indigo-400">
                                                                {{ mb_strtoupper($classroom->title) }}

                                                                @if ($classroom->uuid === $classroom_current->uuid)
                                                                    <span
                                                                        class="text-xs text-indigo-500 animate-pulse ml-2">ASSISTINDO</span>
                                                                @endif
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('video', {
            height: 0,
            calcHeight() {
                const width = window.innerWidth;
                this.height = width >= 1024 ? 500 : width >= 992 ? 265 : width >= 768 ? 280 : 230;
            }
        });
    });
</script>
