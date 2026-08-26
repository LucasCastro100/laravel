<x-web-layout :title="$title">
    <div class="py-12 bg-gray-950">
        <div class="mx-auto sm:px-6 lg:px-8 max-w-4xl">
            <div class="bg-gray-900 overflow-hidden shadow-xl sm:rounded-2xl p-8 border border-gray-800">
                <div class="flex flex-col gap-8 text-gray-200">
                    <div class="space-y-3 text-center">
                        <h1 class="font-bold text-3xl md:text-4xl text-white">Teste do Sistema Representacional</h1>
                        <p class="text-gray-400 text-sm">Ned Herrmann</p>
                    </div>

                    <div class="bg-gray-800/50 rounded-xl p-5 border border-gray-700/50">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Como responder</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 text-sm">
                            <div class="flex items-center gap-2 text-gray-300">
                                <span class="w-7 h-7 flex items-center justify-center rounded-lg bg-blue-600 text-white font-bold text-xs">4</span>
                                <span>Que melhor descreve você</span>
                            </div>
                            <div class="flex items-center gap-2 text-gray-300">
                                <span class="w-7 h-7 flex items-center justify-center rounded-lg bg-blue-500 text-white font-bold text-xs">3</span>
                                <span>Próxima melhor descrição</span>
                            </div>
                            <div class="flex items-center gap-2 text-gray-300">
                                <span class="w-7 h-7 flex items-center justify-center rounded-lg bg-blue-400 text-white font-bold text-xs">2</span>
                                <span>Próxima melhor</span>
                            </div>
                            <div class="flex items-center gap-2 text-gray-300">
                                <span class="w-7 h-7 flex items-center justify-center rounded-lg bg-gray-600 text-white font-bold text-xs">1</span>
                                <span>Que menos descreve você</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <form class="flex flex-col gap-4" action="{{ route('teste.representacional.store') }}"
                            method="POST">
                            @csrf

                            <div class="flex flex-col md:flex-row gap-4">
                                <div class="flex-1 flex flex-col gap-2">
                                    <label for="name" class="text-gray-300 text-sm font-medium">Nome</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                        class="rounded-lg border-gray-700 bg-gray-800 text-white focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                                    @error('name')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="flex-1 flex flex-col gap-2">
                                    <label for="email" class="text-gray-300 text-sm font-medium">E-mail</label>
                                    <input type="text" name="email" id="email" value="{{ old('email') }}"
                                        class="rounded-lg border-gray-700 bg-gray-800 text-white focus:border-blue-500 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                                    @error('email')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="flex-1 flex flex-col gap-2">
                                    <label for="phone" class="text-gray-300 text-sm font-medium">Telefone</label>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                        class="rounded-lg border-gray-700 bg-gray-800 text-white focus:border-blue-500 focus:ring-blue-500 @error('phone') border-red-500 @enderror">
                                    @error('phone')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <hr class="border-gray-700/50" />

                            @if (session('error'))
                                <div class="text-sm text-red-400 bg-red-900/20 p-3 rounded-lg border border-red-800/50" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @foreach ($questions as $key => $question)
                                <div class="py-3">
                                    <h2 class="text-start font-bold text-white text-sm">{{ $key + 1 }}. {{ $question['text'] }}</h2>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2 mt-3">
                                        @foreach ($question['options'] as $option)
                                            <div class="flex items-center gap-3">
                                                <input type="number"
                                                    class="w-12 text-center border-0 border-b-2 border-gray-600 bg-transparent focus:ring-0 focus:border-blue-500 focus:outline-none text-white font-medium"
                                                    name="{{ $option['id'] }}" id="{{ $option['id'] }}"
                                                    data-channel="{{ $option['channel'] }}" min="1" max="4">
                                                <label for="{{ $option['id'] }}" class="flex-1 text-gray-400 text-sm">
                                                    {{ $option['text'] }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                @if (!$loop->last)
                                    <hr class="border-gray-700/50" />
                                @endif
                            @endforeach

                            <div class="text-end mt-6 pt-6 border-t border-gray-700/50">
                                <button type="submit"
                                    class="text-white font-semibold py-3 px-8 rounded-lg bg-blue-600 hover:bg-blue-500 transition-all shadow-lg shadow-blue-600/20 hover:shadow-blue-500/30">
                                    Enviar Respostas
                                </button>
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
