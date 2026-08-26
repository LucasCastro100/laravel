<x-app-layout :title="$title">
    <x-slot name="header">
        <x-page-title title="Gerenciar Usuários" />
    </x-slot>

    <div class="py-8" x-data="{ openDelete: false, deleteUrl: '' }">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-900 rounded-2xl border border-gray-800 shadow-xl p-6">

                <div class="flex items-center justify-between mb-6">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Total</p>
                        <p class="text-2xl font-bold text-gray-100">{{ $users->total() }} <span class="text-sm font-normal text-gray-400">usuários</span></p>
                    </div>
                    <a href="{{ route('admin.users.create') }}"
                        class="flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium rounded-lg transition">
                        <i class="fa-solid fa-plus"></i>
                        Novo Usuário
                    </a>
                </div>

                @if ($users->isEmpty())
                    <x-empty-state title="Nenhum usuário cadastrado." message="Crie o primeiro usuário para começar." />
                @else
                    <div class="overflow-x-auto rounded-xl border border-gray-800">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-800 bg-gray-950/60">
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider whitespace-nowrap">Nome</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider whitespace-nowrap">E-mail</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider whitespace-nowrap">CPF</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider whitespace-nowrap">Tipo</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider whitespace-nowrap">Especialidade</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider whitespace-nowrap">Matrícula</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider whitespace-nowrap">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-800">
                                @foreach ($users as $user)
                                    <tr class="hover:bg-gray-800/40 transition">
                                        <td class="px-4 py-3.5 text-gray-200 font-medium whitespace-nowrap">{{ $user->name }}</td>
                                        <td class="px-4 py-3.5 text-gray-400 whitespace-nowrap">{{ $user->email }}</td>
                                        <td class="px-4 py-3.5 text-gray-400 whitespace-nowrap">{{ $user->cpf }}</td>
                                        <td class="px-4 py-3.5 whitespace-nowrap">
                                            @switch($user->role_id)
                                                @case(1)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-500/10 text-green-400 ring-1 ring-green-500/20">Aluno</span>
                                                    @break
                                                @case(2)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400 ring-1 ring-blue-500/20">Professor</span>
                                                    @break
                                                @case(3)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-500/10 text-purple-400 ring-1 ring-purple-500/20">Admin</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td class="px-4 py-3.5 text-gray-400 whitespace-nowrap">{{ $user->teacher->specialty ?? '—' }}</td>
                                        <td class="px-4 py-3.5 text-gray-400 whitespace-nowrap">{{ $user->student->registration ?? '—' }}</td>
                                        <td class="px-4 py-3.5 whitespace-nowrap">
                                            <div class="flex items-center gap-1">
                                                <a href="{{ route('admin.users.edit', $user->uuid) }}"
                                                    class="p-1.5 rounded-lg text-gray-500 hover:text-yellow-400 hover:bg-yellow-400/10 transition" title="Editar">
                                                    <i class="fa-solid fa-pen text-xs"></i>
                                                </a>
                                                <button
                                                    @click="openDelete = true; deleteUrl = '{{ route('admin.users.destroy', $user->uuid) }}'"
                                                    class="p-1.5 rounded-lg text-gray-500 hover:text-red-400 hover:bg-red-400/10 transition" title="Excluir">
                                                    <i class="fa-solid fa-trash text-xs"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pt-4">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>

        {{-- Modal de Exclusão --}}
        <template x-if="openDelete">
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm"
                @click.self="openDelete = false">
                <div class="bg-gray-900 rounded-2xl border border-gray-800 shadow-2xl w-full max-w-sm p-6"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100">
                    <div class="flex flex-col items-center text-center gap-3 mb-6">
                        <div class="w-14 h-14 rounded-full bg-red-500/10 flex items-center justify-center">
                            <i class="fa-solid fa-triangle-exclamation text-red-400 text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-gray-100">Excluir Usuário</h3>
                            <p class="text-sm text-gray-400 mt-1">Esta ação não pode ser desfeita.</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button @click="openDelete = false"
                            class="flex-1 py-2.5 px-4 border border-gray-700 text-gray-300 rounded-xl hover:bg-gray-800 transition text-sm font-medium">
                            Cancelar
                        </button>
                        <form method="POST" :action="deleteUrl" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full py-2.5 px-4 bg-red-600 hover:bg-red-500 text-white rounded-xl transition text-sm font-medium">
                                Excluir
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </template>
    </div>
</x-app-layout>


