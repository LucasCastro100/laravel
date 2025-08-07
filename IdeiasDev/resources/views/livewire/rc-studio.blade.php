<div class="bg-black text-white">
    {{-- VIDEO --}}
    <section style="background-image: url('{{ asset('storage/rc-studio/usando/fundo-dobra-1.webp') }}')"
        class="relative bg-auto bg-center bg-no-repeat">

        <div class="max-w-4xl mx-auto p-4 text-center space-y-6">

            <header class="text-center">
                <h1 class="font-ethnocentric text-2xl lg:text-4xl mb-2">Orquestre o Show Perfeito, Faça as suas produções impressionarem
                    de verdade</h1>

                <h2 class="font-bebas text-xl lg:text-3xl">O Shows Pro é o pack de samples e efeitos que vai mudar sua maneira de produzir! Eleve o nivel da sua produção do dia pra noite!</h2>
            </header>

            <div class="relative w-full" style="padding-top: 56.25%;">
                <iframe class="absolute top-0 left-0 w-full h-full border-4 border-blue-600 rounded-lg"
                    src="https://www.youtube.com/embed/k18wZeXXL1c" title="Lorem ipsum video" frameborder="0"
                    loading="lazy"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                </iframe>
            </div>

            <button
                class="px-8 py-3 font-bold text-white rounded 
                   bg-gradient-to-r from-[#b70202] to-[#ff1414] 
                   shadow-[0_0_20px_#ff1414]
                   transform transition-transform duration-300 
                   hover:scale-105">
                GARANTIR O SHOWS PRO AGORA
            </button>


            <div class="w-full flex justify-center">
                <img src="{{ asset('storage/rc-studio/usando/pagamento.webp') }}" alt="Imagem ilustrativa lorem ipsum"
                    title="Imagem ilustrativa lorem ipsum" class="max-w-full rounded shadow-md" loading="lazy"
                    decoding="async" fetchpriority="low" />
            </div>
        </div>
    </section>

    {{-- DESCRICAO PACK --}}
    <section style="background-image: url('{{ asset('storage/rc-studio/usando/fundo-dobra-2.webp') }}')"
        class="relative bg-auto bg-center bg-no-repeat">
        <div class="max-w-4xl mx-auto p-4 text-center space-y-6">

            <hr class="mx-auto w-[50%] h-1 bg-gray-400 rounded" aria-hidden="true" />

            <h2 id="descricao-pack" class="font-bebas text-xl lg:text-3xl">Você é produtor, músico ou cantor e sabe:</h2>

            <ul class="text-lg md:text-xl text-gray-200 mb-8 space-y-4">
                <li class="flex items-start gap-3">
                    <i class="fas fa-music text-white-400 mt-1" aria-hidden="true"></i>
                    <span>A <span class="text-white font-bold">abertura decide</span> se a plateia vai arrepiar… ou abrir o Instagram.</span>
                </li>
                <li class="flex items-start gap-3">
                    <i class="fas fa-music text-white-400 mt-1" aria-hidden="true"></i>
                    <span>Sem um impacto inicial, o show inteiro <span class="text-white font-bold">luta em
                            ladeira.</span></span>
                </li>
            </ul>

            <!-- Alerta de dor -->
            <div class="bg-red-100 border border-red-300 text-red-800 px-6 py-4 rounded-lg font-semibold mb-8 w-full">
                <p class="mb-2">Chega de não saber por onde começar.</p>
                <p class="mb-2">Chega de intros e samples genéricos copiados do YouTube.</p>
                <p>Chega de passar horas mixando e ainda assim sempre “<span class="italic">falta algo</span>”.</p>
            </div>

            <!-- Dor reforçada -->
            <p class="text-xl md:text-2xl text-gray-300 mb-10 text-center">
                Muitas vezes você terá <span class="text-white font-bold">apenas segundos</span> para provar que não
                veio brincar!
            </p>

            <button
                class="px-8 py-3 font-bold text-white rounded 
                   bg-gradient-to-r from-[#b70202] to-[#ff1414] 
                   shadow-[0_0_20px_#ff1414]
                   transform transition-transform duration-300 
                   hover:scale-105">
                GARANTIR O SHOWS PRO AGORA
            </button>
        </div>
    </section>

    {{-- CARDS SOBRE OS PACK --}}
    <section style="background-image: url('{{ asset('storage/rc-studio/usando/fundo-dobra-3.webp') }}')"
        class="relative bg-auto bg-center bg-no-repeat">
        <div class="max-w-4xl mx-auto p-4 text-center space-y-6">
            <hr class="mx-auto w-[50%] h-1 bg-gray-400 rounded" aria-hidden="true" />

            <h2 id="cards-pack" class="font-bebas text-xl lg:text-3xl">Tudo que você precisa está dentro do Pack 🎶SHOWS PRO!🎶
            </h2>

            <div class="grid grid-cols-1 gap-6">
                <!-- Card 1 -->
                <article
                    class="bg-gray-900 border border-white rounded-2xl shadow-md p-4 grid grid-cols-1 md:grid-cols-3 items-center gap-4"
                    role="group">

                    <!-- Imagem -->
                    <img src="/storage/rc-studio/usando/card-samples.webp" alt="Imagem do Card 1"
                        title="Imagem do Card 1" class="w-full h-48 object-cover rounded md:h-full" loading="lazy"
                        decoding="async" fetchpriority="low" />

                    <!-- Texto -->
                    <div class="md:col-span-2 text-left">
                        <h3 class="text-lg font-semibold mb-2">Lorem ipsum</h3>
                        <p class="text-sm">Lorem ipsum dolor sit amet.</p>
                    </div>
                </article>

                <!-- Card 2 (invertido) -->
                <article
                    class="bg-gray-900 border border-white rounded-2xl shadow-md p-4 grid grid-cols-1 md:grid-cols-3 items-center gap-4"
                    role="group">

                    <!-- Texto -->
                    <div class="md:col-span-2 text-left md:order-1">
                        <h3 class="text-lg font-semibold mb-2">Lorem ipsum</h3>
                        <p class="text-sm">Lorem ipsum dolor sit amet.</p>
                    </div>

                    <!-- Imagem -->
                    <img src="/storage/rc-studio/usando/card-fx.webp" alt="Imagem do Card 2" title="Imagem do Card 2"
                        class="w-full h-48 object-cover rounded md:h-full md:order-2" loading="lazy" decoding="async"
                        fetchpriority="low" />
                </article>

                <!-- Card 3 -->
                <article
                    class="bg-gray-900 border border-white rounded-2xl shadow-md p-4 grid grid-cols-1 md:grid-cols-3 items-center gap-4"
                    role="group">

                    <!-- Imagem -->
                    <img src="/storage/rc-studio/usando/card-loops.webp" alt="Imagem do Card 3" title="Imagem do Card 3"
                        class="w-full h-48 object-cover rounded md:h-full" loading="lazy" decoding="async"
                        fetchpriority="low" />

                    <!-- Texto -->
                    <div class="md:col-span-2 text-left">
                        <h3 class="text-lg font-semibold mb-2">Lorem ipsum</h3>
                        <p class="text-sm">Lorem ipsum dolor sit amet.</p>
                    </div>
                </article>
            </div>

            <button
                class="px-8 py-3 font-bold text-white rounded 
                   bg-gradient-to-r from-[#b70202] to-[#ff1414] 
                   shadow-[0_0_20px_#ff1414]
                   transform transition-transform duration-300 
                   hover:scale-105">
                GARANTIR O SHOWS PRO AGORA
            </button>
        </div>
    </section>

    {{-- FALANDO SOBRE OS PACK --}}
    <section class="relative">
        <div class="max-w-4xl mx-auto p-4 text-center space-y-6">
            <hr class="mx-auto w-[50%] h-1 bg-gray-400 rounded" aria-hidden="true" />

            <h2 id="falando-pack" class="text-2xl font-semibold">Lorem ipsum</h2>

            <p class="text-base leading-relaxed">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua.
            </p>

            <div class="grid gap-6 p-6">
                <!-- Card 1 -->
                <div
                    class="grid grid-cols-1 md:grid-cols-2 bg-gray-900 border border-gray-700 rounded-lg p-6 items-center gap-6">
                    <div>
                        <h3 class="text-red-500 text-xl font-bold mb-3">Lorem ipsum</h3>
                        <ul class="list-disc list-inside text-green-400 text-sm mb-4 space-y-1">
                            <li>Lorem ipsum dolor sit amet</li>
                            <li>Consectetur adipiscing elit</li>
                            <li>Donec vitae sapien ut libero</li>
                            <li>Curabitur ullamcorper ultricies nisi</li>
                        </ul>
                        <p class="text-sm">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus
                            tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor.
                        </p>
                    </div>
                    <div class="flex justify-center">
                    </div>
                </div>

                <!-- Card 2 -->
                <div
                    class="grid grid-cols-1 md:grid-cols-2 bg-gray-900 border border-gray-700 rounded-lg p-6 items-center gap-6">
                    <div>
                        <h3 class="text-orange-400 text-xl font-bold mb-3">Lorem ipsum</h3>
                        <p class="text-sm mb-4">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce dapibus, tellus ac cursus
                            commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.
                        </p>
                        <p class="text-sm">
                            Sed posuere consectetur est at lobortis. Aenean lacinia bibendum nulla sed consectetur.
                        </p>
                    </div>
                    <div class="flex justify-center">
                    </div>
                </div>

                <!-- Card 3 -->
                <div
                    class="grid grid-cols-1 md:grid-cols-2 bg-gray-900 border border-gray-700 rounded-lg p-6 items-center gap-6">
                    <div>
                        <h3 class="text-pink-500 text-xl font-bold mb-3">Lorem ipsum</h3>
                        <p class="text-sm mb-4">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sagittis lacus vel augue
                            laoreet rutrum faucibus dolor auctor.
                        </p>
                        <p class="text-sm">
                            Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum.
                        </p>
                    </div>
                    <div class="flex justify-center">
                    </div>
                </div>
            </div>

            <button
                class="px-8 py-3 font-bold text-white rounded 
                   bg-gradient-to-r from-[#b70202] to-[#ff1414] 
                   shadow-[0_0_20px_#ff1414]
                   transform transition-transform duration-300 
                   hover:scale-105">
                GARANTIR O SHOWS PRO AGORA
            </button>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6">
                <!-- Coluna esquerda -->
                <div class="border border-red-700 rounded-lg p-6 bg-gray-900">
                    <h3 class="text-white text-lg font-semibold mb-4">Lorem ipsum</h3>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-start gap-2"><span class="text-red-500 text-xl">❌</span> Lorem ipsum
                            dolor sit amet.</li>
                        <li class="flex items-start gap-2"><span class="text-red-500 text-xl">❌</span> Lorem ipsum
                            dolor sit amet.</li>
                        <li class="flex items-start gap-2"><span class="text-red-500 text-xl">❌</span> Lorem ipsum
                            dolor sit amet.</li>
                        <li class="flex items-start gap-2"><span class="text-red-500 text-xl">❌</span> Lorem ipsum
                            dolor sit amet.</li>
                    </ul>
                </div>

                <!-- Coluna direita -->
                <div class="border border-green-600 rounded-lg p-6 bg-gray-900">
                    <h3 class="text-white text-lg font-semibold mb-4">Lorem ipsum</h3>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-start gap-2"><span class="text-green-400 text-xl">✅</span> Lorem
                            ipsum
                            dolor sit amet.</li>
                        <li class="flex items-start gap-2"><span class="text-green-400 text-xl">✅</span> Lorem
                            ipsum
                            dolor sit amet.</li>
                        <li class="flex items-start gap-2"><span class="text-green-400 text-xl">✅</span> Lorem
                            ipsum
                            dolor sit amet.</li>
                        <li class="flex items-start gap-2"><span class="text-green-400 text-xl">✅</span> Lorem
                            ipsum
                            dolor sit amet.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- VALORES --}}
    <section class="relative">
        <div class="max-w-4xl mx-auto p-4 text-center space-y-6">
            <hr class="mx-auto w-[50%] h-1 bg-gray-400 rounded" aria-hidden="true" />

            <h2 id="valores" class="text-2xl font-semibold">Lorem ipsum dolor sit amet</h2>
            <h3 class="text-xl font-semibold">Lorem ipsum consectetur</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                <!-- Oferta Básica -->
                <div class="bg-gray-900 border border-gray-700 p-6 rounded-lg flex flex-col text-center shadow-lg">
                    <h2 class="text-2xl font-bold mb-2">Lorem ipsum</h2>
                    <ul class="text-sm mb-4 space-y-1">
                        <li>✅ Lorem ipsum pack <span class="line-through text-red-500">R$00</span></li>
                        <li>✅ Lorem ipsum presets <span class="line-through text-red-500">R$00</span></li>
                    </ul>
                    <div class="mt-auto flex flex-col items-center">
                        <p class="text-xs text-gray-400 mb-2">De <span class="line-through text-red-500">R$00</span>
                            por apenas:</p>
                        <p class="text-3xl font-bold text-green-500 mb-4">R$00</p>
                        <button class="bg-white text-black font-bold px-4 py-2 rounded hover:bg-gray-300 transition">EU
                            QUERO A OFERTA BÁSICA</button>
                        <p class="text-xs mt-2 text-gray-400">ou 12x de <strong>R$00</strong></p>
                    </div>
                </div>

                <!-- Oferta Advanced -->
                <div class="bg-gray-900 border border-gray-700 p-6 rounded-lg flex flex-col text-center shadow-lg">
                    <h2 class="text-2xl font-bold mb-2">Lorem ipsum advanced</h2>
                    <ul class="text-sm mb-4 space-y-1">
                        <li>✅ Lorem ipsum pack <span class="line-through text-red-500">R$00</span></li>
                        <li>✅ Lorem ipsum presets <span class="line-through text-red-500">R$00</span></li>
                        <li>✅ Lorem ipsum aulas <span class="line-through text-red-500">R$00</span></li>
                        <li>✅ Lorem ipsum networking <span class="text-red-500 italic">inacreditável</span></li>
                        <li>✅ Lorem ipsum exclusivas <span class="line-through text-red-500">R$00</span></li>
                    </ul>
                    <div class="mt-auto flex flex-col items-center">
                        <p class="text-xs text-gray-400 mb-2">De <span class="line-through text-red-500">R$00</span>
                            por apenas:</p>
                        <p class="text-3xl font-bold text-green-500 mb-4">R$00</p>
                        <button class="bg-white text-black font-bold px-4 py-2 rounded hover:bg-gray-300 transition">EU
                            QUERO A OFERTA ADVANCED</button>
                        <p class="text-xs mt-2 text-gray-400">ou 12x de <strong>R$00</strong></p>
                    </div>
                </div>

                <!-- Oferta Premium -->
                <div
                    class="bg-gray-900 bg-gradient-to-br from-orange-600 via-red-600 to-yellow-400 p-1 rounded-lg shadow-xl md:col-span-2 lg:col-span-1 md:mx-auto lg:m-0">
                    <div class="bg-gray-900 p-6 rounded-lg text-center flex flex-col h-full">
                        <span class="bg-green-500 text-black text-xs font-bold px-3 py-1 rounded-full mb-2">MAIS
                            VENDIDO</span>
                        <h2 class="text-2xl font-bold text-orange-400 mb-2">Lorem ipsum premium</h2>
                        <ul class="text-sm mb-4 space-y-1 text-left">
                            <li>✅ Lorem ipsum pack <span class="line-through text-red-500">R$00</span></li>
                            <li>✅ Lorem ipsum presets <span class="line-through text-red-500">R$00</span></li>
                            <li>✅ Lorem ipsum docs <span class="line-through text-red-500">R$00</span></li>
                            <li>✅ Lorem ipsum atualizações <span class="line-through text-red-500">R$00</span></li>
                            <li>✅ Lorem ipsum aulas <span class="line-through text-red-500">R$00</span></li>
                            <li>✅ Lorem ipsum trabalhos <span class="text-red-500">🔥</span></li>
                            <li>✅ Lorem ipsum networking <span class="text-red-500 italic">inacreditável</span></li>
                            <li>✅ Lorem ipsum legendas <span class="line-through text-red-500">R$00</span></li>
                        </ul>
                        <div class="mt-auto flex flex-col items-center">
                            <p class="text-xs mb-2">De <span class="line-through text-red-500">R$00</span> por apenas:
                            </p>
                            <p class="text-3xl font-bold text-green-300 mb-4">R$00</p>
                            <button
                                class="bg-red-500 hover:bg-red-700 text-white font-bold px-4 py-2 rounded transition">EU
                                QUERO A OFERTA PREMIUM</button>
                            <p class="text-xs mt-2 text-gray-400">ou 12x de <strong>R$00</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="relative">
        <div class="max-w-4xl mx-auto p-4 text-center space-y-6">
            <hr class="mx-auto w-[50%] h-1 bg-gray-400 rounded" aria-hidden="true" />
            <h2 class="text-2xl font-semibold">Lorem ipsum</h2>

            <div class="text-left" x-data="{ open: [] }">
                <h2 class="text-2xl font-bold mb-6">Perguntas mais frequentes:</h2>

                <!-- Item 1 -->
                <div class="border-b border-gray-300 py-4">
                    <button @click="open.includes(1) ? open = open.filter(i => i !== 1) : open.push(1)"
                        class="flex justify-between w-full text-left text-red-500 font-semibold text-sm">
                        <span>🔸 Lorem ipsum dolor sit amet?</span>
                        <i aria-hidden="true" :class="open.includes(1) ? 'fa-solid fa-minus' : 'fa-solid fa-plus'"></i>
                    </button>
                    <div x-show="open.includes(1)" x-transition class="mt-2 text-sm">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua.
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="border-b border-gray-300 py-4">
                    <button @click="open.includes(2) ? open = open.filter(i => i !== 2) : open.push(2)"
                        class="flex justify-between w-full text-left text-red-500 font-semibold text-sm">
                        <span>🔸 Lorem ipsum consectetur adipiscing?</span>
                        <i aria-hidden="true" :class="open.includes(2) ? 'fa-solid fa-minus' : 'fa-solid fa-plus'"></i>
                    </button>
                    <div x-show="open.includes(2)" x-transition class="mt-2 text-sm">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua.
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="border-b border-gray-300 py-4">
                    <button @click="open.includes(3) ? open = open.filter(i => i !== 3) : open.push(3)"
                        class="flex justify-between w-full text-left text-red-500 font-semibold text-sm">
                        <span>🔸 Lorem ipsum dolor sit?</span>
                        <i aria-hidden="true" :class="open.includes(3) ? 'fa-solid fa-minus' : 'fa-solid fa-plus'"></i>
                    </button>
                    <div x-show="open.includes(3)" x-transition class="mt-2 text-sm">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    </div>
                </div>

                <!-- Item 4 -->
                <div class="border-b border-gray-300 py-4">
                    <button @click="open.includes(4) ? open = open.filter(i => i !== 4) : open.push(4)"
                        class="flex justify-between w-full text-left text-red-500 font-semibold text-sm">
                        <span>🔸 Lorem ipsum sit amet, consectetur?</span>
                        <i aria-hidden="true" :class="open.includes(4) ? 'fa-solid fa-minus' : 'fa-solid fa-plus'"></i>
                    </button>
                    <div x-show="open.includes(4)" x-transition class="mt-2 text-sm">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore.
                    </div>
                </div>

                <!-- Item 5 -->
                <div class="border-b border-gray-300 py-4">
                    <button @click="open.includes(5) ? open = open.filter(i => i !== 5) : open.push(5)"
                        class="flex justify-between w-full text-left text-red-500 font-semibold text-sm">
                        <span>🔸 Lorem ipsum dolor sit amet?</span>
                        <i aria-hidden="true" :class="open.includes(5) ? 'fa-solid fa-minus' : 'fa-solid fa-plus'"></i>
                    </button>
                    <div x-show="open.includes(5)" x-transition class="mt-2 text-sm">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore.
                    </div>
                </div>

                <!-- Item 6 -->
                <div class="border-b border-gray-300 py-4">
                    <button @click="open.includes(6) ? open = open.filter(i => i !== 6) : open.push(6)"
                        class="flex justify-between w-full text-left text-red-500 font-semibold text-sm">
                        <span>🔸 Lorem ipsum dolor sit amet, consectetur?</span>
                        <i aria-hidden="true" :class="open.includes(6) ? 'fa-solid fa-minus' : 'fa-solid fa-plus'"></i>
                    </button>
                    <div x-show="open.includes(6)" x-transition class="mt-2 text-sm">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- QUEM SOU --}}
    <section class="relative">
        <div class="max-w-4xl mx-auto p-4 text-center space-y-6">
            <hr class="mx-auto w-[50%] h-1 bg-gray-400 rounded" aria-hidden="true" />
             <h2 class="text-2xl font-semibold text-center md:text-left">Lorem ipsum</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center text-left">
                <div>                   
                    <p class="text-base leading-relaxed">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua.
                    </p>
                </div>

                <div class="flex justify-center">
                    <img src="{{ asset('storage/rc-studio/usando/rafa-quem-sou-eu.webp') }}"
                        alt="Imagem ilustrativa lorem ipsum" title="Imagem ilustrativa lorem ipsum"
                        class="rounded shadow-md w-full max-w-xs" loading="lazy" decoding="async"
                        fetchpriority="low" />
                </div>
            </div>
        </div>
    </section>

    {{-- FALE CONOSCO --}}
    <section class="relative">
        <div class="max-w-4xl mx-auto p-4 text-center space-y-6">
            <hr class="mx-auto w-[50%] h-1 bg-gray-400 rounded" aria-hidden="true" />

            <h2 class="text-2xl font-semibold">Lorem ipsum dolor?</h2>

            <a href="https://wa.me/5534991256642" target="_blank" rel="noopener noreferrer"
                class="inline-block bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700 transition"
            >
                Entrar em contato via WhatsApp
            </a>

            <div class="mt-4" role="contentinfo">
                <p>Lorem ipsum</p>
                <p class="text-sm">© 2025 - Todos os direitos reservados</p>
            </div>
        </div>
    </section>
</div>
