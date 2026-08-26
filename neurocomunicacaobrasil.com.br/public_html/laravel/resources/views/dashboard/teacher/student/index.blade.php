<x-app-layout :title="$title">
    <x-slot name="header">
        <x-page-title title="Gerenciar Alunos" />
    </x-slot>

    <div class="py-8">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-900 rounded-2xl border border-gray-800 shadow-xl p-6">

                <div class="flex items-center justify-between mb-6">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Total</p>
                        <p class="text-2xl font-bold text-gray-100">{{ $students->total() }} <span class="text-sm font-normal text-gray-400">alunos</span></p>
                    </div>
                    <a href="{{ route('teacher.students.create') }}"
                        class="flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium rounded-lg transition">
                        <i class="fa-solid fa-plus"></i>
                        Novo Aluno
                    </a>
                </div>

                @if ($students->isEmpty())
                    <x-empty-state title="Nenhum aluno cadastrado." message="Cadastre alunos para vincular aos seus cursos." />
                @else
                    <div class="overflow-x-auto rounded-xl border border-gray-800">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-800 bg-gray-950/60">
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Nome</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">E-mail</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">CPF</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Matrícula</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Cursos</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-800">
                                @foreach ($students as $student)
                                    <tr class="hover:bg-gray-800/40 transition">
                                        <td class="px-4 py-3.5 text-gray-200 font-medium whitespace-nowrap">{{ $student->user->name }}</td>
                                        <td class="px-4 py-3.5 text-gray-400 whitespace-nowrap">{{ $student->user->email }}</td>
                                        <td class="px-4 py-3.5 text-gray-400 whitespace-nowrap">{{ $student->user->cpf }}</td>
                                        <td class="px-4 py-3.5 text-gray-400 whitespace-nowrap">{{ $student->registration ?? '—' }}</td>
                                        <td class="px-4 py-3.5">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400">
                                                {{ $student->matriculation_courses_count ?? 0 }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="pt-4">
                        {{ $students->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>


