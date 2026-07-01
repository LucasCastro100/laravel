<x-app-layout :title="$title">
    <x-slot name="header">
        <x-page-title title="Editar Usuário" />
    </x-slot>

    <div class="py-12">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if ($errors->any())
                    <x-alert-component type="error">
                        <ul class="mb-0 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </x-alert-component>
                @endif

                <form method="POST" action="{{ route('admin.users.update', $user->uuid) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-200">Nome</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                class="appearance-none mt-1 block w-full pl-3 pr-10 py-2 bg-white text-gray-900 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-200">E-mail</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                class="appearance-none mt-1 block w-full pl-3 pr-10 py-2 bg-white text-gray-900 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-200">CPF</label>
                            <input type="text" name="cpf" value="{{ old('cpf', $user->cpf) }}" required
                                class="appearance-none mt-1 block w-full pl-3 pr-10 py-2 bg-white text-gray-900 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-200">Telefone</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                class="appearance-none mt-1 block w-full pl-3 pr-10 py-2 bg-white text-gray-900 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-200">Tipo de Usuário</label>
                            <div class="relative mt-1">
                                <select name="role_id" required id="roleSelect"
                                    class="appearance-none block w-full pl-3 pr-10 py-2 bg-white text-gray-900 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                        </div>

                        <div id="specialtyField" class="{{ $user->role_id == 2 ? '' : 'hidden' }}">
                            <label class="block text-sm font-medium text-gray-200">Especialidade</label>
                            <input type="text" name="specialty" value="{{ old('specialty', $user->teacher->specialty ?? '') }}"
                                class="appearance-none mt-1 block w-full pl-3 pr-10 py-2 bg-white text-gray-900 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-200">Nova Senha (deixe em branco para manter)</label>
                            <input type="password" name="password"
                                class="appearance-none mt-1 block w-full pl-3 pr-10 py-2 bg-white text-gray-900 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-200">Confirmar Nova Senha</label>
                            <input type="password" name="password_confirmation"
                                class="appearance-none mt-1 block w-full pl-3 pr-10 py-2 bg-white text-gray-900 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <a href="{{ route('admin.users') }}"
                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Cancelar</a>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('roleSelect').addEventListener('change', function() {
            const specialtyField = document.getElementById('specialtyField');
            if (this.value === '2') {
                specialtyField.classList.remove('hidden');
            } else {
                specialtyField.classList.add('hidden');
            }
        });

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



