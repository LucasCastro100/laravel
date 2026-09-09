<x-app-layout :title="$title">
    <x-slot name="header">
        <x-page-title title="Gerenciamento dos Cursos" />
    </x-slot>

    <div class="py-8">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-900 rounded-2xl border border-gray-800 shadow-xl p-6">

                <div class="flex items-center justify-between mb-6">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Total</p>
                        <p class="text-2xl font-bold text-gray-100">{{ $courses->count() }} <span class="text-sm font-normal text-gray-400">cursos</span></p>
                    </div>
                    <a href="{{ route('course.create') }}"
                        class="flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium rounded-lg transition">
                        <i class="fa-solid fa-plus"></i>
                        Novo Curso
                    </a>
                </div>

                @if ($courses->isEmpty())
                    <x-empty-state title="Nenhum curso cadastrado." message="Cadastre o primeiro curso para começar a organizar o painel." />
                @else
                    <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($courses as $course)
                            <x-course-card
                                title="{{ $course->title }}"
                                description="{{ $course->description }}"
                                image="{{ asset('storage/' . $course->image_cover) }}"
                                count="{{ $course->users_count }}"
                                href="/curso/{{ $course->uuid }}"
                            >
                                <a href="{{ route('course.edit', $course->uuid) }}"
                                    @click.stop
                                    class="px-3 py-1.5 text-xs text-gray-100 bg-gray-700/60 hover:bg-blue-600 border border-gray-600 rounded-lg transition flex items-center gap-1.5">
                                    <i class="fa-solid fa-pen text-xs"></i> Editar
                                </a>
                                <form method="POST"
                                    action="{{ route('course.destroy', $course->uuid) }}"
                                    @click.stop
                                    onsubmit="return confirm('Tem certeza que deseja excluir o curso \'{{ addslashes($course->title) }}\'? Esta ação não pode ser desfeita.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1.5 text-xs text-red-400 bg-red-500/10 hover:bg-red-500 hover:text-white border border-red-500/30 rounded-lg transition flex items-center gap-1.5">
                                        <i class="fa-solid fa-trash text-xs"></i> Excluir
                                    </button>
                                </form>
                            </x-course-card>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>


