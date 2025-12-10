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

                <div class="mb-4">
                    {{ $classroom_current->description }}
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 w-full" x-data="{ tab: 'classroom', openModule: 0 }" x-cloak
                    @resize.window="$store.video.calcHeight()" x-init="$store.video.calcHeight()">
                    <!-- Coluna Principal -->
                    <div :class="tab === 'comments' ? 'col-span-1 lg:col-span-3' : 'col-span-1 lg:col-span-2'">
                        <!-- Tabs -->
                        <div class="flex border-b border-gray-200 mb-4 space-x-4">
                            <button @click="tab = 'classroom'"
                                :class="tab === 'classroom' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-600'"
                                class="py-2 px-4 font-medium text-sm hover:text-gray-600 hover:border-b-2 hover:border-gray-300">
                                Aula
                            </button>
                            <button @click="tab = 'comments'"
                                :class="tab === 'comments' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-600'"
                                class="py-2 px-4 font-medium text-sm hover:text-gray-600 hover:border-b-2 hover:border-gray-300">
                                Comentários
                            </button>
                        </div>

                        <!-- Conteúdo da Aula -->
                        <div x-show="tab === 'classroom'" x-transition>
                            <div>
                                <iframe :height="$store.video.height"
                                    src="https://www.youtube.com/embed/{{ $videoId }}" title="YouTube video player"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen
                                    class="w-full"></iframe>
                            </div>

                            <div class="mt-4 flex flex-row justify-between items-center gap-4">
                                {{-- Aula concluída ou botão de concluir --}}
                                @if (Auth::user()->role->id != 2)
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
                                @endif

                                <div class="flex flex-row gap-4 items-center justify-end">
                                    {{-- Aula anterior --}}
                                    @if ($previousClassroom != null)
                                        <a href="{{ route('student.classroom.show', ['uuid_classroom' => $previousClassroom->uuid]) }}"
                                            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                                            title="Aula Anterior">
                                            <i class="fa-solid fa-angles-left"></i>
                                            {{-- Aula Anterior --}}
                                        </a>
                                    @endif

                                    {{-- Próxima aula --}}
                                    @if ($nextClassroom != null)
                                        <a href="{{ route('student.classroom.show', ['uuid_classroom' => $nextClassroom->uuid]) }}"
                                            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                                            title="Próxima Aula">
                                            <i class="fa-solid fa-angles-right"></i>
                                            {{-- Próxima Aula --}}
                                        </a>
                                    @endif
                                </div>

                            </div>
                        </div>

                        <!-- Comentários -->
                        <div x-show="tab === 'comments'" x-transition>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4 mt-6">Deixe sua
                                dúvida ou comentário</h3>

                            <form method="POST"
                                action="{{ route('comment.store', ['uuid_classroom' => $classroom_current->uuid]) }}">
                                @csrf
                                <textarea name="comment" rows="4"
                                    class="w-full p-4 border rounded-md focus:ring-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-700"
                                    placeholder="Escreva seu comentário ou dúvida aqui...">{{ old('comment') }}</textarea>

                                @error('comment')
                                    <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                                @enderror

                                <button type="submit"
                                    class="mt-2 px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 dark:hover:bg-indigo-500">
                                    Enviar Comentário
                                </button>
                            </form>

                            <div class="mt-8">
                                @if ($comments->isEmpty())
                                    <p class="text-gray-500 dark:text-gray-400 mt-4">
                                        Nenhum comentário ainda. Seja o primeiro a comentar!
                                    </p>
                                @else
                                    <h4 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-4">
                                        Comentários:
                                    </h4>

                                    @foreach ($comments as $comment)
                                        <div
                                            class="mt-4 p-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-sm">
                                            {{-- Comentário principal --}}
                                            <div class="flex flex-col">
                                                <p class="text-gray-700 dark:text-gray-200">{{ $comment->comment }}</p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 text-right">
                                                    Comentado por: <span
                                                        class="font-medium">{{ $comment->user->name }}</span> -
                                                    {{ $comment->created_at->diffForHumans() }}
                                                </p>
                                            </div>

                                            {{-- Respostas --}}
                                            @if ($comment->replies->isNotEmpty())
                                                <div class="mt-3 pl-6 border-l-2 border-gray-300 dark:border-gray-600">
                                                    @foreach ($comment->replies as $reply)
                                                        <div
                                                            class="mt-2 p-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg shadow-sm">
                                                            <p class="text-gray-700 dark:text-gray-200">
                                                                {{ $reply->reply }}</p>
                                                            <p
                                                                class="text-sm text-gray-500 dark:text-gray-400 mt-1 text-right">
                                                                Respondido por: <span
                                                                    class="font-medium">{{ $reply->user->name }}</span>
                                                                - {{ $reply->created_at->diffForHumans() }}
                                                            </p>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @elseif ($classroom_current->module->course->user_id === Auth::user()->id)
                                                {{-- Botão para professor caso não haja respostas --}}
                                                <div class="mt-3 text-right">
                                                    <a href="{{ route('comments.reply.show', $comment->uuid) }}"
                                                        class="inline-block bg-blue-500 text-white px-4 py-1 rounded-lg hover:bg-blue-600 transition">
                                                        Responder
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach

                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Coluna lateral: Módulos e Aulas (somente na aba "Aula") -->
                    <div x-show="tab === 'classroom'" x-transition>
                        <div>
                            @foreach ($modules as $key => $module)
                                @php
                                    // Verifica se todas as aulas do módulo foram concluídas
                                    $moduleCompleted = collect($module->classrooms)->every(
                                        fn($c) => in_array($c->id, $classroomCompletions),
                                    );
                                @endphp

                                <div class="border border-gray-200 dark:border-gray-700 rounded mb-3">

                                    <!-- Cabeçalho do Módulo -->
                                    <h2>
                                        <button
                                            @click="openModule === {{ $key }} ? openModule = null : openModule = {{ $key }}"
                                            class="flex items-center justify-between w-full p-4 font-medium text-left 
                       text-gray-700 dark:text-gray-300 
                       bg-gray-100 dark:bg-gray-800 
                       hover:bg-gray-200 dark:hover:bg-gray-700">

                                            <!-- Número + título -->
                                            <span class="flex items-center gap-2">
                                                {{-- <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-semibold border">
                        {{ $key + 1 }}
                    </span> --}}
                                                {{ mb_strtoupper($module->title) }}
                                            </span>

                                            <!-- Status do módulo -->
                                            @if ($moduleCompleted)
                                                <span class="text-green-500 text-sm flex items-center gap-1 mr-4">
                                                    <i class="fa-solid fa-circle-check"></i> Completo
                                                </span>
                                            @endif

                                            <!-- Ícone Arrow -->
                                            <svg :class="openModule === {{ $key }} ? 'rotate-180' : ''"
                                                class="w-4 h-4 ml-2 transition-transform duration-300" fill="none"
                                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                    </h2>

                                    <!-- Conteúdo do Módulo (Aulas) -->
                                    <div x-show="openModule === {{ $key }}" x-collapse
                                        class="bg-white dark:bg-black-900">

                                        <ul class="relative border-l border-gray-300 dark:border-gray-700 ml-6 py-4">

                                            @foreach ($module->classrooms as $index => $classroom)
                                                @php
                                                    $completed = in_array($classroom->id, $classroomCompletions);
                                                @endphp

                                                <li class="relative pl-8 mb-8">

                                                    <!-- Bolinha numerada -->
                                                    <div
                                                        class="absolute -left-[14px] top-1 w-7 h-7 rounded-full flex items-center justify-center 
                            text-xs font-semibold border
                            {{ $completed ? 'bg-green-500 text-white border-green-600' : 'bg-gray-200 text-gray-700 border-gray-400' }}">
                                                        {{ $index + 1 }}
                                                    </div>

                                                    <!-- Título da aula -->
                                                    <a href="{{ route('student.classroom.show', ['uuid_classroom' => $classroom->uuid]) }}"
                                                        class="block text-sm font-medium text-gray-800 dark:text-gray-300 hover:text-indigo-500">

                                                        {{ mb_strtoupper($classroom->title) }}

                                                        @if ($classroom->uuid === $classroom_current->uuid)
                                                            <span
                                                                class="text-xs text-indigo-500 animate-pulse ml-1">ASSISTINDO</span>
                                                        @endif
                                                    </a>

                                                    <!-- Status da aula -->
                                                    <span
                                                        class="text-xs mt-1 block
                            {{ $completed ? 'text-green-600' : 'text-gray-400' }}">
                                                        {{ $completed ? '✔ Completo' : '• Em aberto' }}
                                                    </span>

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
