<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-gray-200">Tipos de Conta</h2>
            <button wire:click="openModal" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                + Novo Tipo
            </button>
        </div>

        <div class="bg-gray-900 border border-gray-800 rounded-lg overflow-hidden">
            <table class="w-full text-sm text-left text-gray-400">
                <thead class="text-xs uppercase bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 ">Nome</th>
                        <th class="px-6 py-3 ">Descrição</th>
                        <th class="px-6 py-3 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse ($types as $type)
                        <tr class="hover:bg-gray-800/50">
                            <td class="px-6 py-4 text-white">{{ $type->name ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $type->description ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button wire:click="edit({{ $type->id }})" class="p-1.5 text-blue-500 hover:text-blue-400 hover:bg-blue-500/10 rounded-lg transition" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button wire:click="delete({{ $type->id }})" wire:confirm="Tem certeza?" class="p-1.5 text-red-500 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition" title="Excluir">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12  text-gray-500">Nenhum tipo de conta cadastrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($showModal)
            <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
                <div class="bg-gray-900 border border-gray-800 rounded-lg p-6 w-full max-w-md">
                    <h3 class="text-lg font-semibold text-white mb-4">{{ $typeId ? 'Editar' : 'Novo' }} Tipo de Conta</h3>
                    <form wire:submit="save">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm text-gray-400 mb-1">Nome</label>
                                <input wire:model="name" class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded px-3 py-2">
                                @error('name') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm text-gray-400 mb-1">Descrição</label>
                                <textarea wire:model="description" rows="3" class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded px-3 py-2"></textarea>
                            </div>
                        </div>
                        <div class="flex justify-end gap-3 mt-6">
                            <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 bg-gray-700 text-gray-300 rounded hover:bg-gray-600">Cancelar</button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>
</div>
