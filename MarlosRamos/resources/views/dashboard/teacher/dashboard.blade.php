<x-app-layout :title="$title">
    <x-slot name="header">
        <x-page-title title="Painel do Professor" />
    </x-slot>

    <div class="py-8">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Banner de boas-vindas --}}
            <div class="relative bg-gray-900 rounded-2xl border border-gray-800 overflow-hidden p-6">
                <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">
                            {{ now()->format('d/m/Y') }}
                        </p>
                        <h1 class="text-2xl font-bold text-gray-100">{{ $saudacao }}, {{ $usuario }}!</h1>
                        <p class="text-sm text-gray-400 mt-1">Bem-vindo ao seu painel de professor.</p>
                    </div>
                    <a href="{{ route('course.create') }}"
                        class="shrink-0 flex items-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium rounded-lg transition">
                        <i class="fa-solid fa-plus"></i>
                        Novo Curso
                    </a>
                </div>
                {{-- Decoração sutil --}}
                <div class="absolute inset-y-0 right-0 w-1/3 bg-gradient-to-l from-blue-500/5 to-transparent pointer-events-none"></div>
            </div>

            {{-- Indicadores --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-gray-900 rounded-2xl border border-gray-800 p-5 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-indigo-500/10 flex items-center justify-center shrink-0">
                        <i class="fas fa-clipboard-check text-indigo-400 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Testes com Alunos</p>
                        <p class="text-3xl font-bold text-gray-100 mt-0.5">{{ $testsWithLogin }}</p>
                    </div>
                </div>

                <div class="bg-gray-900 rounded-2xl border border-gray-800 p-5 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-500/10 flex items-center justify-center shrink-0">
                        <i class="fas fa-calendar-days text-purple-400 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Testes em Eventos</p>
                        <p class="text-3xl font-bold text-gray-100 mt-0.5">{{ $testsNotLogin }}</p>
                    </div>
                </div>

                <div class="bg-gray-900 rounded-2xl border border-gray-800 p-5 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-500/10 flex items-center justify-center shrink-0">
                        <i class="fas fa-book text-blue-400 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Cursos Criados</p>
                        <p class="text-3xl font-bold text-gray-100 mt-0.5">{{ $couses }}</p>
                    </div>
                </div>
            </div>

            {{-- Ações rápidas --}}
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider mb-3">Ações Rápidas</p>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
                    <a href="{{ route('course.create') }}"
                        class="bg-gray-900 rounded-2xl border border-gray-800 p-4 flex flex-col items-center gap-2.5 hover:border-blue-500/40 hover:bg-gray-800/60 transition group text-center">
                        <div class="w-10 h-10 rounded-xl bg-blue-500/10 group-hover:bg-blue-500/20 flex items-center justify-center transition">
                            <i class="fa-solid fa-plus text-blue-400 text-sm"></i>
                        </div>
                        <span class="text-xs text-gray-300 font-medium leading-tight">Novo Curso</span>
                    </a>

                    <a href="{{ route('course.index') }}"
                        class="bg-gray-900 rounded-2xl border border-gray-800 p-4 flex flex-col items-center gap-2.5 hover:border-indigo-500/40 hover:bg-gray-800/60 transition group text-center">
                        <div class="w-10 h-10 rounded-xl bg-indigo-500/10 group-hover:bg-indigo-500/20 flex items-center justify-center transition">
                            <i class="fa-solid fa-book-open text-indigo-400 text-sm"></i>
                        </div>
                        <span class="text-xs text-gray-300 font-medium leading-tight">Meus Cursos</span>
                    </a>

                    <a href="{{ route('teacher.students.create') }}"
                        class="bg-gray-900 rounded-2xl border border-gray-800 p-4 flex flex-col items-center gap-2.5 hover:border-green-500/40 hover:bg-gray-800/60 transition group text-center">
                        <div class="w-10 h-10 rounded-xl bg-green-500/10 group-hover:bg-green-500/20 flex items-center justify-center transition">
                            <i class="fa-solid fa-user-plus text-green-400 text-sm"></i>
                        </div>
                        <span class="text-xs text-gray-300 font-medium leading-tight">Novo Aluno</span>
                    </a>

                    <a href="{{ route('teacher.students') }}"
                        class="bg-gray-900 rounded-2xl border border-gray-800 p-4 flex flex-col items-center gap-2.5 hover:border-teal-500/40 hover:bg-gray-800/60 transition group text-center">
                        <div class="w-10 h-10 rounded-xl bg-teal-500/10 group-hover:bg-teal-500/20 flex items-center justify-center transition">
                            <i class="fa-solid fa-users text-teal-400 text-sm"></i>
                        </div>
                        <span class="text-xs text-gray-300 font-medium leading-tight">Gerenciar Alunos</span>
                    </a>

                    <a href="{{ route('teacher.myTests') }}"
                        class="bg-gray-900 rounded-2xl border border-gray-800 p-4 flex flex-col items-center gap-2.5 hover:border-yellow-500/40 hover:bg-gray-800/60 transition group text-center">
                        <div class="w-10 h-10 rounded-xl bg-yellow-500/10 group-hover:bg-yellow-500/20 flex items-center justify-center transition">
                            <i class="fa-solid fa-clipboard-list text-yellow-400 text-sm"></i>
                        </div>
                        <span class="text-xs text-gray-300 font-medium leading-tight">Ver Testes</span>
                    </a>

                    <a href="{{ route('teacher.report') }}"
                        class="bg-gray-900 rounded-2xl border border-gray-800 p-4 flex flex-col items-center gap-2.5 hover:border-orange-500/40 hover:bg-gray-800/60 transition group text-center">
                        <div class="w-10 h-10 rounded-xl bg-orange-500/10 group-hover:bg-orange-500/20 flex items-center justify-center transition">
                            <i class="fa-solid fa-chart-bar text-orange-400 text-sm"></i>
                        </div>
                        <span class="text-xs text-gray-300 font-medium leading-tight">Relatório</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

