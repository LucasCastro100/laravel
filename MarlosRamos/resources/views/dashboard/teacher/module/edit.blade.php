<x-app-layout :title="$title">
    <x-slot name="header">
        <x-page-title title="Editar Módulo" />
    </x-slot>

    <div class="py-8">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 max-w-2xl">

            <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
                <a href="{{ route('course.index') }}" class="hover:text-gray-300 transition">Cursos</a>
                <i class="fa-solid fa-chevron-right text-xs text-gray-700"></i>
                <a href="{{ route('course.show', $module->course->uuid) }}" class="hover:text-gray-300 transition">{{ $module->course->title }}</a>
                <i class="fa-solid fa-chevron-right text-xs text-gray-700"></i>
                <span class="text-gray-300">Editar Módulo</span>
            </div>

            <div class="bg-gray-900 rounded-2xl border border-gray-800 shadow-xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-800 flex items-center gap-3">
                    <div class="w-1 h-6 bg-yellow-500 rounded-full"></div>
                    <h2 class="text-base font-semibold text-gray-100">Editar Módulo</h2>
                    <span class="ml-auto text-xs text-gray-500 bg-gray-800 px-2.5 py-1 rounded-full">{{ $module->course->title }}</span>
                </div>

                @if ($errors->any())
                    <div class="px-6 pt-6">
                        <x-alert-component type="error">
                            <ul class="mb-0 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </x-alert-component>
                    </div>
                @endif

                <form method="POST" action="{{ route('module.update', $module->uuid) }}" class="p-6 space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1.5">Título <span class="text-red-400">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $module->title) }}" required
                            class="block w-full bg-gray-800 text-gray-100 border border-gray-700 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1.5">Descrição</label>
                        <textarea name="description" rows="5"
                            class="block w-full bg-white text-gray-900 border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none">{{ old('description', $module->description) }}</textarea>
                    </div>

                    <div class="flex items-center justify-between pt-5 border-t border-gray-800 mt-2">
                        <a href="{{ route('course.show', $module->course->uuid) }}"
                            class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-400 hover:text-gray-200 border border-gray-700 rounded-lg hover:border-gray-500 transition">
                            <i class="fa-solid fa-arrow-left text-xs"></i>
                            Cancelar
                        </a>
                        <button type="submit"
                            class="flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium rounded-lg transition">
                            <i class="fa-solid fa-floppy-disk"></i>
                            Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>


