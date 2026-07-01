<x-app-layout :title="$title">
    <x-slot name="header">
        <x-page-title title="Fale Conosco" />
    </x-slot>

    <div class="py-8">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Formulário --}}
            <div class="bg-gray-900 rounded-2xl border border-gray-800 p-6" x-data="duvidaForm()">

                <div class="flex items-center gap-3 mb-6">
                    <div class="w-1 h-6 bg-teal-500 rounded-full"></div>
                    <h2 class="text-base font-semibold text-gray-100">Enviar Mensagem</h2>
                </div>

                <form action="{{ route('student.duvidas.store') }}" method="POST" class="space-y-5">
                    @csrf

                    {{-- Tipo --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">Assunto</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label @click="type = 'platform'; courseId = ''"
                                   :class="type === 'platform' ? 'border-teal-500/50 bg-teal-500/10 text-teal-300' : 'border-gray-700 bg-gray-800/50 text-gray-400 hover:border-gray-600'"
                                   class="flex items-center gap-3 p-4 rounded-xl border cursor-pointer transition">
                                <input type="radio" name="type" value="platform" x-model="type" class="sr-only">
                                <div :class="type === 'platform' ? 'bg-teal-500/20' : 'bg-gray-700'" class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0 transition">
                                    <i :class="type === 'platform' ? 'text-teal-400' : 'text-gray-500'" class="fa-solid fa-building text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium">Plataforma</p>
                                    <p class="text-xs opacity-60">Dúvidas gerais sobre o sistema</p>
                                </div>
                            </label>

                            <label @click="type = 'course'"
                                   :class="type === 'course' ? 'border-blue-500/50 bg-blue-500/10 text-blue-300' : 'border-gray-700 bg-gray-800/50 text-gray-400 hover:border-gray-600'"
                                   class="flex items-center gap-3 p-4 rounded-xl border cursor-pointer transition">
                                <input type="radio" name="type" value="course" x-model="type" class="sr-only">
                                <div :class="type === 'course' ? 'bg-blue-500/20' : 'bg-gray-700'" class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0 transition">
                                    <i :class="type === 'course' ? 'text-blue-400' : 'text-gray-500'" class="fa-solid fa-graduation-cap text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium">Curso Específico</p>
                                    <p class="text-xs opacity-60">Dúvida sobre um dos seus cursos</p>
                                </div>
                            </label>
                        </div>
                        @error('type') <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p> @enderror
                    </div>

                    {{-- Select de curso com busca --}}
                    <div x-show="type === 'course'" x-transition>
                        <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">Curso</label>
                        <div class="relative" @click.away="courseOpen = false">
                            <button type="button" @click="courseOpen = !courseOpen"
                                    class="w-full flex items-center justify-between px-4 py-2.5 bg-white border border-gray-300 rounded-xl text-sm text-left transition"
                                    :class="courseOpen ? 'border-blue-500 ring-1 ring-blue-500/30' : 'hover:border-gray-600'">
                                <span :class="courseId ? 'text-gray-900' : 'text-gray-400'" x-text="selectedCourseLabel"></span>
                                <svg :class="courseOpen ? 'rotate-180' : ''" class="w-4 h-4 text-gray-500 transition-transform shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <input type="hidden" name="course_id" :value="courseId">

                            <div x-show="courseOpen" x-transition
                                 class="absolute z-30 w-full mt-1.5 bg-white border border-gray-300 rounded-xl shadow-xl overflow-hidden">
                                <div class="p-2 border-b border-gray-700">
                                    <div class="flex items-center gap-2 bg-gray-900 rounded-lg px-3 py-2">
                                        <i class="fa-solid fa-magnifying-glass text-gray-500 text-xs"></i>
                                        <input type="text" x-model="courseSearch" x-ref="courseSearchInput"
                                               @click.stop @keydown.escape="courseOpen = false"
                                               class="bg-transparent text-sm text-gray-200 placeholder-gray-500 outline-none flex-1"
                                               placeholder="Buscar curso...">
                                    </div>
                                </div>
                                <div class="max-h-48 overflow-y-auto">
                                    <template x-if="filteredCourses.length === 0">
                                        <p class="px-4 py-3 text-sm text-gray-500 text-center">Nenhum curso encontrado</p>
                                    </template>
                                    <template x-for="course in filteredCourses" :key="course.id">
                                        <button type="button"
                                                @click="courseId = course.id; courseOpen = false; courseSearch = ''"
                                                class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-left transition hover:bg-gray-700"
                                                :class="courseId == course.id ? 'text-blue-300 bg-blue-600/10' : 'text-gray-300'">
                                            <i class="fa-solid fa-graduation-cap text-xs" :class="courseId == course.id ? 'text-blue-400' : 'text-gray-500'"></i>
                                            <span x-text="course.title" class="truncate"></span>
                                            <i x-show="courseId == course.id" class="fa-solid fa-check text-blue-400 text-xs ml-auto shrink-0"></i>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>
                        @error('course_id') <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p> @enderror
                    </div>

                    {{-- Mensagem --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">Mensagem</label>
                        <textarea name="message" rows="5"
                            class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-teal-500/40 focus:border-teal-500 resize-none transition"
                            placeholder="Descreva sua dúvida com o máximo de detalhes possível...">{{ old('message') }}</textarea>
                        @error('message') <p class="text-xs text-red-400 mt-1.5">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                                class="flex items-center gap-2 px-5 py-2.5 bg-teal-600 hover:bg-teal-500 text-white text-sm font-medium rounded-lg transition">
                            <i class="fa-solid fa-paper-plane text-xs"></i>
                            Enviar Mensagem
                        </button>
                    </div>
                </form>
            </div>

            {{-- Histórico --}}
            @if ($contacts->isNotEmpty())
                <div class="bg-gray-900 rounded-2xl border border-gray-800 p-6">
                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-1 h-6 bg-gray-600 rounded-full"></div>
                        <h2 class="text-base font-semibold text-gray-100">Minhas Mensagens</h2>
                    </div>

                    <div class="space-y-4">
                        @foreach ($contacts as $contact)
                            <div class="rounded-xl border border-gray-800 bg-gray-800/40 overflow-hidden">
                                <div class="p-4">
                                    <div class="flex items-start justify-between gap-3 mb-3">
                                        <div class="flex items-center gap-2">
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium
                                                {{ $contact->type === 'platform' ? 'bg-teal-500/15 text-teal-300 border border-teal-500/20' : 'bg-blue-500/15 text-blue-300 border border-blue-500/20' }}">
                                                {{ $contact->type === 'platform' ? 'Plataforma' : 'Curso' }}
                                            </span>
                                            @if ($contact->course)
                                                <span class="text-xs text-gray-500">→ {{ $contact->course->title }}</span>
                                            @endif
                                        </div>
                                        <span class="text-xs text-gray-600 shrink-0">{{ $contact->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-sm text-gray-300 leading-relaxed">{{ $contact->message }}</p>
                                </div>

                                @if ($contact->replies->isNotEmpty())
                                    <div class="border-t border-gray-700">
                                        @foreach ($contact->replies as $reply)
                                            <div class="flex gap-3 p-4 bg-gray-700/30">
                                                <div class="w-7 h-7 rounded-full bg-blue-600/20 border border-blue-500/30 flex items-center justify-center shrink-0 mt-0.5">
                                                    <i class="fa-solid fa-user-tie text-blue-400 text-xs"></i>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-center gap-2 mb-1">
                                                        <span class="text-xs font-medium text-gray-300">{{ $reply->user->name }}</span>
                                                        <span class="text-xs text-gray-600">{{ $reply->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    <p class="text-sm text-gray-300 leading-relaxed">{{ $reply->reply }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="border-t border-gray-800 px-4 py-2">
                                        <p class="text-xs text-gray-600 italic">Aguardando resposta...</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('duvidaForm', () => ({
                type: '{{ old('type', 'platform') }}',
                courseId: '{{ old('course_id', '') }}',
                courseSearch: '',
                courseOpen: false,
                courses: @json($myCourses->map(fn($c) => ['id' => $c->id, 'title' => $c->title])),

                get filteredCourses() {
                    if (!this.courseSearch) return this.courses;
                    const q = this.courseSearch.toLowerCase();
                    return this.courses.filter(c => c.title.toLowerCase().includes(q));
                },

                get selectedCourseLabel() {
                    if (!this.courseId) return 'Selecione o curso';
                    const found = this.courses.find(c => c.id == this.courseId);
                    return found ? found.title : 'Selecione o curso';
                }
            }));
        });
    </script>

</x-app-layout>


