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
    <meta property="og:title" content="RC Studio - Produção Musical Profissional" />
    <meta property="og:description"
        content="Arranjos, loops e produção musical profissional para elevar seu show a outro nível." />
    <meta property="og:image" content="https://rcstudio.com.br/rc_og_image.jpg" />
    <meta property="og:url" content="https://rcstudio.com.br/" />
    <meta property="og:type" content="website" />

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="RC Studio - Produção Musical Profissional" />
    <meta name="twitter:description"
        content="Arranjos, loops e produção musical profissional para elevar seu show a outro nível." />
    <meta name="twitter:image" content="https://rcstudio.com.br/rc_og_image.jpg" />
    <meta name="twitter:url" content="https://rcstudio.com.br/" />

    <!-- Fonte -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700;900&display=swap" rel="stylesheet">

    <!-- Favicons padrão -->
    <link rel="icon" type="image/png" sizes="16x16" href="/images/icons/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/images/icons/favicon-96x96.png">

    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/images/icons
/images/icons
/images/icons/apple-touch-icon.png">

    <!-- Android Chrome -->
    <link rel="icon" type="image/png" sizes="192x192"
        href="/images/icons
/images/icons
/images/icons/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512"
        href="/images/icons
/images/icons
/images/icons/android-chrome-512x512.png">

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

        .font-title {
            font-family: 'Orbitron', sans-serif;
        }

        .font-body {
            font-family: 'Figtree', sans-serif;
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
                        Pare de Fazer Produções Amadoras: Aprenda a Criar Shows Que Impressionam
                    </h1>

                    <h2 class="font-title text-2xl lg:text-4xl" tabindex="0">
                        O Shows Pro é o pack de samples e efeitos que vai mudar sua maneira de produzir! Eleve o nível
                        da sua produção do dia pra noite!
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

                <h2 id="descricao-pack" class="font-title text-2xl lg:text-4xl" tabindex="0">
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

                <div class="bg-gradient-to-br from-red-950 via-black to-black border border-red-900/50 p-10 rounded-3xl shadow-2xl mb-12 w-full text-center relative overflow-hidden"
                    role="alert" aria-label="Desafios na produção musical que o Shows Pro resolve">

                    <div class="absolute inset-0 opacity-[0.03] bg-[url('data:image/svg+xml;base64,...')]"></div>

                    <div class="relative z-10 space-y-5">
                        <h4 class="text-red-500 font-black font-title uppercase tracking-[0.2em] text-sm"
                            tabindex="0">
                            O Fim da Frustração
                        </h4>

                        <div
                            class="space-y-4 text-white text-xl md:text-2xl font-semibold leading-snug tracking-tight">
                            <p tabindex="0">
                                Chega de não saber por onde começar.
                            </p>
                            <p tabindex="0">
                                Chega de intros e samples genéricos copiados do YouTube.
                            </p>
                            <p tabindex="0">
                                Chega de produções que <span class="text-red-400 italic">nunca parecem prontas</span>.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Dor reforçada -->
                <p class="text-xl md:text-2xl text-gray-300 mb-10 text-center" tabindex="0">
                    Muitas vezes você terá <span class="text-white font-bold">apenas segundos</span> para provar que
                    não
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

        <div class="relative max-w-6xl mx-auto px-4">
            <div id="video-carousel"
                class="flex overflow-x-auto snap-x snap-mandatory scroll-smooth hide-scrollbar gap-4">

                <div
                    class="snap-center shrink-0 w-full md:w-[calc(50%-8px)] aspect-video rounded-xl overflow-hidden shadow-lg border-2 border-white/10">
                    <iframe class="w-full h-full" src="https://www.youtube.com/embed/eWUaNe4NY74" title="Vídeo 1"
                        loading="lazy" allowfullscreen></iframe>
                </div>

                <div
                    class="snap-center shrink-0 w-full md:w-[calc(50%-8px)] aspect-video rounded-xl overflow-hidden shadow-lg border-2 border-white/10">
                    <iframe class="w-full h-full" src="https://www.youtube.com/embed/PDvOcu9ASvI" title="Vídeo 2"
                        loading="lazy" allowfullscreen></iframe>
                </div>

                <div
                    class="snap-center shrink-0 w-full md:w-[calc(50%-8px)] aspect-video rounded-xl overflow-hidden shadow-lg border-2 border-white/10">
                    <iframe class="w-full h-full" src="https://www.youtube.com/embed/oDZ_Pp0dvrA" title="Vídeo 3"
                        loading="lazy" allowfullscreen></iframe>
                </div>

                <div
                    class="snap-center shrink-0 w-full md:w-[calc(50%-8px)] aspect-video rounded-xl overflow-hidden shadow-lg border-2 border-white/10">
                    <iframe class="w-full h-full" src="https://www.youtube.com/embed/P40iBXVTcRk" title="Vídeo 4"
                        loading="lazy" allowfullscreen></iframe>
                </div>
            </div>

            <div class="mt-8 flex flex-col items-center gap-4">
                <div class="flex items-center gap-4">
                    <button onclick="scrollCarousel(-1)"
                        class="bg-red-700 hover:bg-red-600 w-10 h-10 rounded-full text-white transition-transform hover:scale-110">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button onclick="scrollCarousel(1)"
                        class="bg-red-700 hover:bg-red-600 w-10 h-10 rounded-full text-white transition-transform hover:scale-110">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                <p
                    class="font-title text-white text-[10px] md:text-xs uppercase tracking-[0.3em] opacity-70 text-center">
                    Clique para ver os próximos
                </p>
            </div>
        </div>

        <section style="background-image: url('/assets/images/fundo-dobra-3.webp')" aria-labelledby="cards-pack"
            class="relative bg-auto bg-center bg-no-repeat" role="region">

            <div class="max-w-5xl mx-auto p-4 text-center space-y-6">

                <h2 id="cards-pack" class="font-title text-2xl lg:text-4xl" tabindex="0">
                    Tudo que você precisa está dentro do Pack 🎶SHOWS PRO!🎶
                </h2>

                <div class="text-start text-xl text-gray-300">
                    Depois de anos Produzindo aberturas para os maiores nomes do sertanejo como Hugo e Guilherme,
                    Ana Castela, Felipe Araujo entre outros, Fael Castro decidiu abrir sua caixa de surpresas e
                    mostrar um dos maiores segredos que torna grandes as suas produções de Shows! O Pack shows Pro
                    une as ferramentas necessárias para seus arranjos fluirem de uma vez por todas e suas produções
                    impactarem de verdade!
                </div>

                <ul class="flex flex-col gap-10" aria-label="Componentes incluídos no pack Shows Pro">

                    <li class="group">
                        <article
                            class="relative overflow-hidden bg-zinc-900/40 border border-white/10 backdrop-blur-md hover:border-red-500/40 hover:shadow-[0_0_50px_rgba(239,68,68,0.15)] transition-all duration-500 rounded-[2rem] px-8 py-6 flex flex-col md:flex-row items-center justify-between gap-8 md:gap-16">

                            <div
                                class="absolute -left-20 -top-20 w-64 h-64 bg-red-600/10 blur-[100px] group-hover:bg-red-600/20 transition-colors">
                            </div>

                            <div class="flex-shrink-0 z-10">
                                <img src="/assets/images/samples.png" alt="Samples"
                                    class="w-48 h-48 object-contain transform group-hover:scale-110 group-hover:rotate-3 transition-transform duration-700" />
                            </div>

                            <div class="relative z-10 text-center md:text-right flex-1">
                                <h3 class="text-3xl md:text-4xl font-bold mb-4 font-title text-white">Samples Musicais
                                </h3>
                                <p class="text-zinc-400 text-lg md:text-xl max-w-md ml-auto">Uma curadoria de elite
                                    pronta para dar a identidade profissional que seu show merece.</p>
                            </div>
                        </article>
                    </li>

                    <li class="group">
                        <article
                            class="relative overflow-hidden bg-zinc-900/40 border border-white/10 backdrop-blur-md hover:border-red-500/40 hover:shadow-[0_0_50px_rgba(239,68,68,0.15)] transition-all duration-500 rounded-[2rem] px-8 py-6 flex flex-col md:flex-row items-center justify-between gap-8 md:gap-16">

                            <div
                                class="absolute -right-20 -top-20 w-64 h-64 bg-red-600/10 blur-[100px] group-hover:bg-red-600/20 transition-colors">
                            </div>

                            <div class="relative z-10 text-center md:text-left flex-1 order-2 md:order-1">
                                <h3 class="text-3xl md:text-4xl font-bold mb-4 font-title text-white">Efeitos Sonoros
                                    (FX)</h3>
                                <p class="text-zinc-400 text-lg md:text-xl max-w-md mr-auto md:mr-0">Transições e
                                    impactos cinematográficos que prendem a atenção do público do início ao fim.</p>
                            </div>

                            <div class="flex-shrink-0 z-10 order-1 md:order-2">
                                <img src="/assets/images/efeitos.png" alt="Efeitos"
                                    class="w-48 h-48 object-contain transform group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-700" />
                            </div>
                        </article>
                    </li>

                    <li class="group">
                        <article
                            class="relative overflow-hidden bg-zinc-900/40 border border-white/10 backdrop-blur-md hover:border-red-500/40 hover:shadow-[0_0_50px_rgba(239,68,68,0.15)] transition-all duration-500 rounded-[2rem] px-8 py-6 flex flex-col md:flex-row items-center justify-between gap-8 md:gap-16">

                            <div
                                class="absolute -left-20 -top-20 w-64 h-64 bg-red-600/10 blur-[100px] group-hover:bg-red-600/20 transition-colors">
                            </div>

                            <div class="flex-shrink-0 z-10">
                                <img src="/assets/images/loops.png" alt="Loops"
                                    class="w-48 h-48 object-contain transform group-hover:scale-110 group-hover:rotate-3 transition-transform duration-700" />
                            </div>

                            <div class="relative z-10 text-center md:text-right flex-1">
                                <h3 class="text-3xl md:text-4xl font-bold mb-4 font-title text-white">Loops Exclusivos
                                </h3>
                                <p class="text-zinc-400 text-lg md:text-xl max-w-md ml-auto">Grooves envolventes e
                                    texturas rítmicas criadas para preencher o som com energia máxima.</p>
                            </div>
                        </article>
                    </li>

                </ul>

                <h3 id="cards-pack" class="font-title text-2xl lg:text-4xl" tabindex="0">
                    Use o Shows Pro para impactar a todos em qualquer cenário abaixo:
                </h3>

                <ul class="flex flex-col md:flex-row gap-6" aria-label="Componentes incluídos no pack Shows Pro">
                    <li class="flex-1">
                        <article
                            class="h-[100%] bg-gray-900 border  border-white shadow-[0_0_15px_rgba(255,255,255,0.4)] hover:shadow-[0_0_25px_rgba(255,255,255,0.8)]  rounded-2xl py-4 px-8 flex flex-col items-center gap-4">
                            <div class="font-title text-white text-2xl">
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
                            <div class="font-title text-white text-2xl">
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
                            <div class="font-title text-white text-2xl">
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
            aria-labelledby="relatos-usuarios">
            <div class="max-w-7xl mx-auto px-4 text-center space-y-6">
                <h2 id="relatos-usuarios" class="text-3xl font-bold font-title text-white">
                    Quem usa o Shows Pro para produzir chega em resultados incríveis
                </h2>
                <h3 class="text-lg text-zinc-400">
                    Veja o feedback real de quem já está aplicando o Shows Pro
                </h3>

                <div
                    class="pointer-events-none absolute left-0 top-0 h-full w-24 bg-gradient-to-r from-black to-transparent z-10">
                </div>
                <div
                    class="pointer-events-none absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-black to-transparent z-10">
                </div>

                <div id="drag-carousel"
                    class="flex overflow-x-auto cursor-grab active:cursor-grabbing gap-8 pt-10 pb-5 hide-scrollbar snap-x snap-mandatory select-none">

                    <img src="/assets/images/prova_social_depoimentos/d1.webp"
                        class="snap-center shrink-0 w-64 md:w-80 h-auto object-contain rounded-2xl border border-white/10 transition-all duration-300 hover:scale-105 hover:shadow-[0_0_25px_rgba(255,255,255,0.1)] hover:border-white/30"
                        alt="Depoimento">
                    <img src="/assets/images/prova_social_depoimentos/d3.webp"
                        class="snap-center shrink-0 w-64 md:w-80 h-auto object-contain rounded-2xl border border-white/10 transition-all duration-300 hover:scale-105 hover:shadow-[0_0_25px_rgba(255,255,255,0.1)] hover:border-white/30"
                        alt="Depoimento">
                    <img src="/assets/images/prova_social_depoimentos/d4.webp"
                        class="snap-center shrink-0 w-64 md:w-80 h-auto object-contain rounded-2xl border border-white/10 transition-all duration-300 hover:scale-105 hover:shadow-[0_0_25px_rgba(255,255,255,0.1)] hover:border-white/30"
                        alt="Depoimento">
                    <img src="/assets/images/prova_social_depoimentos/d5.webp"
                        class="snap-center shrink-0 w-64 md:w-80 h-auto object-contain rounded-2xl border border-white/10 transition-all duration-300 hover:scale-105 hover:shadow-[0_0_25px_rgba(255,255,255,0.1)] hover:border-white/30"
                        alt="Depoimento">
                    <img src="/assets/images/prova_social_depoimentos/d6.webp"
                        class="snap-center shrink-0 w-64 md:w-80 h-auto object-contain rounded-2xl border border-white/10 transition-all duration-300 hover:scale-105 hover:shadow-[0_0_25px_rgba(255,255,255,0.1)] hover:border-white/30"
                        alt="Depoimento">
                    <img src="/assets/images/prova_social_depoimentos/d7.webp"
                        class="snap-center shrink-0 w-64 md:w-80 h-auto object-contain rounded-2xl border border-white/10 transition-all duration-300 hover:scale-105 hover:shadow-[0_0_25px_rgba(255,255,255,0.1)] hover:border-white/30"
                        alt="Depoimento">
                    <img src="/assets/images/prova_social_depoimentos/d8.webp"
                        class="snap-center shrink-0 w-64 md:w-80 h-auto object-contain rounded-2xl border border-white/10 transition-all duration-300 hover:scale-105 hover:shadow-[0_0_25px_rgba(255,255,255,0.1)] hover:border-white/30"
                        alt="Depoimento">
                    <img src="/assets/images/prova_social_depoimentos/d10.webp"
                        class="snap-center shrink-0 w-64 md:w-80 h-auto object-contain rounded-2xl border border-white/10 transition-all duration-300 hover:scale-105 hover:shadow-[0_0_25px_rgba(255,255,255,0.1)] hover:border-white/30"
                        alt="Depoimento">
                </div>

                <div class="">
                    <p
                        class="font-title text-white text-[10px] md:text-xs uppercase tracking-[0.3em] opacity-70 text-center">
                        Arraste para ver os próximos
                    </p>
                </div>
            </div>
        </section>

        <section class="relative" role="region" aria-labelledby="valores" id="preco">
            <div class="max-w-6xl mx-auto p-4 text-center space-y-8">

                <h2 id="valores"
                    class="font-title text-3xl lg:text-5xl font-bold
bg-gradient-to-r from-red-500 via-orange-400 to-yellow-400
bg-clip-text text-transparent
tracking-widest
drop-shadow-[0_0_20px_rgba(255,80,0,0.7)]">
                    Escolha seu Plano
                </h2>

                <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 p-6"
                    aria-label="Planos e valores disponíveis">

                    <!-- Essential -->
                    <li class="flex flex-col">

                        <article
                            class="relative bg-black/60 backdrop-blur-md border border-red-500/30
            p-6 rounded-xl
            shadow-[0_0_25px_rgba(255,0,0,0.25)]
            hover:shadow-[0_0_60px_rgba(255,50,0,0.8)]
            hover:-translate-y-2
            transition-all duration-500
            flex flex-col text-center h-full overflow-hidden">

                            <span
                                class="absolute inset-0 rounded-xl border border-red-500/20 animate-pulse pointer-events-none"></span>

                            <h4 id="oferta-essential"
                                class="text-2xl font-bold font-title mb-2 text-white tracking-wide">
                                Essential
                            </h4>

                            <img src="/assets/images/shows-pro-essential.png" alt="Shows Pro: Essential"
                                class="rounded shadow-md w-full object-cover
            hover:scale-105 transition-transform duration-500"
                                loading="lazy">

                            <ul class="text-sm mb-4 space-y-2 text-left text-gray-300">
                                <li class="font-title font-semibold text-md text-gray-400">Intro épica pronta</li>
                                <li class="font-title font-semibold text-md line-through text-red-500">Arranjos mais
                                    exclusivos</li>
                                <li class="font-title font-semibold text-md line-through text-red-500">Mais opções de
                                    intro</li>
                                <li class="font-title font-semibold text-md text-gray-400">Stems individuais</li>
                                <li class="font-title font-semibold text-md  line-through text-red-500">Bônus Pack de
                                    Samplers</li>
                                <li class="font-title font-semibold text-md text-gray-400">Para quem: Primeira intro
                                    profissional</li>
                            </ul>

                            <div class="mt-auto flex flex-col items-center">

                                <p
                                    class="text-4xl font-extrabold
            bg-gradient-to-r from-green-400 to-emerald-500
            bg-clip-text text-transparent
            drop-shadow-[0_0_15px_rgba(0,255,100,0.6)]
            mb-4">
                                    R$ 97
                                </p>

                                <a href="https://pay.kiwify.com.br/rfC2ZVx"
                                    class="bg-gradient-to-r from-red-600 to-orange-500
            text-white font-bold px-6 py-3 rounded-lg
            shadow-[0_0_25px_rgba(255,0,0,0.6)]
            hover:shadow-[0_0_45px_rgba(255,0,0,1)]
            hover:scale-110
            transition-all duration-300">
                                    EU QUERO ESSENTIAL
                                </a>

                            </div>
                        </article>
                    </li>

                    <!-- Plus -->
                    <li class="flex flex-col">

                        <article
                            class="relative bg-black/60 backdrop-blur-md border border-red-500/30
            p-6 rounded-xl
            shadow-[0_0_25px_rgba(255,0,0,0.25)]
            hover:shadow-[0_0_60px_rgba(255,50,0,0.8)]
            hover:-translate-y-2
            transition-all duration-500
            flex flex-col text-center h-full overflow-hidden">

                            <span
                                class="absolute inset-0 rounded-xl border border-red-500/20 animate-pulse pointer-events-none"></span>

                            <h4 id="oferta-plus" class="text-2xl font-bold font-title mb-2 text-white tracking-wide">
                                Plus
                            </h4>

                            <img src="/assets/images/shows-pro-plus.png" alt="Shows Pro: Plus"
                                class="rounded shadow-md w-full object-cover
            hover:scale-105 transition-transform duration-500"
                                loading="lazy">

                            <ul class="text-sm mb-4 space-y-2 text-left text-gray-300">
                                <li class="font-title font-semibold text-md text-gray-400">Intro épica pronta</li>
                                <li class="font-title font-semibold text-md text-gray-400">Arranjos mais exclusivos
                                </li>
                                <li class="font-title font-semibold text-md text-gray-400">Mais opções de intro</li>
                                <li class="font-title font-semibold text-md text-gray-400">Stems individuais</li>
                                <li class="font-title font-semibold text-md line-through text-red-500">Bônus Pack de
                                    Samplers</li>
                                <li class="font-title font-semibold text-md text-gray-400">Para quem: Quer mais punch
                                </li>
                            </ul>

                            <div class="mt-auto flex flex-col items-center">

                                <p
                                    class="text-4xl font-extrabold
            bg-gradient-to-r from-green-400 to-emerald-500
            bg-clip-text text-transparent
            drop-shadow-[0_0_15px_rgba(0,255,100,0.6)]
            mb-4">
                                    R$ 147
                                </p>

                                <a href="https://pay.kiwify.com.br/9iJZ4pB"
                                    class="bg-gradient-to-r from-red-600 to-orange-500
            text-white font-bold px-6 py-3 rounded-lg
            shadow-[0_0_25px_rgba(255,0,0,0.6)]
            hover:shadow-[0_0_45px_rgba(255,0,0,1)]
            hover:scale-110
            transition-all duration-300">
                                    EU QUERO PLUS
                                </a>

                            </div>
                        </article>
                    </li>

                    <!-- Ultimate -->
                    <li class="flex flex-col">

                        <article
                            class="group relative p-[2px] rounded-xl overflow-hidden
            transition-all duration-500
            hover:scale-105
            shadow-[0_0_25px_rgba(255,0,0,0.35)]">

                            <span
                                class="absolute inset-0 rounded-xl
            bg-gradient-to-r from-red-600 via-yellow-500 to-red-600
            animate-[spin_6s_linear_infinite]
            group-hover:animate-[spin_2s_linear_infinite]
            blur-md opacity-70 group-hover:opacity-100
            transition-all duration-500">
                            </span>

                            <div
                                class="relative bg-black/90 backdrop-blur-md
            p-6 rounded-xl text-center
            flex flex-col h-full
            shadow-[0_0_60px_rgba(255,80,0,0.6)]
            group-hover:shadow-[0_0_120px_rgba(255,80,0,1)]
            transition-all duration-500">

                                <h4 id="oferta-ultimate"
                                    class="text-2xl font-bold font-title text-orange-400 mb-2
            drop-shadow-[0_0_20px_rgba(255,140,0,1)]
            transition-all duration-500">
                                    Ultimate
                                </h4>

                                <img src="/assets/images/shows-pro-ultimate.png" alt="Shows Pro: Ultimate"
                                    class="rounded shadow-md w-full object-cover
            hover:scale-105 transition-transform duration-500"
                                    loading="lazy">

                                <ul class="text-sm mb-4 space-y-2 text-left text-gray-300">
                                    <li class="font-title font-semibold text-md text-gray-400">Intro épica pronta</li>
                                    <li class="font-title font-semibold text-md text-gray-400">Arranjos mais exclusivos
                                    </li>
                                    <li class="font-title font-semibold text-md text-gray-400">Mais opções de intro
                                    </li>
                                    <li class="font-title font-semibold text-md text-gray-400">Stems individuais</li>
                                    <li class="font-title font-semibold text-md text-gray-400">Bônus Pack de Samplers
                                    </li>
                                    <li class="font-title font-semibold text-md text-gray-400">Para quem: Busca
                                        experiência stadium</li>
                                </ul>

                                <div class="mt-auto flex flex-col items-center">

                                    <p
                                        class="text-4xl font-extrabold
            bg-gradient-to-r from-green-400 to-emerald-500
            bg-clip-text text-transparent
            drop-shadow-[0_0_20px_rgba(0,255,100,0.8)]
            mb-4">
                                        R$ 197
                                    </p>

                                    <a href="https://pay.kiwify.com.br/hjmY5oG"
                                        class="bg-gradient-to-r from-red-600 to-orange-500
            text-white font-bold px-6 py-3 rounded-lg
            shadow-[0_0_30px_rgba(255,0,0,0.8)]
            hover:shadow-[0_0_60px_rgba(255,0,0,1)]
            hover:scale-110
            transition-all duration-300">
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
                <h2 id="faq-title" class="font-title text-2xl lg:text-4xl" tabindex="0">
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
                    role="button" aria-label="Falar conosco no WhatsApp" title="Falar conosco no WhatsApp">
                    <span class="flex items-center gap-2">
                        Entrar em contato via WhatsApp
                    </span>
                </a>

                <div class="mt-4" role="contentinfo" aria-live="polite">
                    <p class="text-sm">© 2026 - Todos os direitos reservados</p>
                </div>
            </div>
        </section>

        <div class="fixed bottom-6 right-6 z-[9999]">
            <a href="https://wa.me/5534991256642" target="_blank" rel="noopener noreferrer"
                class="flex items-center justify-center w-16 h-16 rounded-full 
                      bg-[#25D366] text-white shadow-[0_4px_10px_rgba(37,211,102,0.5)] 
                      transition-all duration-300 transform 
                      hover:scale-110 hover:shadow-[0_6px_20px_rgba(37,211,102,0.6)] 
                      active:scale-95 active:shadow-md
                      whatsapp-pulse"
                aria-label="Falar conosco no WhatsApp" title="Falar conosco no WhatsApp">
                <i class="fab fa-whatsapp text-4xl"></i>
            </a>
        </div>
    </div>

    <script>
        // --- LÓGICA DO FAQ ---
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

        // --- LÓGICA DO CARROSSEL DE VÍDEOS (BOTÕES) ---
        function scrollCarousel(direction) {
            const carousel = document.getElementById("video-carousel");
            if (!carousel || !carousel.firstElementChild) return;

            const itemWidth = carousel.firstElementChild.offsetWidth;
            const gap = 16;
            const isDesktop = window.innerWidth >= 768;
            const multiplier = isDesktop ? 2 : 1;

            const scrollAmount = (itemWidth + gap) * multiplier;

            carousel.scrollBy({
                left: direction * scrollAmount,
                behavior: "smooth"
            });
        }

        // --- LÓGICA DO CARROSSEL DE DEPOIMENTOS (DRAG/ARRASTAR) ---
        const dragSlider = document.getElementById('drag-carousel');
        if (dragSlider) {
            let isDown = false;
            let startX;
            let scrollLeft;

            dragSlider.addEventListener('mousedown', (e) => {
                isDown = true;
                dragSlider.classList.replace('cursor-grab', 'cursor-grabbing');
                startX = e.pageX - dragSlider.offsetLeft;
                scrollLeft = dragSlider.scrollLeft;
                dragSlider.style.scrollSnapType = 'none'; // Desativa snap para suavizar o drag
                dragSlider.style.scrollBehavior = 'auto'; // Desativa smooth para o drag acompanhar o mouse
            });

            dragSlider.addEventListener('mouseleave', () => {
                isDown = false;
                dragSlider.classList.replace('cursor-grabbing', 'cursor-grab');
            });

            dragSlider.addEventListener('mouseup', () => {
                isDown = false;
                dragSlider.classList.replace('cursor-grabbing', 'cursor-grab');
                dragSlider.style.scrollSnapType = 'x mandatory'; // Reativa o alinhamento automático
                dragSlider.style.scrollBehavior = 'smooth';
            });

            dragSlider.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - dragSlider.offsetLeft;
                const walk = (x - startX) * 2; // Ajuste de sensibilidade
                dragSlider.scrollLeft = scrollLeft - walk;
            });
        }
    </script>
</body>

</html>
