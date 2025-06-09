<x-guest-layout>
    <div x-data="{ tab: 'student' }" class="max-w-xl mx-auto">
        <!-- Abas -->
        <div class="flex flex-col sm:flex-row flex-wrap border-b border-gray-200 mb-4">
            <button type="button" @click="tab = 'student'"
                :class="tab === 'student' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-600'"
                class="py-2 px-4 font-medium text-sm hover:text-gray-600 hover:border-b-2 hover:border-gray-300">
                Aluno
            </button>
            <button type="button" @click="tab = 'teacher'"
                :class="tab === 'teacher' ? 'border-b-2 border-indigo-600 text-indigo-600' : 'text-gray-600'"
                class="py-2 px-4 font-medium text-sm hover:text-gray-600 hover:border-b-2 hover:border-gray-300">
                Professor
            </button>
        </div>

        <!-- Formulário para aluno -->
        <form method="POST" action="{{ route('register') }}" x-show="tab === 'student'" x-cloak>
            @csrf
            <input type="hidden" name="role_id" value="1"> <!-- Aluno -->

            <div class="grid grid-cols-2 gap-4">
                <!-- Name -->
                <div class="col-span-2">
                    <x-input-label for="name" :value="__('Nome')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                        :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="col-span-2">
                    <x-input-label for="email" :value="__('E-mail')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                        :value="old('email')" required autocomplete="email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Telefone -->
                <div class="col-span-2 md:col-span-1">
                    <x-input-label for="phone" :value="__('Telefone')" />
                    <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone"
                        :value="old('phone')" required autocomplete="phone" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <!-- CPF -->
                <div class="col-span-2 md:col-span-1">
                    <x-input-label for="cpf" :value="__('CPF')" />
                    <x-text-input id="cpf" class="block mt-1 w-full" type="text" name="cpf"
                        :value="old('cpf')" required autocomplete="cpf" />
                    <x-input-error :messages="$errors->get('cpf')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="col-span-2">
                    <x-input-label for="password" :value="__('Senha')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="col-span-2">
                    <x-input-label for="password_confirmation" :value="__('Confirmar senha')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                        name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="col-span-2 flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        href="{{ route('login') }}">
                        {{ __('Já tem cadastro?') }}
                    </a>

                    <x-primary-button class="ms-4">
                        {{ __('Registrar como Aluno') }}
                    </x-primary-button>
                </div>
            </div>
        </form>


        <!-- Formulário para professor -->
        <form method="POST" action="{{ route('register') }}" x-show="tab === 'teacher'" x-cloak>
            @csrf
            <input type="hidden" name="role_id" value="2"> <!-- Professor -->

            <div class="grid grid-cols-2 gap-4">
                <!-- Name -->
                <div class="col-span-2">
                    <x-input-label for="name" :value="__('Nome')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                        :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="col-span-2">
                    <x-input-label for="email" :value="__('E-mail')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                        :value="old('email')" required autocomplete="email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Telefone -->
                <div class="col-span-2 md:col-span-1">
                    <x-input-label for="phone" :value="__('Telefone')" />
                    <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone"
                        :value="old('phone')" required autocomplete="phone" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <!-- CPF -->
                <div class="col-span-2 md:col-span-1">
                    <x-input-label for="cpf" :value="__('CPF')" />
                    <x-text-input id="cpf" class="block mt-1 w-full" type="text" name="cpf"
                        :value="old('cpf')" required autocomplete="cpf" />
                    <x-input-error :messages="$errors->get('cpf')" class="mt-2" />
                </div>

                <!-- CATEGORIA -->
                <div class="col-span-2">
                    <x-input-label for="specialty" :value="__('Categoria')" />
                    <x-text-input id="specialty" class="block mt-1 w-full" type="text" name="specialty"
                        :value="old('specialty')" required autocomplete="specialty" />
                    <x-input-error :messages="$errors->get('specialty')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="col-span-2">
                    <x-input-label for="password" :value="__('Senha')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="col-span-2">
                    <x-input-label for="password_confirmation" :value="__('Confirmar senha')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                        name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="col-span-2 flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        href="{{ route('login') }}">
                        {{ __('Já tem cadastro?') }}
                    </a>

                    <x-primary-button class="ms-4">
                        {{ __('Registrar como Professor') }}
                    </x-primary-button>
                </div>
            </div>
        </form>
    </div>
</x-guest-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const phoneInput = document.querySelectorAll('#phone');
        const cpfInput = document.querySelectorAll('#cpf');

        if (phoneInput.length > 0) {
            phoneInput.forEach(input => {
                input.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');

                    if (value.length > 11) value = value.slice(0, 11);

                    if (value.length > 10) {
                        // Celular: (99) 99999-9999
                        value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
                    } else if (value.length >= 2 && value.length <= 10) {
                        // Fixo: (99) 9999-9999
                        value = value.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
                    }

                    e.target.value = value;
                });
            });
        }

        if (cpfInput.length > 0) {
            cpfInput.forEach(input => {
                input.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');

                    if (value.length > 11) value = value.slice(0, 11);

                    value = value.replace(/(\d{3})(\d)/, '$1.$2');
                    value = value.replace(/(\d{3})\.(\d{3})(\d)/, '$1.$2.$3');
                    value = value.replace(/(\d{3})\.(\d{3})\.(\d{3})(\d{1,2})/, '$1.$2.$3-$4');

                    e.target.value = value;
                });
            });
        }
    });
</script>
