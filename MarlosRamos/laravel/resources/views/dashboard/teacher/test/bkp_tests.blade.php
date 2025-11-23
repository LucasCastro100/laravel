<x-app-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gerencimanto dos testes') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ openShow: false, openCreate: false, openEdit: false, openDelete: false, selectedCourse: null }">
        <div class="mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if (session('success'))
                    <x-alert-component type="success" :message="session('success')" />
                @endif

                @if (session('error'))
                    <x-alert-component type="error" :message="session('error')" />
                @endif

                {{-- <div class="text-right">
                    <button @click="openCreate = true" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">Novo
                        Teste</button>
                </div> --}}

                @if ($tests->isEmpty())
                    <div class="text-center text-gray-500">
                        Nenhum teste cadastrado.
                    </div>
                @else
                    <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($tests as $index => $course)
                            <div class="bg-white shadow-lg rounded-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-2 cursor-pointer relative"
                            onclick="window.location.href = '{{ route('course.show', ['uuid' => $course->uuid]) }}'">
                                <img src="{{ Storage::url($course->image) }}" alt="Imagem do curso"
                                    class="w-full h-48 object-cover">
                                <div class="p-4">
                                    <div class="absolute top-2 right-2 flex row items-center justify-center gap-2 p-1 bg-white border-2 border-gray-500 rounded-md text-black text-xs">
                                        <i class="fas fa-user"></i>                                        
                                        {{ $course->users_count }}
                                    </div>

                                    <h3 class="text-xl font-semibold text-gray-800">{{ $course->title }}</h3>
                                    <p class="text-gray-600 mt-2">{{ Str::limit($course->description, 100) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <template x-if="openCreate">
            <div class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 p-1" @click.stop>
                <div class="bg-white p-6 rounded-lg w-full max-w-2xl max-h-full">
                    <button @click="openCreate = false"
                        class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                        <i class="fa-solid fa-xmark"></i>
                    </button>

                    <h2 class="text-xl mb-4">Cadastrar Curso</h2>
                    <form method="POST" action="{{ route('course.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 md:gap-6 gap-1">
                            <div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 font-medium">Título</label>
                                    <input type="text" name="title"
                                        class="w-full border border-gray-300 p-2 rounded">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-gray-700 font-medium">Descrição</label>
                                    <textarea name="description" class="w-full border border-gray-300 p-2 rounded"></textarea>
                                </div>
                            </div>

                            <div class="mb-4 relative">
                                <label class="block text-gray-700 font-medium">Imagem de capa</label>
                                <label for="dropzone-file"
                                    class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                    <div class="flex flex-col items-center justify-center p-4">
                                        <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Clique para o
                                                upload</span></p>
                                        <p class="text-xs text-gray-500">SVG, PNG, JPG or GIF</p>
                                    </div>
                                    <input id="dropzone-file" type="file" class="hidden" name="image"
                                        accept="image/*" onchange="previewImage(event)" />

                                    <!-- Pré-visualização da imagem dentro da área de dropzone -->
                                    <div id="image-preview-container"
                                        class="absolute inset-0 flex items-center justify-center hidden h-100 pt-5">
                                        <img id="image-preview" class="w-full h-full object-contain rounded-lg pt-1"
                                            alt="Pré-visualização da Imagem" />
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="button" @click="openCreate = false"
                                class="bg-red-500 text-white px-4 py-2 rounded mr-2">Fechar</button>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </div>
</x-app-layout>

<script>
    function previewImage(event) {
        const file = event.target.files[0]; // Obter o arquivo selecionado
        const reader = new FileReader();

        reader.onload = function(e) {
            const previewImage = document.getElementById('image-preview');
            const previewContainer = document.getElementById('image-preview-container');

            // Definir a imagem como pré-visualização
            previewImage.src = e.target.result;

            // Mostrar a imagem dentro da área de dropzone
            previewContainer.classList.remove('hidden');
        }

        reader.readAsDataURL(file); // Ler a imagem como URL base64
    }
</script>
