<div class="py-6" wire:poll.30s="loadUsers">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-gray-200">Usuários</h2>
            <span class="text-xs text-gray-500">{{ $users->where('online', true)->count() }} online agora</span>
        </div>

        <div class="bg-gray-900 border border-gray-800 overflow-hidden shadow-xl rounded-lg">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-400">
                    <thead class="text-xs uppercase bg-gray-800 text-gray-400">
                        <tr>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Nome</th>
                            <th class="px-6 py-3">E-mail</th>
                            <th class="px-6 py-3">Role</th>
                            <th class="px-6 py-3">Última atividade</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @foreach ($users as $user)
                            <tr class="hover:bg-gray-800/50">
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-2">
                                        <span class="h-2.5 w-2.5 rounded-full {{ $user['online'] ? 'bg-green-500' : 'bg-gray-600' }}"></span>
                                        <span class="{{ $user['online'] ? 'text-green-400' : 'text-gray-500' }}">
                                            {{ $user['online'] ? 'Online' : 'Offline' }}
                                        </span>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-white">{{ $user['name'] }}</td>
                                <td class="px-6 py-4">{{ $user['email'] }}</td>
                                <td class="px-6 py-4">{{ $user['role'] }}</td>
                                <td class="px-6 py-4">{{ $user['last_seen'] ?? 'Nunca' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
