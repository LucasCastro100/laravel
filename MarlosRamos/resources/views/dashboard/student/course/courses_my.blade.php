<x-app-layout :title="$title">
    <x-slot name="header">
        <x-page-title title="Meus cursos" />
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-200">
                @if (session('success'))
                    <x-alert-component type="success" :message="session('success')" />
                @endif

                @if (session('error'))
                    <x-alert-component type="error" :message="session('error')" />
                @endif

                @if ($courses->isEmpty())
                    <div class="text-center
                        text-gray-200">
                        Você não possui nenhum curso!
                    </div>
                @else
                    <div class="grid sm:grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach ($courses as $index => $course)
                            <x-course-card
                                title="{{ $course->title }}"
                                description="{{ $course->description }}"
                                image="{{ Storage::url($course->image_cover) }}"
                            >
                                <x-action-button href="{{ route('student.courseShow', ['uuid' => $course->uuid]) }}" variant="primary">Acessar</x-action-button>
                            </x-course-card>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
