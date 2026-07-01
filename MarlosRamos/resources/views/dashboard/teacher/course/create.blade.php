<x-app-layout :title="$title">
    <x-slot name="header">
        <x-page-title title="Novo Curso" />
    </x-slot>

    <div class="py-8">
        <div class="mx-auto px-4 sm:px-6 lg:px-8 max-w-3xl">

            <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
                <a href="{{ route('course.index') }}" class="hover:text-gray-300 transition">Cursos</a>
                <i class="fa-solid fa-chevron-right text-xs text-gray-700"></i>
                <span class="text-gray-300">Novo Curso</span>
            </div>

            <div class="bg-gray-900 rounded-2xl border border-gray-800 shadow-xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-800 flex items-center gap-3">
                    <div class="w-1 h-6 bg-blue-500 rounded-full"></div>
                    <h2 class="text-base font-semibold text-gray-100">Cadastrar Novo Curso</h2>
                </div>

                @if ($errors->any())
                    <div class="px-6 pt-6">
                        <x-alert-component type="error">
                            <ul class="mb-0 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </x-alert-component>
                    </div>
                @endif

                <form method="POST" action="{{ route('course.store') }}" enctype="multipart/form-data" class="p-6 space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1.5">Título <span class="text-red-400">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" required
                            class="block w-full bg-gray-800 text-gray-100 border border-gray-700 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Preço (R$)</label>
                            <input type="number" name="price" step="0.01" min="0" value="{{ old('price') }}"
                                class="block w-full bg-gray-800 text-gray-100 border border-gray-700 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Link de Pagamento</label>
                            <input type="text" name="payment_link" value="{{ old('payment_link') }}"
                                class="block w-full bg-gray-800 text-gray-100 border border-gray-700 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1.5">Descrição</label>
                        <textarea name="description" rows="5"
                            class="block w-full bg-white text-gray-900 border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none">{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-400 mb-3 uppercase tracking-wide text-xs">Imagens</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div x-data="{ preview: null }">
                                <label class="block text-sm font-medium text-gray-300 mb-1.5">Imagem de Capa</label>
                                <label for="dropzone-cover"
                                    class="relative flex flex-col items-center justify-center w-full h-36 border-2 border-dashed rounded-xl cursor-pointer transition overflow-hidden"
                                    :class="preview ? 'border-blue-500/50' : 'border-gray-700 bg-gray-800 hover:border-gray-500'">
                                    <template x-if="!preview">
                                        <div class="flex flex-col items-center gap-2 text-gray-500 pointer-events-none">
                                            <i class="fa-solid fa-cloud-arrow-up text-2xl"></i>
                                            <div class="text-center">
                                                <p class="text-xs"><span class="font-medium text-blue-400">Clique para enviar</span></p>
                                                <p class="text-xs mt-0.5">PNG, JPG, GIF</p>
                                            </div>
                                        </div>
                                    </template>
                                    <template x-if="preview">
                                        <img :src="preview" class="absolute inset-0 w-full h-full object-contain p-1 pointer-events-none" />
                                    </template>
                                    <input type="file" id="dropzone-cover" name="image_cover" class="hidden" accept="image/*"
                                        @change="const f=$event.target.files[0];if(f){const r=new FileReader();r.onload=e=>preview=e.target.result;r.readAsDataURL(f)}else{preview=null}">
                                </label>
                            </div>

                            <div x-data="{ preview: null }">
                                <label class="block text-sm font-medium text-gray-300 mb-1.5">Imagem Banner</label>
                                <label for="dropzone-banner"
                                    class="relative flex flex-col items-center justify-center w-full h-36 border-2 border-dashed rounded-xl cursor-pointer transition overflow-hidden"
                                    :class="preview ? 'border-blue-500/50' : 'border-gray-700 bg-gray-800 hover:border-gray-500'">
                                    <template x-if="!preview">
                                        <div class="flex flex-col items-center gap-2 text-gray-500 pointer-events-none">
                                            <i class="fa-solid fa-cloud-arrow-up text-2xl"></i>
                                            <div class="text-center">
                                                <p class="text-xs"><span class="font-medium text-blue-400">Clique para enviar</span></p>
                                                <p class="text-xs mt-0.5">PNG, JPG, GIF</p>
                                            </div>
                                        </div>
                                    </template>
                                    <template x-if="preview">
                                        <img :src="preview" class="absolute inset-0 w-full h-full object-contain p-1 pointer-events-none" />
                                    </template>
                                    <input type="file" id="dropzone-banner" name="image_banner" class="hidden" accept="image/*"
                                        @change="const f=$event.target.files[0];if(f){const r=new FileReader();r.onload=e=>preview=e.target.result;r.readAsDataURL(f)}else{preview=null}">
                                </label>
                            </div>
                        </div>
                    </div>

                    <div x-data="{ preview: null }">
                        <label class="block text-sm font-medium text-gray-300 mb-1.5">Fundo do Certificado</label>
                        <label for="dropzone-cert"
                            class="relative flex flex-col items-center justify-center w-full h-36 border-2 border-dashed rounded-xl cursor-pointer transition overflow-hidden"
                            :class="preview ? 'border-blue-500/50' : 'border-gray-700 bg-gray-800 hover:border-gray-500'">
                            <template x-if="!preview">
                                <div class="flex flex-col items-center gap-2 text-gray-500 pointer-events-none">
                                    <i class="fa-solid fa-certificate text-2xl"></i>
                                    <div class="text-center">
                                        <p class="text-xs"><span class="font-medium text-blue-400">Clique para enviar</span></p>
                                        <p class="text-xs mt-0.5">JPEG, PNG, WEBP (max 5MB)</p>
                                    </div>
                                </div>
                            </template>
                            <template x-if="preview">
                                <img :src="preview" class="absolute inset-0 w-full h-full object-contain p-1 pointer-events-none" />
                            </template>
                            <input type="file" id="dropzone-cert" name="certificate_background" class="hidden" accept="image/*"
                                @change="const f=$event.target.files[0];if(f){const r=new FileReader();r.onload=e=>preview=e.target.result;r.readAsDataURL(f)}else{preview=null}">
                        </label>
                    </div>

                    <div>
                        <label class="flex items-center gap-3 cursor-pointer select-none">
                            <input type="checkbox" name="certificate_enabled" value="1" {{ old('certificate_enabled') ? 'checked' : '' }}
                                class="w-4 h-4 rounded border-gray-600 bg-gray-800 text-blue-600 focus:ring-blue-500">
                            <span class="text-sm text-gray-300">Habilitar certificado para este curso</span>
                        </label>
                    </div>

                    <div class="flex items-center justify-between pt-5 border-t border-gray-800 mt-2">
                        <a href="{{ route('course.index') }}"
                            class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-400 hover:text-gray-200 border border-gray-700 rounded-lg hover:border-gray-500 transition">
                            <i class="fa-solid fa-arrow-left text-xs"></i>
                            Cancelar
                        </a>
                        <button type="submit"
                            class="flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium rounded-lg transition">
                            <i class="fa-solid fa-floppy-disk"></i>
                            Salvar Curso
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>


