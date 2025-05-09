<x-app-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Painel do aluno') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">
                        {{ __('Cursos') }}
                    </h2>

                    @if ($courses->isEmpty())
                        <div class="text-center
                        text-gray-500">
                            Mais cursos em breve!
                        </div>
                    @else
                        <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            @foreach ($courses as $index => $course)
                                <div
                                    class="bg-white shadow-lg rounded-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
                                    <img src="{{ Storage::url($course->image) }}" alt="Imagem do curso"
                                        class="w-full h-48 object-cover">

                                    <div class="p-4">
                                        <h3 class="text-xl font-semibold text-gray-800">{{ $course->title }}</h3>
                                        <p class="text-gray-600 mt-2">{{ Str::limit($course->description, 100) }}</p>
                                    </div>

                                    <div class="py-4 text-right">
                                        @if (in_array($course->id, $userCourseIds))
                                            <span
                                                class="cursor-pointer text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-green-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-800 dark:text-white dark:border-gray-600 dark:hover:bg-green-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                                onclick="window.location.href = '/meus-curso/{{ $course->uuid }}'">Acessar</span>
                                        @else
                                            <form
                                                action="{{ route('matriculation.course.store', ['course_uuid' => $course->uuid, 'user_uuid' => Auth::user()->uuid]) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="cursor-pointer text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                                                    Matrícular
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="p-4">
                            {{ $courses->links() }}
                        </div>
                    @endif
                </div>

                <div class="p-6 text-gray-900">
                    <h2 class="text-lg font-medium text-gray-900 mb-4">
                        {{ __('Testes') }}
                    </h2>

                    @if ($tests->isEmpty())
                        <div class="text-center
                        text-gray-500">
                            Mais cursos em breve!
                        </div>
                    @else
                        <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            @foreach ($tests as $index => $test)
                                <div class="bg-white shadow-lg rounded-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-2">
                                    <div class="p-4">
                                        <h3 class="text-xl font-semibold text-gray-800">{{ $test->title }}</h3>
                                        <p class="text-gray-600 mt-2">{{ Str::limit($test->description, 100) }}</p>
                                    </div>

                                    <div class="py-4 text-right">
                                        @if (in_array($test->id, $userTestIds))
                                            <span
                                                class="cursor-pointer text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-green-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-800 dark:text-white dark:border-gray-600 dark:hover:bg-green-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                                onclick="window.location.href = '/meus-testes/{{ $test->uuid }}'">Acessar</span>
                                        @else
                                            <form
                                                action="{{ route('matriculation.test.store', ['test_uuid' => $test->uuid, 'user_uuid' => Auth::user()->uuid]) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="cursor-pointer text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                                                    Matrícular
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="p-4">
                            {{ $tests->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
