<x-app-layout :title="$title">
    <x-slot name="header">
        <x-page-title title="Cadastrar Aluno" />
    </x-slot>

    <div class="py-8">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
                <a href="{{ route('teacher.students') }}" class="hover:text-gray-300 transition">Alunos</a>
                <i class="fa-solid fa-chevron-right text-xs text-gray-700"></i>
                <span class="text-gray-300">Cadastrar Aluno</span>
            </div>

            <div class="bg-gray-900 rounded-2xl border border-gray-800 shadow-xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-800 flex items-center gap-3">
                    <div class="w-1 h-6 bg-blue-500 rounded-full"></div>
                    <h2 class="text-base font-semibold text-gray-100">Cadastrar Novo Aluno</h2>
                </div>

                @if ($errors->any())
                    <div class="px-6 pt-6">
                        <x-alert-component type="error">
                            <ul class="mb-0 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </x-alert-component>
                    </div>
                @endif

                <form method="POST" action="{{ route('teacher.students.store') }}" class="p-6 space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Nome <span class="text-red-400">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                class="block w-full bg-gray-800 text-gray-100 border border-gray-700 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">E-mail <span class="text-red-400">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="block w-full bg-gray-800 text-gray-100 border border-gray-700 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">CPF <span class="text-red-400">*</span></label>
                            <input type="text" name="cpf" value="{{ old('cpf') }}" required
                                class="block w-full bg-gray-800 text-gray-100 border border-gray-700 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Telefone</label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                class="block w-full bg-gray-800 text-gray-100 border border-gray-700 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Senha <span class="text-red-400">*</span></label>
                            <input type="password" name="password" required
                                class="block w-full bg-gray-800 text-gray-100 border border-gray-700 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Confirmar Senha <span class="text-red-400">*</span></label>
                            <input type="password" name="password_confirmation" required
                                class="block w-full bg-gray-800 text-gray-100 border border-gray-700 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-5 border-t border-gray-800 mt-2">
                        <a href="{{ route('teacher.students') }}"
                            class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-400 hover:text-gray-200 border border-gray-700 rounded-lg hover:border-gray-500 transition">
                            <i class="fa-solid fa-arrow-left text-xs"></i>
                            Cancelar
                        </a>
                        <button type="submit"
                            class="flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium rounded-lg transition">
                            <i class="fa-solid fa-floppy-disk"></i>
                            Salvar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const cpfInput = document.querySelector('input[name="cpf"]');
        const phoneInput = document.querySelector('input[name="phone"]');

        if (cpfInput) {
            cpfInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 11) value = value.slice(0, 11);
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})\.(\d{3})(\d)/, '$1.$2.$3');
                value = value.replace(/(\d{3})\.(\d{3})\.(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
                e.target.value = value;
            });
        }

        if (phoneInput) {
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 11) value = value.slice(0, 11);
                if (value.length > 10) {
                    value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
                } else if (value.length >= 2 && value.length <= 10) {
                    value = value.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
                }
                e.target.value = value;
            });
        }
    </script>
</x-app-layout>
