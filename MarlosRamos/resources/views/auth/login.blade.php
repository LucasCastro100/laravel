<x-guest-layout>
    <x-auth-session-status class="mb-5" :status="session('status')" />

    <div class="mb-6">
        <h1 class="text-xl font-semibold text-white">Bem-vindo de volta</h1>
        <p class="text-sm text-gray-400 mt-1">Acesse sua conta para continuar</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        {{-- E-mail --}}
        <div>
            <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1.5">E-mail</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-3.5 flex items-center pointer-events-none">
                    <i class="fa-regular fa-envelope text-gray-500 text-sm"></i>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    placeholder="seu@email.com"
                    class="block w-full bg-white/5 border border-white/10 text-white placeholder-gray-600 rounded-xl pl-10 pr-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500/40 transition">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
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

        {{-- Submit --}}
        <div class="pt-2">
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-500 text-white font-semibold py-3 rounded-xl shadow-lg shadow-blue-900/30 transition text-sm tracking-wide">
                Entrar
            </button>
        </div>

        {{-- Links --}}
        @if (Route::has('password.request'))
            <div class="flex flex-col items-center gap-2 pt-2">
                <a href="{{ route('password.request') }}"
                    class="text-sm text-gray-400 hover:text-gray-200 transition">
                    Esqueceu a senha?
                </a>
                <a href="{{ route('register') }}"
                    class="text-sm text-blue-400 hover:text-blue-300 transition font-medium">
                    Não tem conta? Cadastre-se
                </a>
            </div>
        @endif
    </form>
</x-guest-layout>
