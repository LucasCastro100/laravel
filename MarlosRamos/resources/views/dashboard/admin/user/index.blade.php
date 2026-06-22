<x-app-layout :title="$title">
    <x-slot name="header">
        <x-page-title title="Gerenciar Usuários" />
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if (session('success'))
                    <x-alert-component type="success" :message="session('success')" />
                @endif

                @if (session('error'))
                    <x-alert-component type="error" :message="session('error')" />
                @endif

                <div class="text-right">
                    <a href="{{ route('admin.users.create') }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
                        <i class="fa-solid fa-plus"></i> Novo Usuário
                    </a>
                </div>

                @if ($users->isEmpty())
                    <x-empty-state title="Nenhum usuário cadastrado." message="Crie o primeiro usuário para começar." />
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border border-gray-700">
                            <thead class="bg-gray-950 text-sm font-semibold text-gray-200">
                                <tr>
                                    <th class="p-3">Nome</th>
                                    <th class="p-3">E-mail</th>
                                    <th class="p-3">CPF</th>
                                    <th class="p-3">Tipo</th>
                                    <th class="p-3">Especialidade</th>
                                    <th class="p-3">Matrícula</th>
                                    <th class="p-3">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr class="border-t border-gray-700 hover:bg-gray-800">
                                        <td class="p-3">{{ $user->name }}</td>
                                        <td class="p-3">{{ $user->email }}</td>
                                        <td class="p-3">{{ $user->cpf }}</td>
                                        <td class="p-3">
                                            @switch($user->role_id)
                                                @case(1)
                                                    <span class="px-2 py-1 text-xs rounded bg-green-600 text-white">Aluno</span>
                                                    @break
                                                @case(2)
                                                    <span class="px-2 py-1 text-xs rounded bg-blue-600 text-white">Professor</span>
                                                    @break
                                                @case(3)
                                                    <span class="px-2 py-1 text-xs rounded bg-purple-600 text-white">Admin</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td class="p-3">{{ $user->teacher->specialty ?? '--' }}</td>
                                        <td class="p-3">{{ $user->student->registration ?? '--' }}</td>
                                        <td class="p-3">
                                            <div class="flex gap-2">
                                                <a href="{{ route('admin.users.edit', $user->uuid) }}"
                                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs">
                                                    <i class="fa-solid fa-edit"></i> Editar
                                                </a>
                                                <form method="POST" action="{{ route('admin.users.destroy', $user->uuid) }}"
                                                    onsubmit="return confirm('Tem certeza que deseja excluir este usuário?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                                                        <i class="fa-solid fa-trash"></i> Excluir
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>