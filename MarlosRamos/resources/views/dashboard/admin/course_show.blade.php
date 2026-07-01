<x-app-layout :title="$title">
    <x-slot name="header">
        <x-page-title title="Curso" />
    </x-slot>

    <div class="py-12" x-data="{ openModule: false, openClassroom: false, openEdit: false, openDelete: false, editModule: false, editClassroom: false, selectedCourse: {}, selectModule: {}, selectClassroom: {}, selectedParentUuid: '', selectedModuleId: null }">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg p-6">

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
                                        <button
                                            @click="open = false; selectedItem = {{ json_encode($course) }}; selectedType = 'curso'; openDelete = true"
                                            class="w-full text-left px-4 py-2 rounded hover:bg-red-500 hover:text-white">
                                            Deletar Curso
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

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 w-full">
                        <!-- Card de Alunos -->
                        <div class="bg-gray-800 p-4 rounded-lg shadow-lg flex items-center space-x-4">
                            <i class="fas fa-user-graduate text-3xl text-blue-500"></i>
                            <div>
                                <p class="text-lg font-medium">Alunos</p>
                                <p class="text-xl font-semibold">{{ $course->users_count }}</p>
                            </div>
                        </div>

                        <!-- Card de Módulos -->
                        <div class="bg-gray-800 p-4 rounded-lg shadow-lg flex items-center space-x-4">
                            <i class="fas fa-cogs text-3xl text-green-500"></i>
                            <div>
                                <p class="text-lg font-medium">Módulos</p>
                                <p class="text-xl font-semibold">{{ $course->modules_count }}</p>
                            </div>
                        </div>

                        <!-- Card de Aulas -->
                        <div class="bg-gray-800 p-4 rounded-lg shadow-lg flex items-center space-x-4">
                            <i class="fas fa-chalkboard-teacher text-3xl text-yellow-500"></i>
                            <div>
                                <p class="text-lg font-medium">Aulas</p>
                                <p class="text-xl font-semibold">{{ $course->modules->sum('classrooms_count') }}</p>
                            </div>
                        </div>
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
                                                            @click="dropClassroom.includes({{ $module->id }}) ? dropClassroom = dropClassroom.filter(id => id !== {{ $module->id }}) : dropClassroom.push({{ $module->id }})"
                                                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-800 border border-gray-700 text-gray-400 hover:bg-gray-700 hover:text-gray-200 transition">
                                                            <svg :class="dropClassroom.includes({{ $module->id }}) ? 'rotate-180' : ''"
                                                                 class="w-3.5 h-3.5 transition-transform duration-200"
                                                                 fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                                            </svg>
                                                        </button>

                                                        <div class="relative" x-data="{ openMenuModule: false, dtop: 0, dright: 0 }">
                                                            <button @click.stop="const r=$el.getBoundingClientRect(); dtop=r.bottom+4; dright=window.innerWidth-r.right; openMenuModule=!openMenuModule"
                                                                class="rounded-full bg-gray-800 p-2 text-gray-200 hover:bg-gray-700">
                                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                                            </button>
                                                            <div x-show="openMenuModule" @click.away="openMenuModule = false"
                                                                :style="{ top: dtop+'px', right: dright+'px' }"
                                                                class="fixed w-40 rounded-lg border border-gray-700 bg-gray-800 p-2 shadow-lg z-[9999]" x-transition>
                                                                <ul class="space-y-1">
                                                                    <li>
                                                                        <button
                                                                            @click="openMenuModule = false; editModule = true; selectedModule = {{ json_encode($module) }}; openEditModule = true; selectedParentUuid = '{{ $module->uuid }}'"
                                                                            class="w-full rounded px-3 py-2 text-left text-sm text-gray-100 hover:bg-blue-600/20">
                                                                            Editar Módulo
                                                                        </button>
                                                                    </li>
                                                                    <li>
                                                                        <button
                                                                            @click="openMenuModule = false; openDelete = true; selectedItem = {{ json_encode($module) }}; selectedType = 'modulo'"
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
                                                                <a href="{{ route('admin.classroom.show', $classroom->uuid) }}"
                                                                   class="flex items-center gap-2 flex-1 min-w-0 group">
                                                                    <i class="fa-solid fa-play-circle text-xs text-gray-500 group-hover:text-blue-400 shrink-0 transition"></i>
                                                                    <span class="text-sm text-gray-100 truncate group-hover:text-blue-300 transition">{{ $classroom->title }}</span>
                                                                </a>

                                                                <div class="relative shrink-0" x-data="{ open: false, dtop: 0, dright: 0 }">
                                                                    <button @click.stop="const r=$el.getBoundingClientRect(); dtop=r.bottom+4; dright=window.innerWidth-r.right; open=!open"
                                                                        class="rounded-full bg-gray-800 p-2 text-gray-200 hover:bg-gray-700">
                                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                                    </button>
                                                                    <div x-show="open" @click.away="open = false"
                                                                        :style="{ top: dtop+'px', right: dright+'px' }"
                                                                        class="fixed w-40 rounded-lg border border-gray-700 bg-gray-800 p-2 shadow-lg z-[9999]" x-transition>
                                                                        <ul class="space-y-1">
                                                                            <li>
                                                                                <button
                                                                                    @click="open = false; selectedModuleId = {{ $module->id }}; selectClassroom = {{ json_encode($classroom) }}; selectedParentUuid = '{{ $classroom->uuid }}'; editClassroom = true"
                                                                                    class="w-full rounded px-3 py-2 text-left text-sm text-gray-100 hover:bg-blue-600/20">
                                                                                    Editar Aula
                                                                                </button>
                                                                            </li>
                                                                            <li>
                                                                                <button
                                                                                    @click="open = false; selectedItem = {{ json_encode($classroom) }}; selectedType = 'aula'; openDelete = true"
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
                        <button @click="openEdit = false" class="text-gray-200 hover:text-gray-200">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <form method="POST" :action="`/curso/${selectedCourse.uuid}`" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div>
                            <label class="block text-sm font-medium text-gray-200">Título</label>
                            <input type="text" name="title" x-model="selectedCourse.title"
                                class="appearance-none mt-1 block w-full pl-3 pr-10 py-2 bg-white text-gray-900 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-[1fr_2fr] gap-4 mt-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-200">Preço (R$)</label>
                                <input type="number" name="price" step="0.01" min="0" x-model="selectedCourse.price"
                                    class="appearance-none mt-1 block w-full pl-3 pr-10 py-2 bg-white text-gray-900 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-200">Link pagamento</label>
                                <input type="text" name="payment_link" x-model="selectedCourse.payment_link"
                                    class="appearance-none mt-1 block w-full pl-3 pr-10 py-2 bg-white text-gray-900 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-200">Descrição</label>
                            <textarea name="description" x-model="selectedCourse.description" rows="8" class="appearance-none mt-1 block w-full pl-3 pr-10 py-2 bg-white text-gray-900 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 mt-4">
                            <div class="relative flex-1 min-w-0">
                                <label class="block text-sm font-medium text-gray-200 mb-1">Imagem de capa</label>
                                <label for="dropzone-cover-edit"
                                    class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-white hover:bg-gray-50 transition">
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
                                    class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-white hover:bg-gray-50 transition">
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

                    <form method="POST" :action="`/modulo/${selectedParentUuid}`">
                        @csrf

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-200">Título</label>
                            <input type="text" id="title" name="title"
                                class="appearance-none mt-1 block w-full pl-3 pr-10 py-2 bg-white text-gray-900 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-200">Descrição</label>
                            <textarea id="description" name="description" rows="6"
                                class="appearance-none mt-1 block w-full pl-3 pr-10 py-2 bg-white text-gray-900 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                required></textarea>
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

                    <form method="POST" :action="`/modulo/${selectedModule.uuid}`">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-200">Título</label>
                            <input type="text" id="title" name="title" x-model="selectedModule.title"
                                class="appearance-none mt-1 block w-full pl-3 pr-10 py-2 bg-white text-gray-900 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-200">Descrição</label>
                            <textarea id="description" name="description" x-model="selectedModule.description" rows="6"
                                class="appearance-none mt-1 block w-full pl-3 pr-10 py-2 bg-white text-gray-900 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                required></textarea>
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
                                class="appearance-none mt-1 block w-full pl-3 pr-10 py-2 bg-white text-gray-900 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-200">Descrição</label>
                            <textarea id="description" name="description" rows="6"
                                class="appearance-none mt-1 block w-full pl-3 pr-10 py-2 bg-white text-gray-900 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                required></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="video" class="block text-sm font-medium text-gray-200">URL do
                                Vídeo</label>
                            <input type="url" id="video" name="video"
                                class="appearance-none mt-1 block w-full pl-3 pr-10 py-2 bg-white text-gray-900 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="module_id" class="block text-sm font-medium text-gray-200">Selecionar
                                Módulo</label>
                            <div class="relative mt-1">
                                <select id="module_id" name="module_id"
                                    class="appearance-none block w-full pl-3 pr-10 py-2 bg-white text-gray-900 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    required>
                                    <option disabled selected>Selecione o Módulo</option>
                                    @foreach ($course->modules as $module)
                                        <option value="{{ $module->id }}"> {{ $module->title }}</option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
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
                    <form method="POST" :action="`/aula/${selectClassroom.uuid}/editar`">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-200">Nome da Aula</label>
                            <input type="text" id="title" name="title"
                                class="appearance-none mt-1 block w-full pl-3 pr-10 py-2 bg-white text-gray-900 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                required  x-model="selectClassroom.title">
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-200">Descrição</label>
                            <textarea id="description" name="description" rows="6"
                                class="appearance-none mt-1 block w-full pl-3 pr-10 py-2 bg-white text-gray-900 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                required x-model="selectClassroom.description"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="video" class="block text-sm font-medium text-gray-200">URL do
                                Vídeo</label>
                            <input type="url" id="video" name="video"
                                class="appearance-none mt-1 block w-full pl-3 pr-10 py-2 bg-white text-gray-900 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                required  x-model="selectClassroom.video">
                        </div>

                        <div class="mb-4">
                            <label for="module_id" class="block text-sm font-medium text-gray-200">Selecionar
                                Módulo</label>
                            <div class="relative mt-1">
                                <select id="module_id" name="module_id" x-model="selectedModuleId"
                                    class="appearance-none block w-full pl-3 pr-10 py-2 bg-white text-gray-900 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    required>
                                    <option value="" disabled selected>Selecione o Módulo</option>
                                    @foreach ($course->modules as $module)
                                        <option value="{{ $module->id }}"
                                            :selected="selectedModuleId === {{ $module->id }}">{{ $module->title }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
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
                        <form method="POST" :action="`/${selectedType}/${selectedItem?.uuid}`">
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






