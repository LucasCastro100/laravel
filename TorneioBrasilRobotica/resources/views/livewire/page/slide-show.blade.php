<div x-data="{
    slideIndex: @entangle('currentSlide'),
    slides: {{ json_encode($slides) }},
    isFirst() { return this.slideIndex === 0; },
    isLast() { return this.slideIndex === this.slides.length - 1; }
}" class="relative w-full h-full bg-white flex items-center justify-center overflow-hidden"
    style="background-image: url('{{ asset('storage/tbr/image/bg_pptx.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <template x-for="(slide, index) in slides" :key="index">
        <div x-show="slideIndex === index" x-transition
            class="absolute inset-0 flex flex-col items-center justify-center px-8 text-center bg-black bg-opacity-30 overflow-hidden"
            style="max-height: 100vh;">
            <h1 class="text-8xl font-bold mb-6 text-white max-w-4xl mx-auto"
                x-text="slide.categoryLabel + ' - ' + slide.modalidadeLabel"></h1>
            <h5 class="text-8xl text-yellow-500 mb-4 max-w-3xl mx-auto" x-text="slide.posNumber + 'º Lugar'"></h5>
            <h5 class="text-8xl text-blue-400 font-semibold max-w-3xl mx-auto" x-text="slide.teamName ?? ''"></h5>
        </div>
    </template>

    {{-- Botão Voltar (escondido no primeiro slide) --}}
    <button x-show="!isFirst()" wire:click="prev"
        class="absolute left-8 top-1/2 transform -translate-y-1/2 px-4 py-3 bg-gray-800 bg-opacity-70 text-white rounded hover:bg-gray-700 transition"
        aria-label="Anterior" style="display: none;" x-transition.opacity>
        <i class="fas fa-chevron-left fa-lg"></i>
    </button>

    <button x-show="!isLast()" wire:click="next"
        class="absolute right-8 top-1/2 transform -translate-y-1/2 px-4 py-3 bg-gray-800 bg-opacity-70 text-white rounded hover:bg-gray-700 transition"
        aria-label="Próximo" style="display: none;" x-transition.opacity>
        <i class="fas fa-chevron-right fa-lg"></i>
    </button>
</div>
