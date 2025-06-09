<x-app-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Curso') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ openModule: false, openClassroom: false, openEdit: false, openDelete: false, editModule: false, editClassroom: false, selectedCourse: {}, selectModule: {}, selectClassroom: {}, selectedParentUuid: '' }">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
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
                            <button @click="open = !open" class="text-gray-600 hover:text-gray-900 focus:outline-none">
                                <i class="fas fa-cog text-xl"></i>
                            </button>

                            <!-- Menu Dropdown -->
                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 mt-2 w-56 bg-white border rounded-lg shadow-lg p-2 z-10"
                                x-transition>

                                <!-- Itens do menu em linha -->
                                <ul class="space-y-1">
                                    <li>
                                        <button
                                            @click="openModule = true; selectedParentUuid = {{ json_encode($course->uuid) }}"
                                            class="w-full text-left px-4 py-2 rounded hover:bg-blue-500 hover:text-white">
                                            Novo Módulo
                                        </button>
                                    </li>
                                    <li>
                                        <button
                                            @click="openClassroom = true; selectModule = {{ json_encode($course->modules) }}"
                                            class="w-full text-left px-4 py-2 rounded hover:bg-blue-500 hover:text-white">
                                            Nova Aula
                                        </button>
                                    </li>
                                    <li>
                                        <button @click="selectedCourse = {{ json_encode($course) }}; openEdit = true"
                                            class="w-full text-left px-4 py-2 rounded hover:bg-yellow-500 hover:text-white">
                                            Editar Curso
                                        </button>
                                    </li>
                                    <li>
                                        <button
                                            @click="selectedItem = {{ json_encode($course) }}; selectedType = 'curso'; openDelete = true"
                                            class="w-full text-left px-4 py-2 rounded hover:bg-red-500 hover:text-white">
                                            Deletar Curso
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>


                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 w-full">
                        <!-- Card de Alunos -->
                        <div class="bg-white p-4 rounded-lg shadow-lg flex items-center space-x-4">
                            <i class="fas fa-user-graduate text-3xl text-blue-500"></i>
                            <div>
                                <p class="text-lg font-medium">Alunos</p>
                                <p class="text-xl font-semibold">{{ $course->users_count }}</p>
                            </div>
                        </div>

                        <!-- Card de Módulos -->
                        <div class="bg-white p-4 rounded-lg shadow-lg flex items-center space-x-4">
                            <i class="fas fa-cogs text-3xl text-green-500"></i>
                            <div>
                                <p class="text-lg font-medium">Módulos</p>
                                <p class="text-xl font-semibold">{{ $course->modules_count }}</p>
                            </div>
                        </div>

                        <!-- Card de Aulas -->
                        <div class="bg-white p-4 rounded-lg shadow-lg flex items-center space-x-4">
                            <i class="fas fa-chalkboard-teacher text-3xl text-yellow-500"></i>
                            <div>
                                <p class="text-lg font-medium">Aulas</p>
                                <p class="text-xl font-semibold">{{ $course->modules->sum('classrooms_count') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="w-full" x-data="{ dropClassroom: [] }">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 w-full">
                            <div class="sm:col-span-1 md:col-span-1">
                                <img src="{{ asset('storage/' . $course->image) }}" alt="Imagem do Curso"
                                    class="w-full h-auto mb-4">
                                <p class="text-gray-600">{{ $course->description }}</p>
                            </div>

                            <div class="sm:col-span-1 md:col-span-2">
                                @if ($course->modules->isEmpty())
                                    <div class="text-center text-gray-500">
                                        Nenhum módulo cadastrado.
                                    </div>
                                @else
                                    @foreach ($course->modules as $module)
                                        <div class="mb-4 relative z-0">
                                            <div class="border rounded-lg p-4 bg-gray-100">
                                                <div class="flex justify-between items-center relative">
                                                    <h3 class="font-semibold">{{ $module->title }}</h3>

                                                    <div class="flex items-center space-x-2">
                                                        <!-- Botão de Expandir/Recolher -->
                                                        <button
                                                        @click="if (dropClassroom.includes({{ $module->id }})) { dropClassroom = dropClassroom.filter(id => id !== {{ $module->id }}); } else { dropClassroom.push({{ $module->id }}); }"
                                                        class="text-blue-500">
                                                        <span x-show="!dropClassroom.includes({{ $module->id }})">+</span>
                                                        <span x-show="dropClassroom.includes({{ $module->id }})">-</span>
                                                    </button>

                                                        <!-- Dropdown de Opções -->
                                                        <div class="relative" x-data="{ openMenuModule: false }">
                                                            <!-- Ícone de Três Pontos -->
                                                            <button @click="openMenuModule = !openMenuModule"
                                                                class="text-gray-500 hover:text-gray-700">
                                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                                            </button>

                                                            <!-- Menu Dropdown -->
                                                            <div x-show="openMenuModule"
                                                            @click.away="openMenuModule = false"                                                                
                                                                class="absolute right-0 mt-2 w-40 bg-white border rounded-lg shadow-lg p-2 z-10"
                                                                x-transition>
                                                                <ul class="space-y-1">
                                                                    <li>
                                                                        <button
                                                                            @click="editModule = true; selectedModule = {{ json_encode($module) }}; openEditModule = true; selectedParentUuid = '{{ $module->uuid }}'"
                                                                            class="w-full text-left px-4 py-2 rounded hover:bg-blue-500 hover:text-white">
                                                                            Editar Módulo
                                                                        </button>
                                                                    </li>
                                                                    <li>
                                                                        <button
                                                                            @click="openDelete = true; selectedItem = {{ json_encode($module) }}; selectedType = 'modulo'"
                                                                            class="w-full text-left px-4 py-2 rounded hover:bg-red-500 hover:text-white">
                                                                            Excluir Módulo
                                                                        </button>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Dropdown de Aulas -->
                                                <div x-ref="container" x-collapse
                                                    x-show="dropClassroom.includes({{ $module->id }})">
                                                    @if ($module->classrooms->isEmpty())
                                                        <div class="text-center text-gray-500">
                                                            Nenhuma aula cadastrada.
                                                        </div>
                                                    @else
                                                        @foreach ($module->classrooms as $classroom)
                                                            <div class="flex justify-between items-center p-2 border-b relative">
                                                                <div class="flex items-center" @click="window.location.href = '/aula/' + {{ json_encode($classroom->uuid) }}">
                                                                    <span>{{ $classroom->title }}</span>
                                                                </div>

                                                                <div class="relative" x-data="{ open: false }">
                                                                    <!-- Ícone de três pontos -->
                                                                    <button @click="open = !open"
                                                                        class="text-gray-500 hover:text-gray-700">
                                                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                                                    </button>

                                                                    <!-- Dropdown de Ações -->
                                                                    <div x-show="open" @click.away="open = false"
                                                                        class="absolute right-0 mt-2 w-40 bg-white border rounded-lg shadow-lg p-2 z-10"
                                                                        x-transition>
                                                                        <ul class="space-y-1">
                                                                            <li>
                                                                                <button
                                                                                    @click="selectedModuleId = {{ ($module->id) }}; selectClassroom = {{ json_encode($classroom) }}; selectedParentUuid = '{{ $classroom->uuid }}';editClassroom = true"
                                                                                    class="w-full text-left px-4 py-2 rounded hover:bg-blue-500 hover:text-white">
                                                                                    Editar Aula
                                                                                </button>
                                                                            </li>
                                                                            <li>
                                                                                <button
                                                                                    @click="selectedItem = {{ json_encode($classroom) }}; selectedType = 'aula'; openDelete = true"
                                                                                    class="w-full text-left px-4 py-2 rounded hover:bg-red-500 hover:text-white">
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
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

          <template x-if="openEdit">
            <div class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 p-1">
                <div class="bg-white p-6 rounded-lg relative w-full max-w-md max-h-full">
                    <button @click="openEdit = false" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                    <h2 class="text-xl mb-4">Editar Curso</h2>
                    <form method="POST" :action="`/painel-professor/curso/${selectedCourse.uuid}`" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium">Título</label>
                            <input type="text" name="title" x-model="selectedCourse.title"
                                class="w-full border border-gray-300 p-2 rounded">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium">Descrição</label>
                            <textarea name="description" x-model="selectedCourse.description" class="w-full border border-gray-300 p-2 rounded"></textarea>
                        </div>

                        <div class="mb-4 relative">
                            <label class="block text-gray-700 font-medium">Imagem de capa</label>
                            <label for="dropzone-file"
                                class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                <div class="flex flex-col items-center justify-center p-4">
                                    <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Clique para o
                                            upload</span></p>
                                    <p class="text-xs text-gray-500">SVG, PNG, JPG or GIF</p>
                                </div>
                                <input id="dropzone-file" type="file" class="hidden" name="image"
                                    accept="image/*" onchange="previewImage(event)" />

                                <!-- Pré-visualização da imagem dentro da área de dropzone -->
                                <div id="image-preview-container"
                                    class="absolute inset-0 flex items-center justify-center hidden h-100 pt-5">
                                    <img id="image-preview" class="w-full h-full object-contain rounded-lg pt-1"
                                        alt="Pré-visualização da Imagem" />
                                </div>

                                <div id="image-from-db" x-show="selectedCourse.image"
                                    class="absolute inset-0 flex items-center justify-center pt-6">
                                    <img x-bind:src="'/storage/' + selectedCourse.image"
                                        class="w-full h-full object-contain rounded-lg" alt="Imagem do Curso">
                                </div>
                            </label>
                        </div>

                        <div class="flex justify-end">
                            <button type="button" @click="openEdit = false"
                                class="bg-gray-500 text-white px-4 py-2 rounded mr-2 font-medium">Fechar</button>

                            <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded font-medium">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

        <template x-if="openModule">
            <div class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 p-1">
                <div class="bg-white p-6 rounded-lg relative w-full max-w-md max-h-full">
                    <button @click="openModule = false"
                        class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                        <i class="fa-solid fa-xmark"></i>
                    </button>

                    <!-- Formulário de Criação do Módulo -->
                    <form method="POST" :action="`/painel-professor/modulo/${selectedParentUuid}`">
                        @csrf
                        <!-- Ou PUT, dependendo da sua necessidade -->

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Título</label>
                            <input type="text" id="title" name="title"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                >
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
                            <textarea id="description" name="description" rows="4"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                ></textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="button" @click="openModule = false"
                                class="bg-gray-500 text-white px-4 py-2 rounded mr-2 font-medium">Cancelar</button>
                            <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded font-medium">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

        <template x-if="editModule">
            <div class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 p-1">
                <div class="bg-white p-6 rounded-lg relative w-full max-w-md max-h-full">
                    <button @click="editModule = false"
                        class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                        <i class="fa-solid fa-xmark"></i>
                    </button>

                    <!-- Formulário de Edição do Módulo -->
                    <form method="POST" :action="`/painel-professor/modulo/${selectedModule.uuid}`">
                        @csrf
                        @method('PUT') <!-- Usando PUT para editar -->
                        
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Título</label>
                            <input type="text" id="title" name="title" x-model="selectedModule.title"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                >
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
                            <textarea id="description" name="description" x-model="selectedModule.description" rows="4"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                ></textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="button" @click="editModule = false"
                                class="bg-gray-500 text-white px-4 py-2 rounded mr-2 font-medium">Cancelar</button>
                            <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded font-medium">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

        <template x-if="openClassroom">
            <div class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 p-1">
                <div class="bg-white p-6 rounded-lg relative w-full max-w-md max-h-full">
                    <button @click="openClassroom = false"
                        class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                        <i class="fa-solid fa-xmark"></i>
                    </button>

                    <!-- Formulário de Criação de Aula -->
                    <form method="POST" action="{{ route('classroom.store') }}">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Nome da Aula</label>
                            <input type="text" id="title" name="title"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                >
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
                            <textarea id="description" name="description" rows="4"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                ></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="video" class="block text-sm font-medium text-gray-700">URL do
                                Vídeo</label>
                            <input type="url" id="video" name="video"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                >
                        </div>

                        <div class="mb-4">
                            <label for="module_id" class="block text-sm font-medium text-gray-700">Selecionar
                                Módulo</label>
                            <select id="module_id" name="module_id"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                >

                                <option disabled selected>Selecione o Módulo</option>
                                @foreach ($course->modules as $module)
                                    <option value="{{ $module->id }}"> {{ $module->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex justify-end">
                            <button type="button" @click="openClassroom = false"
                                class="bg-gray-500 text-white px-4 py-2 rounded mr-2 font-medium">Cancelar</button>
                            <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded font-medium">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
        
        <template x-if="editClassroom">
            <div class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 p-1">
                <div class="bg-white p-6 rounded-lg relative w-full max-w-md max-h-full">
                    <button @click="editClassroom = false"
                        class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                    <!-- Formulário de Criação de Aula -->
                    <form method="POST" :action="`/painel-professor/aula/${selectClassroom.uuid}/editar`">
                        @csrf
                        @method('PUT') <!-- Usando PUT para editar -->
                        
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Nome da Aula</label>
                            <input type="text" id="title" name="title"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                  x-model="selectClassroom.title">
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Descrição</label>
                            <textarea id="description" name="description" rows="4"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                 x-model="selectClassroom.description"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="video" class="block text-sm font-medium text-gray-700">URL do
                                Vídeo</label>
                            <input type="url" id="video" name="video"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                  x-model="selectClassroom.video">
                        </div>

                        <div class="mb-4">
                            <label for="module_id" class="block text-sm font-medium text-gray-700">Selecionar
                                Módulo</label>
                            <select id="module_id" name="module_id" x-model="selectedModuleId"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                >
                                <option value="" disabled selected>Selecione o Módulo</option>
                                @foreach ($course->modules as $module)
                                    <option value="{{ $module->id }}"
                                        :selected="selectedModuleId === {{ $module->id }}">{{ $module->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex justify-end">
                            <button type="button" @click="editClassroom = false"
                                class="bg-gray-500 text-white px-4 py-2 rounded mr-2 font-medium">Cancelar</button>
                            <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 rounded font-medium">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

        <template x-if="openDelete">
            <div class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 p-1">
                <div class="bg-white p-6 rounded-lg relative  w-full max-w-md max-h-full">
                    <button @click="openDelete = false"
                        class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                    <h2 class="text-xl mb-4">Confirmar Exclusão</h2>
                    {{-- <p class="mb-4">Tem certeza de que deseja excluir o curso <strong
                            x-text="selectedCourse.title"></strong>?</p> --}}
                    <div class="flex justify-end">
                        <button type="button" @click="openDelete = false"
                            class="bg-gray-500 text-white px-4 py-2 rounded mr-2 font-medium">Cancelar</button>
                        <form method="POST" :action="`/painel-professor/${selectedType}/${selectedItem?.uuid}`">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-500 text-white px-4 py-2 rounded font-medium">Excluir</button>
                        </form>
                    </div>
                </div>
            </div>
        </template>
    </div>
</x-app-layout>

<script>
    function previewImage(event) {
        const file = event.target.files[0]; // Obter o arquivo selecionado
        const reader = new FileReader();

        const previewImage = document.getElementById('image-preview');
        const previewContainer = document.getElementById('image-preview-container');
        const imageFromDb = document.getElementById('image-from-db');

        if (imageFromDb) {
            imageFromDb.remove();
        }

        reader.onload = function(e) {
            // Definir a imagem como pré-visualização
            previewImage.src = e.target.result;

            // Mostrar a imagem dentro da área de dropzone
            previewContainer.classList.remove('hidden');
        };

        reader.readAsDataURL(file); // Ler a imagem como URL base64
    }

    document.addEventListener('DOMContentLoaded', function() {
        const previewImage = document.getElementById('image-preview');
        const previewContainer = document.getElementById('image-preview-container');
        const imageFromDb = document.getElementById('image-from-db');

        if (imageFromDb) {
            // Garantir que a imagem do banco seja visível quando o modal for aberto
            previewContainer.classList.add('hidden');
            imageFromDb.style.display = 'block';
        }
    });

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
