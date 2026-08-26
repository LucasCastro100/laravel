<x-app-layout :title="$title">
    <x-slot name="header">
        <x-page-title title="Gerenciamento dos Cursos" />
    </x-slot>

    <div class="py-8">
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
                                image="{{ Storage::url($course->image_cover) }}"
                                count="{{ $course->users_count }}"
                                href="{{ route('course.show', ['uuid' => $course->uuid]) }}"
                            />
                        @endforeach
                    </div>

                    <div class="pt-6">
                        {{ $courses->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
