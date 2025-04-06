<x-app-layout :title="'Gerenciar Aulas'">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Aulas') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{
        openCreate: false, 
        openEdit: false, 
        openDelete: false, 
        selectedClassroom: null,
        selectedCourseId: null,
        modules: @json($modules),
        filteredModules() {
            return this.modules.filter(module => module.course_id == this.selectedCourseId);
        }
    }">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if (session('success'))
                    <div class="bg-green-500 text-white p-4 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-500 text-white p-4 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <button @click="openCreate = true" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">Cadastrar Aula</button>
                
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-white">
                        <tr>
                            <th class="py-2 px-4 border-b text-center">#</th>
                            <th class="py-2 px-4 border-b text-center">Módulo</th>
                            <th class="py-2 px-4 border-b text-center">Título</th>
                            <th class="py-2 px-4 border-b text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($classrooms as $index => $classroom)
                            <tr class="{{ $loop->even ? 'bg-gray-50' : '' }}">
                                <td class="py-2 px-4 border-b text-center">{{ $index + 1 }}</td>
                                <td class="py-2 px-4 border-b">{{ $classroom->module->title }}</td>
                                <td class="py-2 px-4 border-b">{{ $classroom->title }}</td>
                                <td class="py-2 px-4 border-b text-center">
                                    <button @click="selectedClassroom = {{ $classroom }}; openEdit = true" class="bg-yellow-500 text-white px-4 py-2 rounded">Editar</button>
                                    <button @click="selectedClassroom = {{ $classroom }}; openDelete = true" class="bg-red-500 text-white px-4 py-2 rounded">Excluir</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal de Cadastro -->
        <template x-if="openCreate">
            <div class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 p-1">
                <div class="bg-white p-6 rounded-lg w-full max-w-md max-h-full">
                    <h2 class="text-xl mb-4">Cadastrar Aula</h2>
                    <form method="POST" action="{{ route('classroom.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700">Curso</label>
                            <select name="course_id" x-model="selectedCourseId" class="w-full border border-gray-300 p-2 rounded">
                                <option value="">Selecione um curso</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4" x-show="selectedCourseId">
                            <label class="block text-gray-700">Módulo</label>
                            <select name="module_id" class="w-full border border-gray-300 p-2 rounded">
                                <template x-for="module in filteredModules()" :key="module.id">
                                    <option :value="module.id" x-text="module.title"></option>
                                </template>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Título</label>
                            <input type="text" name="title" class="w-full border border-gray-300 p-2 rounded">
                        </div>
                        <div class="flex justify-end">
                            <button type="button" @click="openCreate = false" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Fechar</button>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

        <!-- Modal de Edição -->
        <template x-if="openEdit">
            <div class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 p-1">
                <div class="bg-white p-6 rounded-lg relative w-full max-w-md max-h-full">
                    <button @click="openEdit = false" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                        &times;
                    </button>
                    <h2 class="text-xl mb-4">Editar Aula</h2>
                    <form method="POST" :action="`/aula/${selectedClassroom.id}`">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-gray-700">Título</label>
                            <input type="text" name="title" x-model="selectedClassroom.title" class="w-full border border-gray-300 p-2 rounded">
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Módulo</label>
                            <select name="module_id" class="w-full border border-gray-300 p-2 rounded">
                                <template x-for="module in filteredModules()" :key="module.id">
                                    <option :value="module.id" x-text="module.title"></option>
                                </template>
                            </select>
                        </div>
                        <div class="flex justify-end">
                            <button type="button" @click="openEdit = false" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Fechar</button>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

        <!-- Modal de Exclusão -->
        <template x-if="openDelete">
            <div class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 p-1">
                <div class="bg-white p-6 rounded-lg relative w-full max-w-md max-h-full">
                    <button @click="openDelete = false" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                        &times;
                    </button>
                    <h2 class="text-xl mb-4">Confirmar Exclusão</h2>
                    <p class="mb-4">Tem certeza de que deseja excluir a aula <strong x-text="selectedClassroom.title"></strong>?</p>
                    <div class="flex justify-end">
                        <button type="button" @click="openDelete = false" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancelar</button>
                        <form method="POST" :action="`/aula/${selectedClassroom.id}`">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Excluir</button>
                        </form>
                    </div>
                </div>
            </div>
        </template>
    </div>
</x-app-layout>
