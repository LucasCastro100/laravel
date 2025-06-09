<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informações do perfil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Atualize as informações do perfil e o endereço de e-mail da sua conta.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6" x-data="{selectedUserImage: {{ json_encode(Auth::user()->image) }}}">            
            <div>
                <!-- Nome -->
                <div class="mb-4">
                    <x-input-label for="name" :value="__('Nome')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                        :value="old('name', $user->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('E-mail')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                        :value="old('email', $user->email)" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                        <div>
                            <p class="text-sm mt-2 text-gray-800">
                                {{ __('Seu endereço de e-mail não foi verificado.') }}
                                <button form="send-verification"
                                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{ __('Clique aqui para reenviar o e-mail de verificação.') }}
                                </button>
                            </p>
                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 font-medium text-sm text-green-600">
                                    {{ __('Um novo link de verificação foi enviado para seu endereço de e-mail.') }}
                                </p>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Telefone -->
                <div class="mb-4">
                    <x-input-label for="phone" :value="__('Telefone')" />
                    <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                        :value="old('phone', $user->phone)" required autofocus autocomplete="phone" />
                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                </div>

                <!-- CPF -->
                <div class="mb-4">
                    <x-input-label for="cpf" :value="__('CPF')" />
                    <x-text-input id="cpf" name="cpf" type="text" class="mt-1 block w-full"
                        :value="old('cpf', $user->cpf)" readonly autofocus autocomplete="cpf" />
                    <x-input-error class="mt-2" :messages="$errors->get('cpf')" />
                </div>
            </div>

            <!-- Dropzone -->
            <div class="relative mb-4">
                <label class="block text-gray-700 font-medium">Imagem de capa</label>
                <label for="dropzone-file"
                    class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 h-[calc(100%-1rem)]">
                    <div class="flex flex-col items-center justify-center p-4">
                        <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 20 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                        </svg>
                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Clique para o
                                upload</span></p>
                        <p class="text-xs text-gray-500">SVG, PNG, JPG or GIF</p>
                    </div>
                    <input id="dropzone-file" type="file" class="hidden" name="image" accept="image/*"
                        onchange="previewImage(event)" />

                    <!-- Preview da imagem -->
                    <div id="image-preview-container" class="absolute inset-0 flex items-center justify-center hidden h-100 pt-5">
                        <img id="image-preview" class="w-full h-full object-contain rounded-lg pt-1"
                            alt="Pré-visualização da Imagem" />
                    </div>

                    <div id="image-from-db" x-show="selectedUserImage"
                        class="absolute inset-0 flex items-center justify-center pt-6">
                        <img x-bind:src="'/storage/' + selectedUserImage"
                            class="w-full h-full object-contain rounded-lg" alt="Imagem do Curso">
                    </div>
                </label>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Salvar') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Salvo.') }}</p>
            @endif
        </div>
    </form>
</section>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        const previewImage = document.getElementById('image-preview');
        const previewContainer = document.getElementById('image-preview-container');
        const imageFromDb = document.getElementById('image-from-db');

        if (imageFromDb) {
            imageFromDb.classList.add('hidden');
        }

        if (!file) {
            previewContainer.classList.add('hidden');
            return;
        }

        reader.onload = function (e) {
            previewImage.src = e.target.result;
            previewContainer.classList.remove('hidden');
        };

        reader.readAsDataURL(file);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const previewContainer = document.getElementById('image-preview-container');
        const imageFromDb = document.getElementById('image-from-db');

        if (previewContainer) previewContainer.classList.add('hidden');
        if (imageFromDb) {
            const img = imageFromDb.querySelector('img');
            if (img && img.src && !img.src.includes('undefined') && !img.src.includes('null')) {
                imageFromDb.classList.remove('hidden');
            } else {
                imageFromDb.classList.add('hidden');
            }
        }

        // Aplica máscaras
        const phoneInput = document.getElementById('phone');
        const cpfInput = document.getElementById('cpf');

        if (phoneInput) {
            phoneInput.addEventListener('input', function (e) {
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
        }

        if (cpfInput) {
            cpfInput.addEventListener('input', function (e) {
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
