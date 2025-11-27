<x-app-layout title="Comentários">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Comentários') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                @foreach ($courses as $course)
                    <div x-data="{ openCourse: false }" class="bg-white rounded-xl shadow p-6 hover:shadow-lg transition">
                        <div class="flex items-center justify-between cursor-pointer" @click="openCourse = !openCourse">
                            <h3 class="text-xl font-bold text-blue-700">{{ $course->title }}</h3>
                            <span x-text="openCourse ? '-' : '+' " class="text-blue-500 font-bold"></span>
                        </div>

                        <div x-show="openCourse" x-transition class="mt-6 space-y-4 pl-6 border-l-4 border-blue-200">
                            @foreach ($course->modules as $module)
                                <div x-data="{ openModule: false }"
                                    class="bg-blue-50 rounded-lg p-4 hover:bg-blue-100 transition">
                                    <div class="flex items-center justify-between cursor-pointer"
                                        @click="openModule = !openModule">
                                        <h4 class="font-semibold text-blue-600">{{ $module->title }}</h4>
                                        <span x-text="openModule ? '-' : '+' " class="text-blue-500 font-bold"></span>
                                    </div>

                                    <div x-show="openModule" x-transition
                                        class="mt-4 space-y-4 pl-6 border-l-2 border-blue-300">
                                        @foreach ($module->classrooms as $classroom)
                                            <div x-data="{ openClass: false }"
                                                class="bg-white rounded-lg p-3 shadow-sm hover:shadow transition">
                                                <div class="flex items-center justify-between cursor-pointer"
                                                    @click="openClass = !openClass">
                                                    <h5 class="font-medium text-gray-700">{{ $classroom->title }}</h5>
                                                    <span x-text="openClass ? '-' : '+' "
                                                        class="text-gray-500 font-bold"></span>
                                                </div>

                                                <div x-show="openClass" x-transition class="mt-3 space-y-3 pl-6">
                                                    @foreach ($classroom->comments as $comment)
                                                        <div class="bg-gray-50 p-3 rounded border-l-2 border-gray-300">
                                                            <p class="text-gray-700">{{ $comment->comment }}</p>
                                                            <small class="text-gray-500">
                                                                {{ $comment->user->name }} -
                                                                {{ $comment->created_at->diffForHumans() }}
                                                            </small>

                                                            @php
                                                                $iAlreadyReplied = $comment->replies->contains(
                                                                    function ($r) {
                                                                        return $r->user_id === Auth::id();
                                                                    },
                                                                );
                                                            @endphp

                                                            @if (!$iAlreadyReplied)
                                                                <div class="mt-2">
                                                                    <a href="{{ route('comments.reply.show', $comment->uuid) }}"
                                                                        class="inline-block bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">
                                                                        Responder
                                                                    </a>
                                                                </div>
                                                            @endif

                                                            {{-- Replies do comentário --}}
                                                            @foreach ($comment->replies as $reply)
                                                                <div
                                                                    class="bg-gray-100 p-2 rounded border-l-2 border-gray-200 mt-2 ml-4">
                                                                    <p class="text-gray-700">{{ $reply->reply }}</p>
                                                                    <small class="text-gray-500">
                                                                        {{ $reply->user->name }} -
                                                                        {{ $reply->created_at->diffForHumans() }}
                                                                    </small>
                                                                </div>                                                               
                                                            @endforeach
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
