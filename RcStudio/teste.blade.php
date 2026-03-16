<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Meta Tags -->
    <title>Título da Página</title>
    <meta name="description" content="Descrição da página aqui">
    <meta name="keywords" content="música, produção musical, intros, beats, artista, cantor">
    <meta name="author" content="Seu Nome ou Marca">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Título para redes sociais" />
    <meta property="og:description" content="Descrição para redes sociais" />
    <meta property="og:image" content="URL_DA_IMAGEM" />
    <meta property="og:url" content="https://rcstudio.com.br/" />
    <meta property="og:type" content="website" />

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Título para Twitter" />
    <meta name="twitter:description" content="Descrição para Twitter" />
    <meta name="twitter:image" content="URL_DA_IMAGEM" />
    <meta name="twitter:url" content="https://rcstudio.com.br/" />

    <!-- Fonte -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


    <!-- Ícones -->
    <script src="https://kit.fontawesome.com/5ae086a3a0.js" crossorigin="anonymous"></script>

    <style>
        section {
            padding: 1rem 0;
        }

        #site-header,
        #site-footer {
            display: none
        }

        .elementor embed,
        .elementor iframe,
        .elementor object,
        .elementor video {
            border: auto !important;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        @keyframes scroll {
            0% {
                transform: translateX(0);
            }

            /* Ajuste o valor do calc para bater com o seu gap (0.5rem = gap-4, 1.5rem = gap-6) */
            100% {
                transform: translateX(calc(-50% - 0.75rem));
            }
        }

        .animate-scroll {
            animation: scroll 60s linear infinite;
            /* Aumentei para 45s para ficar mais elegante */
        }

        .pause-hover:hover {
            animation-play-state: paused;
            /* O carrossel para quando o usuário coloca o mouse em cima */
        }
    </style>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans antialiased">
    <div class="bg-black text-white space-y-2">
        <section style="background-image: url('/assets/images/fundo-dobra-1.webp')" aria-labelledby="video-heading"
            class="relative bg-auto bg-center bg-no-repeat" role="region">

            <div class="max-w-5xl mx-auto p-4 text-center space-y-6">

                <header class="text-center">
                    <h1 id="video-heading" class="font-ethocentric text-2xl lg:text-4xl mb-2" tabindex="0">
                        Orquestre o Show Perfeito, Faça as suas produções impressionarem de verdade
                    </h1>

                    <h2 class="font-bebas text-2xl lg:text-4xl" tabindex="0">
                        O Shows Pro é o pack de samples e efeitos que vai mudar sua maneira de produzir! Eleve o nível
                        da
                        sua produção do dia pra noite!
                    </h2>
                </header>

                <div class="relative w-full" style="padding-top: 56.25%;">
                    <iframe class="absolute top-0 left-0 w-full h-full border-4 border-blue-600 rounded-lg"
                        style="border-width: 4px; border-radius: 0.5rem; --tw-border-opacity: 1;
                    border-color: rgb(37 99 235 / var(--tw-border-opacity, 1));"
                        src="https://www.youtube.com/embed/oNJCRjqjQa8"
                        title="Vídeo promocional do Shows Pro explicando os benefícios do pack"
                        aria-label="Vídeo explicativo do produto Shows Pro" frameborder="0" loading="lazy"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                    </iframe>
                </div>

                <button onclick="document.getElementById('valores').scrollIntoView({ behavior: 'smooth' })"
                    class="px-8 py-3 font-bold text-white rounded
               bg-gradient-to-r from-[#8b0000] to-[#b22222]
               shadow-[0_0_20px_#b22222]
               transform transition-transform duration-300
               hover:scale-105 hover:brightness-110
               focus:outline-none focus:ring-4 focus:ring-red-700 focus:ring-opacity-60"
                    aria-label="Botão para garantir o produto Shows Pro">
                    GARANTIR O SHOWS PRO AGORA
                </button>


                <div class="w-full flex justify-center">
                    <img src="/assets/images/pagamento.webp" alt="Meios de pagamento aceitos para adquirir o Shows Pro"
                        title="Formas de pagamento disponíveis" class="max-w-full rounded shadow-md" loading="lazy"
                        decoding="async" fetchpriority="low" />
                </div>
            </div>
        </section>

        <section style="background-image: url('/assets/images/fundo-dobra-2.webp')" aria-labelledby="descricao-pack"
            class="relative bg-auto bg-center bg-no-repeat" role="region">

            <div class="max-w-5xl mx-auto p-4 text-center space-y-6">

                <h2 id="descricao-pack" class="font-bebas text-2xl lg:text-4xl" tabindex="0">
                    Você é produtor, músico ou cantor e sabe:
                </h2>

                <ul class="text-lg md:text-xl text-gray-200 mb-8 space-y-4"
                    aria-label="Lista de dores e desafios comuns">
                    <li class="flex items-start gap-3">
                        <i class="fas fa-music text-white-400 mt-1" aria-hidden="true"></i>
                        <span>
                            A <span class="text-white font-bold">abertura decide</span> se a plateia vai arrepiar… ou
                            abrir
                            o Instagram.
                        </span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-music text-white-400 mt-1" aria-hidden="true"></i>
                        <span>
                            Sem um impacto inicial, o show inteiro <span class="text-white font-bold">luta em
                                ladeira.</span>
                        </span>
                    </li>
                </ul>

                <!-- Alerta de dor -->
                <div class="bg-red-100 border border-red-300 text-red-800 px-6 py-4 rounded-lg font-semibold mb-8 w-full"
                    role="alert" aria-label="Mensagem de alerta sobre desafios na produção">
                    <p class="mb-2" tabindex="0">Chega de não saber por onde começar.</p>
                    <p class="mb-2" tabindex="0">Chega de intros e samples genéricos copiados do YouTube.</p>
                    <p tabindex="0">
                        Chega de passar horas mixando e ainda assim sempre <span class="italic">falta algo</span>.
                    </p>
                </div>

                <!-- Dor reforçada -->
                <p class="text-xl md:text-2xl text-gray-300 mb-10 text-center" tabindex="0">
                    Muitas vezes você terá <span class="text-white font-bold">apenas segundos</span> para provar que não
                    veio brincar!
                </p>

                <button onclick="document.getElementById('valores').scrollIntoView({ behavior: 'smooth' })"
                    class="px-8 py-3 font-bold text-white rounded
                       bg-gradient-to-r from-[#8b0000] to-[#b22222]
                       shadow-[0_0_20px_#b22222]
                       transform transition-transform duration-300
                       hover:scale-105 hover:brightness-110
                       focus:outline-none focus:ring-4 focus:ring-red-700 focus:ring-opacity-60"
                    aria-label="Botão para garantir o produto Shows Pro">
                    GARANTIR O SHOWS PRO AGORA
                </button>

            </div>
        </section>

        <section class="relative" aria-labelledby="videos-usuarios">
            <div class="max-w-5xl mx-auto p-4 text-center space-y-6">

                <h2 id="videos-usuarios" class="text-2xl font-semibold">
                    O Shows Pro permite elevar o nível da sua Produção!
                </h2>

                <h3 class="text-xl font-semibold">
                    Assista abaixo aberturas feitas pelo Rafael Castro utilizando todos os Packs do Shows Pro
                </h3>

                <!-- CARROSSEL -->
                <div class="relative">

                    <!-- SLIDER -->
                    <div id="video-carousel"
                        class="flex gap-4 overflow-x-auto snap-x snap-mandatory scroll-smooth cursor-grab select-none hide-scrollbar">

                        <!-- Slide 1 -->
                        <div class="snap-center shrink-0 w-full md:w-1/2">
                            <div class="aspect-video rounded-xl overflow-hidden shadow-lg">
                                <iframe class="w-full h-full pointer-events-none"
                                    src="https://www.youtube.com/embed/eWUaNe4NY74" title="Vídeo 1" loading="lazy"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        </div>

                        <!-- Slide 2 -->
                        <div class="snap-center shrink-0 w-full md:w-1/2">
                            <div class="aspect-video rounded-xl overflow-hidden shadow-lg">
                                <iframe class="w-full h-full pointer-events-none"
                                    src="https://www.youtube.com/embed/PDvOcu9ASvI" title="Vídeo 2" loading="lazy"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        </div>

                        <!-- Slide 3 -->
                        <div class="snap-center shrink-0 w-full md:w-1/2">
                            <div class="aspect-video rounded-xl overflow-hidden shadow-lg">
                                <iframe class="w-full h-full pointer-events-none"
                                    src="https://www.youtube.com/embed/oDZ_Pp0dvrA" title="Vídeo 3" loading="lazy"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        </div>

                        <!-- Slide 4 -->
                        <div class="snap-center shrink-0 w-full md:w-1/2">
                            <div class="aspect-video rounded-xl overflow-hidden shadow-lg">
                                <iframe class="w-full h-full pointer-events-none"
                                    src="https://www.youtube.com/embed/P40iBXVTcRk" title="Vídeo 3" loading="lazy"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                    </div>

                    <!-- DOTS (MOBILE) -->
                    <div class="flex justify-center gap-2 mt-4">
                        <button class="dot w-2.5 h-2.5 rounded-full bg-gray-400" onclick="goToSlide(0)"></button>
                        <button class="dot w-2.5 h-2.5 rounded-full bg-gray-300" onclick="goToSlide(1)"></button>
                        <button class="dot w-2.5 h-2.5 rounded-full bg-gray-300" onclick="goToSlide(2)"></button>
                    </div>

                </div>
            </div>
        </section>

        <section style="background-image: url('/assets/images/fundo-dobra-3.webp')" aria-labelledby="cards-pack"
            class="relative bg-auto bg-center bg-no-repeat" role="region">

            <div class="max-w-5xl mx-auto p-4 text-center space-y-6">

                <h2 id="cards-pack" class="font-bebas text-2xl lg:text-4xl" tabindex="0">
                    Tudo que você precisa está dentro do Pack 🎶SHOWS PRO!🎶
                </h2>

                <div class="text-start text-xl text-gray-300">
                    Depois de anos Produzindo aberturas para os maiores nomes do sertanejo como Hugo e Guilherme,
                    Ana Castela, Felipe Araujo entre outros, Fael Castro decidiu abrir sua caixa de surpresas e
                    mostrar um dos maiores segredos que torna grandes as suas produções de Shows! O Pack shows Pro
                    une as ferramentas necessárias para seus arranjos fluirem de uma vez por todas e suas produções
                    impactarem de verdade!
                </div>

                <ul class="flex flex-col gap-6" aria-label="Componentes incluídos no pack Shows Pro">
                    <!-- Card 1 -->
                    <li>
                        <article
                            class="bg-gray-900  border border-white shadow-[0_0_15px_rgba(255,255,255,0.4)] hover:shadow-[0_0_25px_rgba(255,255,255,0.8)]          transition-all duration-500  rounded-2xl py-4 px-8 flex flex-col md:flex-row items-center gap-4">
                            <img src="/assets/images/card-samples.webp"
                                alt="Imagem representando os samples incluídos no pack"
                                title="Samples musicais exclusivos"
                                class="w-[50%] md:w-[33%] object-cover rounded mx-auto md:mx-0" loading="lazy"
                                decoding="async" fetchpriority="low" />

                            <div class="w-full text-left">
                                <h3 id="card1-title" class="text-lg font-semibold mb-2" tabindex="0">Samples
                                    Musicais</h3>
                                <p class="text-sm" tabindex="0">Uma seleção de samples prontos para dar identidade
                                    ao seu show.</p>
                            </div>
                        </article>
                    </li>

                    <!-- Card 2 -->
                    <li>
                        <article
                            class="bg-gray-900  border border-white shadow-[0_0_15px_rgba(255,255,255,0.4)] hover:shadow-[0_0_25px_rgba(255,255,255,0.8)]          transition-all duration-500  rounded-2xl py-4 px-8 flex flex-col md:flex-row items-center gap-4">

                            <!-- Imagem primeiro no mobile -->
                            <img src="/assets/images/card-fx.webp" alt="Imagem ilustrando efeitos sonoros disponíveis"
                                title="Efeitos sonoros impactantes"
                                class="w-[50%] md:w-[33%] object-cover rounded mx-auto md:mx-0 order-1 md:order-2"
                                loading="lazy" decoding="async" fetchpriority="low" />

                            <!-- Texto depois no mobile -->
                            <div class="w-full text-left order-2 md:order-1">
                                <h3 id="card2-title" class="text-lg font-semibold mb-2" tabindex="0">Efeitos
                                    Sonoros (FX)</h3>
                                <p class="text-sm" tabindex="0">FX de impacto para criar momentos memoráveis no seu
                                    set.</p>
                            </div>
                        </article>
                    </li>

                    <!-- Card 3 -->
                    <li>
                        <article
                            class="bg-gray-900 border border-white shadow-[0_0_15px_rgba(255,255,255,0.4)] hover:shadow-[0_0_25px_rgba(255,255,255,0.8)]          transition-all duration-500  rounded-2xl py-4 px-8 flex flex-col md:flex-row items-center gap-4">
                            <img src="/assets/images/card-loops.webp"
                                alt="Imagem representando loops incluídos no pack" title="Loops prontos para usar"
                                class="w-[50%] md:w-[33%] object-cover rounded mx-auto md:mx-0" loading="lazy"
                                decoding="async" fetchpriority="low" />

                            <div class="w-full text-left">
                                <h3 id="card3-title" class="text-lg font-semibold mb-2" tabindex="0">Loops
                                    Exclusivos</h3>
                                <p class="text-sm" tabindex="0">Crie atmosferas envolventes com loops de alta
                                    qualidade.</p>
                            </div>
                        </article>
                    </li>
                </ul>

                <h3 id="cards-pack" class="font-bebas text-2xl lg:text-4xl" tabindex="0">
                    Use o Shows Pro para impactar a todos em qualquer cenário abaixo:
                </h3>

                <ul class="flex flex-col md:flex-row gap-6" aria-label="Componentes incluídos no pack Shows Pro">
                    <li class="flex-1">
                        <article
                            class="h-[100%] bg-gray-900 border  border-white shadow-[0_0_15px_rgba(255,255,255,0.4)] hover:shadow-[0_0_25px_rgba(255,255,255,0.8)]  rounded-2xl py-4 px-8 flex flex-col items-center gap-4">
                            <div class="font-bebas text-white text-2xl">
                                No Palco
                            </div>
                            <div class="text-white text-lg">
                                Comece o show com uma intro épica que faz o público vibrar antes mesmo da
                                primeira nota.
                            </div>
                        </article>
                    </li>

                    <li class="flex-1">
                        <article
                            class="h-[100%] bg-gray-900 border  border-white shadow-[0_0_15px_rgba(255,255,255,0.4)] hover:shadow-[0_0_25px_rgba(255,255,255,0.8)]  rounded-2xl py-4 px-8 flex flex-col items-center gap-4">
                            <div class="font-bebas text-white text-2xl">
                                No Estúdio
                            </div>
                            <div class="text-white text-lg">
                                Use os efeitos e loops como base criativa para trilhas, introduções ou
                                ambientações. Agilidade + qualidade sonora.
                            </div>
                        </article>
                    </li>

                    <li class="flex-1">
                        <article
                            class="h-[100%] bg-gray-900 border  border-white shadow-[0_0_15px_rgba(255,255,255,0.4)] hover:shadow-[0_0_25px_rgba(255,255,255,0.8)]  rounded-2xl py-4 px-8 flex flex-col items-center gap-4">
                            <div class="font-bebas text-white text-2xl">
                                Em Eventos
                            </div>
                            <div class="text-white text-lg">
                                Tenha introduções prontas e adaptáveis para qualquer formato de apresentação
                            </div>
                        </article>
                    </li>
                </ul>

                <button onclick="document.getElementById('valores').scrollIntoView({ behavior: 'smooth' })"
                    class="px-8 py-3 font-bold text-white rounded bg-gradient-to-r from-[#8b0000] to-[#b22222] shadow-[0_0_20px_#b22222] transform transition-transform duration-300 hover:scale-105 hover:brightness-110 focus:outline-none focus:ring-4 focus:ring-red-700 focus:ring-opacity-60"
                    aria-label="Botão para garantir o produto Shows Pro">
                    GARANTIR O SHOWS PRO AGORA
                </button>

            </div>
        </section>

        <section class="relative py-20 bg-gradient-to-b from-black via-zinc-900 to-black overflow-hidden"
            aria-labelledby="quem-usa">

            <div class="max-w-5xl mx-auto p-4 text-center space-y-6">

                <h2 id="relatos-usuarios" class="text-3xl font-bold text-white">
                    Quem usa o Shows Pro para produzir chega em resultados incríveis
                </h2>

                <h3 id="relatos-usuarios-subheadline" class="text-lg text-zinc-400">
                    Veja o feedback real de quem já está aplicando o Shows Pro
                </h3>

                <!-- fade lateral -->
                <div
                    class="pointer-events-none absolute left-0 top-0 h-full w-24 bg-gradient-to-r from-black to-transparent z-10">
                </div>
                <div
                    class="pointer-events-none absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-black to-transparent z-10">
                </div>

                <div class="relative w-full overflow-hidden py-10">

                    <div class="flex w-max animate-scroll pause-hover gap-8">

                        <div class="flex gap-8">

                            <img src="/assets/images/prova_social_depoimentos/d1.webp"
                                class="w-72 h-auto object-contain rounded-2xl shadow-2xl border border-white/10 hover:scale-105 hover:shadow-[0_0_30px_rgba(255,255,255,0.1)] transition duration-300"
                                alt="Prova 1">

                            <img src="/assets/images/prova_social_depoimentos/d3.webp"
                                class="w-72 h-auto object-contain rounded-2xl shadow-2xl border border-white/10 hover:scale-105 hover:shadow-[0_0_30px_rgba(255,255,255,0.1)] transition duration-300"
                                alt="Prova 3">

                            <img src="/assets/images/prova_social_depoimentos/d4.webp"
                                class="w-72 h-auto object-contain rounded-2xl shadow-2xl border border-white/10 hover:scale-105 hover:shadow-[0_0_30px_rgba(255,255,255,0.1)] transition duration-300"
                                alt="Prova 4">

                            <img src="/assets/images/prova_social_depoimentos/d5.webp"
                                class="w-72 h-auto object-contain rounded-2xl shadow-2xl border border-white/10 hover:scale-105 hover:shadow-[0_0_30px_rgba(255,255,255,0.1)] transition duration-300"
                                alt="Prova 5">

                            <img src="/assets/images/prova_social_depoimentos/d6.webp"
                                class="w-72 h-auto object-contain rounded-2xl shadow-2xl border border-white/10 hover:scale-105 hover:shadow-[0_0_30px_rgba(255,255,255,0.1)] transition duration-300"
                                alt="Prova 6">

                            <img src="/assets/images/prova_social_depoimentos/d7.webp"
                                class="w-72 h-auto object-contain rounded-2xl shadow-2xl border border-white/10 hover:scale-105 hover:shadow-[0_0_30px_rgba(255,255,255,0.1)] transition duration-300"
                                alt="Prova 7">

                            <img src="/assets/images/prova_social_depoimentos/d8.webp"
                                class="w-72 h-auto object-contain rounded-2xl shadow-2xl border border-white/10 hover:scale-105 hover:shadow-[0_0_30px_rgba(255,255,255,0.1)] transition duration-300"
                                alt="Prova 8">

                            <img src="/assets/images/prova_social_depoimentos/d9.webp"
                                class="w-72 h-auto object-contain rounded-2xl shadow-2xl border border-white/10 hover:scale-105 hover:shadow-[0_0_30px_rgba(255,255,255,0.1)] transition duration-300"
                                alt="Prova 9">

                            <img src="/assets/images/prova_social_depoimentos/d10.webp"
                                class="w-72 h-auto object-contain rounded-2xl shadow-2xl border border-white/10 hover:scale-105 hover:shadow-[0_0_30px_rgba(255,255,255,0.1)] transition duration-300"
                                alt="Prova 10">

                        </div>

                        <!-- duplicação para scroll infinito -->

                        <div class="flex gap-8">

                            <img src="/assets/images/prova_social_depoimentos/d1.webp"
                                class="w-72 h-auto object-contain rounded-2xl shadow-2xl border border-white/10 hover:scale-105 hover:shadow-[0_0_30px_rgba(255,255,255,0.1)] transition duration-300"
                                alt="Prova 1">

                            <img src="/assets/images/prova_social_depoimentos/d3.webp"
                                class="w-72 h-auto object-contain rounded-2xl shadow-2xl border border-white/10 hover:scale-105 hover:shadow-[0_0_30px_rgba(255,255,255,0.1)] transition duration-300"
                                alt="Prova 3">

                            <img src="/assets/images/prova_social_depoimentos/d4.webp"
                                class="w-72 h-auto object-contain rounded-2xl shadow-2xl border border-white/10 hover:scale-105 hover:shadow-[0_0_30px_rgba(255,255,255,0.1)] transition duration-300"
                                alt="Prova 4">

                            <img src="/assets/images/prova_social_depoimentos/d5.webp"
                                class="w-72 h-auto object-contain rounded-2xl shadow-2xl border border-white/10 hover:scale-105 hover:shadow-[0_0_30px_rgba(255,255,255,0.1)] transition duration-300"
                                alt="Prova 5">

                            <img src="/assets/images/prova_social_depoimentos/d6.webp"
                                class="w-72 h-auto object-contain rounded-2xl shadow-2xl border border-white/10 hover:scale-105 hover:shadow-[0_0_30px_rgba(255,255,255,0.1)] transition duration-300"
                                alt="Prova 6">

                            <img src="/assets/images/prova_social_depoimentos/d7.webp"
                                class="w-72 h-auto object-contain rounded-2xl shadow-2xl border border-white/10 hover:scale-105 hover:shadow-[0_0_30px_rgba(255,255,255,0.1)] transition duration-300"
                                alt="Prova 7">

                            <img src="/assets/images/prova_social_depoimentos/d8.webp"
                                class="w-72 h-auto object-contain rounded-2xl shadow-2xl border border-white/10 hover:scale-105 hover:shadow-[0_0_30px_rgba(255,255,255,0.1)] transition duration-300"
                                alt="Prova 8">

                            <img src="/assets/images/prova_social_depoimentos/d9.webp"
                                class="w-72 h-auto object-contain rounded-2xl shadow-2xl border border-white/10 hover:scale-105 hover:shadow-[0_0_30px_rgba(255,255,255,0.1)] transition duration-300"
                                alt="Prova 9">

                            <img src="/assets/images/prova_social_depoimentos/d10.webp"
                                class="w-72 h-auto object-contain rounded-2xl shadow-2xl border border-white/10 hover:scale-105 hover:shadow-[0_0_30px_rgba(255,255,255,0.1)] transition duration-300"
                                alt="Prova 10">

                        </div>

                    </div>

                </div>

            </div>

        </section>

        <section class="relative" role="region" aria-labelledby="valores" id="preco">
            <div class="max-w-5xl mx-auto p-4 text-center space-y-6">
                <h2 id="valores" class="font-bebas text-2xl lg:text-4xl" tabindex="0">
                    Escolha seu Plano
                </h2>

                <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6"
                    aria-label="Planos e valores disponíveis">

                    <!-- Essential -->
                    <li class="flex flex-col">
                        <article
                            class="relative bg-black/80 border border-red-500/30 p-6 rounded-xl 
                            shadow-[0_0_20px_rgba(255,0,0,0.25)] hover:scale-105                         
                            transition-all duration-500 
                            flex flex-col text-center h-full overflow-hidden">

                            <span
                                class="absolute inset-0 rounded-xl border border-red-500/20 animate-pulse pointer-events-none"></span>

                            <h4 id="oferta-essential" class="text-2xl font-bold mb-2 text-white">
                                Essential
                            </h4>

                            <img src="/assets/images/shows-pro-essentialpng" alt="Shows Pro: Essential"
                                class="rounded shadow-md w-full max-w-sm md:max-w-none h-auto md:h-full object-cover"
                                loading="lazy">

                            <ul class="text-sm mb-4 space-y-1 text-left text-gray-300">
                                <li>Intro épica pronta</li>
                                <li class="line-through text-red-500">Arranjos mais exclusivos</li>
                                <li class="line-through text-red-500">Mais opções de intro</li>
                                <li>Stems individuais</li>
                                <li class="line-through text-red-500">Bônus Pack de Samplers</li>
                                <li>Para quem: Primeira intro prof</li>
                            </ul>

                            <div class="mt-auto flex flex-col items-center">
                                <p class="text-3xl font-bold text-green-500 mb-4">R$ 97,00</p>

                                <a href="https://pay.kiwify.com.br/rfC2ZVx"
                                    class="bg-white text-black font-bold px-4 py-2 rounded 
                                    hover:bg-gray-300 transition">
                                    EU QUERO ESSENTIAL
                                </a>
                            </div>
                        </article>
                    </li>

                    <!-- Plus -->
                    <li class="flex flex-col">
                        <article
                            class="relative bg-black/80 border border-red-500/30 p-6 rounded-xl 
                            shadow-[0_0_20px_rgba(255,0,0,0.25)]                             
                            transition-all duration-500  hover:scale-105
                            flex flex-col text-center h-full overflow-hidden">

                            <span
                                class="absolute inset-0 rounded-xl border border-red-500/20 animate-pulse pointer-events-none"></span>

                            <h4 id="oferta-plus" class="text-2xl font-bold mb-2 text-white">
                                Plus
                            </h4>

                            <img src="/assets/images/shows-pro-plus.png" alt="Shows Pro: Plus"
                                class="rounded shadow-md w-full max-w-sm md:max-w-none h-auto md:h-full object-cover"
                                loading="lazy">

                            <ul class="text-sm mb-4 space-y-1 text-left text-gray-300">
                                <li>Intro épica pronta</li>
                                <li>Arranjos mais exclusivos</li>
                                <li>Mais opções de intro</li>
                                <li>Stems individuais</li>
                                <li class="line-through text-red-500">Bônus Pack de Samplers</li>
                                <li>Para quem: Quer mais punch</li>
                            </ul>

                            <div class="mt-auto flex flex-col items-center">
                                <p class="text-3xl font-bold text-green-500 mb-4">R$ 147,00</p>
                                <a href="https://pay.kiwify.com.br/9iJZ4pB"
                                    class="bg-white text-black font-bold px-4 py-2 rounded 
                                    hover:bg-gray-300 transition">
                                    EU QUERO PLUS
                                </a>
                            </div>
                        </article>
                    </li>

                    <!-- Ultimate -->
                    <li class="flex flex-col">

                        <article
                            class="group relative p-[2px] rounded-xl overflow-hidden transition-all duration-500 hover:scale-105 shadow-[0_0_20px_rgba(255,0,0,0.25)] ">

                            <!-- Borda neon girando -->
                            <span
                                class="absolute inset-0 rounded-xl                     bg-gradient-to-r from-red-600 via-yellow-500 to-red-600 
                                animate-[spin_6s_linear_infinite] group-hover:animate-[spin_2s_linear_infinite]
                                blur-md opacity-70 group-hover:opacity-100 transition-all duration-500">
                            </span>

                            <div
                                class="relative bg-black/95 p-6 rounded-xl text-center                             flex flex-col h-full                             shadow-[0_0_60px_rgba(255,80,0,0.6)]                            group-hover:shadow-[0_0_100px_rgba(255,80,0,1)]                             transition-all duration-500">

                                <h4 id="oferta-ultimate"
                                    class="text-2xl font-bold text-orange-400 mb-2 
                                     drop-shadow-[0_0_15px_rgba(255,140,0,0.9)]
                                 group-hover:drop-shadow-[0_0_25px_rgba(255,200,0,1)]
                                    transition-all duration-500">
                                    Ultimate
                                </h4>

                                <img src="/assets/images/shows-pro-ultimate.png" alt="Shows Pro: Ultimate"
                                    class="rounded shadow-md w-full max-w-sm md:max-w-none h-auto md:h-full object-cover"
                                    loading="lazy">

                                <ul class="text-sm mb-4 space-y-1 text-left text-gray-300">
                                    <li>Intro épica pronta</li>
                                    <li>Arranjos mais exclusivos</li>
                                    <li>Mais opções de intro</li>
                                    <li>Stems individuais</li>
                                    <li>Bônus Pack de Samplers</li>
                                    <li>Para quem: Busca experiência stadium</li>
                                </ul>

                                <div class="mt-auto flex flex-col items-center">
                                    <p class="text-3xl font-bold text-green-500 mb-4">R$ 197,00</p>

                                    <a href="https://pay.kiwify.com.br/hjmY5oG"
                                        class="bg-gradient-to-r from-red-600 to-orange-500 
                                    shadow-[0_0_25px_rgba(255,0,0,0.7)] 
                                    group-hover:shadow-[0_0_50px_rgba(255,0,0,1)] 
                                    text-white font-bold px-4 py-2 rounded 
                                    transition-all duration-300 hover:scale-110">
                                        EU QUERO ULTIMATE
                                    </a>
                                </div>
                            </div>
                        </article>
                    </li>
                </ul>
            </div>
        </section>

        <section class="relative" aria-labelledby="quem-sou-titulo">
            <div class="max-w-5xl mx-auto p-4">

                <div class="grid grid-cols-1 md:grid-cols-5 md:grid-rows-5 gap-6 md:gap-4 items-start">

                    <div class="md:col-span-3 md:row-span-3 flex justify-center" role="figure">
                        <img src="/assets/images/rafa-quem-sou-eu-2.jpeg" alt="Rafa: produtor musical"
                            class="rounded shadow-md w-full max-w-sm md:max-w-none h-auto md:h-full object-cover"
                            loading="lazy">
                    </div>

                    <div class="md:col-span-2 md:row-span-3 space-y-4">
                        <p class="text-lg leading-relaxed">
                            Meu nome é Rafael Castro, mas muitos me conhecem como <strong>Fael Castro</strong> — músico
                            e produtor musical com uma trajetória construída nos palcos e nos bastidores da música
                            brasileira.
                        </p>

                        <p class="text-lg leading-relaxed">
                            Ao longo dos anos, tive o privilégio de atuar acompanhando grandes artistas nacionais em
                            shows por todo o país, contribuindo diretamente na performance ao vivo e na construção de
                            experiências memoráveis para o público. Entre os nomes com quem já trabalhei nos palcos
                            estão <strong>Diego & Victor Hugo, Ana Castela e Israel & Rodolffo.</strong>
                        </p>
                    </div>

                    <div class="md:col-span-5 md:row-span-2 space-y-4">
                        <p class="text-lg leading-relaxed">
                            Nos bastidores, minha atuação vai além da performance. Como produtor musical, participei da
                            produção de aberturas e shows de artistas como <strong>Hugo & Guilherme, Felipe Araújo, Ana
                                Castela, Emílio & Eduardo, Rio Negro & Solimões</strong>, entre outros grandes nomes do
                            mercado sertanejo.
                        </p>

                        <p class="text-lg leading-relaxed">
                            Minha trajetória também ultrapassou fronteiras: já realizei turnês internacionais, levando a
                            música brasileira para os Estados Unidos e para a Europa, ampliando minha vivência artística
                            e experiência de palco.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="relative" aria-labelledby="faq-title">
            <div class="max-w-5xl mx-auto p-4 text-center space-y-6">
                <h2 id="faq-title" class="font-bebas text-2xl lg:text-4xl" tabindex="0">
                    Perguntas Frequentes
                </h2>

                <div class="border-b border-gray-300 py-4 text-left">
                    <button type="button"
                        class="faq-toggle flex justify-between items-center w-full text-left text-red-500 font-semibold focus:outline-none"
                        aria-expanded="false" aria-controls="faq-answer-1">
                        <span class="text-xl">🔸 Para quem é o Shows Pro?</span>
                        <i class="fa-solid fa-plus transition-transform duration-300" aria-hidden="true"></i>
                    </button>

                    <div id="faq-answer-1"
                        class="faq-answer grid grid-rows-[0fr] transition-[grid-template-rows] duration-300 ease-out overflow-hidden"
                        role="region">
                        <div class="min-h-0">
                            <div class="mt-4 text-md text-left text-gray-200">
                                <p class="mb-2">O Shows Pro é indicado para <strong>Iniciantes, Intermediários e
                                        Profissionais</strong>.</p>
                                <p class="mb-2"><strong>Iniciantes:</strong> Auxilia no treino, estudo sobre Tracks,
                                    produção musical, instrumentos e arranjos.</p>
                                <p class="mb-2"><strong>Intermediários:</strong> Ajuda na criação de novas ideias. Os
                                    Packs funcionam como assistência.</p>
                                <p><strong>Profissionais:</strong> Modelos prontos de temas e samplers para agilizar
                                    processos.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-b border-gray-300 py-4 text-left">
                    <button type="button"
                        class="faq-toggle flex justify-between items-center w-full text-left text-red-500 font-semibold focus:outline-none"
                        aria-expanded="false" aria-controls="faq-answer-2">
                        <span class="text-xl">🔸 Como funciona o acesso ao produto?</span>
                        <i class="fa-solid fa-plus transition-transform duration-300" aria-hidden="true"></i>
                    </button>

                    <div id="faq-answer-2"
                        class="faq-answer grid grid-rows-[0fr] transition-[grid-template-rows] duration-300 ease-out overflow-hidden"
                        role="region">
                        <div class="min-h-0">
                            <div class="mt-4 text-md text-left text-gray-200">
                                Após efetuar a compra, o seu acesso será enviado para o e-mail cadastrado na
                                plataforma <strong>Kiwify</strong>, onde estarão hospedados todos os arquivos.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-b border-gray-300 py-4 text-left">
                    <button type="button"
                        class="faq-toggle flex justify-between items-center w-full text-left text-red-500 font-semibold focus:outline-none"
                        aria-expanded="false" aria-controls="faq-answer-3">
                        <span class="text-xl">🔸 Tenho garantia após a compra?</span>
                        <i class="fa-solid fa-plus transition-transform duration-300" aria-hidden="true"></i>
                    </button>

                    <div id="faq-answer-3"
                        class="faq-answer grid grid-rows-[0fr] transition-[grid-template-rows] duration-300 ease-out overflow-hidden"
                        role="region">
                        <div class="min-h-0">
                            <div class="mt-4 text-md text-left text-gray-200">
                                Caso o Shows Pro não atenda às suas expectativas, você pode solicitar reembolso
                                em até <strong>7 dias</strong>.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="relative" aria-labelledby="rodape">
            <div class="max-w-5xl mx-auto p-4 text-center space-y-6">
                <a href="https://wa.me/5534991256642" target="_blank" rel="noopener noreferrer"
                    class="inline-block bg-green-600 text-white font-bold py-3 px-8 rounded-md 
           shadow-[0_0_10px_#25D366] 
           hover:shadow-[0_0_20px_#25D366] 
           hover:scale-105            
           transition-all duration-300"
                    role="button" aria-label="Entrar em contato via WhatsApp">
                    <span class="flex items-center gap-2">
                        Entrar em contato via WhatsApp
                    </span>
                </a>

                <div class="mt-4" role="contentinfo" aria-live="polite">
                    <p class="text-sm">© 2026 - Todos os direitos reservados</p>
                </div>
            </div>
        </section>
    </div>

    <script>
        document.querySelectorAll('.faq-toggle').forEach(button => {
            button.addEventListener('click', () => {
                const faqAnswer = button.nextElementSibling;
                const isOpen = button.getAttribute('aria-expanded') === 'true';
                const icon = button.querySelector('i');

                document.querySelectorAll('.faq-toggle').forEach(otherBtn => {
                    if (otherBtn !== button) {
                        otherBtn.setAttribute('aria-expanded', 'false');
                        otherBtn.nextElementSibling.classList.replace('grid-rows-[1fr]',
                            'grid-rows-[0fr]');
                        otherBtn.querySelector('i').classList.replace('fa-minus', 'fa-plus');
                        otherBtn.querySelector('i').style.transform = 'rotate(0deg)';
                    }
                });

                if (isOpen) {
                    button.setAttribute('aria-expanded', 'false');
                    faqAnswer.classList.replace('grid-rows-[1fr]', 'grid-rows-[0fr]');
                    icon.classList.replace('fa-minus', 'fa-plus');
                    icon.style.transform = 'rotate(0deg)';
                } else {
                    button.setAttribute('aria-expanded', 'true');
                    faqAnswer.classList.replace('grid-rows-[0fr]', 'grid-rows-[1fr]');
                    icon.classList.replace('fa-plus', 'fa-minus');
                    icon.style.transform = 'rotate(180deg)';
                }
            });
        });

        const carousel = document.getElementById("video-carousel")
        const slides = carousel.children
        const slideGap = 16
        let currentIndex = 0
        let isAnimating = false

        function getSlideWidth() {
            return slides[0].offsetWidth + slideGap
        }

        function scrollToIndex(index) {
            if (isAnimating) return
            isAnimating = true

            const maxIndex = slides.length - 1
            if (index < 0) index = maxIndex
            if (index > maxIndex) index = 0

            currentIndex = index

            carousel.scrollTo({
                left: getSlideWidth() * currentIndex,
                behavior: "smooth",
            })

            setTimeout(() => {
                isAnimating = false
                updateDots()
            }, 450)
        }

        function goToSlide(index) {
            scrollToIndex(index)
        }

        function updateDots() {
            document.querySelectorAll(".dot").forEach((dot, i) => {
                dot.classList.toggle("bg-gray-400", i === currentIndex)
                dot.classList.toggle("bg-gray-300", i !== currentIndex)
            })
        }

        let isDown = false
        let startX
        let scrollLeft

        carousel.addEventListener("mousedown", (e) => {
            isDown = true
            carousel.classList.add("cursor-grabbing")
            startX = e.pageX - carousel.offsetLeft
            scrollLeft = carousel.scrollLeft
        })

        carousel.addEventListener("mouseleave", () => {
            isDown = false
            carousel.classList.remove("cursor-grabbing")
        })

        carousel.addEventListener("mouseup", () => {
            isDown = false
            carousel.classList.remove("cursor-grabbing")

            currentIndex = Math.round(carousel.scrollLeft / getSlideWidth())
            scrollToIndex(currentIndex)
        })

        carousel.addEventListener("mousemove", (e) => {
            if (!isDown) return
            e.preventDefault()
            const x = e.pageX - carousel.offsetLeft
            const walk = (x - startX) * 1.4
            carousel.scrollLeft = scrollLeft - walk
        })

        let scrollTimeout
        carousel.addEventListener("scroll", () => {
            if (isAnimating || isDown) return

            clearTimeout(scrollTimeout)
            scrollTimeout = setTimeout(() => {
                currentIndex = Math.round(carousel.scrollLeft / getSlideWidth())
                updateDots()
            }, 120)
        })
    </script>
</body>

</html>
