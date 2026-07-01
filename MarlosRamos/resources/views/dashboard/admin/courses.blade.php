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
                                image="{{ Storage::url($course->image_cover) }}"
                                count="{{ $course->users_count }}"
                                href="/curso/{{ $course->uuid }}"
                            />
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>


