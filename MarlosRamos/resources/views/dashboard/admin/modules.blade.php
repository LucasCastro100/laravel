<x-app-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Módulos') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ openCreate: false, openEdit: false, openDelete: false, selectedModule: null }">
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

                <button @click="openCreate = true" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">Cadastrar Módulo</button>
                
                @if ($modules->isEmpty())
                    <div class="text-center text-gray-500">
                        Nenhum módulo cadastrado.
                    </div>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-white">
                            <tr>
                                <th class="py-2 px-4 border-b text-center">#</th>
                                <th class="py-2 px-4 border-b text-center">Curso</th>
                                <th class="py-2 px-4 border-b text-center">Título</th>
                                <th class="py-2 px-4 border-b text-center">Qtd. Aulas</th>
                                <th class="py-2 px-4 border-b text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($modules as $index => $module)
                                <tr class="{{ $loop->even ? 'bg-gray-50' : '' }}">
                                    <td class="py-2 px-4 border-b text-center">{{ $index + 1 }}</td>
                                    <td class="py-2 px-4 border-b">{{ $module->course->title }}</td>
                                    <td class="py-2 px-4 border-b">{{ $module->title }}</td>
                                    <td class="py-2 px-4 border-b text-center">{{ $module->classrooms->count() }}</td>
                                    <td class="py-2 px-4 border-b text-center">
                                        <button @click="selectedModule = {{ $module }}; openEdit = true" class="bg-yellow-500 text-white px-4 py-2 rounded">Editar</button>
                                        <button @click="selectedModule = {{ $module }}; openDelete = true" class="bg-red-500 text-white px-4 py-2 rounded">Excluir</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <template x-if="openCreate">
            <div class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 p-1">
                <div class="bg-white p-6 rounded-lg w-full max-w-md max-h-full">
                    <h2 class="text-xl mb-4">Cadastrar Módulo</h2>
                    <form method="POST" action="{{ route('module.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700">Curso</label>
                            <select name="course_id" class="w-full border border-gray-300 p-2 rounded">
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->title }}</option>
                                @endforeach
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

        <template x-if="openEdit">
            <div class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 p-1">
                <div class="bg-white p-6 rounded-lg w-full max-w-md max-h-full">
                    <h2 class="text-xl mb-4">Editar Módulo</h2>
                    <form method="POST" :action="`/module/${selectedModule.id}`">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-gray-700">Título</label>
                            <input type="text" name="title" x-model="selectedModule.title" class="w-full border border-gray-300 p-2 rounded">
                        </div>
                        <div class="flex justify-end">
                            <button type="button" @click="openEdit = false" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Fechar</button>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

        <template x-if="openDelete">
            <div class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 p-1">
                <div class="bg-white p-6 rounded-lg w-full max-w-md max-h-full">
                    <h2 class="text-xl mb-4">Confirmar Exclusão</h2>
                    <p class="mb-4">Tem certeza de que deseja excluir o módulo <strong x-text="selectedModule.title"></strong>?</p>
                    <div class="flex justify-end">
                        <button type="button" @click="openDelete = false" class="bg-gray-500 text-white px-4 py-2 rounded mr-2">Cancelar</button>
                        <form method="POST" :action="`/module/${selectedModule.id}`">
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
