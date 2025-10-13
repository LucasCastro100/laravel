<x-app-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sistema Representacional') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex flex-col gap-8">
                    <div>
                        <h1 class="font-bold text-2xl md:text-4xl text-center">Teste do Sistema Representacional</h1>
                        <h3 class="font-bold text-center">Ned Hermman</h3>
                    </div>                    

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4">
                        <div class="col-span-1">4 = A que melhor descreve você</div>

                        <div class="col-span-1">3 = A próxima melhor descrição</div>

                        <div class="col-span-1">2 = A próxima melhor</div>

                        <div class="col-span-1">1 = A que menos descreve você</div>
                    </div>

                    <div class="">
                        <form class="flex flex-col gap-4" action="{{ route('student.saveTest') }}" method="POST">
                            @csrf
                            @foreach ($questions as $question)
                                <div class="">
                                    <h1 class="text-center font-bold">{{ $question['text'] }}</h1>

                                    @foreach ($question['options'] as $option)
                                        <div class="flex flex-col gap-2">
                                            <label for="">{{ $option['text'] }}</label>
                                        </div>
                                    @endforeach
                                </div>

                                <hr />
                            @endforeach

                            <div class="text-end">
                                <button type="submit"
                                    class="text-white font-bold py-2 px-4 rounded-md bg-blue-400 hover:bg-blue-800">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
