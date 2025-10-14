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
                            @foreach ($questions as $key => $question)
                                <div class="">
                                    <h1 class="text-start font-bold">{{ $key + 1 }}. {{ $question['text'] }}</h1>

                                    @foreach ($question['options'] as $option)
                                        <div class="flex flex-col md:flex-row gap-2 mt-2">
                                            <input type="number" class="flex border-0 border-b-2 border-black focus:ring-0 focus:border-black focus:outline-none" name="{{ $option['id'] }}" id="{{ $option['id'] }}" data-channel={{ $option['channel'] }} min="1" max="4">
                                            <label for="{{ $option['id'] }}" class="flex flex-1 text-gray-700 items-end">{{ $option['text'] }} ({{ $option['channel'] }})</label>
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
          const inputs = document.querySelectorAll('input[type="number"][id^="Q"]');
        
          inputs.forEach(input => {
            input.addEventListener('input', () => {
              const value = parseInt(input.value);
              const questionId = input.id.split('_')[0]; // Ex: "Q1_V" -> pega "Q1"
        
              // Filtra todos os inputs da mesma pergunta
              const sameQuestionInputs = Array.from(inputs).filter(i => i.id.startsWith(questionId));
        
              // 1️⃣ Garante que o valor está entre 1 e 4
              if (value < 1 || value > 4 || isNaN(value)) {
                input.value = '';
                return;
              }
        
              // 2️⃣ Impede valores repetidos dentro da mesma pergunta
              sameQuestionInputs.forEach(other => {
                if (other !== input && other.value === input.value) {
                  input.value = '';
                  input.classList.add('border-b-red-500');
                  setTimeout(() => input.classList.remove('border-b-red-500'), 1000);
                }
              });
            });
          });
        });
        </script>
        
</x-app-layout>
