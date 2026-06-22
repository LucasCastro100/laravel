<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>RC Studio - Produção Musical Profissional</title>
    <meta name="description"
        content="Arranjos, loops e produção musical profissional para elevar seu show a outro nível.">
    <meta name="keywords" content="música, produção musical, intros, beats, artista, cantor">
    <meta name="author" content="RC Studio">

    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://rcstudio.com.br/" />
    <meta property="og:title" content="RC Studio - Produção Musical Profissional" />
    <meta property="og:description"
        content="Arranjos, loops e produção musical profissional para elevar seu show a outro nível." />
    <meta property="og:image" content="https://rcstudio.com.br/images/og-share-rc.png" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:url" content="https://rcstudio.com.br/" />
    <meta name="twitter:title" content="RC Studio - Produção Musical Profissional" />
    <meta name="twitter:description"
        content="Arranjos, loops e produção musical profissional para elevar seu show a outro nível." />
    <meta name="twitter:image" content="https://rcstudio.com.br/images/og-share-rc.png" />

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700;900&display=swap" rel="stylesheet">

    <link rel="icon" type="image/png" sizes="16x16" href="/images/icons/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/icons/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/images/icons/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="/images/icons/android-chrome-512x512.png">

    <script src="https://kit.fontawesome.com/5ae086a3a0.js" crossorigin="anonymous"></script>

    <style>
        /* ─── Reset & Base ─── */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --red-dark: #8b0000;
            --red-mid: #b22222;
            --red-500: #ef4444;
            --red-400: #f87171;
            --red-600: #dc2626;
            --orange-400: #fb923c;
            --orange-500: #f97316;
            --yellow-400: #facc15;
            --green-400: #4ade80;
            --emerald-500: #10b981;
            --zinc-400: #a1a1aa;
            --zinc-900: #18181b;
            --gray-300: #d1d5db;
            --gray-200: #e5e7eb;
            --gray-900: #111827;
            --white: #ffffff;
            --black: #000000;

            --font-title: 'Orbitron', sans-serif;
            --font-body: 'Figtree', sans-serif;

            --max-w: 80rem;
            /* 5xl = 64rem; 6xl = 72rem; 7xl = 80rem */
            --max-w-5xl: 64rem;
            --max-w-6xl: 72rem;
            --max-w-7xl: 80rem;

            --radius-xl: 0.75rem;
            --radius-2xl: 1rem;
            --radius-3xl: 1.5rem;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font-body);
            background: var(--black);
            color: var(--white);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            line-height: 1.6;
        }

        img {
            max-width: 100%;
            display: block;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        ul {
            list-style: none;
        }

        /* ─── Utility ─── */
        .font-title {
            font-family: var(--font-title);
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        /* ─── Animations ─── */
        @keyframes pulse-ring {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .5;
            }
        }

        @keyframes spin-slow {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes spin-fast {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes whatsapp-pulse {

            0%,
            100% {
                box-shadow: 0 4px 10px rgba(37, 211, 102, .5);
            }

            50% {
                box-shadow: 0 6px 28px rgba(37, 211, 102, .8);
            }
        }

        @keyframes gradient-text {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        /* ─── Wrapper ─── */
        #site-header,
        #site-footer {
            display: none;
        }

        .page-wrapper {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            background: var(--black);
            color: var(--white);
        }

        /* ─── Section base ─── */
        section {
            padding: 1rem 0;
        }

        .container {
            max-width: var(--max-w-5xl);
            margin: 0 auto;
            padding: 1rem;
        }

        .container--6xl {
            max-width: var(--max-w-6xl);
        }

        .container--7xl {
            max-width: var(--max-w-7xl);
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        /* ─── Headings ─── */
        .heading-hero {
            font-family: var(--font-title);
            font-size: clamp(1.4rem, 4vw, 2.5rem);
            line-height: 1.25;
            margin-bottom: 0.5rem;
        }

        .heading-xl {
            font-family: var(--font-title);
            font-size: clamp(1.4rem, 4vw, 2.5rem);
            line-height: 1.3;
        }

        .heading-2xl {
            font-family: var(--font-title);
            font-size: clamp(1.75rem, 5vw, 3rem);
            font-weight: 700;
        }

        .heading-gradient {
            background: linear-gradient(90deg, var(--red-500), var(--orange-400), var(--yellow-400));
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: 0.2em;
            filter: drop-shadow(0 0 20px rgba(255, 80, 0, .7));
            animation: gradient-text 4s ease infinite;
        }

        /* ─── Buttons ─── */
        .btn-cta {
            display: inline-block;
            padding: 0.75rem 2rem;
            font-weight: 700;
            color: var(--white);
            border-radius: var(--radius-xl);
            background: linear-gradient(to right, var(--red-dark), var(--red-mid));
            box-shadow: 0 0 20px var(--red-mid);
            border: none;
            cursor: pointer;
            font-size: 1rem;
            letter-spacing: 0.05em;
            transition: transform .3s, filter .3s, box-shadow .3s;
        }

        .btn-cta:hover {
            transform: scale(1.05);
            filter: brightness(1.1);
            box-shadow: 0 0 30px var(--red-mid);
        }

        .btn-cta:focus {
            outline: none;
            box-shadow: 0 0 0 4px rgba(185, 28, 28, .6);
        }

        /* ─── SECTION 1 — Hero vídeo ─── */
        .hero-section {
            background-image: url('/assets/images/fundo-dobra-1.webp');
            background-size: auto;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
        }

        .hero-section .container {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            align-items: center;
        }

        /* Responsive video */
        .video-wrapper {
            position: relative;
            width: 100%;
            padding-top: 56.25%;
        }

        .video-wrapper iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 4px solid #2563eb;
            border-radius: 0.5rem;
        }

        /* Payment img */
        .payment-img-wrap {
            display: flex;
            justify-content: center;
            width: 100%;
        }

        /* ─── SECTION 2 — Dores ─── */
        .dores-section {
            background-image: url('/assets/images/fundo-dobra-2.webp');
            background-size: auto;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
        }

        .dores-section .container {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            align-items: center;
        }

        .dores-list {
            font-size: clamp(1rem, 2.5vw, 1.25rem);
            color: var(--gray-200);
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 2rem;
            width: 100%;
            text-align: left;
        }

        .dores-list li {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .dores-list i {
            margin-top: 0.25rem;
            flex-shrink: 0;
        }

        .frustracao-box {
            background: linear-gradient(135deg, #450a0a, var(--black), var(--black));
            border: 1px solid rgba(153, 27, 27, .5);
            padding: 2.5rem;
            border-radius: var(--radius-3xl);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, .5);
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .frustracao-box::before {
            content: '';
            position: absolute;
            inset: 0;
            opacity: .03;
        }

        .frustracao-inner {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .frustracao-label {
            color: var(--red-500);
            font-family: var(--font-title);
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            font-size: 0.875rem;
        }

        .frustracao-text {
            font-size: clamp(1.1rem, 3vw, 1.5rem);
            font-weight: 600;
            line-height: 1.35;
            letter-spacing: -0.01em;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .text-italic-red {
            color: var(--red-400);
            font-style: italic;
        }

        .urgency-text {
            font-size: clamp(1.1rem, 3vw, 1.5rem);
            color: var(--gray-300);
            margin-bottom: 2.5rem;
        }

        /* ─── Video Carousel ─── */
        .carousel-wrapper {
            position: relative;
            max-width: var(--max-w-6xl);
            margin: 0 auto;
            padding: 0 1rem;
        }

        .video-carousel {
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            gap: 1rem;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .video-carousel::-webkit-scrollbar {
            display: none;
        }

        .video-carousel-item {
            scroll-snap-align: center;
            flex-shrink: 0;
            width: 100%;
            aspect-ratio: 16/9;
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .4);
            border: 2px solid rgba(255, 255, 255, .1);
        }

        .video-carousel-item iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .carousel-controls {
            margin-top: 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .carousel-buttons {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .btn-carousel {
            background: var(--red-600);
            color: var(--white);
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .2s, transform .2s;
        }

        .btn-carousel:hover {
            background: #ef4444;
            transform: scale(1.1);
        }

        .carousel-hint {
            font-family: var(--font-title);
            color: var(--white);
            font-size: 0.625rem;
            text-transform: uppercase;
            letter-spacing: 0.3em;
            opacity: 0.7;
        }

        @media (min-width: 768px) {
            .video-carousel-item {
                width: calc(50% - 8px);
            }
        }

        /* ─── SECTION 3 — Pack Cards ─── */
        .pack-section {
            background-image: url('/assets/images/fundo-dobra-3.webp');
            background-size: auto;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
        }

        .pack-section .container {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            align-items: center;
        }

        .pack-description {
            text-align: left;
            font-size: clamp(1rem, 2.5vw, 1.25rem);
            color: var(--gray-300);
            line-height: 1.7;
        }

        /* Item cards */
        .pack-items {
            display: flex;
            flex-direction: column;
            gap: 2.5rem;
            width: 100%;
        }

        .pack-card {
            position: relative;
            overflow: hidden;
            background: rgba(24, 24, 27, .4);
            border: 1px solid rgba(255, 255, 255, .1);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: var(--radius-3xl);
            padding: 1.5rem 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2rem;
            transition: border-color .5s, box-shadow .5s;
        }

        .pack-card:hover {
            border-color: rgba(239, 68, 68, .4);
            box-shadow: 0 0 50px rgba(239, 68, 68, .15);
        }

        .pack-card .glow {
            position: absolute;
            width: 16rem;
            height: 16rem;
            background: rgba(220, 38, 38, .1);
            filter: blur(100px);
            transition: background .4s;
            pointer-events: none;
        }

        .pack-card:hover .glow {
            background: rgba(220, 38, 38, .2);
        }

        .glow--left {
            left: -5rem;
            top: -5rem;
        }

        .glow--right {
            right: -5rem;
            top: -5rem;
        }

        .pack-card-img {
            flex-shrink: 0;
            z-index: 1;
        }

        .pack-card-img img {
            width: 12rem;
            height: 12rem;
            object-fit: contain;
            transform-origin: center;
            transition: transform .7s;
        }

        .pack-card:hover .pack-card-img img {
            transform: scale(1.1) rotate(3deg);
        }

        .pack-card--reverse:hover .pack-card-img img {
            transform: scale(1.1) rotate(-3deg);
        }

        .pack-card-text {
            position: relative;
            z-index: 1;
            flex: 1;
        }

        .pack-card-text h3 {
            font-family: var(--font-title);
            font-size: clamp(1.5rem, 4vw, 2.25rem);
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .pack-card-text p {
            color: var(--zinc-400);
            font-size: clamp(1rem, 2.5vw, 1.25rem);
            max-width: 28rem;
        }

        @media (min-width: 768px) {
            .pack-card {
                flex-direction: row;
                justify-content: space-between;
            }

            .pack-card--reverse {
                flex-direction: row-reverse;
            }

            .pack-card-text--right {
                text-align: right;
            }

            .pack-card-text--right p {
                margin-left: auto;
            }
        }

        /* Cenário cards */
        .cenarios-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
            width: 100%;
        }

        @media (min-width: 768px) {
            .cenarios-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        .cenario-card {
            background: var(--gray-900);
            border: 1px solid var(--white);
            box-shadow: 0 0 15px rgba(255, 255, 255, .4);
            border-radius: var(--radius-2xl);
            padding: 1rem 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            transition: box-shadow .3s;
            height: 100%;
        }

        .cenario-card:hover {
            box-shadow: 0 0 25px rgba(255, 255, 255, .8);
        }

        .cenario-card h4 {
            font-family: var(--font-title);
            font-size: 1.5rem;
        }

        .cenario-card p {
            font-size: 1.125rem;
        }

        /* ─── Testimonials ─── */
        .testimonials-section {
            position: relative;
            padding: 5rem 0;
            background: linear-gradient(to bottom, var(--black), var(--zinc-900), var(--black));
            overflow: hidden;
        }

        .testimonials-section .container--7xl {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            align-items: center;
        }

        .testimonials-section h2 {
            font-size: 1.875rem;
            font-weight: 700;
        }

        .testimonials-section h3 {
            font-size: 1.125rem;
            color: var(--zinc-400);
        }

        /* Fade edges */
        .fade-left,
        .fade-right {
            pointer-events: none;
            position: absolute;
            top: 0;
            height: 100%;
            width: 6rem;
            z-index: 10;
        }

        .fade-left {
            left: 0;
            background: linear-gradient(to right, var(--black), transparent);
        }

        .fade-right {
            right: 0;
            background: linear-gradient(to left, var(--black), transparent);
        }

        .drag-carousel {
            display: flex;
            overflow-x: auto;
            cursor: grab;
            gap: 2rem;
            padding: 2.5rem 0 1.25rem;
            scrollbar-width: none;
            -ms-overflow-style: none;
            scroll-snap-type: x mandatory;
            user-select: none;
            width: 100%;
        }

        .drag-carousel::-webkit-scrollbar {
            display: none;
        }

        .drag-carousel.grabbing {
            cursor: grabbing;
        }

        .drag-carousel img {
            scroll-snap-align: center;
            flex-shrink: 0;
            width: 16rem;
            height: auto;
            object-fit: contain;
            border-radius: var(--radius-2xl);
            border: 1px solid rgba(255, 255, 255, .1);
            transition: transform .3s, box-shadow .3s, border-color .3s;
        }

        @media (min-width: 768px) {
            .drag-carousel img {
                width: 20rem;
            }
        }

        .drag-carousel img:hover {
            transform: scale(1.05);
            box-shadow: 0 0 25px rgba(255, 255, 255, .1);
            border-color: rgba(255, 255, 255, .3);
        }

        .drag-hint {
            font-family: var(--font-title);
            font-size: 0.625rem;
            text-transform: uppercase;
            letter-spacing: 0.3em;
            opacity: 0.7;
        }

        /* ─── Pricing ─── */
        .pricing-section {
            position: relative;
        }

        .pricing-section .container--6xl {
            display: flex;
            flex-direction: column;
            gap: 2rem;
            align-items: center;
            padding: 1rem;
        }

        .plans-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            padding: 1.5rem;
            width: 100%;
        }

        @media (min-width: 768px) {
            .plans-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) {
            .plans-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        /* Plan card base */
        .plan-card {
            position: relative;
            background: rgba(0, 0, 0, .6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(239, 68, 68, .3);
            padding: 1.5rem;
            border-radius: var(--radius-xl);
            box-shadow: 0 0 25px rgba(255, 0, 0, .25);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transition: box-shadow .5s, transform .5s;
            overflow: hidden;
        }

        .plan-card:hover {
            box-shadow: 0 0 60px rgba(255, 50, 0, .8);
            transform: translateY(-0.5rem);
        }

        .plan-card::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: var(--radius-xl);
            border: 1px solid rgba(239, 68, 68, .2);
            animation: pulse-ring 2s ease-in-out infinite;
            pointer-events: none;
        }

        .plan-card h4 {
            font-family: var(--font-title);
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            letter-spacing: 0.05em;
        }

        .plan-card img {
            width: 100%;
            border-radius: 0.375rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, .3);
            transition: transform .5s;
            margin-bottom: 1rem;
        }

        .plan-card:hover img {
            transform: scale(1.05);
        }

        .plan-features {
            list-style: none;
            font-size: 0.875rem;
            margin-bottom: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            text-align: left;
            width: 100%;
            color: var(--gray-300);
        }

        .plan-features li {
            font-family: var(--font-title);
            font-weight: 600;
            font-size: 0.9rem;
            color: #9ca3af;
        }

        .plan-features li.strike {
            text-decoration: line-through;
            color: var(--red-500);
        }

        .plan-price {
            font-size: 2.25rem;
            font-weight: 800;
            background: linear-gradient(to right, var(--green-400), var(--emerald-500));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            filter: drop-shadow(0 0 15px rgba(0, 255, 100, .6));
            margin-bottom: 1rem;
        }

        .plan-card .mt-auto {
            margin-top: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .btn-plan {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: linear-gradient(to right, var(--red-600), var(--orange-500));
            color: var(--white);
            font-weight: 700;
            border-radius: 0.5rem;
            box-shadow: 0 0 25px rgba(255, 0, 0, .6);
            transition: box-shadow .3s, transform .3s;
            font-size: 0.9rem;
            letter-spacing: 0.03em;
        }

        .btn-plan:hover {
            box-shadow: 0 0 45px rgba(255, 0, 0, 1);
            transform: scale(1.1);
        }

        /* Ultimate plan — animated border */
        .plan-card--ultimate-wrap {
            position: relative;
            padding: 2px;
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: 0 0 25px rgba(255, 0, 0, .35);
            transition: transform .5s;
        }

        .plan-card--ultimate-wrap:hover {
            transform: scale(1.05);
        }

        .plan-card--ultimate-border {
            position: absolute;
            inset: 0;
            border-radius: var(--radius-xl);
            background: conic-gradient(from 0deg, var(--red-600), var(--yellow-400), var(--red-600));
            animation: spin-slow 6s linear infinite;
            filter: blur(6px);
            opacity: 0.7;
            transition: opacity .5s, animation-duration .5s;
        }

        .plan-card--ultimate-wrap:hover .plan-card--ultimate-border {
            opacity: 1;
            animation-duration: 2s;
        }

        .plan-card--ultimate {
            position: relative;
            background: rgba(0, 0, 0, .9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 1.5rem;
            border-radius: var(--radius-xl);
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 0 60px rgba(255, 80, 0, .6);
            transition: box-shadow .5s;
        }

        .plan-card--ultimate-wrap:hover .plan-card--ultimate {
            box-shadow: 0 0 120px rgba(255, 80, 0, 1);
        }

        .plan-card--ultimate h4 {
            font-family: var(--font-title);
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--orange-400);
            margin-bottom: 0.5rem;
            filter: drop-shadow(0 0 20px rgba(255, 140, 0, 1));
        }

        /* ─── About / Quem sou ─── */
        .about-section .container {
            padding: 1rem;
        }

        .about-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
            align-items: start;
        }

        @media (min-width: 768px) {
            .about-grid {
                grid-template-columns: 3fr 2fr;
                grid-template-rows: auto auto;
            }

            .about-img {
                grid-column: 1;
                grid-row: 1 / 3;
            }

            .about-text1 {
                grid-column: 2;
                grid-row: 1;
            }

            .about-text2 {
                grid-column: 1 / 3;
                grid-row: 3;
            }
        }

        .about-img img {
            border-radius: 0.375rem;
            width: 100%;
            max-width: 24rem;
            height: auto;
            object-fit: cover;
        }

        @media (min-width: 768px) {
            .about-img img {
                max-width: none;
                height: 100%;
            }
        }

        .about-text1,
        .about-text2 {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .about-text1 p,
        .about-text2 p {
            font-size: 1.125rem;
            line-height: 1.75;
        }

        /* ─── FAQ ─── */
        .faq-section .container {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .faq-item {
            border-bottom: 1px solid var(--gray-300);
            padding: 1rem 0;
            text-align: left;
        }

        .faq-toggle {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            text-align: left;
            color: var(--red-500);
            font-weight: 600;
            background: none;
            border: none;
            cursor: pointer;
        }

        .faq-toggle span {
            font-size: 1.25rem;
        }

        .faq-toggle i {
            transition: transform .3s;
        }

        .faq-answer {
            display: grid;
            grid-template-rows: 0fr;
            transition: grid-template-rows .3s ease-out;
            overflow: hidden;
        }

        .faq-answer.open {
            grid-template-rows: 1fr;
        }

        .faq-answer-inner {
            min-height: 0;
        }

        .faq-answer-content {
            margin-top: 1rem;
            font-size: 0.95rem;
            color: var(--gray-200);
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        /* ─── Footer ─── */
        .footer-section .container {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            align-items: center;
        }

        .btn-whatsapp {
            display: inline-block;
            background: #16a34a;
            color: var(--white);
            font-weight: 700;
            padding: 0.75rem 2rem;
            border-radius: 0.375rem;
            box-shadow: 0 0 10px #25D366;
            transition: box-shadow .3s, transform .3s;
        }

        .btn-whatsapp:hover {
            box-shadow: 0 0 20px #25D366;
            transform: scale(1.05);
        }

        .btn-whatsapp span {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .footer-copy {
            font-size: 0.875rem;
        }

        /* ─── Floating WhatsApp ─── */
        .whatsapp-float {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            z-index: 9999;
        }

        .whatsapp-float a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 4rem;
            height: 4rem;
            border-radius: 50%;
            background: #25D366;
            color: var(--white);
            animation: whatsapp-pulse 2s ease-in-out infinite;
            transition: transform .3s;
        }

        .whatsapp-float a:hover {
            transform: scale(1.1);
        }

        .whatsapp-float a:active {
            transform: scale(.95);
        }

        .whatsapp-float i {
            font-size: 2.25rem;
        }
    </style>

    <!-- Pixel X App - START -->
    <script type='text/javascript'>
        ! function() {
            var e = window.location.href,
                t = document.title,
                n = Date.now(),
                o = document.createElement('script');
            o.src = 'https://pxa.rcstudio.com.br/remote?url=' + encodeURIComponent(e) + '&title=' + encodeURIComponent(t) +
                '&time=' + n, o.async = !0, document.head.appendChild(o)
        }()
    </script>
    <!-- Pixel X App - END -->
</head>

<body>
    <div class="page-wrapper">

        <!-- ═══ SECTION 1: Hero ═══ -->
        <section class="hero-section" aria-labelledby="video-heading" role="region">
            <div class="container text-center">

                <header class="text-center">
                    <h1 id="video-heading" class="heading-hero" tabindex="0">
                        Pare de Fazer Produções Amadoras: Aprenda a Criar Shows Que Impressionam
                    </h1>
                    <h2 class="heading-xl" tabindex="0">
                        O Shows Pro é o pack de samples e efeitos que vai mudar sua maneira de produzir! Eleve o nível
                        da sua produção do dia pra noite!
                    </h2>
                </header>

                <div class="video-wrapper">
                    <iframe src="https://www.youtube.com/embed/oNJCRjqjQa8"
                        title="Vídeo promocional do Shows Pro explicando os benefícios do pack"
                        aria-label="Vídeo explicativo do produto Shows Pro" frameborder="0" loading="lazy"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                    </iframe>
                </div>

                <button onclick="document.getElementById('valores').scrollIntoView({ behavior: 'smooth' })"
                    class="btn-cta" aria-label="Botão para garantir o produto Shows Pro">
                    GARANTIR O SHOWS PRO AGORA
                </button>

                <div class="payment-img-wrap">
                    <img src="/assets/images/pagamento.webp" alt="Meios de pagamento aceitos para adquirir o Shows Pro"
                        title="Formas de pagamento disponíveis" loading="lazy" decoding="async" fetchpriority="low" />
                </div>
            </div>
        </section>

        <!-- ═══ SECTION 2: Dores ═══ -->
        <section class="dores-section" aria-labelledby="descricao-pack" role="region">
            <div class="container text-center">

                <h2 id="descricao-pack" class="heading-xl" tabindex="0">
                    Você é produtor, músico ou cantor e sabe:
                </h2>

                <ul class="dores-list" aria-label="Lista de dores e desafios comuns">
                    <li>
                        <i class="fas fa-music" aria-hidden="true"></i>
                        <span>
                            A <strong>abertura decide</strong> se a plateia vai arrepiar… ou abrir o Instagram.
                        </span>
                    </li>
                    <li>
                        <i class="fas fa-music" aria-hidden="true"></i>
                        <span>
                            Sem um impacto inicial, o show inteiro <strong>luta em ladeira.</strong>
                        </span>
                    </li>
                </ul>

                <div class="frustracao-box" role="alert"
                    aria-label="Desafios na produção musical que o Shows Pro resolve">
                    <div class="frustracao-inner">
                        <p class="frustracao-label">O Fim da Frustração</p>
                        <div class="frustracao-text">
                            <p tabindex="0">Chega de não saber por onde começar.</p>
                            <p tabindex="0">Chega de intros e samples genéricos copiados do YouTube.</p>
                            <p tabindex="0">Chega de produções que <span class="text-italic-red">nunca parecem
                                    prontas</span>.</p>
                        </div>
                    </div>
                </div>

                <p class="urgency-text" tabindex="0">
                    Muitas vezes você terá <strong>apenas segundos</strong> para provar que não veio brincar!
                </p>
            </div>
        </section>

        <!-- ═══ Video Carousel ═══ -->
        <div class="carousel-wrapper" aria-labelledby="carousel-wrapper">
            <h2 id="carousel-wrapper" class="heading-xl" style="text-align: center">
                Confira os vídeos abaixo
            </h2>
            <h2 id="carousel-wrapper" class="heading-xl" style="text-align: center">
                Todas mega produções que criamos usando o Shows Pro
            </h2>
            <div id="video-carousel" class="video-carousel">
                <div class="video-carousel-item">
                    <iframe src="https://www.youtube.com/embed/eWUaNe4NY74" title="Vídeo 1" loading="lazy"
                        allowfullscreen></iframe>
                </div>
                <div class="video-carousel-item">
                    <iframe src="https://www.youtube.com/embed/PDvOcu9ASvI" title="Vídeo 2" loading="lazy"
                        allowfullscreen></iframe>
                </div>
                <div class="video-carousel-item">
                    <iframe src="https://www.youtube.com/embed/oDZ_Pp0dvrA" title="Vídeo 3" loading="lazy"
                        allowfullscreen></iframe>
                </div>
                <div class="video-carousel-item">
                    <iframe src="https://www.youtube.com/embed/P40iBXVTcRk" title="Vídeo 4" loading="lazy"
                        allowfullscreen></iframe>
                </div>
            </div>

            <div class="carousel-controls">
                <div class="carousel-buttons">
                    <button onclick="scrollCarousel(-1)" class="btn-carousel" aria-label="Anterior">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button onclick="scrollCarousel(1)" class="btn-carousel" aria-label="Próximo">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                <p class="carousel-hint">Clique para ver os próximos</p>
            </div>
        </div>

        <!-- ═══ SECTION 3: Pack ═══ -->
        <section class="pack-section" aria-labelledby="cards-pack" role="region">
            <div class="container text-center">

                <h2 id="cards-pack" class="heading-xl" tabindex="0">
                    Tudo que você precisa está dentro do Pack 🎶SHOWS PRO!🎶
                </h2>

                <p class="pack-description">
                    Depois de anos Produzindo aberturas para os maiores nomes do sertanejo como Hugo e Guilherme,
                    Ana Castela, Felipe Araujo entre outros, Fael Castro decidiu abrir sua caixa de surpresas e
                    mostrar um dos maiores segredos que torna grandes as suas produções de Shows! O Pack shows Pro
                    une as ferramentas necessárias para seus arranjos fluirem de uma vez por todas e suas produções
                    impactarem de verdade!
                </p>

                <ul class="pack-items" aria-label="Componentes incluídos no pack Shows Pro">

                    <li class="pack-card">
                        <div class="glow glow--left"></div>
                        <div class="pack-card-img">
                            <img src="/assets/images/samples.png" alt="Samples" />
                        </div>
                        <div class="pack-card-text pack-card-text--right">
                            <h3>Samples Musicais</h3>
                            <p>Uma curadoria de elite pronta para dar a identidade profissional que seu show merece.</p>
                        </div>
                    </li>

                    <li class="pack-card pack-card--reverse">
                        <div class="glow glow--right"></div>
                        <div class="pack-card-text">
                            <h3>Efeitos Sonoros (FX)</h3>
                            <p>Transições e impactos cinematográficos que prendem a atenção do público do início ao fim.
                            </p>
                        </div>
                        <div class="pack-card-img">
                            <img src="/assets/images/efeitos.png" alt="Efeitos" />
                        </div>
                    </li>

                    <li class="pack-card">
                        <div class="glow glow--left"></div>
                        <div class="pack-card-img">
                            <img src="/assets/images/loops.png" alt="Loops" />
                        </div>
                        <div class="pack-card-text pack-card-text--right">
                            <h3>Loops Exclusivos</h3>
                            <p>Grooves envolventes e texturas rítmicas criadas para preencher o som com energia máxima.
                            </p>
                        </div>
                    </li>

                </ul>

                <h3 class="heading-xl" tabindex="0">
                    Use o Shows Pro para impactar a todos em qualquer cenário abaixo:
                </h3>

                <ul class="cenarios-grid" aria-label="Cenários de uso do Shows Pro">
                    <li>
                        <article class="cenario-card">
                            <h4>No Palco</h4>
                            <p>Comece o show com uma intro épica que faz o público vibrar antes mesmo da primeira nota.
                            </p>
                        </article>
                    </li>
                    <li>
                        <article class="cenario-card">
                            <h4>No Estúdio</h4>
                            <p>Use os efeitos e loops como base criativa para trilhas, introduções ou ambientações.
                                Agilidade + qualidade sonora.</p>
                        </article>
                    </li>
                    <li>
                        <article class="cenario-card">
                            <h4>Em Eventos</h4>
                            <p>Tenha introduções prontas e adaptáveis para qualquer formato de apresentação</p>
                        </article>
                    </li>
                </ul>

                <button onclick="document.getElementById('valores').scrollIntoView({ behavior: 'smooth' })"
                    class="btn-cta" aria-label="Botão para garantir o produto Shows Pro">
                    GARANTIR O SHOWS PRO AGORA
                </button>
            </div>
        </section>

        <!-- ═══ Testimonials ═══ -->
        <section class="testimonials-section" aria-labelledby="relatos-usuarios">
            <div class="fade-left"></div>
            <div class="fade-right"></div>
            <div class="container--7xl"
                style="max-width:80rem;margin:0 auto;padding:0 1rem;display:flex;flex-direction:column;gap:1.5rem;align-items:center;text-align:center;">

                <h2 id="relatos-usuarios" class="heading-2xl">
                    Quem usa o Shows Pro para produzir chega em resultados incríveis
                </h2>
                <h3 style="font-size:1.125rem;color:var(--zinc-400);">
                    Veja o feedback real de quem já está aplicando o Shows Pro
                </h3>

                <div id="drag-carousel" class="drag-carousel">
                    <img src="/assets/images/prova_social_depoimentos/d1.webp" alt="Depoimento">
                    <img src="/assets/images/prova_social_depoimentos/d3.webp" alt="Depoimento">
                    <img src="/assets/images/prova_social_depoimentos/d4.webp" alt="Depoimento">
                    <img src="/assets/images/prova_social_depoimentos/d5.webp" alt="Depoimento">
                    <img src="/assets/images/prova_social_depoimentos/d6.webp" alt="Depoimento">
                    <img src="/assets/images/prova_social_depoimentos/d7.webp" alt="Depoimento">
                    <img src="/assets/images/prova_social_depoimentos/d8.webp" alt="Depoimento">
                    <img src="/assets/images/prova_social_depoimentos/d10.webp" alt="Depoimento">
                </div>

                <p class="drag-hint">Arraste para ver os próximos</p>
            </div>
        </section>

        <!-- ═══ Pricing ═══ -->
        <section class="pricing-section viewcontent" role="region" aria-labelledby="valores" id="preco">
            <div class="container--6xl"
                style="max-width:72rem;margin:0 auto;padding:1rem;display:flex;flex-direction:column;gap:2rem;align-items:center;text-align:center;">

                <h2 id="valores" class="heading-2xl heading-gradient">
                    Escolha seu Plano
                </h2>

                <ul class="plans-grid" aria-label="Planos e valores disponíveis">

                    <!-- Essential -->
                    <li style="display:flex;flex-direction:column;">
                        <article class="plan-card" style="height:100%;">
                            <h4 id="oferta-essential">Essential</h4>
                            <img src="/assets/images/shows-pro-essential.png" alt="Shows Pro: Essential"
                                loading="lazy">
                            <ul class="plan-features">
                                <li>Intro épica pronta</li>
                                <li class="strike">Arranjos mais exclusivos</li>
                                <li class="strike">Mais opções de intro</li>
                                <li>Stems individuais</li>
                                <li class="strike">Bônus Pack de Samples</li>
                                <li>Para quem: Primeira intro profissional</li>
                            </ul>
                            <div class="mt-auto">
                                <p class="plan-price">R$ 127</p>
                                <a href="https://pay.kiwify.com.br/chmLFIJ" class="btn-plan IniciateCheckout">
                                    EU QUERO ESSENTIAL
                                </a>
                            </div>
                        </article>
                    </li>

                    <!-- Plus -->
                    <li style="display:flex;flex-direction:column;">
                        <article class="plan-card" style="height:100%;">
                            <h4 id="oferta-plus">Plus</h4>
                            <img src="/assets/images/shows-pro-plus.png" alt="Shows Pro: Plus" loading="lazy">
                            <ul class="plan-features">
                                <li>Intro épica pronta</li>
                                <li>Arranjos mais exclusivos</li>
                                <li>Mais opções de intro</li>
                                <li>Stems individuais</li>
                                <li class="strike">Bônus Pack de Samples</li>
                                <li>Para quem: Quer mais punch</li>
                            </ul>
                            <div class="mt-auto">
                                <p class="plan-price">R$ 167</p>
                                <a href="https://pay.kiwify.com.br/uJUgCl5" class="btn-plan IniciateCheckout">
                                    EU QUERO PLUS
                                </a>
                            </div>
                        </article>
                    </li>

                    <!-- Ultimate -->
                    <li style="display:flex;flex-direction:column;">
                        <div class="plan-card--ultimate-wrap" style="height:100%;">
                            <div class="plan-card--ultimate-border"></div>
                            <div class="plan-card--ultimate" style="height:100%;">
                                <h4 id="oferta-ultimate">Ultimate</h4>
                                <img src="/assets/images/shows-pro-ultimate.png" alt="Shows Pro: Ultimate"
                                    loading="lazy"
                                    style="border-radius:.375rem;width:100%;transition:transform .5s;margin-bottom:1rem;">
                                <ul class="plan-features">
                                    <li>Intro épica pronta</li>
                                    <li>Arranjos mais exclusivos</li>
                                    <li>Mais opções de intro</li>
                                    <li>Stems individuais</li>
                                    <li>Bônus Pack de Samples</li>
                                    <li>Para quem: Busca experiência stadium</li>
                                </ul>
                                <div class="mt-auto">
                                    <p class="plan-price" style="filter:drop-shadow(0 0 20px rgba(0,255,100,.8));">R$
                                        197</p>
                                    <a href="https://pay.kiwify.com.br/hjmY5oG" class="btn-plan IniciateCheckout">
                                        EU QUERO ULTIMATE
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>

                </ul>
            </div>
        </section>

        <!-- ═══ About ═══ -->
        <section class="about-section" aria-labelledby="quem-sou-titulo">
            <div class="container">
                <div class="about-grid">
                    <div class="about-img" role="figure">
                        <img src="/assets/images/rafa-quem-sou-eu-2.jpeg" alt="Rafa: produtor musical"
                            loading="lazy">
                    </div>
                    <div class="about-text1">
                        <p>
                            Meu nome é Rafael Castro, mas muitos me conhecem como <strong>Fael Castro</strong> — músico
                            e produtor musical com uma trajetória construída nos palcos e nos bastidores da música
                            brasileira.
                        </p>
                        <p>
                            Ao longo dos anos, tive o privilégio de atuar acompanhando grandes artistas nacionais em
                            shows por todo o país, contribuindo diretamente na performance ao vivo e na construção de
                            experiências memoráveis para o público. Entre os nomes com quem já trabalhei nos palcos
                            estão <strong>Diego & Victor Hugo, Ana Castela e Israel & Rodolffo.</strong>
                        </p>
                    </div>
                    <div class="about-text2">
                        <p>
                            Nos bastidores, minha atuação vai além da performance. Como produtor musical, participei da
                            produção de aberturas e shows de artistas como <strong>Hugo & Guilherme, Felipe Araújo, Ana
                                Castela, Emílio & Eduardo, Rio Negro & Solimões</strong>, entre outros grandes nomes do
                            mercado sertanejo.
                        </p>
                        <p>
                            Minha trajetória também ultrapassou fronteiras: já realizei turnês internacionais, levando a
                            música brasileira para os Estados Unidos e para a Europa, ampliando minha vivência artística
                            e experiência de palco.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ═══ FAQ ═══ -->
        <section class="faq-section" aria-labelledby="faq-title">
            <div class="container text-center">
                <h2 id="faq-title" class="heading-xl" tabindex="0">Perguntas Frequentes</h2>

                <div class="faq-item">
                    <button type="button" class="faq-toggle" aria-expanded="false" aria-controls="faq-answer-1">
                        <span>🔸 Para quem é o Shows Pro?</span>
                        <i class="fa-solid fa-plus" aria-hidden="true"></i>
                    </button>
                    <div id="faq-answer-1" class="faq-answer" role="region">
                        <div class="faq-answer-inner">
                            <div class="faq-answer-content">
                                <p>O Shows Pro é indicado para <strong>Iniciantes, Intermediários e
                                        Profissionais</strong>.</p>
                                <p><strong>Iniciantes:</strong> Auxilia no treino, estudo sobre Tracks, produção
                                    musical, instrumentos e arranjos.</p>
                                <p><strong>Intermediários:</strong> Ajuda na criação de novas ideias. Os Packs funcionam
                                    como assistência.</p>
                                <p><strong>Profissionais:</strong> Modelos prontos de temas e samples para agilizar
                                    processos.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button type="button" class="faq-toggle" aria-expanded="false" aria-controls="faq-answer-2">
                        <span>🔸 Como funciona o acesso ao produto?</span>
                        <i class="fa-solid fa-plus" aria-hidden="true"></i>
                    </button>
                    <div id="faq-answer-2" class="faq-answer" role="region">
                        <div class="faq-answer-inner">
                            <div class="faq-answer-content">
                                <p>Após efetuar a compra, o seu acesso será enviado para o e-mail cadastrado na
                                    plataforma <strong>Kiwify</strong>, onde estarão hospedados todos os arquivos.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="faq-item">
                    <button type="button" class="faq-toggle" aria-expanded="false" aria-controls="faq-answer-3">
                        <span>🔸 Tenho garantia após a compra?</span>
                        <i class="fa-solid fa-plus" aria-hidden="true"></i>
                    </button>
                    <div id="faq-answer-3" class="faq-answer" role="region">
                        <div class="faq-answer-inner">
                            <div class="faq-answer-content">
                                <p>Caso o Shows Pro não atenda às suas expectativas, você pode solicitar reembolso
                                    em até <strong>7 dias</strong>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ═══ Footer ═══ -->
        <section class="footer-section" aria-labelledby="rodape">
            <div class="container text-center">
                <a href="https://wa.me/5534991256642" target="_blank" rel="noopener noreferrer" class="btn-whatsapp"
                    role="button" aria-label="Falar conosco no WhatsApp" title="Falar conosco no WhatsApp">
                    <span>Entrar em contato via WhatsApp</span>
                </a>
                <div role="contentinfo" aria-live="polite">
                    <p class="footer-copy">© 2026 - Todos os direitos reservados</p>
                </div>
            </div>
        </section>

    </div><!-- end .page-wrapper -->

    <!-- Floating WhatsApp -->
    <div class="whatsapp-float">
        <a href="https://wa.me/5534991256642" target="_blank" rel="noopener noreferrer"
            aria-label="Falar conosco no WhatsApp" title="Falar conosco no WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>
    </div>

    <script>
        // ── FAQ ──
        document.querySelectorAll('.faq-toggle').forEach(button => {
            button.addEventListener('click', () => {
                const answer = button.nextElementSibling;
                const isOpen = button.getAttribute('aria-expanded') === 'true';
                const icon = button.querySelector('i');

                document.querySelectorAll('.faq-toggle').forEach(other => {
                    if (other !== button) {
                        other.setAttribute('aria-expanded', 'false');
                        other.nextElementSibling.classList.remove('open');
                        other.querySelector('i').className = 'fa-solid fa-plus';
                        other.querySelector('i').style.transform = '';
                    }
                });

                if (isOpen) {
                    button.setAttribute('aria-expanded', 'false');
                    answer.classList.remove('open');
                    icon.className = 'fa-solid fa-plus';
                    icon.style.transform = '';
                } else {
                    button.setAttribute('aria-expanded', 'true');
                    answer.classList.add('open');
                    icon.className = 'fa-solid fa-minus';
                    icon.style.transform = 'rotate(180deg)';
                }
            });
        });

        // ── Video Carousel ──
        function scrollCarousel(direction) {
            const carousel = document.getElementById('video-carousel');
            if (!carousel || !carousel.firstElementChild) return;
            const itemWidth = carousel.firstElementChild.offsetWidth;
            const gap = 16;
            const isDesktop = window.innerWidth >= 768;
            const multiplier = isDesktop ? 2 : 1;
            carousel.scrollBy({
                left: direction * (itemWidth + gap) * multiplier,
                behavior: 'smooth'
            });
        }

        // ── Drag Carousel ──
        const dragSlider = document.getElementById('drag-carousel');
        if (dragSlider) {
            let isDown = false,
                startX, scrollLeft;

            dragSlider.addEventListener('mousedown', e => {
                isDown = true;
                dragSlider.classList.add('grabbing');
                startX = e.pageX - dragSlider.offsetLeft;
                scrollLeft = dragSlider.scrollLeft;
                dragSlider.style.scrollSnapType = 'none';
                dragSlider.style.scrollBehavior = 'auto';
            });
            dragSlider.addEventListener('mouseleave', () => {
                isDown = false;
                dragSlider.classList.remove('grabbing');
            });
            dragSlider.addEventListener('mouseup', () => {
                isDown = false;
                dragSlider.classList.remove('grabbing');
                dragSlider.style.scrollSnapType = 'x mandatory';
                dragSlider.style.scrollBehavior = 'smooth';
            });
            dragSlider.addEventListener('mousemove', e => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - dragSlider.offsetLeft;
                const walk = (x - startX) * 2;
                dragSlider.scrollLeft = scrollLeft - walk;
            });
        }
    </script>
</body>

</html>
