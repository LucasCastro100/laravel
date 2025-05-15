<x-app-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teste') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if (session('success'))
                    <x-alert-component type="success" :message="session('success')" />
                @endif

                @if (session('error'))
                    <x-alert-component type="error" :message="session('error')" />
                @endif

                @if ($tests->isEmpty())
                    <div class="text-center
                        text-gray-500">
                        Você não possui nenhum teste!
                    </div>
                @else
                    <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($tests as $index => $course)
                            <div class="bg-white shadow-lg rounded-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-2"
                                onclick="window.location.href = '{{ route('student.testhow', ['uuid' =>$test->uuid ]) }}'">
                                <img src="{{ Storage::url($course->image) }}" alt="Imagem do curso"
                                    class="w-full h-48 object-cover">

                                <div class="p-4">
                                    <h3 class="text-xl font-semibold text-gray-800">{{ $course->title }}</h3>
                                    <p class="text-gray-600 mt-2">{{ Str::limit($course->description, 100) }}</p>
                                </div>

                                <div class="py-4 text-right">
                                    <span
                                        class="cursor-pointer text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-green-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-800 dark:text-white dark:border-gray-600 dark:hover:bg-green-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                        onclick="window.location.href = '/curso/{{ $course->uuid }}'">Acessar</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
