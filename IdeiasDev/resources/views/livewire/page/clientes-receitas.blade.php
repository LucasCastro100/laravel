<div>
    <div class="bg-gray-900 border border-gray-800 p-6 rounded-xl mb-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-gray-100">Receitas</h1>
            <button wire:click="openModal" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                + Nova Receita
            </button>
        </div>
    </div>

    <div class="bg-gray-900 border border-gray-800 rounded-lg overflow-hidden w-full">
        <table class="w-full text-sm text-left text-gray-400">
            <thead class="text-xs uppercase bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 ">Cliente</th>
                        <th class="px-6 py-3 ">Valor</th>
                        <th class="px-6 py-3 ">Mês</th>
                        <th class="px-6 py-3 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse ($receitas as $r)
                        <tr class="hover:bg-gray-800/50">
                            <td class="px-6 py-4 text-white">{{ $r->client->name }}</td>
                        <td class="px-6 py-4 font-medium text-green-400">
                            R$ {{ number_format($r->value, 2, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">{{ str_pad($r->month, 2, '0', STR_PAD_LEFT) }}/{{ $r->year }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end gap-1">
                                <button wire:click="edit({{ $r->id }})" class="p-1.5 text-blue-500 hover:text-blue-400 hover:bg-blue-500/10 rounded-lg transition" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button wire:click="delete({{ $r->id }})" wire:confirm="Tem certeza?" class="p-1.5 text-red-500 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition" title="Excluir">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12  text-gray-500">Nenhuma receita cadastrada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($showModal)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-gray-900 border border-gray-800 rounded-lg p-6 w-full max-w-lg max-h-[90vh] overflow-y-auto">
                <h3 class="text-lg font-semibold text-white mb-4">{{ $receitaId ? 'Editar' : 'Nova' }} Receita</h3>
                <form wire:submit="save">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm text-gray-400 mb-1">Cliente</label>
                            <select wire:model="client_id" class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded px-3 py-2">
                                <option value="">Selecione</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                            @error('client_id') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm text-gray-400 mb-1">Plano</label>
                            <select wire:model.live="plan_id" class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded px-3 py-2">
                                <option value="">Selecione</option>
                                @foreach ($plans as $plan)
                                    <option value="{{ $plan->id }}">{{ $plan->name }} — R$ {{ number_format($plan->value, 2, ',', '.') }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-400 mb-1">Valor (R$)</label>
                            <div x-data="{ display: '' }"
                                x-init="$watch('$wire.value', v => { display = v ? parseFloat(v).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : '0,00'; })"
                                class="w-full bg-gray-800/50 border border-gray-700 text-gray-400 rounded px-3 py-2"
                                x-text="display || '0,00'">
                            </div>
                            @error('value') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-gray-400 mb-1">Mês</label>
                                <select wire:model="month" class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded px-3 py-2">
                                    @foreach (range(1, 12) as $m)
                                        <option value="{{ $m }}">{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}</option>
                                    @endforeach
                                </select>
                                @error('month') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm text-gray-400 mb-1">Ano</label>
                                <select wire:model="year" class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded px-3 py-2">
                                    @foreach (range(now()->year - 2, now()->year + 2) as $y)
                                        <option value="{{ $y }}">{{ $y }}</option>
                                    @endforeach
                                </select>
                                @error('year') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-400 mb-1">Data de Vencimento</label>
                            <input wire:model="due_date" type="date" class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded px-3 py-2">
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