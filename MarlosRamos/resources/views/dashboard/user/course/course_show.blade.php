<x-app-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Curso') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ dropClassroom: [] }">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex flex-col items-center justify-center gap-6 w-full">

                    <!-- NOVOS CARDS DE PROGRESSO -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 w-full">

                        <!-- Duração total -->
                        <div class="bg-white p-4 rounded-lg shadow-lg flex items-center space-x-4">
                            <i class="fas fa-clock text-3xl text-purple-500"></i>
                            <div>
                                <p class="text-lg font-medium">Duração Total</p>
                                <p class="text-xl font-semibold">{{ $durationTotal }}</p>
                            </div>
                        </div>

                        <!-- Aulas concluídas -->
                        <div class="bg-white p-4 rounded-lg shadow-lg flex items-center space-x-4">
                            <i class="fas fa-check-circle text-3xl text-green-500"></i>
                            <div>
                                <p class="text-lg font-medium">Aulas Concluídas</p>
                                <p class="text-xl font-semibold">{{ $completedClasses }} / {{ $totalClasses }}</p>
                            </div>
                        </div>

                        <!-- Barra de progresso -->
                        <div class="bg-white p-4 rounded-lg shadow-lg sm:col-span-2 md:col-span-1">
                            <p class="text-lg font-medium mb-2">Progresso</p>
                            <div class="w-full bg-gray-300 h-6 rounded-full">
                                <div class="bg-green-500 h-6 rounded-full text-xs text-white text-center flex items-center justify-center"
                                    style="width: {{ $progress }}%;">
                                    <span class="w-full ml-4">{{ $progress }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Descrição e módulos -->
                    <div class="w-full">
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 w-full">
                            <div class="sm:col-span-2 md:col-span-1">
                                <img src="{{ asset('storage/' . $course->image) }}" alt="Imagem do Curso"
                                    class="w-full h-auto mb-4">
                                <p class="text-gray-600">{{ $course->description }}</p>
                            </div>

                            <div class="sm:col-span-2">
                                @if ($course->modules->isEmpty())
                                    <div class="text-center text-gray-500">
                                        Nenhum módulo cadastrado.
                                    </div>
                                @else
                                    @foreach ($course->modules as $module)
                                        <div class="mb-4 relative z-0">
                                            <div class="border rounded-lg p-4 bg-gray-100">
                                                <div class="flex justify-between items-center relative">
                                                    <div>
                                                        <h3 class="font-semibold">{{ $module->title }}</h3>
                                                        @php
                                                            $classesModule = $module->classrooms;
                                                            $total = $classesModule->count();
                                                            $completed = $classesModule
                                                                ->filter(
                                                                    fn($aula) => $aula->completedByUsers->contains(
                                                                        auth()->id(),
                                                                    ),
                                                                )
                                                                ->count();
                                                        @endphp
                                                        <p class="text-sm text-gray-600">{{ $completed }} /
                                                            {{ $total }} aulas concluídas</p>
                                                    </div>

                                                    <button
                                                        @click="dropClassroom.includes({{ $module->id }}) ? dropClassroom = dropClassroom.filter(id => id !== {{ $module->id }}) : dropClassroom.push({{ $module->id }})"
                                                        class="text-blue-500">
                                                        <span
                                                            x-show="!dropClassroom.includes({{ $module->id }})">+</span>
                                                        <span
                                                            x-show="dropClassroom.includes({{ $module->id }})">-</span>
                                                    </button>
                                                </div>

                                                <!-- Lista de aulas -->
                                                <div x-ref="container" x-collapse
                                                    x-show="dropClassroom.includes({{ $module->id }})">
                                                    @if ($classesModule->isEmpty())
                                                        <div class="text-center text-gray-500">
                                                            Nenhuma aula cadastrada.
                                                        </div>
                                                    @else
                                                        @foreach ($classesModule as $classroom)
                                                            <div
                                                                class="flex justify-between items-center p-2 border-b relative">
                                                                <div class="flex items-center space-x-2 cursor-pointer"
                                                                    @click="window.location.href = '/aula/' + {{ json_encode($classroom->uuid) }}">
                                                                    <span>{{ $classroom->title }}</span>
                                                                    @if ($classroom->completedByUsers->contains(auth()->id()))
                                                                        <i class="fas fa-check text-green-500"></i>
                                                                    @endif
                                                                </div>
                                                                @if ($classroom->duration)
                                                                    <span
                                                                        class="text-sm text-gray-500">{{ $classroom->duration }}</span>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
