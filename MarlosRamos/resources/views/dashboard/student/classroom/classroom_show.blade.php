<x-app-layout :title="$title">
    <x-slot name="header">
        <x-page-title title="{{ $title }}" />
    </x-slot>

    @php
        $roleId = Auth::user()->role_id;
        $isStudent = $roleId === 1;
        $isTeacher = $roleId === 2;

        $classroomRoute = $isTeacher ? 'tacher.classroom.show' : ($roleId === 3 ? 'admin.classroom.show' : 'student.classroom.show');
        $coursesRoute   = $isTeacher ? 'course.index' : ($roleId === 3 ? 'admin.dashBoard' : 'student.myCourses');
        $coursesLabel   = $isStudent ? 'Meus Cursos' : 'Cursos';
        $courseShowRoute = $isStudent ? 'student.courseShow' : 'course.show';
    @endphp

    <div class="py-8">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2 text-xs text-gray-500 mb-5 flex-wrap">
                <a href="{{ route($coursesRoute) }}" class="hover:text-gray-300 transition">{{ $coursesLabel }}</a>
                <i class="fa-solid fa-chevron-right text-gray-700"></i>
                <a href="{{ route($courseShowRoute, $course->uuid) }}" class="hover:text-gray-300 transition truncate max-w-[160px]">{{ $course->title }}</a>
                <i class="fa-solid fa-chevron-right text-gray-700"></i>
                <span class="text-gray-300 truncate max-w-[160px]">{{ $title }}</span>
            </div>

            <div x-data="{ tab: 'classroom', openModule: null }" @resize.window="calcHeight()"
                 x-init="$store.video && $store.video.calcHeight()">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    {{-- Coluna principal --}}
                    <div :class="tab === 'comments' ? 'lg:col-span-3' : 'lg:col-span-2'" class="space-y-4">

                        {{-- Tabs --}}
                        <div class="flex gap-1 p-1 bg-gray-800 rounded-xl w-fit">
                            <button @click="tab = 'classroom'"
                                    :class="tab === 'classroom' ? 'bg-gray-700 text-gray-100 shadow-sm' : 'text-gray-400 hover:text-gray-200'"
                                    class="flex items-center gap-2 px-4 py-1.5 rounded-lg text-sm font-medium transition">
                                <i class="fa-solid fa-play text-xs"></i> Aula
                            </button>
                            <button @click="tab = 'comments'"
                                    :class="tab === 'comments' ? 'bg-gray-700 text-gray-100 shadow-sm' : 'text-gray-400 hover:text-gray-200'"
                                    class="flex items-center gap-2 px-4 py-1.5 rounded-lg text-sm font-medium transition">
                                <i class="fa-solid fa-comment text-xs"></i> Comentários
                            </button>
                        </div>

                        {{-- Aba: Aula --}}
                        <div x-show="tab === 'classroom'" x-transition class="space-y-4">
                            {{-- Player de vídeo --}}
                            <div class="bg-gray-900 rounded-2xl border border-gray-800 overflow-hidden">
                                <iframe :height="$store.video.height"
                                    src="https://www.youtube.com/embed/{{ $videoId }}"
                                    title="{{ $title }}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    referrerpolicy="strict-origin-when-cross-origin"
                                    allowfullscreen
                                    class="w-full block"></iframe>
                            </div>

                            {{-- Info + ações --}}
                            <div class="bg-gray-900 rounded-2xl border border-gray-800 p-5">
                                <h1 class="text-lg font-semibold text-gray-100 mb-1">{{ $title }}</h1>
                                <p class="text-xs text-gray-500">{{ $module_current->title }} · {{ $course->title }}</p>

                                @if (!empty($classroom_current->description))
                                    <p class="mt-3 text-sm text-gray-300 leading-relaxed">{{ $classroom_current->description }}</p>
                                @endif

                                {{-- Navegação + concluir --}}
                                <div class="flex items-center justify-between mt-5 pt-4 border-t border-gray-800">
                                    <div class="flex items-center gap-2">
                                        @if ($previousClassroom)
                                            <a href="{{ route($classroomRoute, ['uuid_classroom' => $previousClassroom->uuid]) }}"
                                               class="flex items-center gap-1.5 px-3 py-2 text-sm bg-gray-800 hover:bg-gray-700 border border-gray-700 text-gray-300 rounded-lg transition">
                                                <i class="fa-solid fa-chevron-left text-xs"></i> Anterior
                                            </a>
                                        @endif
                                        @if ($nextClassroom)
                                            <a href="{{ route($classroomRoute, ['uuid_classroom' => $nextClassroom->uuid]) }}"
                                               class="flex items-center gap-1.5 px-3 py-2 text-sm bg-gray-800 hover:bg-gray-700 border border-gray-700 text-gray-300 rounded-lg transition">
                                                Próxima <i class="fa-solid fa-chevron-right text-xs"></i>
                                            </a>
                                        @endif
                                    </div>

                                    @if ($isStudent)
                                        @if ($isCompleted)
                                            <span class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-green-400 bg-green-500/10 border border-green-500/20 rounded-lg">
                                                <i class="fa-solid fa-circle-check"></i> Concluída
                                            </span>
                                        @else
                                            <form action="{{ route('classroom.completeClassroom', ['uuid_classroom' => $classroom_current->uuid]) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                        class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-500 rounded-lg transition">
                                                    <i class="fa-solid fa-check"></i> Concluir Aula
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Aba: Comentários --}}
                        <div x-show="tab === 'comments'" x-transition class="space-y-4">
                            {{-- Formulário de comentário --}}
                            <div class="bg-gray-900 rounded-2xl border border-gray-800 p-5">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-1 h-5 bg-blue-500 rounded-full"></div>
                                    <h3 class="text-sm font-semibold text-gray-100">Deixe sua dúvida ou comentário</h3>
                                </div>
                                <form method="POST" action="{{ route('comment.store', ['uuid_classroom' => $classroom_current->uuid]) }}">
                                    @csrf
                                    <textarea name="comment" rows="4"
                                        class="block w-full bg-white text-gray-900 border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                                        placeholder="Escreva aqui...">{{ old('comment') }}</textarea>
                                    @error('comment')
                                        <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p>
                                    @enderror
                                    <div class="flex justify-end mt-3">
                                        <button type="submit"
                                                class="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium rounded-lg transition">
                                            <i class="fa-solid fa-paper-plane text-xs"></i> Enviar
                                        </button>
                                    </div>
                                </form>
                            </div>

                            {{-- Lista de comentários --}}
                            @if ($comments->isEmpty())
                                <div class="bg-gray-900 rounded-2xl border border-gray-800 p-8 text-center">
                                    <i class="fa-solid fa-comments text-2xl text-gray-700 mb-2"></i>
                                    <p class="text-sm text-gray-500">Nenhum comentário ainda. Seja o primeiro!</p>
                                </div>
                            @else
                                <div class="space-y-3">
                                    @foreach ($comments as $comment)
                                        <div class="bg-gray-900 rounded-2xl border border-gray-800 p-4">
                                            <p class="text-sm text-gray-200 leading-relaxed">{{ $comment->comment }}</p>
                                            <p class="text-xs text-gray-500 mt-2 text-right">
                                                <span class="text-gray-400">{{ $comment->user->name }}</span>
                                                · {{ $comment->created_at->diffForHumans() }}
                                            </p>

                                            {{-- Respostas --}}
                                            @if ($comment->replies->isNotEmpty())
                                                <div class="mt-3 pl-4 border-l-2 border-gray-700 space-y-2">
                                                    @foreach ($comment->replies as $reply)
                                                        <div class="bg-gray-800/60 rounded-xl p-3">
                                                            <p class="text-sm text-gray-300">{{ $reply->reply }}</p>
                                                            <p class="text-xs text-gray-500 mt-1 text-right">
                                                                <span class="text-gray-400">{{ $reply->user->name }}</span>
                                                                · {{ $reply->created_at->diffForHumans() }}
                                                            </p>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @elseif ($classroom_current->module->course->user_id === Auth::user()->id)
                                                <div class="mt-3 flex justify-end">
                                                    <a href="{{ route('comments.reply.show', $comment->uuid) }}"
                                                       class="flex items-center gap-1.5 px-3 py-1.5 text-xs text-blue-400 border border-blue-500/20 rounded-lg hover:bg-blue-500/10 transition">
                                                        <i class="fa-solid fa-reply text-xs"></i> Responder
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                    </div>

                    {{-- Sidebar: Módulos e Aulas (só na aba Aula) --}}
                    <div x-show="tab === 'classroom'" x-transition>
                        <div class="bg-gray-900 rounded-2xl border border-gray-800 overflow-hidden">
                            <div class="px-4 py-3 border-b border-gray-800 flex items-center gap-2">
                                <i class="fa-solid fa-list-ul text-xs text-gray-500"></i>
                                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Conteúdo do Curso</span>
                            </div>

                            <div class="divide-y divide-gray-800">
                                @foreach ($modules as $key => $module)
                                    @php
                                        $moduleCompleted = collect($module->classrooms)->every(
                                            fn($c) => in_array($c->id, $classroomCompletions)
                                        );
                                    @endphp

                                    <div>
                                        {{-- Cabeçalho do módulo --}}
                                        <button @click="openModule === {{ $key }} ? openModule = null : openModule = {{ $key }}"
                                                class="flex items-center justify-between w-full px-4 py-3 text-left hover:bg-gray-800/60 transition">
                                            <span class="text-xs font-semibold text-gray-300 uppercase tracking-wide truncate pr-2">
                                                {{ $module->title }}
                                            </span>
                                            <div class="flex items-center gap-2 shrink-0">
                                                @if ($moduleCompleted)
                                                    <i class="fa-solid fa-circle-check text-green-400 text-xs"></i>
                                                @endif
                                                <svg :class="openModule === {{ $key }} ? 'rotate-180' : ''"
                                                     class="w-3.5 h-3.5 text-gray-500 transition-transform duration-200"
                                                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </div>
                                        </button>

                                        {{-- Aulas do módulo --}}
                                        <div x-show="openModule === {{ $key }}" x-collapse>
                                            <ul class="bg-gray-950/50">
                                                @foreach ($module->classrooms as $index => $classroom)
                                                    @php
                                                        $completed = in_array($classroom->id, $classroomCompletions);
                                                        $isCurrent = $classroom->uuid === $classroom_current->uuid;
                                                    @endphp
                                                    <li>
                                                        <a href="{{ route($classroomRoute, ['uuid_classroom' => $classroom->uuid]) }}"
                                                           class="flex items-center gap-3 px-4 py-2.5 text-sm transition
                                                               {{ $isCurrent ? 'bg-blue-600/10 border-l-2 border-blue-500 text-blue-300' : 'hover:bg-gray-800/60 text-gray-400 hover:text-gray-200' }}">
                                                            <span class="w-5 h-5 rounded-full text-xs font-semibold shrink-0 flex items-center justify-center border
                                                                {{ $completed ? 'bg-green-500/10 border-green-500/40 text-green-400' : 'border-gray-600 text-gray-500' }}">
                                                                {{ $index + 1 }}
                                                            </span>
                                                            <span class="truncate flex-1">{{ $classroom->title }}</span>
                                                            @if ($isCurrent)
                                                                <span class="text-xs text-blue-400 animate-pulse shrink-0">▶</span>
                                                            @elseif ($completed)
                                                                <i class="fa-solid fa-check text-green-500 text-xs shrink-0"></i>
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

</x-app-layout>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('video', {
            height: 0,
            calcHeight() {
                const width = window.innerWidth;
                this.height = width >= 1024 ? 500 : width >= 768 ? 380 : width >= 480 ? 260 : 220;
            }
        });
        Alpine.store('video').calcHeight();
    });
</script>


