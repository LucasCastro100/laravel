<div>
    <div class="bg-gray-900 border border-gray-800 p-6 rounded-xl mb-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-gray-100">Clientes</h1>
            <button wire:click="openModal" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                + Novo Cliente
            </button>
        </div>
    </div>

        <div class="bg-gray-900 border border-gray-800 rounded-lg overflow-hidden">
            <table class="w-full text-sm text-left text-gray-400">
                <thead class="text-xs uppercase bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 ">Status</th>
                        <th class="px-6 py-3 ">Nome</th>
                        <th class="px-6 py-3 ">Email</th>
                        <th class="px-6 py-3 ">Telefone</th>
                        <th class="px-6 py-3 ">Documento</th>
                        <th class="px-6 py-3 ">Total Arrecadado</th>
                        <th class="px-6 py-3 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse ($clients as $client)
                        <tr class="hover:bg-gray-800/50 {{ !$client->active ? 'opacity-60' : '' }}">
                            <td class="px-6 py-4">
                                @if ($client->active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-900 text-green-300">
                                        Ativo
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-900 text-red-300">
                                        Inativo
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-white">{{ $client->name }}</td>
                            <td class="px-6 py-4">{{ $client->email ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $client->phone ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $client->document ?? '-' }}</td>
                            <td class="px-6 py-4 text-green-400 font-medium">
                                R$ {{ number_format($client->total_revenue ?? 0, 2, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button wire:click="edit({{ $client->id }})" class="p-1.5 text-blue-500 hover:text-blue-400 hover:bg-blue-500/10 rounded-lg transition" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @if ($client->active)
                                        <button wire:click="deactivate({{ $client->id }})" wire:confirm="Desativar {{ $client->name }}? As contas pendentes serão baixadas automaticamente." class="p-1.5 text-yellow-500 hover:text-yellow-400 hover:bg-yellow-500/10 rounded-lg transition" title="Desativar">
                                            <i class="fas fa-pause"></i>
                                        </button>
                                    @else
                                        <button wire:click="activate({{ $client->id }})" class="p-1.5 text-green-500 hover:text-green-400 hover:bg-green-500/10 rounded-lg transition" title="Ativar">
                                            <i class="fas fa-play"></i>
                                        </button>
                                    @endif
                                    <button wire:click="delete({{ $client->id }})" wire:confirm="Tem certeza?" class="p-1.5 text-red-500 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition" title="Excluir">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12  text-gray-500">Nenhum cliente cadastrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($showModal)
            <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
                <div class="bg-gray-900 border border-gray-800 rounded-lg p-6 w-full max-w-lg max-h-[90vh] overflow-y-auto">
                    <h3 class="text-lg font-semibold text-white mb-4">{{ $clientId ? 'Editar' : 'Novo' }} Cliente</h3>
                    <form wire:submit="save" class="space-y-4">
                        <div>
                            <label class="block text-sm text-gray-300 mb-1">Nome</label>
                            <input wire:model="name" class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-500">
                            @error('name') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm text-gray-300 mb-1">Email</label>
                            <input type="email" wire:model="email" class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-500">
                            @error('email') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-gray-300 mb-1">Telefone</label>
                                <input wire:model="phone" maxlength="15" placeholder="(99) 99999-9999"
                                    x-on:input="
                                        let val = $event.target.value.replace(/\D/g, '').substring(0, 11);
                                        val = val.replace(/^(\d{2})(\d)/, '($1) $2').replace(/(\d{5})(\d)/, '$1-$2');
                                        $event.target.value = val"
                                    class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-500">
                                @error('phone') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm text-gray-300 mb-1">Documento</label>
                                <input wire:model="document" maxlength="18" placeholder="CPF ou CNPJ"
                                    x-on:input="
                                        let val = $event.target.value.replace(/\D/g, '').substring(0, 14);
                                        if (val.length <= 11) {
                                            val = val.replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d)/, '$1.$2').replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                                        } else {
                                            val = val.replace(/^(\d{2})(\d)/, '$1.$2').replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3').replace(/\.(\d{3})(\d)/, '.$1/$2').replace(/(\d{4})(\d)/, '$1-$2');
                                        }
                                        $event.target.value = val"
                                    class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-500">
                                @error('document') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-300 mb-1">Endereço</label>
                            <textarea wire:model="address" rows="2" class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-500"></textarea>
                            @error('address') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm text-gray-300 mb-1">Observações</label>
                            <textarea wire:model="notes" rows="2" class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-500"></textarea>
                            @error('notes') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div class="flex justify-end gap-3 pt-2">
                            <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 bg-gray-700 text-gray-300 rounded-lg hover:bg-gray-600 transition">Cancelar</button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
</div>
