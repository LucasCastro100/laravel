<x-app-layout title="Teste Representacional">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Curso') }}
        </h2>
    </x-slot>

    <div class="py-12">
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

                <div class="text-right">
                    <button class="bg-gray-500 text-white px-4 py-2 rounded mb-4"
                        @click="window.location.href='/cursos/'" id="btn-todos">Todos os CURSOS</button>

                    <button class="bg-gray-500
                        text-white px-4 py-2 rounded mb-4"
                        @click="window.location.href='/cursos?filter=joined'" id="btn-meus">Meus
                        CURSOS</button>
                </div>

                @if ($courses->isEmpty())
                    <div class="text-center
                        text-gray-500">
                        {{ $message }}
                    </div>
                @else
                    <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($courses as $index => $course)
                            <div class="bg-white shadow-lg rounded-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-2"
                                @click="window.location.href = '/curso/' + {{ json_encode($course->uuid) }}">
                                <img src="{{ Storage::url($course->image) }}" alt="Imagem do curso"
                                    class="w-full h-48 object-cover">
                                <div class="p-4">
                                    <h3 class="text-xl font-semibold text-gray-800">{{ $course->title }}</h3>
                                    <p class="text-gray-600 mt-2">{{ Str::limit($course->description, 100) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const path = window.location.pathname;
        const search = window.location.search;

        const btnTodos = document.getElementById('btn-todos');
        const btnMeus = document.getElementById('btn-meus');

        if (search.includes('filter=joined')) {
            btnMeus.classList.add('bg-blue-600');
            btnMeus.classList.remove('bg-gray-500');

            btnTodos.classList.add('bg-gray-500');
            btnTodos.classList.remove('bg-blue-600');
        } else {
            btnTodos.classList.add('bg-blue-600');
            btnTodos.classList.remove('bg-gray-500');

            btnMeus.classList.add('bg-gray-500');
            btnMeus.classList.remove('bg-blue-600');
        }
    });
</script>
