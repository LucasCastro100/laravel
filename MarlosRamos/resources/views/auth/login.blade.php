<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('E-mail')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Senha')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-8 flex flex-col gap-4">

            <x-primary-button class="w-full justify-center">
                {{ __('Acessar') }}
            </x-primary-button>

            @if (Route::has('password.request'))
                <div class="flex flex-col items-center gap-2 mt-2">
                    <a class="underline text-sm text-gray-200 hover:text-gray-400 rounded-md" href="{{ route('password.request') }}">
                        {{ __('Esqueceu a senha?') }}
                    </a>

                    <a class="underline text-sm text-gray-200 hover:text-gray-400 rounded-md" href="{{ route('register') }}">
                        {{ __('Não possui conta?') }}
                    </a>
                </div>
            @endif
        </div>
    </form>
</x-guest-layout>
