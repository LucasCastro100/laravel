<x-app-layout :title="$title">
    <x-slot name="header">
        <x-page-title title="Gerencimanto dos cursos" />
    </x-slot>

    {{-- @php dd(session()->all()) @endphp --}}

    <div class="py-12" x-data="{ openShow: false, openCreate: false, openEdit: false, openDelete: false, selectedCourse: null }">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if (session('success'))
                    <x-alert-component type="success" :message="session('success')" />
                @endif

                @if (session('error'))
                    <x-alert-component type="error" :message="session('error')" />
                @endif

                @if ($errors->any())
                    <x-alert-component type="error">
                        <ul class="mb-0 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </x-alert-component>
                @endif

                <div class="text-right">
                    <x-action-button variant="primary" @click="openCreate = true" class="mb-4">Novo Curso</x-action-button>
                </div>

                @if ($courses->isEmpty())
                    <x-empty-state title="Nenhum curso cadastrado." message="Crie o primeiro curso para começar a publicar aulas e materiais." />
                @else
                    <div class="grid sm:grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach ($courses as $course)
                            <x-course-card
                                title="{{ $course->title }}"
                                description="{{ $course->description }}"
                                image="{{ Storage::url($course->image_cover) }}"
                                count="{{ $course->users_count }}"
                                href="{{ route('course.show', ['uuid' => $course->uuid]) }}"
                            />
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <template x-if="openCreate">
            <div class="fixed inset-0 bg-gray-950 bg-opacity-75" @click.stop>
                <div class="flex h-full items-center justify-center p-2 sm:p-4">
                    <div class="bg-gray-950 p-4 sm:p-6 rounded-lg w-full max-w-2xl my-4 max-h-[90%] overflow-y-auto custom-scrollbar">
                        <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl">Cadastrar Curso</h2>
                        <button @click="openCreate = false"
                            class="text-gray-200 hover:text-gray-200">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <form method="POST" action="{{ route('course.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-200">Título</label>
                            <input type="text" name="title"
                                class="mt-1 block w-full px-3 py-2 bg-gray-950 text-gray-200 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-[1fr_2fr] gap-4 mt-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-200">Preço (R$)</label>
                                <input type="number" name="price" step="0.01" min="0"
                                    class="mt-1 block w-full px-3 py-2 bg-gray-950 text-gray-200 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-200">Link pagamento</label>
                                <input type="text" name="payment_link"
                                    class="mt-1 block w-full px-3 py-2 bg-gray-950 text-gray-200 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-200">Descrição</label>
                            <textarea name="description" rows="8" class="mt-1 block w-full px-3 py-2 bg-gray-950 text-gray-200 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 mt-4">
                            <div class="relative flex-1 min-w-0">
                                <label class="block text-sm font-medium text-gray-200 mb-1">Imagem de capa</label>
                                <label for="dropzone-cover"
                                    class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-950 hover:bg-gray-900">
                                    <div class="flex flex-col items-center justify-center p-3">
                                        <svg class="w-6 h-6 mb-2 text-gray-200" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                        </svg>
                                        <p class="mb-1 text-xs text-gray-200"><span class="font-semibold">Clique para upload</span></p>
                                        <p class="text-xs text-gray-200">SVG, PNG, JPG ou GIF</p>
                                    </div>
                                    <input id="dropzone-cover" type="file" class="hidden" name="image_cover"
                                        accept="image/*" onchange="window.previewImage(event, { previewImageId: 'image-cover-preview', previewContainerId: 'image-cover-preview-container' })" />
                                    <div id="image-cover-preview-container"
                                        class="absolute inset-0 hidden flex items-center justify-center">
                                        <img id="image-cover-preview" class="w-full h-full object-contain rounded-lg p-1"
                                            alt="Pré-visualização da Capa" />
                                    </div>
                                </label>
                            </div>

                            <div class="relative flex-1 min-w-0">
                                <label class="block text-sm font-medium text-gray-200 mb-1">Imagem banner</label>
                                <label for="dropzone-banner"
                                    class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-950 hover:bg-gray-900">
                                    <div class="flex flex-col items-center justify-center p-3">
                                        <svg class="w-6 h-6 mb-2 text-gray-200" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                        </svg>
                                        <p class="mb-1 text-xs text-gray-200"><span class="font-semibold">Clique para upload</span></p>
                                        <p class="text-xs text-gray-200">SVG, PNG, JPG ou GIF</p>
                                    </div>
                                    <input id="dropzone-banner" type="file" class="hidden" name="image_banner"
                                        accept="image/*" onchange="window.previewImage(event, { previewImageId: 'image-banner-preview', previewContainerId: 'image-banner-preview-container' })" />
                                    <div id="image-banner-preview-container"
                                        class="absolute inset-0 hidden flex items-center justify-center">
                                        <img id="image-banner-preview" class="w-full h-full object-contain rounded-lg p-1"
                                            alt="Pré-visualização do Banner" />
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-4">
                            <button type="button" @click="openCreate = false"
                                class="bg-red-500 text-white px-4 py-2 rounded">Fechar</button>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Salvar</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </template>
    </div>
</x-app-layout>
