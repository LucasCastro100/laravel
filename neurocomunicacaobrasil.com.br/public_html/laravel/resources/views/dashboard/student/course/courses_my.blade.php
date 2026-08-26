<x-app-layout :title="$title">
    <x-slot name="header">
        <x-page-title title="Meus Cursos" />
    </x-slot>

    <div class="py-8">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-900 rounded-2xl border border-gray-800 shadow-xl p-6">

                @if ($courses->isEmpty())
                    <x-empty-state title="Nenhum curso ainda." message="Você ainda não está matriculado em nenhum curso." />
                @else
                    <div class="grid sm:grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach ($courses as $course)
                            <x-course-card
                                title="{{ $course->title }}"
                                description="{{ $course->description }}"
                                image="{{ Storage::url($course->image_cover) }}"
                            >
                                <x-action-button href="{{ route('student.courseShow', ['uuid' => $course->uuid]) }}" variant="primary">Acessar</x-action-button>
                            </x-course-card>
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
