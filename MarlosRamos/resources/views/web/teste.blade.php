<x-web-layout :title="$title">
    <x-slot name="header">
        <x-page-title title="Sistema Representacional" />
    </x-slot>

    <div class="py-12 bg-gray-950">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-black overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-800">
                <div class="flex flex-col gap-8 text-gray-200">
                    <div class="space-y-2">
                        <x-application-logo class="w-1/2 md:w-44 fill-current mx-auto text-white" />
                        <h1 class="font-bold text-2xl md:text-4xl text-center text-white">Teste do Sistema Representacional</h1>
                        <h3 class="font-bold text-center text-gray-400">Ned Hermman</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 text-gray-400">
                        <div class="col-span-1">4 = A que melhor descreve você</div>
                        <div class="col-span-1">3 = A próxima melhor descrição</div>
                        <div class="col-span-1">2 = A próxima melhor</div>
                        <div class="col-span-1">1 = A que menos descreve você</div>
                    </div>

                    <div class="">
                        <form class="flex flex-col gap-4" action="{{ route('teste.representacional.store') }}"
                            method="POST">
                            @csrf

                            <div class="flex flex-col lg:flex-row gap-4">
                                {{-- Nome --}}
                                <div class="flex-1 flex flex-col gap-2">
                                    <label for="name" class="text-gray-300">Nome</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                        class="rounded-md border-gray-700 bg-gray-800 text-white focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror">

                                    @error('name')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- E-mail --}}
                                <div class="flex-1 flex flex-col gap-2">
                                    <label for="email" class="text-gray-300">E-mail</label>
                                    <input type="text" name="email" id="email" value="{{ old('email') }}"
                                        class="rounded-md border-gray-700 bg-gray-800 text-white focus:border-blue-500 focus:ring-blue-500 @error('email') border-red-500 @enderror">

                                    @error('email')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Telefone --}}
                                <div class="flex-1 flex flex-col gap-2">
                                    <label for="phone" class="text-gray-300">Telefone</label>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                        class="rounded-md border-gray-700 bg-gray-800 text-white focus:border-blue-500 focus:ring-blue-500 @error('phone') border-red-500 @enderror">

                                    @error('phone')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <hr class="border-gray-700" />

                            @if (session('error'))
                                <div class="text-sm text-red-500 bg-red-900/20 p-3 rounded-lg"
                                    role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @foreach ($questions as $key => $question)
                                <div class="py-2">
                                    <h1 class="text-start font-bold text-white">{{ $key + 1 }}. {{ $question['text'] }}</h1>

                                    @foreach ($question['options'] as $option)
                                        <div class="flex flex-col md:flex-row gap-2 mt-2">
                                            <input type="number"
                                                class="flex border-0 border-b-2 border-gray-600 bg-transparent focus:ring-0 focus:border-blue-500 focus:outline-none text-white"
                                                name="{{ $option['id'] }}" id="{{ $option['id'] }}"
                                                data-channel="{{ $option['channel'] }}" min="1" max="4">
                                            <label for="{{ $option['id'] }}"
                                                class="flex flex-1 text-gray-300 items-end">
                                                {{ $option['text'] }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                                <hr class="border-gray-700" />
                            @endforeach

                            <div class="text-end mt-4">
                                <button type="submit"
                                    class="text-white font-bold py-2 px-6 rounded-md bg-blue-600 hover:bg-blue-700 transition-colors">Salvar</button>
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
            const phoneInput = document.querySelectorAll('#phone');

            if (phoneInput.length > 0) {
                phoneInput.forEach(input => {
                    input.addEventListener('input', function(e) {
                        let value = e.target.value.replace(/\D/g, '');
                        if (value.length > 11) value = value.slice(0, 11);
                        if (value.length > 10) {
                            value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
                        } else if (value.length >= 2 && value.length <= 10) {
                            value = value.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
                        }
                        e.target.value = value;
                    });
                });
            }

            inputs.forEach(input => {
                input.addEventListener('input', () => {
                    const value = parseInt(input.value);
                    const questionId = input.id.split('_')[0];
                    const sameQuestionInputs = Array.from(inputs).filter(i => i.id.startsWith(questionId));

                    if (value < 1 || value > 4 || isNaN(value)) {
                        input.value = '';
                        return;
                    }

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
</x-web-layout>
