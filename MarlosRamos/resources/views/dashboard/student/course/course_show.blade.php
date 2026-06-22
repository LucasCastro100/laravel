<x-app-layout :title="$title">
    <x-slot name="header">
        <x-page-title title="Curso" />
    </x-slot>

    <div class="py-12" x-data="{ dropClassroom: [] }">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex flex-col items-center justify-center gap-6 w-full">

                    <!-- NOVOS CARDS DE PROGRESSO -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 w-full">

                        <!-- Duração total -->
                        <div class="bg-gray-800 p-4 rounded-lg shadow-lg flex items-center space-x-4">
                            <i class="fas fa-clock text-3xl text-purple-500"></i>
                            <div>
                                <p class="text-lg font-medium">Duração Total</p>
                                <p class="text-xl font-semibold">{{ $durationTotal }}</p>
                            </div>
                        </div>

                        <!-- Aulas concluídas -->
                        <div class="bg-gray-800 p-4 rounded-lg shadow-lg flex items-center space-x-4">
                            <i class="fas fa-check-circle text-3xl text-green-500"></i>
                            <div>
                                <p class="text-lg font-medium">Aulas Concluídas</p>
                                <p class="text-xl font-semibold">{{ $completedClasses }} / {{ $totalClasses }}</p>
                            </div>
                        </div>

                        <!-- Barra de progresso -->
                        <div class="bg-gray-800 p-4 rounded-lg shadow-lg sm:col-span-2 md:col-span-1">
                            <p class="text-lg font-medium mb-2">Progresso</p>
                            <div class="w-full bg-gray-300 h-6 rounded-full">
                                <div class="bg-green-500 h-6 rounded-full text-xs text-white text-center flex items-center justify-center"
                                    style="width: {{ $progress }}%;">
                                    <span class="w-full ml-4">{{ $progress }}%</span>
                                </div>
                            </div>
                            @if ($course->certificate_enabled && $progress >= 95)
                                <a href="{{ route('student.certificate', $course->uuid) }}"
                                    class="mt-3 block text-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-medium">
                                    <i class="fa-solid fa-certificate"></i> Gerar Certificado
                                </a>
                            @elseif ($course->certificate_enabled)
                                <p class="mt-2 text-xs text-gray-400 text-center">
                                    Complete 95% do curso para gerar o certificado
                                </p>
                            @endif
                        </div>
                    </div>

                    @if ($course->image_banner)
                        <div class="overflow-hidden rounded-xl border border-gray-800 bg-gray-900 w-full">
                            <img src="{{ asset('storage/' . $course->image_banner) }}" alt="Banner do Curso"
                                class="aspect-video w-full object-cover">
                        </div>
                    @endif

                    <div class="w-full">
                        <div class="grid grid-cols-1 xl:grid-cols-[1.6fr_1.1fr] gap-6 w-full items-start">
                            <aside class="space-y-4 rounded-2xl border border-gray-800 bg-gray-950/70 p-4 shadow-lg">
                                <div class="overflow-hidden rounded-xl border border-gray-800 bg-gray-900">
                                    <img src="{{ asset('storage/' . $course->image_cover) }}" alt="Imagem do Curso"
                                        class="aspect-video w-full object-cover">
                                </div>
                                <div class="rounded-xl border border-gray-800 bg-gray-900 p-4">
                                    <p class="text-sm uppercase tracking-[0.25em] text-blue-300">Resumo</p>
                                    <p class="mt-3 whitespace-pre-line text-gray-200">{{ $course->description }}</p>
                                </div>
                            </aside>

                            <section class="rounded-2xl border border-gray-800 bg-gray-950/70 p-4 shadow-lg">
                                <div class="mt-4 space-y-4">
                                    @if ($course->modules->isEmpty())
                                        <div class="rounded-xl border border-gray-800 bg-gray-900 p-6 text-center text-gray-200">
                                            Nenhum módulo cadastrado.
                                        </div>
                                    @else
                                        @foreach ($course->modules as $module)
                                            @php
                                                $classesModule = $module->classrooms;
                                                $total = $classesModule->count();
                                                $completed = $classesModule
                                                    ->filter(fn($aula) => $aula->users->contains(auth()->id()))
                                                    ->count();
                                            @endphp

                                            <article class="rounded-xl border border-gray-800 bg-gray-900 p-4 shadow-sm">
                                                <div class="flex flex-wrap items-start justify-between gap-3">
                                                    <div>
                                                        <h3 class="text-lg font-semibold text-gray-100">{{ $module->title }}</h3>
                                                        <p class="mt-1 text-sm text-gray-200">{{ $completed }} / {{ $total }} aulas concluídas</p>
                                                        @if (!empty($module->total_duration))
                                                            <p class="text-sm text-gray-300">{{ $module->total_duration }}</p>
                                                        @endif
                                                        @if (!empty($module->description))
                                                            <p class="mt-2 whitespace-pre-line text-sm text-gray-200">{{ $module->description }}</p>
                                                        @endif
                                                    </div>

                                                    <button type="button"
                                                        @click="dropClassroom.includes({{ $module->id }}) ? dropClassroom = dropClassroom.filter(id => id !== {{ $module->id }}) : dropClassroom.push({{ $module->id }})"
                                                        class="rounded-full bg-blue-600/10 px-3 py-1 text-sm text-blue-200 hover:bg-blue-600/20">
                                                        <span x-show="!dropClassroom.includes({{ $module->id }})">Expandir</span>
                                                        <span x-show="dropClassroom.includes({{ $module->id }})">Recolher</span>
                                                    </button>
                                                </div>

                                                <div x-ref="container" x-collapse x-show="dropClassroom.includes({{ $module->id }})" class="mt-4 space-y-2">
                                                    @if ($classesModule->isEmpty())
                                                        <div class="rounded-lg border border-dashed border-gray-700 bg-gray-800/70 p-4 text-center text-gray-200">
                                                            Nenhuma aula cadastrada.
                                                        </div>
                                                    @else
                                                        @foreach ($classesModule as $classroom)
                                                            <div class="flex flex-wrap items-center justify-between gap-3 rounded-lg border border-gray-800 bg-gray-800/80 p-3">
                                                                <button type="button"
                                                                    onclick="window.location.href = '{{ route('student.classroom.show', ['uuid_classroom' => $classroom->uuid]) }}'"
                                                                    class="flex items-center gap-2 text-left text-gray-100 hover:text-blue-200">
                                                                    @if ($classroom->users->contains(auth()->id()))
                                                                        <i class="text-sm fa-solid fa-circle-check text-green-500"></i>
                                                                    @else
                                                                        <i class="text-sm fa-solid fa-circle-xmark text-gray-400"></i>
                                                                    @endif
                                                                    <span>{{ $classroom->title }}</span>
                                                                </button>
                                                                @if ($classroom->duration)
                                                                    <span class="text-sm text-gray-300">{{ $classroom->duration }}</span>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </article>
                                        @endforeach
                                    @endif
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
