<div>
    <div class="bg-gray-900 border border-gray-800 p-6 rounded-xl mb-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-gray-100">Contas Financeiras</h1>
            <button wire:click="openModal" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                + Nova Conta
            </button>
        </div>
    </div>

        <div class="bg-gray-900 border border-gray-800 rounded-lg p-4 mb-6">
            <div class="flex gap-4 items-end">
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Mês</label>
                    <select wire:model.live="filterMonth" class="bg-gray-800 border border-gray-700 text-gray-200 rounded px-3 py-2">
                        @foreach (range(1, 12) as $m)
                            <option value="{{ $m }}">{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Ano</label>
                    <select wire:model.live="filterYear" class="bg-gray-800 border border-gray-700 text-gray-200 rounded px-3 py-2">
                        @foreach (range(now()->year - 2, now()->year + 2) as $y)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="bg-gray-900 border border-gray-800 rounded-lg overflow-hidden">
            <table class="w-full text-sm text-left text-gray-400">
                <thead class="text-xs uppercase bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 ">Descrição</th>
                        <th class="px-6 py-3 ">Tipo</th>
                        <th class="px-6 py-3 ">Categoria</th>
                        <th class="px-6 py-3 ">Valor</th>
                        <th class="px-6 py-3 ">Vencimento</th>
                        <th class="px-6 py-3 ">Status</th>
                        <th class="px-6 py-3 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse ($transactions as $t)
                        <tr class="hover:bg-gray-800/50">
                            <td class="px-6 py-4 text-white">{{ $t->description ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $t->accountType?->name ?? '-' }}</td>
                            <td class="px-6 py-4">
                                @if ($t->category)
                                    <span class="inline-flex items-center gap-1.5">
                                        <span class="inline-block w-2.5 h-2.5 rounded-full" style="background: {{ $t->category->color ?? '#6b7280' }}"></span>
                                        {{ $t->category->name }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 font-medium {{ isset($t->value) && $t->value >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                R$ {{ isset($t->value) ? number_format($t->value, 2, ',', '.') : '-' }}
                            </td>
                            <td class="px-6 py-4">{{ $t->due_date?->format('d/m/Y') ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <button wire:click="togglePaid({{ $t->id }})"
                                    class="px-2 py-1 text-xs rounded-full {{ $t->paid ? 'bg-green-900 text-green-400' : 'bg-yellow-900 text-yellow-400' }}">
                                    {{ $t->paid ? 'Pago' : 'Pendente' }}
                                </button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button wire:click="edit({{ $t->id }})" class="p-1.5 text-blue-500 hover:text-blue-400 hover:bg-blue-500/10 rounded-lg transition" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button wire:click="delete({{ $t->id }})" wire:confirm="Tem certeza?" class="p-1.5 text-red-500 hover:text-red-400 hover:bg-red-500/10 rounded-lg transition" title="Excluir">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12  text-gray-500">Nenhuma conta encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($showModal)
            <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
                <div class="bg-gray-900 border border-gray-800 rounded-lg p-6 w-full max-w-lg max-h-[90vh] overflow-y-auto">
                    <h3 class="text-lg font-semibold text-white mb-4">{{ $transactionId ? 'Editar' : 'Nova' }} Conta</h3>
                    <form wire:submit="save" class="space-y-4">
                        <div>
                            <label class="block text-sm text-gray-300 mb-1">Tipo</label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2 text-gray-300 cursor-pointer">
                                    <input type="radio" wire:model="type" value="expense" class="text-red-500 focus:ring-red-500">
                                    <span class="text-red-400">Despesa</span>
                                </label>
                                <label class="flex items-center gap-2 text-gray-300 cursor-pointer">
                                    <input type="radio" wire:model="type" value="income" class="text-green-500 focus:ring-green-500">
                                    <span class="text-green-400">Receita</span>
                                </label>
                            </div>
                            @error('type') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-gray-300 mb-1">Valor (R$)</label>
                                <input x-data="{ display: '' }"
                                    x-init="display = $wire.value ? parseFloat($wire.value).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : ''"
                                    x-on:input="
                                        let v = $event.target.value.replace(/\D/g, '');
                                        if (v.length === 0) { display = ''; $wire.set('value', ''); return; }
                                        let n = (parseInt(v) / 100).toFixed(2);
                                        display = n.replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                                        $wire.set('value', parseFloat(n));
                                    "
                                    x-bind:value="display"
                                    inputmode="numeric" placeholder="0,00"
                                    class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('value') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm text-gray-300 mb-1">Tipo de Conta</label>
                                <select wire:model="account_type_id" class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Selecione</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-gray-300 mb-1">Categoria</label>
                                <select wire:model="category_id" class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Selecione</option>
                                    @foreach ($cats as $cat)
                                        <option value="{{ $cat->id }}" style="background: {{ $cat->color ?? '#6b7280' }}20; border-left: 3px solid {{ $cat->color ?? '#6b7280' }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm text-gray-300 mb-1">Vencimento</label>
                                <input wire:model="due_date" type="date" class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('due_date') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div>
                            <label class="flex items-center gap-2 text-gray-300 cursor-pointer">
                                <input type="checkbox" wire:model="paid" class="rounded bg-gray-800 border-gray-700 text-blue-500 focus:ring-blue-500">
                                Pago
                            </label>
                        </div>
                        @if ($paid)
                            <div>
                                <label class="block text-sm text-gray-300 mb-1">Data de Pagamento</label>
                                <input wire:model="paid_date" type="date" class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        @endif
                        <div>
                            <label class="block text-sm text-gray-300 mb-1">Observações</label>
                            <textarea wire:model="notes" rows="2" class="w-full bg-gray-800 border border-gray-700 text-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
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
