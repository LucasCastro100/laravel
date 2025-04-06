<x-app-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cursos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <h1 class="text-2xl font-bold">Cursos Disponíveis</h1>
                <button @click="mostrarMeusCursos = !mostrarMeusCursos" class="bg-blue-500 text-white px-4 py-2 rounded mt-2">
                    <span x-text="mostrarMeusCursos ? 'Mostrar Todos os Cursos' : 'Mostrar Meus Cursos'"></span>
                </button>
                
                <ul>
                    @foreach($cursos as $curso)
                        <li x-show="!mostrarMeusCursos || {{ auth()->user()->cursos->contains($curso) ? 'true' : 'false' }}">
                            <a href="{{ route('curso.show', $curso->id) }}" class="text-blue-500">{{ $curso->titulo }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>