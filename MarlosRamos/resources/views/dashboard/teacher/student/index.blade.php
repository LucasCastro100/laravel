<x-app-layout :title="$title">
    <x-slot name="header">
        <x-page-title title="Gerenciar Alunos" />
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
                    <a href="{{ route('teacher.students.create') }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">
                        <i class="fa-solid fa-plus"></i> Novo Aluno
                    </a>
                </div>

                @if ($students->isEmpty())
                    <x-empty-state title="Nenhum aluno cadastrado." message="Cadastre alunos para vincular aos seus cursos." />
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border border-gray-700">
                            <thead class="bg-gray-950 text-sm font-semibold text-gray-200">
                                <tr>
                                    <th class="p-3">Nome</th>
                                    <th class="p-3">E-mail</th>
                                    <th class="p-3">CPF</th>
                                    <th class="p-3">Matrícula</th>
                                    <th class="p-3">Cursos Vinculados</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr class="border-t border-gray-700 hover:bg-gray-800">
                                        <td class="p-3">{{ $student->user->name }}</td>
                                        <td class="p-3">{{ $student->user->email }}</td>
                                        <td class="p-3">{{ $student->user->cpf }}</td>
                                        <td class="p-3">{{ $student->registration }}</td>
                                        <td class="p-3">{{ $student->matriculation_courses_count ?? 0 }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4">
                        {{ $students->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>