<x-app-layout :title="$title">
    <x-slot name="header">
        <x-page-title title="Curso" />
    </x-slot>

    <div class="py-8" x-data="{ openDelete: false, selectedItem: null, selectedType: '' }">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-900 rounded-2xl border border-gray-800 shadow-xl p-6">

                <div class="flex flex-col items-center justify-center gap-6">
                    <!-- Cabeçalho do curso -->
                    <div class="flex items-center justify-between w-full">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('course.index') }}" class="text-gray-500 hover:text-gray-300 transition">
                                <i class="fa-solid fa-arrow-left text-sm"></i>
                            </a>
                            <h3 class="font-semibold text-lg text-gray-100">{{ $course->title }}</h3>
                        </div>

                        <div x-data="{ open: false, dtop: 0, dright: 0 }" class="relative">
                            <button @click.stop="const r=$el.getBoundingClientRect(); dtop=r.bottom+4; dright=window.innerWidth-r.right; open=!open"
                                class="flex items-center gap-2 px-3 py-2 text-sm text-gray-300 bg-gray-800 hover:bg-gray-700 rounded-lg border border-gray-700 transition">
                                <i class="fas fa-cog text-sm"></i>
                                <span class="hidden sm:inline">Gerenciar</span>
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </button>

                            <div x-show="open" @click.away="open = false"
                                :style="{ top: dtop+'px', right: dright+'px' }"
                                class="fixed w-52 bg-white border border-gray-300 rounded-xl shadow-xl p-1.5 z-[9999]"
                                x-transition>
                                <ul class="space-y-0.5">
                                    <li>
                                        <a href="{{ route('module.create', $course->uuid) }}"
                                            class="flex items-center gap-2.5 w-full px-3 py-2 rounded-lg text-sm text-gray-200 hover:bg-blue-600/20 hover:text-blue-300 transition">
                                            <i class="fa-solid fa-folder-plus text-xs w-4 text-center"></i>
                                            Novo Módulo
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('classroom.create', $course->uuid) }}"
                                            class="flex items-center gap-2.5 w-full px-3 py-2 rounded-lg text-sm text-gray-200 hover:bg-purple-600/20 hover:text-purple-300 transition">
                                            <i class="fa-solid fa-video text-xs w-4 text-center"></i>
                                            Nova Aula
                                        </a>
                                    </li>
                                    <li class="border-t border-gray-700 mt-1 pt-1">
                                        <a href="{{ route('course.edit', $course->uuid) }}"
                                            class="flex items-center gap-2.5 w-full px-3 py-2 rounded-lg text-sm text-gray-200 hover:bg-yellow-600/20 hover:text-yellow-300 transition">
                                            <i class="fa-solid fa-pen text-xs w-4 text-center"></i>
                                            Editar Curso
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('teacher.linkCourse', $course->uuid) }}"
                                            class="flex items-center gap-2.5 w-full px-3 py-2 rounded-lg text-sm text-gray-200 hover:bg-green-600/20 hover:text-green-300 transition">
                                            <i class="fa-solid fa-user-plus text-xs w-4 text-center"></i>
                                            Vincular Alunos
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    @if ($course->image_banner)
                        <div class="overflow-hidden rounded-xl border border-gray-800 bg-gray-900 w-full">
                            <img src="{{ asset('storage/' . $course->image_banner) }}" alt="Banner do Curso"
                                class="aspect-video w-full object-cover">
                        </div>
                    @endif

                    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4 w-full">
                        <a href="{{ route('teacher.linkCourse', $course->uuid) }}"
                            class="bg-gray-800 p-4 rounded-xl shadow-lg flex items-center space-x-3 hover:bg-blue-700/30 transition-colors border border-blue-600/20">
                            <i class="fas fa-user-plus text-2xl text-blue-400"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-100">Gerenciar Alunos</p>
                                <p class="text-xs text-blue-300">{{ $course->users_count }} vinculados</p>
                            </div>
                        </a>

                        <div class="bg-gray-800 p-4 rounded-xl shadow-lg flex items-center space-x-3 border border-gray-700">
                            <i class="fas fa-cogs text-2xl text-green-500"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-200">Módulos</p>
                                <p class="text-xl font-bold text-gray-100">{{ $course->modules_count }}</p>
                            </div>
                        </div>

                        <div class="bg-gray-800 p-4 rounded-xl shadow-lg flex items-center space-x-3 border border-gray-700">
                            <i class="fas fa-chalkboard-teacher text-2xl text-yellow-500"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-200">Aulas</p>
                                <p class="text-xl font-bold text-gray-100">{{ $course->modules->sum('classrooms_count') }}</p>
                            </div>
                        </div>

                        @if ($course->payment_link)
                            <a href="{{ $course->payment_link }}" target="_blank" rel="noopener noreferrer"
                                class="bg-gray-800 p-4 rounded-xl shadow-lg flex items-center space-x-3 hover:bg-gray-700 transition-colors border border-gray-700">
                                <i class="fas fa-shopping-bag text-2xl text-purple-500"></i>
                                <div>
                                    <p class="text-sm font-medium text-gray-100">Link de Compra</p>
                                    <p class="text-xs text-gray-400">Abrir</p>
                                </div>
                            </a>
                        @else
                            <div class="bg-gray-800 p-4 rounded-xl shadow-lg flex items-center space-x-3 border border-gray-700">
                                <i class="fas fa-shopping-bag text-2xl text-gray-600"></i>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Sem link de pagamento</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="w-full" x-data="{ dropClassroom: [] }">
                        <div class="grid grid-cols-1 xl:grid-cols-[1.6fr_1.1fr] gap-6 w-full items-start">
                            <aside class="space-y-4 rounded-2xl border border-gray-800 bg-gray-950/70 p-4 shadow-lg">
                                <div class="overflow-hidden rounded-xl border border-gray-800 bg-gray-900">
                                    <img src="{{ asset('storage/' . $course->image_cover) }}" alt="Imagem do Curso"
                                        class="aspect-video w-full object-cover">
                                </div>
                                <div class="rounded-xl border border-gray-800 bg-gray-900 p-4">
                                    <p class="text-xs uppercase tracking-widest text-blue-300 font-medium">Resumo</p>
                                    <p class="mt-3 whitespace-pre-line text-sm text-gray-300 leading-relaxed">{{ $course->description }}</p>
                                </div>

                                {{-- Alunos Matriculados --}}
                                <div class="rounded-xl border border-gray-800 bg-gray-900 p-4">
                                    <p class="text-xs uppercase tracking-widest text-blue-300 font-medium">
                                        Alunos Matriculados
                                        <span class="ml-1 text-gray-500 normal-case">({{ $enrolledStudents->count() }})</span>
                                    </p>
                                    <div class="mt-3 space-y-2 max-h-60 overflow-y-auto">
                                        @forelse ($enrolledStudents as $enrolled)
                                            <div class="flex items-center justify-between p-2 rounded-lg bg-gray-800">
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-user-graduate text-blue-400 text-xs"></i>
                                                    <span class="text-sm text-gray-200">{{ $enrolled->name }}</span>
                                                </div>
                                                <form method="POST"
                                                    action="{{ route('teacher.destroyLinkCourse', ['courseUuid' => $course->uuid, 'userUuid' => $enrolled->uuid]) }}"
                                                    onsubmit="return confirm('Remover acesso do aluno a este curso?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-xs text-red-400 hover:text-red-300 ml-2 p-1"
                                                        title="Remover aluno">
                                                        <i class="fa-solid fa-times"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @empty
                                            <p class="text-sm text-gray-500 text-center py-2">Nenhum aluno matriculado</p>
                                        @endforelse
                                    </div>
                                    <a href="{{ route('teacher.linkCourse', $course->uuid) }}"
                                        class="mt-3 flex items-center justify-center gap-1.5 text-sm text-blue-400 hover:text-blue-300 transition">
                                        <i class="fa-solid fa-user-plus text-xs"></i> Gerenciar Alunos
                                    </a>
                                </div>

                                {{-- Alunos Disponíveis para Vincular --}}
                                <div class="rounded-xl border border-gray-800 bg-gray-900 p-4">
                                    <p class="text-xs uppercase tracking-widest text-green-300 font-medium">
                                        Alunos Disponíveis
                                        <span class="ml-1 text-gray-500 normal-case">({{ $availableStudents->count() }})</span>
                                    </p>
                                    <div class="mt-3 space-y-2 max-h-60 overflow-y-auto">
                                        @forelse ($availableStudents as $available)
                                            <div class="flex items-center justify-between p-2 rounded-lg bg-gray-800">
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-user text-gray-500 text-xs"></i>
                                                    <span class="text-sm text-gray-200">{{ $available->user->name }}</span>
                                                </div>
                                                <form method="POST"
                                                    action="{{ route('teacher.storeLinkCourse', $course->uuid) }}">
                                                    @csrf
                                                    <input type="hidden" name="students[]" value="{{ $available->user->uuid }}">
                                                    <button type="submit"
                                                        class="text-xs text-blue-400 hover:text-blue-300 ml-2 p-1"
                                                        title="Vincular aluno">
                                                        <i class="fa-solid fa-plus"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @empty
                                            <p class="text-sm text-gray-500 text-center py-2">Nenhum aluno disponível</p>
                                        @endforelse
                                    </div>
                                </div>
                            </aside>

                            <section class="rounded-2xl border border-gray-800 bg-gray-950/70 p-4 shadow-lg">
                                <div class="flex items-center justify-between mb-4">
                                    <p class="text-xs uppercase tracking-widest text-gray-400 font-medium">Módulos e Aulas</p>
                                    <a href="{{ route('module.create', $course->uuid) }}"
                                        class="flex items-center gap-1.5 text-xs text-blue-400 hover:text-blue-300 transition">
                                        <i class="fa-solid fa-plus"></i> Módulo
                                    </a>
                                </div>
                                <div class="space-y-4">
                                    @if ($course->modules->isEmpty())
                                        <div class="rounded-xl border border-dashed border-gray-700 bg-gray-900 p-6 text-center">
                                            <i class="fa-solid fa-folder-open text-2xl text-gray-700 mb-2"></i>
                                            <p class="text-sm text-gray-500">Nenhum módulo cadastrado.</p>
                                            <a href="{{ route('module.create', $course->uuid) }}"
                                                class="mt-3 inline-flex items-center gap-1.5 text-xs text-blue-400 hover:text-blue-300 transition">
                                                <i class="fa-solid fa-plus"></i> Criar primeiro módulo
                                            </a>
                                        </div>
                                    @else
                                        @foreach ($course->modules as $module)
                                            <article class="rounded-xl border border-gray-800 bg-gray-900 shadow-sm">
                                                <div class="flex flex-wrap items-center justify-between gap-3 p-4">
                                                    <div class="flex-1 min-w-0">
                                                        <h3 class="text-sm font-semibold text-gray-100 truncate">{{ $module->title }}</h3>
                                                        @if (!empty($module->description))
                                                            <p class="mt-0.5 text-xs text-gray-400 truncate">{{ $module->description }}</p>
                                                        @endif
                                                    </div>

                                                    <div class="flex items-center gap-2 shrink-0">
                                                        <button
                                                            @click="if (dropClassroom.includes({{ $module->id }})) { dropClassroom = dropClassroom.filter(id => id !== {{ $module->id }}); } else { dropClassroom.push({{ $module->id }}); }"
                                                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-800 border border-gray-700 text-gray-400 hover:bg-gray-700 hover:text-gray-200 transition">
                                                            <svg :class="dropClassroom.includes({{ $module->id }}) ? 'rotate-180' : ''"
                                                                 class="w-3.5 h-3.5 transition-transform duration-200"
                                                                 fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                                            </svg>
                                                        </button>

                                                        <div class="relative" x-data="{ openMenuModule: false, dtop: 0, dright: 0 }">
                                                            <button @click.stop="const r=$el.getBoundingClientRect(); dtop=r.bottom+4; dright=window.innerWidth-r.right; openMenuModule=!openMenuModule"
                                                                class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-800 border border-gray-700 text-gray-400 hover:bg-gray-700 hover:text-gray-200 transition">
                                                                <i class="fa-solid fa-ellipsis-vertical text-sm"></i>
                                                            </button>
                                                            <div x-show="openMenuModule" @click.away="openMenuModule = false"
                                                                :style="{ top: dtop+'px', right: dright+'px' }"
                                                                class="fixed w-44 rounded-xl border border-gray-700 bg-gray-800 p-1.5 shadow-xl z-[9999]"
                                                                x-transition>
                                                                <ul class="space-y-0.5">
                                                                    <li>
                                                                        <a href="{{ route('module.edit', $module->uuid) }}"
                                                                            class="flex items-center gap-2 w-full rounded-lg px-3 py-2 text-xs text-gray-200 hover:bg-blue-600/20 hover:text-blue-300 transition">
                                                                            <i class="fa-solid fa-pen w-3"></i>
                                                                            Editar Módulo
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <button @click="openMenuModule = false; openDelete = true; selectedItem = {{ json_encode($module) }}; selectedType = 'modulo'"
                                                                            class="flex items-center gap-2 w-full rounded-lg px-3 py-2 text-xs text-gray-200 hover:bg-red-600/20 hover:text-red-300 transition">
                                                                            <i class="fa-solid fa-trash w-3"></i>
                                                                            Excluir Módulo
                                                                        </button>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div x-ref="container" x-collapse x-show="dropClassroom.includes({{ $module->id }})" class="border-t border-gray-800">
                                                    @if ($module->classrooms->isEmpty())
                                                        <div class="p-4 text-center">
                                                            <p class="text-xs text-gray-500">Nenhuma aula cadastrada.</p>
                                                            <a href="{{ route('classroom.create', $course->uuid) }}"
                                                                class="mt-1 inline-flex items-center gap-1 text-xs text-blue-400 hover:text-blue-300 transition">
                                                                <i class="fa-solid fa-plus"></i> Adicionar aula
                                                            </a>
                                                        </div>
                                                    @else
                                                        <div class="divide-y divide-gray-800">
                                                            @foreach ($module->classrooms as $classroom)
                                                                <div class="flex items-center justify-between gap-3 px-4 py-3 hover:bg-gray-800/50 transition">
                                                                    <a href="{{ route('tacher.classroom.show', $classroom->uuid) }}"
                                                                       class="flex items-center gap-2.5 min-w-0 flex-1 group">
                                                                        <i class="fa-solid fa-play-circle text-xs text-gray-500 group-hover:text-blue-400 shrink-0 transition"></i>
                                                                        <span class="text-sm text-gray-200 truncate group-hover:text-blue-300 transition">{{ $classroom->title }}</span>
                                                                    </a>

                                                                    <div class="relative shrink-0" x-data="{ open: false, dtop: 0, dright: 0 }">
                                                                        <button @click.stop="const r=$el.getBoundingClientRect(); dtop=r.bottom+4; dright=window.innerWidth-r.right; open=!open"
                                                                            class="w-7 h-7 flex items-center justify-center rounded-lg bg-gray-800 border border-gray-700 text-gray-500 hover:text-gray-300 transition">
                                                                            <i class="fa-solid fa-ellipsis-vertical text-xs"></i>
                                                                        </button>
                                                                        <div x-show="open" @click.away="open = false"
                                                                            :style="{ top: dtop+'px', right: dright+'px' }"
                                                                            class="fixed w-40 rounded-xl border border-gray-700 bg-gray-800 p-1.5 shadow-xl z-[9999]"
                                                                            x-transition>
                                                                            <ul class="space-y-0.5">
                                                                                <li>
                                                                                    <a href="{{ route('classroom.edit', $classroom->uuid) }}"
                                                                                        class="flex items-center gap-2 w-full rounded-lg px-3 py-2 text-xs text-gray-200 hover:bg-blue-600/20 hover:text-blue-300 transition">
                                                                                        <i class="fa-solid fa-pen w-3"></i>
                                                                                        Editar Aula
                                                                                    </a>
                                                                                </li>
                                                                                <li>
                                                                                    <button @click="open = false; selectedItem = {{ json_encode($classroom) }}; selectedType = 'aula'; openDelete = true"
                                                                                        class="flex items-center gap-2 w-full rounded-lg px-3 py-2 text-xs text-gray-200 hover:bg-red-600/20 hover:text-red-300 transition">
                                                                                        <i class="fa-solid fa-trash w-3"></i>
                                                                                        Excluir Aula
                                                                                    </button>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </article>
                                        @endforeach
                                    @endif
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal de Exclusão --}}
        <template x-if="openDelete">
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm"
                @click.self="openDelete = false">
                <div class="bg-gray-900 rounded-2xl border border-gray-800 shadow-2xl w-full max-w-sm p-6"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100">
                    <div class="flex flex-col items-center text-center gap-3 mb-6">
                        <div class="w-14 h-14 rounded-full bg-red-500/10 flex items-center justify-center">
                            <i class="fa-solid fa-triangle-exclamation text-red-400 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-gray-100">Confirmar Exclusão</h3>
                            <p class="text-sm text-gray-400 mt-1">Esta ação não pode ser desfeita.</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button @click="openDelete = false"
                            class="flex-1 py-2.5 px-4 border border-gray-700 text-gray-300 rounded-xl hover:bg-gray-800 transition text-sm font-medium">
                            Cancelar
                        </button>
                        <form method="POST" :action="`/painel-professor/${selectedType}/${selectedItem?.uuid}`" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full py-2.5 px-4 bg-red-600 hover:bg-red-500 text-white rounded-xl transition text-sm font-medium">
                                Excluir
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </template>
    </div>
</x-app-layout>



