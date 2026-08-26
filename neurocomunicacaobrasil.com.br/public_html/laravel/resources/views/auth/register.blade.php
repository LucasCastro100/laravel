<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-xl font-semibold text-white">Criar conta</h1>
        <p class="text-sm text-gray-400 mt-1">Preencha os dados para se cadastrar</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-3">
        @csrf
        <input type="hidden" name="role_id" value="1">

        {{-- Nome --}}
        <div>
            <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1.5">Nome</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                    <i class="fa-regular fa-user text-gray-500 text-sm"></i>
                </div>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    placeholder="Seu nome completo"
                    class="block w-full bg-white/5 border border-white/10 text-white placeholder-gray-600 rounded-xl pl-10 pr-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500/40 transition">
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
        </div>

        {{-- E-mail --}}
        <div>
            <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1.5">E-mail</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                    <i class="fa-regular fa-envelope text-gray-500 text-sm"></i>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    placeholder="seu@email.com"
                    class="block w-full bg-white/5 border border-white/10 text-white placeholder-gray-600 rounded-xl pl-10 pr-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500/40 transition">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        {{-- Telefone + CPF --}}
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1.5">Telefone</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                        <i class="fa-solid fa-phone text-gray-500 text-sm"></i>
                    </div>
                    <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required
                        placeholder="(00) 00000-0000"
                        class="block w-full bg-white/5 border border-white/10 text-white placeholder-gray-600 rounded-xl pl-10 pr-3 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500/40 transition">
                </div>
                <x-input-error :messages="$errors->get('phone')" class="mt-1.5" />
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1.5">CPF</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                        <i class="fa-regular fa-id-card text-gray-500 text-sm"></i>
                    </div>
                    <input id="cpf" type="text" name="cpf" value="{{ old('cpf') }}" required
                        placeholder="000.000.000-00"
                        class="block w-full bg-white/5 border border-white/10 text-white placeholder-gray-600 rounded-xl pl-10 pr-3 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500/40 transition">
                </div>
                <x-input-error :messages="$errors->get('cpf')" class="mt-1.5" />
            </div>
        </div>

        {{-- Senha --}}
        <div>
            <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1.5">Senha</label>
            <div class="relative" x-data="{ show: false }">
                <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                    <i class="fa-solid fa-lock text-gray-500 text-sm"></i>
                </div>
                <input id="password" :type="show ? 'text' : 'password'" name="password" required
                    placeholder="••••••••"
                    class="block w-full bg-white/5 border border-white/10 text-white placeholder-gray-600 rounded-xl pl-10 pr-11 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500/40 transition">
                <button type="button" @click="show = !show"
                    class="absolute inset-y-0 right-3.5 flex items-center text-gray-500 hover:text-gray-300 transition">
                    <i x-show="!show" class="fa-regular fa-eye text-sm"></i>
                    <i x-show="show" class="fa-regular fa-eye-slash text-sm" x-cloak></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        {{-- Confirmar Senha --}}
        <div>
            <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1.5">Confirmar Senha</label>
            <div class="relative" x-data="{ show: false }">
                <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                    <i class="fa-solid fa-lock text-gray-500 text-sm"></i>
                </div>
                <input id="password_confirmation" :type="show ? 'text' : 'password'" name="password_confirmation" required
                    placeholder="••••••••"
                    class="block w-full bg-white/5 border border-white/10 text-white placeholder-gray-600 rounded-xl pl-10 pr-11 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500/40 transition">
                <button type="button" @click="show = !show"
                    class="absolute inset-y-0 right-3.5 flex items-center text-gray-500 hover:text-gray-300 transition">
                    <i x-show="!show" class="fa-regular fa-eye text-sm"></i>
                    <i x-show="show" class="fa-regular fa-eye-slash text-sm" x-cloak></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
        </div>

        {{-- Submit --}}
        <div class="pt-2">
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-500 text-white font-semibold py-3 rounded-xl shadow-lg shadow-blue-900/30 transition text-sm tracking-wide">
                Criar conta
            </button>
        </div>

        {{-- Link login --}}
        <div class="text-center pt-1">
            <a href="{{ route('login') }}"
                class="text-sm text-gray-400 hover:text-gray-200 transition">
                Já tem conta? <span class="text-blue-400 hover:text-blue-300 font-medium">Entrar</span>
            </a>
        </div>
    </form>
</x-guest-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const phoneInput = document.querySelector('#phone');
        const cpfInput = document.querySelector('#cpf');

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
    });
</script>
