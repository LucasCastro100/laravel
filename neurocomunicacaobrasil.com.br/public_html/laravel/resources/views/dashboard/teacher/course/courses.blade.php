<x-app-layout :title="$title">
    <x-slot name="header">
        <x-page-title title="Gerenciamento dos Cursos" />
    </x-slot>

    <div class="py-8" x-data="{ openDelete: false, deleteUrl: '', deleteTitle: '' }">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-900 rounded-2xl border border-gray-800 shadow-xl p-6">

                @if ($errors->any())
                    <x-alert-component type="error">
                        <ul class="mb-0 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </x-alert-component>
                @endif

                <div class="flex items-center justify-between mb-6">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Total</p>
                        <p class="text-2xl font-bold text-gray-100">{{ $courses->total() }}</p>
                    </div>
                    <a href="{{ route('course.create') }}"
                        class="flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium rounded-lg transition">
                        <i class="fa-solid fa-plus"></i>
                        Novo Curso
                    </a>
                </div>

                @if ($courses->isEmpty())
                    <x-empty-state title="Nenhum curso cadastrado." message="Crie o primeiro curso para começar a publicar aulas e materiais." />
                @else
                    <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach ($courses as $course)
                            <x-course-card
                                title="{{ $course->title }}"
                                description="{{ $course->description }}"
                                image="{{ asset('storage/' . $course->image_cover) }}"
                                count="{{ $course->users_count }}"
                                href="{{ route('course.show', ['uuid' => $course->uuid]) }}"
                            >
                                <a href="{{ route('course.edit', $course->uuid) }}"
                                    @click.stop
                                    class="px-3 py-1.5 text-xs text-gray-100 bg-gray-700/60 hover:bg-blue-600 border border-gray-600 rounded-lg transition flex items-center gap-1.5">
                                    <i class="fa-solid fa-pen text-xs"></i> Editar
                                </a>
                                <button
                                    @click.stop="openDelete = true; deleteUrl = '{{ route('course.destroy', $course->uuid) }}'; deleteTitle = {{ json_encode($course->title) }}"
                                    class="px-3 py-1.5 text-xs text-red-400 bg-red-500/10 hover:bg-red-500 hover:text-white border border-red-500/30 rounded-lg transition flex items-center gap-1.5">
                                    <i class="fa-solid fa-trash text-xs"></i> Excluir
                                </button>
                            </x-course-card>
                        @endforeach
                    </div>

                    <div class="pt-6">
                        {{ $courses->links() }}
                    </div>
                @endif
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
                            <h3 class="text-base font-semibold text-gray-100">Excluir Curso</h3>
                            <p class="text-sm text-gray-400 mt-1">
                                Tem certeza que deseja excluir <span class="text-gray-200 font-medium" x-text="deleteTitle"></span>?
                                Esta ação não pode ser desfeita.
                            </p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button @click="openDelete = false"
                            class="flex-1 py-2.5 px-4 border border-gray-700 text-gray-300 rounded-xl hover:bg-gray-800 transition text-sm font-medium">
                            Cancelar
                        </button>
                        <form method="POST" :action="deleteUrl" class="flex-1">
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