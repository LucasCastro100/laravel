<x-app-layout :title="$title">
    <x-slot name="header">
        <x-page-title title="Curso" />
    </x-slot>

    <div class="py-12" x-data="{ openModule: false, openClassroom: false, openEdit: false, openDelete: false, editModule: false, editClassroom: false, selectedCourse: {}, selectModule: {}, selectClassroom: {}, selectedParentUuid: '', selectedModuleId: null }">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if (session('success'))
                    <x-alert-component type="success" :message="session('success')" />
                @endif

                @if (session('error'))
                    <x-alert-component type="error" :message="session('error')" />
                @endif

                <div class="flex flex-col items-center justify-center gap-6">
                    <!-- Primeira Div (Título e Menu) -->
                    <div class="flex items-center justify-between w-full">
                        <h3 class="font-medium">{{ $course->title }}</h3>

                        <div x-data="{ open: false }" class="relative">
                            <!-- Ícone de Engrenagem -->
                            <button @click="open = !open" class="text-gray-200 hover:text-gray-100 focus:outline-none">
                                <i class="fas fa-cog text-xl"></i>
                            </button>

                            <!-- Menu Dropdown -->
                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 mt-2 w-56 bg-gray-800 border rounded-lg shadow-lg p-2 z-10"
                                x-transition>

                                <!-- Itens do menu em linha -->
                                <ul class="space-y-1">
                                    <li>
                                        <button
                                            @click="open = false; openModule = true; selectedParentUuid = {{ json_encode($course->uuid) }}"
                                            class="w-full text-left px-4 py-2 rounded hover:bg-blue-500 hover:text-white">
                                            Novo Módulo
                                        </button>
                                    </li>
                                    <li>
                                        <button
                                            @click="open = false; openClassroom = true; selectModule = {{ json_encode($course->modules) }}"
                                            class="w-full text-left px-4 py-2 rounded hover:bg-blue-500 hover:text-white">
                                            Nova Aula
                                        </button>
                                    </li>
                                    <li>
                                        <button @click="open = false; selectedCourse = {{ json_encode($course) }}; openEdit = true"
                                            class="w-full text-left px-4 py-2 rounded hover:bg-yellow-500 hover:text-white">
                                            Editar Curso
                                        </button>
                                    </li>
                                    <li>
                                        <a href="{{ route('teacher.linkCourse', $course->uuid) }}"
                                            class="w-full text-left px-4 py-2 rounded hover:bg-green-500 hover:text-white block">
                                            Vincular Alunos
                                        </a>
                                    </li>
                                    <li>
                                        <button
                                            @click="open = false; selectedCourse = {{ json_encode($course) }}; openEdit = true"
                                            class="w-full text-left px-4 py-2 rounded hover:bg-yellow-500 hover:text-white">
                                            Editar Curso
                                        </button>
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

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6 w-full">
                        <!-- Card Gerenciar Alunos -->
                        <a href="{{ route('teacher.linkCourse', $course->uuid) }}"
                            class="bg-gray-800 p-4 rounded-lg shadow-lg flex items-center space-x-4 hover:bg-blue-700 transition-colors border border-blue-600/30">
                            <i class="fas fa-user-plus text-3xl text-blue-400"></i>
                            <div>
                                <p class="text-lg font-medium text-gray-100">Gerenciar Alunos</p>
                                <p class="text-sm text-blue-300">{{ $course->users_count }} vinculados</p>
                            </div>
                        </a>

                        <!-- Card de Módulos -->
                        <div class="bg-gray-800 p-4 rounded-lg shadow-lg flex items-center space-x-4 hover:bg-gray-700 transition-colors">
                            <i class="fas fa-cogs text-3xl text-green-500"></i>
                            <div>
                                <p class="text-lg font-medium">Módulos</p>
                                <p class="text-xl font-semibold">{{ $course->modules_count }}</p>
                            </div>
                        </div>

                        <!-- Card de Aulas -->
                        <div class="bg-gray-800 p-4 rounded-lg shadow-lg flex items-center space-x-4 hover:bg-gray-700 transition-colors">
                            <i class="fas fa-chalkboard-teacher text-3xl text-yellow-500"></i>
                            <div>
                                <p class="text-lg font-medium">Aulas</p>
                                <p class="text-xl font-semibold">{{ $course->modules->sum('classrooms_count') }}</p>
                            </div>
                        </div>

                        <!-- Card Link de Compra -->
                        @if ($course->payment_link)
                            <a href="{{ $course->payment_link }}" target="_blank" rel="noopener noreferrer"
                            class="bg-gray-800 p-4 rounded-lg shadow-lg flex items-center space-x-4 hover:bg-gray-700 transition-colors">
                            <i class="fas fa-shopping-bag text-3xl text-purple-500"></i>
                            <div>
                                <p class="text-lg font-medium text-gray-100">Link de Compra</p>
                            </div>
                        </a>
                        @else
                            <div class="bg-gray-800 p-4 rounded-lg shadow-lg flex items-center space-x-4 hover:bg-gray-700 transition-colors">
                            <i class="fas fa-shopping-bag text-3xl text-purple-500"></i>
                            <div>
                                <p class="text-lg font-medium text-red-600">Não possui link de pagamento</p>
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
                                    <p class="text-sm uppercase tracking-[0.25em] text-blue-300">Resumo</p>
                                    <p class="mt-3 whitespace-pre-line text-gray-200">{{ $course->description }}</p>
                                </div>

                                {{-- Alunos Matriculados --}}
                                <div class="rounded-xl border border-gray-800 bg-gray-900 p-4">
                                    <p class="text-sm uppercase tracking-[0.25em] text-blue-300">
                                        Alunos Matriculados
                                        <span class="ml-1 text-xs text-gray-400">({{ $enrolledStudents->count() }})</span>
                                    </p>
                                    <div class="mt-3 space-y-2 max-h-60 overflow-y-auto">
                                        @forelse ($enrolledStudents as $enrolled)
                                            <div class="flex items-center justify-between p-2 rounded-lg bg-gray-800">
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-user-graduate text-blue-400 text-sm"></i>
                                                    <span class="text-sm text-gray-200">{{ $enrolled->name }}</span>
                                                </div>
                                                <form method="POST"
                                                    action="{{ route('teacher.destroyLinkCourse', ['courseUuid' => $course->uuid, 'userUuid' => $enrolled->uuid]) }}"
                                                    onsubmit="return confirm('Remover acesso do aluno a este curso?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-xs text-red-400 hover:text-red-300 ml-2"
                                                        title="Remover aluno">
                                                        <i class="fa-solid fa-times"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @empty
                                            <p class="text-sm text-gray-400 text-center py-2">Nenhum aluno matriculado</p>
                                        @endforelse
                                    </div>
                                    <a href="{{ route('teacher.linkCourse', $course->uuid) }}"
                                        class="mt-3 block text-center text-sm text-blue-400 hover:text-blue-300">
                                        <i class="fa-solid fa-user-plus"></i> Gerenciar Alunos
                                    </a>
                                </div>

                                {{-- Alunos Disponíveis para Vincular --}}
                                <div class="rounded-xl border border-gray-800 bg-gray-900 p-4">
                                    <p class="text-sm uppercase tracking-[0.25em] text-green-300">
                                        Alunos Disponíveis
                                        <span class="ml-1 text-xs text-gray-400">({{ $availableStudents->count() }})</span>
                                    </p>
                                    <div class="mt-3 space-y-2 max-h-60 overflow-y-auto">
                                        @forelse ($availableStudents as $available)
                                            <div class="flex items-center justify-between p-2 rounded-lg bg-gray-800">
                                                <div class="flex items-center gap-2">
                                                    <i class="fas fa-user text-gray-400 text-sm"></i>
                                                    <span class="text-sm text-gray-200">{{ $available->user->name }}</span>
                                                </div>
                                                <form method="POST"
                                                    action="{{ route('teacher.storeLinkCourse', $course->uuid) }}">
                                                    @csrf
                                                    <input type="hidden" name="students[]" value="{{ $available->user->uuid }}">
                                                    <button type="submit"
                                                        class="text-xs text-blue-400 hover:text-blue-300 ml-2"
                                                        title="Vincular aluno">
                                                        <i class="fa-solid fa-plus"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @empty
                                            <p class="text-sm text-gray-400 text-center py-2">Nenhum aluno disponível</p>
                                        @endforelse
                                    </div>
                                </div>
                            </aside>

                            <section class="rounded-2xl border border-gray-800 bg-gray-950/70 p-4 shadow-lg">
                                <div class="mt-4 space-y-4">
                                    @if ($course->modules->isEmpty())
                                        <div class="rounded-xl border border-gray-800 bg-gray-900 p-6 text-center text-gray-200">
                                            Nenhum módulo cadastrado.
                                        </div>
                                    @else
                                        @foreach ($course->modules as $module)
                                            <article class="rounded-xl border border-gray-800 bg-gray-900 p-4 shadow-sm">
                                                <div class="flex flex-wrap items-start justify-between gap-3">
                                                    <div>
                                                        <h3 class="text-lg font-semibold text-gray-100">{{ $module->title }}</h3>
                                                        @if (!empty($module->description))
                                                            <p class="mt-1 whitespace-pre-line text-sm text-gray-200">{{ $module->description }}</p>
                                                        @endif
                                                    </div>

                                                    <div class="flex items-center gap-2">
                                                        <button
                                                            @click="if (dropClassroom.includes({{ $module->id }})) { dropClassroom = dropClassroom.filter(id => id !== {{ $module->id }}); } else { dropClassroom.push({{ $module->id }}); }"
                                                            class="rounded-full bg-blue-600/10 px-3 py-1 text-sm text-blue-200 hover:bg-blue-600/20">
                                                            <span x-show="!dropClassroom.includes({{ $module->id }})">Expandir</span>
                                                            <span x-show="dropClassroom.includes({{ $module->id }})">Recolher</span>
                                                        </button>

                                                        <div class="relative" x-data="{ openMenuModule: false }">
                                                            <button @click="openMenuModule = !openMenuModule"
                                                                class="rounded-full bg-gray-800 p-2 text-gray-200 hover:bg-gray-700">
                                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                                            </button>
                                                            <div x-show="openMenuModule" @click.away="openMenuModule = false"
                                                                class="absolute right-0 mt-2 w-40 rounded-lg border border-gray-700 bg-gray-800 p-2 shadow-lg z-10" x-transition>
                                                                <ul class="space-y-1">
                                                                        <li>
                                                                        <button @click="openMenuModule = false; editModule = true; selectedModule = {{ json_encode($module) }}; openEditModule = true; selectedParentUuid = '{{ $module->uuid }}'"
                                                                            class="w-full rounded px-3 py-2 text-left text-sm text-gray-100 hover:bg-blue-600/20">
                                                                            Editar Módulo
                                                                        </button>
                                                                    </li>
                                                                    <li>
                                                                        <button @click="openMenuModule = false; openDelete = true; selectedItem = {{ json_encode($module) }}; selectedType = 'modulo'"
                                                                            class="w-full rounded px-3 py-2 text-left text-sm text-gray-100 hover:bg-red-600/20">
                                                                            Excluir Módulo
                                                                        </button>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div x-ref="container" x-collapse x-show="dropClassroom.includes({{ $module->id }})" class="mt-4 space-y-2">
                                                    @if ($module->classrooms->isEmpty())
                                                        <div class="rounded-lg border border-dashed border-gray-700 bg-gray-800/70 p-4 text-center text-gray-200">
                                                            Nenhuma aula cadastrada.
                                                        </div>
                                                    @else
                                                        @foreach ($module->classrooms as $classroom)
                                                            <div class="flex flex-wrap items-center justify-between gap-3 rounded-lg border border-gray-800 bg-gray-800/80 p-3">
                                                                <button type="button" @click="window.location.href = '/painel-professor/aula/' + {{ json_encode($classroom->uuid) }}"
                                                                    class="text-left text-gray-100 hover:text-blue-200">
                                                                    {{ $classroom->title }}
                                                                </button>

                                                                <div class="relative" x-data="{ open: false }">
                                                                    <button @click="open = !open"
                                                                        class="rounded-full bg-gray-800 p-2 text-gray-200 hover:bg-gray-700">
                                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                                    </button>
                                                                    <div x-show="open" @click.away="open = false"
                                                                        class="absolute right-0 mt-2 w-40 rounded-lg border border-gray-700 bg-gray-800 p-2 shadow-lg z-10" x-transition>
                                                                        <ul class="space-y-1">
                                                                            <li>
                                                                                <button @click="open = false; selectedModuleId = {{ $module->id }}; selectClassroom = {{ json_encode($classroom) }}; selectedParentUuid = '{{ $classroom->uuid }}'; editClassroom = true"
                                                                                    class="w-full rounded px-3 py-2 text-left text-sm text-gray-100 hover:bg-blue-600/20">
                                                                                    Editar Aula
                                                                                </button>
                                                                            </li>
                                                                            <li>
                                                                                <button @click="open = false; selectedItem = {{ json_encode($classroom) }}; selectedType = 'aula'; openDelete = true"
                                                                                    class="w-full rounded px-3 py-2 text-left text-sm text-gray-100 hover:bg-red-600/20">
                                                                                    Excluir Aula
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
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

        <template x-if="openEdit">
            <div class="fixed inset-0 bg-gray-950 bg-opacity-75" @click.stop>
                <div class="flex h-full items-center justify-center p-2 sm:p-4">
                    <div class="bg-gray-950 p-4 sm:p-6 rounded-lg w-full max-w-2xl my-4 max-h-[90%] overflow-y-auto custom-scrollbar">
                        <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl">Editar Curso</h2>
                        <button @click="openEdit = false"
                            class="text-gray-200 hover:text-gray-200">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <form method="POST" :action="`/painel-professor/curso/${selectedCourse.uuid}`"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-medium text-gray-200">Título</label>
                            <input type="text" name="title" x-model="selectedCourse.title"
                                class="mt-1 block w-full px-3 py-2 bg-gray-950 text-gray-200 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-[1fr_2fr] gap-4 mt-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-200">Preço (R$)</label>
                                <input type="number" name="price" step="0.01" min="0" x-model="selectedCourse.price"
                                    class="mt-1 block w-full px-3 py-2 bg-gray-950 text-gray-200 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-200">Link pagamento</label>
                                <input type="text" name="payment_link" x-model="selectedCourse.payment_link"
                                    class="mt-1 block w-full px-3 py-2 bg-gray-950 text-gray-200 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-200">Descrição</label>
                            <textarea name="description" x-model="selectedCourse.description" rows="8" class="mt-1 block w-full px-3 py-2 bg-gray-950 text-gray-200 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 mt-4">
                            <div class="relative flex-1 min-w-0">
                                <label class="block text-sm font-medium text-gray-200 mb-1">Imagem de capa</label>
                                <label for="dropzone-cover-edit"
                                    class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-950 hover:bg-gray-900">
                                    <div class="flex flex-col items-center justify-center p-3">
                                        <svg class="w-6 h-6 mb-2 text-gray-200" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                        </svg>
                                        <p class="mb-1 text-xs text-gray-200"><span class="font-semibold">Clique para upload</span></p>
                                        <p class="text-xs text-gray-200">SVG, PNG, JPG ou GIF</p>
                                    </div>
                                    <input id="dropzone-cover-edit" type="file" class="hidden" name="image_cover"
                                        accept="image/*" onchange="window.previewImage(event, { previewImageId: 'image-cover-preview-edit', previewContainerId: 'image-cover-preview-container-edit', imageFromDbId: 'image-cover-from-db' })" />
                                    <div id="image-cover-preview-container-edit"
                                        class="absolute inset-0 hidden flex items-center justify-center">
                                        <img id="image-cover-preview-edit" class="w-full h-full object-contain rounded-lg p-1"
                                            alt="Pré-visualização da Capa" />
                                    </div>
                                    <div id="image-cover-from-db" x-show="selectedCourse.image_cover"
                                        class="absolute inset-0 flex items-center justify-center">
                                        <img x-bind:src="'/storage/' + selectedCourse.image_cover"
                                            class="w-full h-full object-contain rounded-lg p-1" alt="Capa do Curso">
                                    </div>
                                </label>
                            </div>

                            <div class="relative flex-1 min-w-0">
                                <label class="block text-sm font-medium text-gray-200 mb-1">Imagem banner</label>
                                <label for="dropzone-banner-edit"
                                    class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-950 hover:bg-gray-900">
                                    <div class="flex flex-col items-center justify-center p-3">
                                        <svg class="w-6 h-6 mb-2 text-gray-200" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                        </svg>
                                        <p class="mb-1 text-xs text-gray-200"><span class="font-semibold">Clique para upload</span></p>
                                        <p class="text-xs text-gray-200">SVG, PNG, JPG ou GIF</p>
                                    </div>
                                    <input id="dropzone-banner-edit" type="file" class="hidden" name="image_banner"
                                        accept="image/*" onchange="window.previewImage(event, { previewImageId: 'image-banner-preview-edit', previewContainerId: 'image-banner-preview-container-edit', imageFromDbId: 'image-banner-from-db' })" />
                                    <div id="image-banner-preview-container-edit"
                                        class="absolute inset-0 hidden flex items-center justify-center">
                                        <img id="image-banner-preview-edit" class="w-full h-full object-contain rounded-lg p-1"
                                            alt="Pré-visualização do Banner" />
                                    </div>
                                    <div id="image-banner-from-db" x-show="selectedCourse.image_banner"
                                        class="absolute inset-0 flex items-center justify-center">
                                        <img x-bind:src="'/storage/' + selectedCourse.image_banner"
                                            class="w-full h-full object-contain rounded-lg p-1" alt="Banner do Curso">
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="relative flex-1 min-w-0 mt-4">
                            <label class="block text-sm font-medium text-gray-200 mb-1">Fundo do Certificado</label>
                            <label for="dropzone-certificate-edit"
                                class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-950 hover:bg-gray-900">
                                <div class="flex flex-col items-center justify-center p-3">
                                    <svg class="w-6 h-6 mb-2 text-gray-200" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                    </svg>
                                    <p class="mb-1 text-xs text-gray-200"><span class="font-semibold">Clique para upload</span></p>
                                    <p class="text-xs text-gray-200">JPEG, PNG, WEBP (max 5MB)</p>
                                </div>
                                <input id="dropzone-certificate-edit" type="file" class="hidden" name="certificate_background"
                                    accept="image/*" />
                            </label>
                        </div>

                        <div class="mt-4">
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="certificate_enabled" value="1"
                                    x-bind:checked="selectedCourse.certificate_enabled"
                                    class="rounded border-gray-600 bg-gray-800 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-gray-200">Habilitar certificado para este curso</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-between mt-4">
                            <button type="button" @click="openEdit = false"
                                class="bg-red-500 text-white px-4 py-2 rounded">Fechar</button>

                            <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded">Salvar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </template>

        <template x-if="openModule">
            <div class="fixed inset-0 bg-gray-950 bg-opacity-75" @click.stop>
                <div class="flex h-full items-center justify-center p-1">
                    <div class="bg-gray-950 p-6 rounded-lg relative w-full max-w-md my-4 max-h-[90%] overflow-y-auto custom-scrollbar">
                        <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl">Novo Módulo</h2>
                        <button @click="openModule = false"
                            class="text-gray-200 hover:text-gray-200">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <form method="POST" :action="`/painel-professor/modulo/${selectedParentUuid}`">
                        @csrf

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-200">Título</label>
                            <input type="text" id="title" name="title"
                                class="mt-1 block w-full px-3 py-2 bg-gray-950 text-gray-200 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-200">Descrição</label>
                            <textarea id="description" name="description" rows="6"
                                class="mt-1 block w-full px-3 py-2 bg-gray-950 text-gray-200 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="button" @click="openModule = false"
                                class="bg-red-500 text-white px-4 py-2 rounded">Fechar</button>
                            <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded">Salvar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </template>

        <template x-if="editModule">
            <div class="fixed inset-0 bg-gray-950 bg-opacity-75" @click.stop>
                <div class="flex h-full items-center justify-center p-1">
                    <div class="bg-gray-950 p-6 rounded-lg relative w-full max-w-md my-4 max-h-[90%] overflow-y-auto custom-scrollbar">
                        <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl">Editar Módulo</h2>
                        <button @click="editModule = false"
                            class="text-gray-200 hover:text-gray-200">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <form method="POST" :action="`/painel-professor/modulo/${selectedModule.uuid}`">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-200">Título</label>
                            <input type="text" id="title" name="title" x-model="selectedModule.title"
                                class="mt-1 block w-full px-3 py-2 bg-gray-950 text-gray-200 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-200">Descrição</label>
                            <textarea id="description" name="description" x-model="selectedModule.description" rows="6"
                                class="mt-1 block w-full px-3 py-2 bg-gray-950 text-gray-200 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="button" @click="editModule = false"
                                class="bg-red-500 text-white px-4 py-2 rounded">Fechar</button>
                            <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded">Salvar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </template>

        <template x-if="openClassroom">
            <div class="fixed inset-0 bg-gray-950 bg-opacity-75" @click.stop>
                <div class="flex h-full items-center justify-center p-1">
                    <div class="bg-gray-950 p-6 rounded-lg relative w-full max-w-md my-4 max-h-[90%] overflow-y-auto custom-scrollbar">
                        <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl">Nova Aula</h2>
                        <button @click="openClassroom = false"
                            class="text-gray-200 hover:text-gray-200">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('classroom.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-200">Nome da Aula</label>
                            <input type="text" id="title" name="title"
                                class="mt-1 block w-full px-3 py-2 bg-gray-950 text-gray-200 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-200">Descrição</label>
                            <textarea id="description" name="description" rows="6"
                                class="mt-1 block w-full px-3 py-2 bg-gray-950 text-gray-200 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="video" class="block text-sm font-medium text-gray-200">URL do
                                Vídeo</label>
                            <input type="url" id="video" name="video"
                                class="mt-1 block w-full px-3 py-2 bg-gray-950 text-gray-200 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div class="mb-4">
                            <label for="module_id" class="block text-sm font-medium text-gray-200">Selecionar
                                Módulo</label>
                            <select id="module_id" name="module_id"
                                class="mt-1 block w-full px-3 py-2 bg-gray-950 text-gray-200 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">

                                <option disabled selected>Selecione o Módulo</option>
                                @foreach ($course->modules as $module)
                                    <option value="{{ $module->id }}"> {{ $module->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="button" @click="openClassroom = false"
                                class="bg-red-500 text-white px-4 py-2 rounded">Fechar</button>
                            <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded">Salvar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </template>

        <template x-if="editClassroom">
            <div class="fixed inset-0 bg-gray-950 bg-opacity-75" @click.stop>
                <div class="flex h-full items-center justify-center p-1">
                    <div class="bg-gray-950 p-6 rounded-lg relative w-full max-w-md my-4 max-h-[90%] overflow-y-auto custom-scrollbar">
                        <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl">Editar Aula</h2>
                        <button @click="editClassroom = false"
                            class="text-gray-200 hover:text-gray-200">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <form method="POST" :action="`/painel-professor/aula/${selectClassroom.uuid}/editar`">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-200">Nome da Aula</label>
                            <input type="text" id="title" name="title"
                                class="mt-1 block w-full px-3 py-2 bg-gray-950 text-gray-200 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                x-model="selectClassroom.title">
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-200">Descrição</label>
                            <textarea id="description" name="description" rows="6"
                                class="mt-1 block w-full px-3 py-2 bg-gray-950 text-gray-200 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                x-model="selectClassroom.description"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="video" class="block text-sm font-medium text-gray-200">URL do
                                Vídeo</label>
                            <input type="url" id="video" name="video"
                                class="mt-1 block w-full px-3 py-2 bg-gray-950 text-gray-200 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                x-model="selectClassroom.video">
                        </div>

                        <div class="mb-4">
                            <label for="module_id" class="block text-sm font-medium text-gray-200">Selecionar
                                Módulo</label>
                            <select id="module_id" name="module_id" x-model="selectedModuleId"
                                class="mt-1 block w-full px-3 py-2 bg-gray-950 text-gray-200 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="" disabled selected>Selecione o Módulo</option>
                                @foreach ($course->modules as $module)
                                    <option value="{{ $module->id }}"
                                        :selected="selectedModuleId === {{ $module->id }}">{{ $module->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="button" @click="editClassroom = false"
                                class="bg-red-500 text-white px-4 py-2 rounded">Fechar</button>
                            <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded">Salvar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </template>

        <template x-if="openDelete">
            <div class="fixed inset-0 bg-gray-950 bg-opacity-75" @click.stop>
                <div class="flex h-full items-center justify-center p-1">
                    <div class="bg-gray-950 p-6 rounded-lg relative w-full max-w-md my-4 max-h-[90%] overflow-y-auto custom-scrollbar">
                        <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl">Confirmar Exclusão</h2>
                        <button @click="openDelete = false"
                            class="text-gray-200 hover:text-gray-200">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    {{-- <p class="mb-4">Tem certeza de que deseja excluir o curso <strong
                            x-text="selectedCourse.title"></strong>?</p> --}}
                    <div class="flex items-center justify-between">
                        <button type="button" @click="openDelete = false"
                            class="bg-red-500 text-white px-4 py-2 rounded">Fechar</button>
                        <form method="POST" :action="`/painel-professor/${selectedType}/${selectedItem?.uuid}`">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-500 text-white px-4 py-2 rounded">Excluir</button>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</x-app-layout>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('deleteModal', () => ({
            openDelete: false,
            selectedItem: null,
            selectedType: '',

            get deleteUrl() {
                if (!this.selectedType || !this.selectedItem?.uuid) return '#';
                return `/${this.selectedType}/${this.selectedItem.uuid}`;
            }
        }));
    });
</script>
