<x-app-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $course->title }} / {{ $module_current->title }} / {{ $title }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if (session('success'))
                    <div class="bg-green-500 text-white p-4 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-500 text-white p-4 rounded mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="py-12">
                    <div class="mx-auto sm:px-6 lg:px-8">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 w-full">
                            <div class="col-span-1 lg:col-span-2" x-data @resize.window="$store.video.calcHeight()" x-init="$store.video.calcHeight()">
                                <iframe :height="$store.video.height" src="https://www.youtube.com/embed/{{ $videoId }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen class="w-full"></iframe>
                            </div>

                            <div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('video', {
            height: 0,
            calcHeight() {
                const width = window.innerWidth;
                this.height = width >= 1024 ? 500 : width >= 992 ? 265 : width >= 768 ? 280 : 230;
            }
        });
    });
</script>
