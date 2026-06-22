<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>RC Studio - Produção Musical Profissional</title>
    <meta name="description" content="Arranjos, loops e produção musical profissional para elevar seu show a outro nível.">
    <meta name="keywords" content="música, production musical, intros, beats, artista, cantor">
    <meta name="author" content="RC Studio">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://rcstudio.com.br/" />
    <meta property="og:title" content="RC Studio - Produção Musical Profissional" />
    <meta property="og:description" content="Arranjos, loops e produção musical profissional para elevar seu show a outro nível." />
    <meta property="og:image" content="https://rcstudio.com.br/images/og-share-rc.png" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:url" content="https://rcstudio.com.br/" />
    <meta name="twitter:title" content="RC Studio - Produção Musical Profissional" />
    <meta name="twitter:description" content="Arranjos, loops e produção musical profissional para elevar seu show a outro nível." />
    <meta name="twitter:image" content="https://rcstudio.com.br/images/og-share-rc.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700;900&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="icon" type="image/png" sizes="16x16" href="/images/icons/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/icons/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/icons/apple-touch-icon.png">

    <script src="https://kit.fontawesome.com/5ae086a3a0.js" crossorigin="anonymous" defer></script>

    <!-- ═══ ARQUITETURA DE ESTILOS GLOBAIS CONSOLIDADA ═══ -->
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --bg-black: #000000;
            --bg-surface: #0b0b10;
            --bg-deep: #050507;
            --red-bright: #ef4444;
            --red-dark: #8b0000;
            --red-mid: #b22222;
            --red-600: #dc2626;
            --orange-400: #fb923c;
            --orange-500: #f97316;
            --yellow-400: #facc15;
            --green-400: #4ade80;
            --emerald-500: #10b981;
            --text-muted: #a1a1aa;
            --zinc-400: #a1a1aa;
            --zinc-900: #18181b;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-900: #111827;
            --white: #ffffff;

            --font-title: 'Orbitron', sans-serif;
            --font-body: 'Figtree', sans-serif;

            --max-w-5xl: 64rem;
            --max-w-6xl: 72rem;
            --max-w-7xl: 80rem;

            --radius-lg: 1.25rem;
            --radius-xl: 0.75rem;
            --radius-2xl: 1rem;
            --radius-3xl: 1.5rem;

            --transition-smooth: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font-body);
            background: var(--bg-black);
            color: var(--white);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            line-height: 1.6;
            overflow-x: hidden;
        }

        .page-wrapper {
            display: flex;
            flex-direction: column;
            background: var(--bg-black);
        }

        .container {
            max-width: var(--max-w-5xl);
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* Títulos e Tipografia Premium */
        .modern-section-title {
            font-family: var(--font-title);
            font-size: clamp(2rem, 4.5vw, 3.2rem);
            font-weight: 900;
            text-transform: uppercase;
            text-align: center;
            letter-spacing: -0.02em;
            margin-bottom: 0.75rem;
            background: linear-gradient(180deg, #ffffff 40%, #a1a1aa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 30px rgba(255, 255, 255, 0.05);
        }

        .section-subtitle {
            text-align: center;
            color: var(--text-muted);
            font-size: clamp(1rem, 2.5vw, 1.2rem);
            max-width: 650px;
            margin: 0 auto 4rem auto;
            line-height: 1.6;
        }

        .heading-gradient {
            background: linear-gradient(90deg, var(--red-500), var(--orange-400), var(--yellow-400));
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: 0.1em;
            filter: drop-shadow(0 0 20px rgba(255, 80, 0, 0.4));
            animation: gradient-text 4s ease infinite;
        }

        /* Elementos de Chamada de Ação (CTA) */
        .btn-cta-modern {
            display: inline-block;
            padding: 1.2rem 2.5rem;
            font-family: var(--font-title);
            font-weight: 900;
            font-size: 1.05rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: var(--white);
            background: linear-gradient(135deg, var(--red-600), #991b1b);
            border-radius: var(--radius-lg);
            box-shadow: 0 10px 30px rgba(239, 68, 68, 0.2);
            transition: var(--transition-smooth);
            border: none;
            cursor: pointer;
            text-align: center;
        }

        .btn-cta-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(239, 68, 68, 0.4);
            filter: brightness(1.1);
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

        /* Animações Core */
        @keyframes pulse-ring {
            0%, 100% { opacity: 0.8; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(1.02); }
        }

        @keyframes spin-slow {
            to { transform: rotate(360deg); }
        }

        @keyframes whatsapp-pulse {
            0%, 100% { box-shadow: 0 10px 30px rgba(16, 185, 129, 0.35); }
            50% { box-shadow: 0 15px 45px rgba(16, 185, 129, 0.6); }
        }

        @keyframes gradient-text {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        /* Seções Mestre */
        .premium-section {
            padding: 6rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
        }

        /* Estilos do Módulo Hero */
        .hero-module {
            position: relative; 
            padding: 8rem 0 6rem 0;
            background: radial-gradient(circle at 50% -20%, rgba(239, 68, 68, 0.15) 0%, transparent 60%);
            text-align: center;
        }
        
        .hero-content-wrap {
            max-width: 900px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .title-hero-premium {
            font-family: var(--font-title); 
            font-size: clamp(2.2rem, 5vw, 3.8rem); 
            line-height: 1.1; 
            font-weight: 900; 
            text-transform: uppercase; 
            margin-bottom: 1.5rem; 
            letter-spacing: -0.03em;
            background: linear-gradient(135deg, #ffffff 30%, #f3f4f6 60%, var(--red-bright));
            -webkit-background-clip: text; 
            -webkit-text-fill-color: transparent;
        }

        .hero-content-wrap h2 { 
            font-size: clamp(1.1rem, 2.2vw, 1.35rem); 
            color: var(--text-muted); 
            font-weight: 400; 
            line-height: 1.6; 
            margin-bottom: 3.5rem; 
            max-width: 750px;
        }

        .hero-asset-wide {
            width: 100%;
            max-width: 960px;
            margin-bottom: 3.5rem;
            position: relative;
        }

        .hero-frame-video {
            position: relative; 
            width: 100%; 
            padding-top: 56.25%;
            border-radius: var(--radius-lg); 
            overflow: hidden; 
            background: #000;
            box-shadow: 0 30px 60px rgba(0,0,0,0.8), 0 0 50px rgba(220, 38, 38, 0.15); 
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: var(--transition-smooth);
        }

        .hero-asset-wide:hover .hero-frame-video { 
            transform: translateY(-2px); 
            border-color: rgba(239, 68, 68, 0.25); 
        }

        .hero-frame-video iframe { 
            position: absolute; 
            top: 0; 
            left: 0; 
            width: 100%; 
            height: 100%; 
            border: none; 
        }

        .hero-payment { 
            margin-top: 2rem; 
            opacity: 0.4; 
            filter: grayscale(1); 
            transition: var(--transition-smooth); 
        }

        .hero-content-wrap:hover .hero-payment { 
            opacity: 0.8; 
            filter: grayscale(0); 
        }

        /* Estilos do Módulo Dores */
        .pain-module { background-color: var(--bg-surface); }
        .pain-layout { display: grid; grid-template-columns: 1fr; gap: 2rem; margin-top: 2rem; }
        @media (min-width: 768px) { .pain-layout { grid-template-columns: repeat(2, 1fr); } }
        .card-pain {
            background: linear-gradient(135deg, rgba(15, 15, 22, 0.6) 0%, rgba(8, 8, 12, 0.8) 100%);
            border: 1px solid rgba(255, 255, 255, 0.03); padding: 3rem 2rem; border-radius: var(--radius-lg);
            position: relative; overflow: hidden; transition: var(--transition-smooth);
        }
        .card-pain:hover { border-color: rgba(239, 68, 68, 0.2); transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.5); }
        .card-pain i { color: var(--red-bright); font-size: 1.6rem; margin-bottom: 1.2rem; display: block; filter: drop-shadow(0 0 8px rgba(239,68,68,0.3)); }
        .card-pain h3 { font-family: var(--font-title); font-size: 1.3rem; margin-bottom: 0.8rem; text-transform: uppercase; }
        .card-pain p { color: var(--text-muted); font-size: 1rem; line-height: 1.6; }
        .frustration-strip {
            grid-column: 1 / -1; background: linear-gradient(135deg, rgba(153, 27, 27, 0.06) 0%, rgba(6, 6, 8, 0.5) 100%);
            border: 1px solid rgba(239, 68, 68, 0.12); padding: 3.5rem 2rem; border-radius: var(--radius-lg); text-align: center;
        }
        .frustration-strip h4 { font-family: var(--font-title); color: var(--red-bright); text-transform: uppercase; letter-spacing: 0.15em; font-size: 0.85rem; margin-bottom: 1rem; }
        .frustration-strip p { font-size: clamp(1.15rem, 2.5vw, 1.6rem); font-weight: 700; max-width: 800px; margin: 0 auto; color: #f4f4f5; }
        .urgency-text { font-size: clamp(1.1rem, 2.5vw, 1.4rem); color: var(--zinc-400); margin-top: 2rem; text-align: center; }

        /* Estilos do Carrossel de Vídeos */
        .video-showcase-module { background-color: var(--bg-deep); overflow: hidden; }
        .showcase-container { max-width: var(--max-w-6xl); margin: 0 auto; padding: 0 1.5rem; position: relative; }
        .premium-carousel-viewport { display: flex; gap: 1.5rem; overflow-x: auto; scroll-snap-type: x mandatory; padding: 1rem 0; scroll-behavior: smooth; }
        .premium-carousel-viewport::-webkit-scrollbar { display: none; }
        .premium-carousel-viewport { scrollbar-width: none; }
        .premium-video-node {
            scroll-snap-align: start; flex: 0 0 100%; width: 100%; background: #000; border-radius: var(--radius-lg);
            overflow: hidden; border: 1px solid rgba(255, 255, 255, 0.04); position: relative; padding-top: 56.25%;
            box-shadow: 0 20px 40px rgba(0,0,0,0.6); transition: var(--transition-smooth);
        }
        @media (min-width: 768px) { .premium-video-node { flex: 0 0 calc(50% - 0.75rem); width: calc(50% - 0.75rem); } }
        .premium-video-node iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none; }
        .premium-video-node:hover { border-color: rgba(239, 68, 68, 0.2); transform: translateY(-2px); }
        .carousel-action-bar { display: flex; flex-direction: column; align-items: center; gap: 1rem; margin-top: 2.5rem; }
        .nav-trigger-group { display: flex; gap: 1rem; }
        .nav-trigger-btn {
            width: 3.2rem; height: 3.2rem; border-radius: 50%; background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05); color: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: var(--transition-smooth);
        }
        .nav-trigger-btn:hover { background: var(--red-bright); border-color: var(--red-bright); box-shadow: 0 0 15px rgba(239,68,68,0.4); }
        .carousel-action-bar span { font-family: var(--font-title); font-size: 0.65rem; letter-spacing: 0.2em; text-transform: uppercase; color: var(--text-muted); }

        /* Estilos do Módulo Pack */
        .pack-module { background-color: var(--bg-surface); position: relative; }
        .pack-cards-grid { display: grid; grid-template-columns: 1fr; gap: 2rem; margin: 4rem 0; }
        @media (min-width: 768px) { .pack-cards-grid { grid-template-columns: repeat(3, 1fr); } }
        
        .pack-feature-card {
            background: linear-gradient(180deg, rgba(15, 15, 22, 0.6) 0%, rgba(8, 8, 12, 0.9) 100%);
            border: 1px solid rgba(255, 255, 255, 0.04); border-radius: var(--radius-lg);
            padding: 3rem 2rem; text-align: center; display: flex; flex-direction: column; align-items: center;
            transition: var(--transition-smooth); position: relative; overflow: hidden;
        }
        .pack-feature-card:hover { transform: translateY(-6px); border-color: rgba(239, 68, 68, 0.25); box-shadow: 0 30px 60px rgba(0, 0, 0, 0.6); }
        
        .pack-asset-display { width: 180px; height: 180px; margin-bottom: 2.5rem; position: relative; display: flex; align-items: center; justify-content: center; }
        .pack-asset-display::before {
            content: ''; position: absolute; width: 140px; height: 140px; background: radial-gradient(circle, rgba(239, 68, 68, 0.15) 0%, transparent 75%);
            top: 50%; left: 50%; transform: translate(-50%, -50%) scale(0.8); z-index: 0; pointer-events: none; transition: var(--transition-smooth); opacity: 0.7;
        }
        .pack-feature-card:hover .pack-asset-display::before { transform: translate(-50%, -50%) scale(1.2); background: radial-gradient(circle, rgba(239, 68, 68, 0.25) 0%, transparent 75%); opacity: 1; }
        .pack-asset-display img { width: 100%; height: auto; object-fit: contain; z-index: 1; filter: drop-shadow(0 15px 30px rgba(0,0,0,0.6)); transition: var(--transition-smooth); }
        .pack-feature-card:hover .pack-asset-display img { transform: scale(1.06) translateY(-4px); filter: drop-shadow(0 20px 40px rgba(0,0,0,0.8)); }
        
        .pack-feature-card h3 { font-family: var(--font-title); font-size: 1.4rem; text-transform: uppercase; font-weight: 700; margin-bottom: 1rem; letter-spacing: -0.01em; color: #ffffff; }
        .pack-feature-card p { color: var(--text-muted); font-size: 0.98rem; line-height: 1.6; margin: 0; }
        
        .scenarios-box-grid { display: grid; grid-template-columns: 1fr; gap: 1.5rem; margin: 3.5rem 0; }
        @media (min-width: 768px) { .scenarios-box-grid { grid-template-columns: repeat(3, 1fr); } }
        .scenarios-card-item { background: linear-gradient(180deg, rgba(11, 11, 16, 0.4) 0%, rgba(6, 6, 8, 0.6) 100%); border: 1px solid rgba(255, 255, 255, 0.03); padding: 2.5rem 2rem; border-radius: var(--radius-lg); text-align: left; transition: var(--transition-smooth); position: relative; }
        .scenarios-card-item:hover { border-color: rgba(255, 255, 255, 0.08); background: rgba(15, 15, 22, 0.5); }
        
        .scenario-badge {
            display: inline-flex; align-items: center; gap: 0.5rem; font-family: var(--font-title); font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--red-bright); background: rgba(239, 68, 68, 0.08); padding: 0.3rem 0.75rem; border-radius: 20px; margin-bottom: 1.25rem; border: 1px solid rgba(239, 68, 68, 0.15);
        }
        .scenarios-card-item h4 { font-family: var(--font-title); margin-bottom: 0.75rem; color: #ffffff; text-transform: uppercase; font-size: 1.15rem; font-weight: 700; }
        .scenarios-card-item p { color: var(--text-muted); font-size: 0.95rem; line-height: 1.6; margin: 0; }
        .text-center { text-align: center; }

        /* Estilos do Módulo de Depoimentos */
        .testimonials-module { background-color: var(--bg-deep); overflow: hidden; position: relative; }
        .testimonials-viewport { display: flex; gap: 1.5rem; overflow-x: auto; scroll-snap-type: x mandatory; padding: 2rem 0; scroll-behavior: smooth; }
        .testimonials-viewport::-webkit-scrollbar { display: none; }
        .testimonials-viewport { scrollbar-width: none; }
        .testimonial-node { scroll-snap-align: center; flex: 0 0 280px; width: 280px; transition: var(--transition-smooth); }
        @media (min-width: 768px) { .testimonial-node { flex: 0 0 320px; width: 320px; } }
        .testimonial-node img { width: 100%; height: auto; border-radius: var(--radius-lg); border: 1px solid rgba(255,255,255,0.04); box-shadow: 0 15px 35px rgba(0,0,0,0.5); transition: var(--transition-smooth); }
        .testimonial-node:hover img { transform: scale(1.03); border-color: rgba(255,255,255,0.15); box-shadow: 0 20px 45px rgba(0,0,0,0.7); }
        .fade-edge-left, .fade-edge-right { position: absolute; top: 0; bottom: 0; width: 8rem; z-index: 5; pointer-events: none; }
        .fade-edge-left { left: 0; background: linear-gradient(to right, var(--bg-deep), transparent); }
        .fade-edge-right { right: 0; background: linear-gradient(to left, var(--bg-deep), transparent); }

        /* Estilos do Módulo de Preços */
        .price-module { background-color: var(--bg-surface); }
        .price-cards-layout { display: grid; grid-template-columns: 1fr; gap: 2.5rem; align-items: stretch; margin-top: 3rem; }
        @media (min-width: 768px) { .price-cards-layout { grid-template-columns: repeat(2, 1fr); } }
        @media (min-width: 1024px) { .price-cards-layout { grid-template-columns: repeat(3, 1fr); } }
        .box-tier-card {
            background: linear-gradient(180deg, rgba(15, 15, 22, 0.7) 0%, rgba(6, 6, 8, 0.9) 100%);
            border: 1px solid rgba(255, 255, 255, 0.04); border-radius: var(--radius-lg);
            padding: 3.5rem 2rem; display: flex; flex-direction: column; align-items: center;
            transition: var(--transition-smooth); position: relative;
        }
        .box-tier-card:hover { transform: translateY(-6px); border-color: rgba(255,255,255,0.08); box-shadow: 0 25px 50px rgba(0,0,0,0.6); }
        .box-tier-card.tier-featured {
            background: padding-box linear-gradient(var(--bg-surface), var(--bg-surface)), border-box linear-gradient(135deg, #f59e0b, var(--red-bright));
            border: 2px solid transparent; box-shadow: 0 20px 50px rgba(239, 68, 68, 0.12);
        }
        .box-tier-card.tier-featured::before {
            content: ''; position: absolute; inset: 0; border-radius: calc(var(--radius-lg) - 2px); border: 1px solid rgba(255, 255, 255, 0.02); pointer-events: none;
        }
        .badge-premium-orange {
            position: absolute; top: -13px; background: linear-gradient(90deg, #f59e0b, #d97706);
            color: #000; font-family: var(--font-title); font-size: 0.65rem; font-weight: 900;
            padding: 0.4rem 1.2rem; border-radius: 30px; letter-spacing: 0.1em; text-transform: uppercase;
        }
        .box-tier-card h4 { font-family: var(--font-title); font-size: 1.5rem; text-transform: uppercase; margin-bottom: 1.5rem; font-weight: 700; }
        .box-tier-card img { width: 100%; max-width: 150px; height: auto; margin-bottom: 2rem; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.5)); transition: var(--transition-smooth); }
        .box-tier-card:hover img { transform: scale(1.04); }
        .list-specs { list-style: none; width: 100%; text-align: left; margin-bottom: 3rem; display: flex; flex-direction: column; gap: 0.85rem; }
        .list-specs li { font-size: 0.95rem; color: #a1a1aa; display: flex; align-items: center; gap: 0.75rem; }
        .list-specs li i { color: #34d399; font-size: 0.9rem; }
        .list-specs li.line-blocked { color: #3f3f46; text-decoration: line-through; }
        .list-specs li.line-blocked i { color: #3f3f46; }
        .bottom-action-wrap { margin-top: auto; width: 100%; text-align: center; }
        .value-label { font-family: var(--font-title); font-size: 2.6rem; font-weight: 900; color: #34d399; margin-bottom: 1.2rem; letter-spacing: -0.02em; }
        .btn-full-width { width: 100%; padding: 1rem 1.5rem; font-size: 0.95rem; }

        /* Estilos do Módulo Perfil (Quem Sou Eu) com Texto Fluido */
        .profile-module { background-color: var(--bg-deep); position: relative; }
        .profile-fluid-layout { margin-top: 3.5rem; width: 100%; display: block; }
        .profile-fluid-layout::after { content: ""; display: table; clear: both; }
        
        .profile-fluid-media { float: left; width: 100%; max-width: 380px; margin: 0 auto 2rem auto; position: relative; }
        @media (min-width: 768px) { .profile-fluid-media { margin: 0 2.5rem 1.5rem 0; } }
        
        .profile-media-mask { border-radius: var(--radius-lg); overflow: hidden; border: 1px solid rgba(255, 255, 255, 0.06); box-shadow: 0 25px 50px rgba(0,0,0,0.7); background-color: var(--bg-surface); transition: var(--transition-smooth); }
        .profile-media-mask img { width: 100%; height: auto; display: block; filter: grayscale(0.1) contrast(1.02); transition: var(--transition-smooth); }
        
        .profile-fluid-media:hover .profile-media-mask { border-color: rgba(239, 68, 68, 0.25); box-shadow: 0 30px 60px rgba(0,0,0,0.85); }
        .profile-fluid-media:hover .profile-media-mask img { filter: grayscale(0) contrast(1); }
        
        .profile-fluid-text h3 { font-family: var(--font-title); font-size: clamp(1.8rem, 3.5vw, 2.4rem); margin-bottom: 1.2rem; text-transform: uppercase; font-weight: 900; letter-spacing: -0.01em; background: linear-gradient(135deg, #ffffff, #c8c8cc); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .profile-fluid-text p { color: var(--text-muted); font-size: clamp(1rem, 1.6vw, 1.1rem); line-height: 1.75; margin-bottom: 1.25rem; text-align: justify; }
        @media (max-width: 768px) { .profile-fluid-text p { text-align: left; } }
        .profile-fluid-text p strong { color: #ffffff; font-weight: 600; }

        /* Estilos do Módulo FAQ */
        .qa-module { background-color: var(--bg-surface); }
        .qa-stack-container { max-width: 800px; margin: 3rem auto 0 auto; display: flex; flex-direction: column; gap: 1.25rem; }
        .accordion-row-node { background: linear-gradient(180deg, rgba(11, 11, 16, 0.4) 0%, rgba(6, 6, 8, 0.6) 100%); border: 1px solid rgba(255, 255, 255, 0.03); border-radius: var(--radius-lg); overflow: hidden; transition: var(--transition-smooth); }
        .accordion-bar-button { width: 100%; padding: 1.75rem 2rem; background: none; border: none; display: flex; justify-content: space-between; align-items: center; color: #ffffff; font-family: var(--font-body); font-size: 1.15rem; font-weight: 600; text-align: left; cursor: pointer; }
        .accordion-bar-button span { padding-right: 1.5rem; }
        .accordion-bar-button i { color: var(--red-bright); font-size: 1rem; transition: var(--transition-smooth); width: 30px; height: 30px; background: rgba(255, 255, 255, 0.02); border-radius: 50%; display: flex; align-items: center; justify-content: center; }
        .accordion-dropdown-pane { max-height: 0; overflow: hidden; transition: max-height 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
        .accordion-inner-text { padding: 0 2rem 1.75rem 2rem; color: var(--text-muted); font-size: 1rem; line-height: 1.7; }
        .accordion-inner-text p { margin-bottom: 0.75rem; }
        .accordion-inner-text p:last-child { margin-bottom: 0; }
        .accordion-inner-text strong { color: #ffffff; }
        .accordion-row-node.node-active { border-color: rgba(239, 68, 68, 0.2); background: rgba(15, 15, 22, 0.7); box-shadow: 0 15px 30px rgba(0,0,0,0.4); }
        .accordion-row-node.node-active .accordion-bar-button i { transform: rotate(135deg); background: rgba(239, 68, 68, 0.1); }

        /* Estilos do Módulo de Rodapé */
        .footer-module { background-color: var(--bg-deep); padding: 5rem 0; text-align: center; }
        .btn-wa-green { background: linear-gradient(135deg, #10b981 0%, #047857 100%); box-shadow: 0 10px 25px rgba(16, 185, 129, 0.15); }
        .btn-wa-green:hover { background: linear-gradient(135deg, #34d399 0%, #059669 100%); box-shadow: 0 0 35px rgba(16, 185, 129, 0.25), 0 10px 25px rgba(4, 120, 87, 0.3); }
        .footer-copy { font-size: 0.85rem; letter-spacing: 0.02em; color: #42424a; margin-top: 2.5rem; }
        .fixed-sticky-wa { position: fixed; bottom: 2rem; right: 2rem; z-index: 9999; width: 56px; height: 56px; background: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #ffffff; font-size: 1.6rem; animation: whatsapp-pulse 2s infinite; transition: var(--transition-smooth); border: 1px solid rgba(255,255,255,0.05); }
        .fixed-sticky-wa:hover { transform: scale(1.06) translateY(-2px); background: #34d399; }
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

        <!-- ================= DOBRA 1: HERO ================= -->
        <section class="hero-module" aria-labelledby="hero-title-id">
            <div class="container">
                <div class="hero-content-wrap">
                    <h1 id="hero-title-id" class="title-hero-premium">Pare de Fazer Produções Amadoras</h1>
                    <h2>O <strong>Shows Pro</strong> é a caixa de ferramentas definitiva com samples, efeitos e loops premium criados por especialistas para dar peso e clareza comercial imediata aos seus arranjos.</h2>
                    
                    <!-- Vídeo Centralizado de Grande Porte -->
                    <div class="hero-asset-wide">
                        <div class="hero-frame-video">
                            <iframe src="https://www.youtube.com/embed/oNJCRjqjQa8?rel=0" title="Apresentação do Shows Pro" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>

                    <button onclick="document.getElementById('preco').scrollIntoView({ behavior: 'smooth' })" class="btn-cta-modern" aria-label="Garantir acesso ao produto Shows Pro">Garantir O Shows Pro Agora</button>
                    <br>
                    <img src="/assets/images/pagamento.webp" alt="Formas de pagamento aceitas" class="hero-payment" loading="eager" width="320" height="45">
                </div>
            </div>
        </section>

        <!-- ═══ DOBRA 2: DORES & DESAFIOS (Consciência Comercial) ═══ -->
        <section class="premium-section pain-module" aria-labelledby="pain-title-id">
            <div class="container">
                <h2 id="pain-title-id" class="modern-section-title">Você sabe o peso da responsabilidade</h2>
                <p class="section-subtitle">O nível atual do mercado exige impacto instantâneo dos profissionais. Entenda os desafios sonoros imediatos.</p>
                
                <div class="pain-layout">
                    <div class="card-pain">
                        <i class="fa-solid fa-bolt" aria-hidden="true"></i>
                        <h3>O Impacto Inicial</h3>
                        <p>A introdução determina se a plateia vai se arrepiar e focar na sua performance ou perder o interesse e abrir as redes sociais.</p>
                    </div>
                    <div class="card-pain">
                        <i class="fa-solid fa-wave-square" aria-hidden="true"></i>
                        <h3>Segundos Decisivos</h3>
                        <p>Sem um elemento sonoro profissional no início, toda a sequência do show luta contra a dispersão natural da audiência.</p>
                    </div>
                    <div class="frustration-strip">
                        <h4>O Fim da Frustração</h4>
                        <p>Chega de travar na hora de criar arranjos, de depender de arquivos copiados do YouTube ou de entregar produções que nunca parecem prontas.</p>
                    </div>
                </div>
                <p class="urgency-text">Muitas vezes você terá <strong>apenas segundos</strong> para provar que não veio brincar!</p>
            </div>
        </section>

        <!-- ═══ DOBRA 3: DEMONSTRAÇÃO (Carrossel de Portfólio em Vídeo) ═══ -->
        <section class="premium-section video-showcase-module" aria-labelledby="showcase-title-id">
            <div class="showcase-container">
                <h2 id="showcase-title-id" class="modern-section-title">Resultados de Alto Padrão</h2>
                <p class="section-subtitle">Confira abaixo as mega produções estruturadas, editadas e finalizadas utilizando o ecossistema do Shows Pro.</p>

                <div id="premium-video-slider" class="premium-carousel-viewport">
                    <div class="premium-video-node">
                        <iframe src="https://www.youtube.com/embed/eWUaNe4NY74?rel=0" title="Demonstração Real 1" allowfullscreen loading="lazy"></iframe>
                    </div>
                    <div class="premium-video-node">
                        <iframe src="https://www.youtube.com/embed/PDvOcu9ASvI?rel=0" title="Demonstração Real 2" allowfullscreen loading="lazy"></iframe>
                    </div>
                    <div class="premium-video-node">
                        <iframe src="https://www.youtube.com/embed/oDZ_Pp0dvrA?rel=0" title="Demonstração Real 3" allowfullscreen loading="lazy"></iframe>
                    </div>
                    <div class="premium-video-node">
                        <iframe src="https://www.youtube.com/embed/P40iBXVTcRk?rel=0" title="Demonstração Real 4" allowfullscreen loading="lazy"></iframe>
                    </div>
                </div>

                <div class="carousel-action-bar">
                    <div class="nav-trigger-group">
                        <button type="button" onclick="handleVideoScroll(-1)" class="nav-trigger-btn" aria-label="Vídeo anterior"><i class="fa-solid fa-chevron-left"></i></button>
                        <button type="button" onclick="handleVideoScroll(1)" class="nav-trigger-btn" aria-label="Próximo vídeo"><i class="fa-solid fa-chevron-right"></i></button>
                    </div>
                    <span>Clique para navegar</span>
                </div>
            </div>
        </section>

        <!-- ═══ DOBRA 4: ENTREGÁVEIS DO PACK & CASOS DE USO ═══ -->
        <section class="premium-section pack-module" aria-labelledby="pack-title-id">
            <div class="container">
                <h2 id="pack-title-id" class="modern-section-title">O Arsenal Completo do Pack</h2>
                <p class="section-subtitle">Uma biblioteca com foco em alta definição acústica, desenvolvida milimetricamente para preencher o espectro das suas tracks.</p>
                
                <!-- Grid de Cards de Produtos -->
                <div class="pack-cards-grid">
                    
                    <!-- Card 1 -->
                    <div class="pack-feature-card">
                        <div class="pack-asset-display">
                            <img src="/assets/images/samples.png" alt="Amostras e Samples Premium" loading="lazy" width="180" height="180">
                        </div>
                        <h3>Samples Musicais</h3>
                        <p>Curadoria acústica de elite selecionada para introduzir punch, peso e o acabamento comercial impecável exigido pelas grandes gravadoras e palcos atuais.</p>
                    </div>
                    
                    <!-- Card 2 -->
                    <div class="pack-feature-card">
                        <div class="pack-asset-display">
                            <img src="/assets/images/efeitos.png" alt="Efeitos Sonoros Especiais" loading="lazy" width="180" height="180">
                        </div>
                        <h3>Efeitos Sonoros (FX)</h3>
                        <p>Impactos profundos, sub-drops e transições dinâmicas com características cinematográficas, projetados para reter a atenção total do ouvinte.</p>
                    </div>
                    
                    <!-- Card 3 -->
                    <div class="pack-feature-card">
                        <div class="pack-asset-display">
                            <img src="/assets/images/loops.png" alt="Loops Rítmicos e Grooves" loading="lazy" width="180" height="180">
                        </div>
                        <h3>Loops Exclusivos</h3>
                        <p>Grooves rítmicos envolventes e texturas orgânicas desenvolvidos para encaixe perfeito no grid temporal, poupando tempo na edição de frequências básicas.</p>
                    </div>

                </div>

                <!-- Seção de Contexto de Aplicação -->
                <h3 class="modern-section-title" style="font-size: 1.6rem; margin-top: 6rem; margin-bottom: 1rem;">Dominância Sonora em Qualquer Ambiente</h3>
                <p class="section-subtitle" style="margin-bottom: 2rem;">Adapte os arquivos com facilidade e veja o impacto prático em seu fluxo de trabalho:</p>

                <div class="scenarios-box-grid">
                    <!-- Cenário 1 -->
                    <div class="scenarios-card-item">
                        <div class="scenario-badge"><i class="fa-solid fa-tower-broadcast"></i> Live Performance</div>
                        <h4>No Palco</h4>
                        <p>Comece sua apresentação com pressão sonora massiva que domina a acústica do ambiente e prende o público instantaneamente.</p>
                    </div>
                    
                    <!-- Cenário 2 -->
                    <div class="scenarios-card-item">
                        <div class="scenario-badge"><i class="fa-solid fa-sliders"></i> Studio Workflow</div>
                        <h4>No Estúdio</h4>
                        <p>Otimize drasticamente sua velocidade de entrega final sem abrir mão do rigor técnico na mixagem e pós-processamento.</p>
                    </div>
                    
                    <!-- Cenário 3 -->
                    <div class="scenarios-card-item">
                        <div class="scenario-badge"><i class="fa-solid fa-network-wired"></i> Versatility</div>
                        <h4>Em Eventos</h4>
                        <p>Elementos versáteis de engenharia de áudio ideais para adaptação ágil e segura em múltiplos sistemas de som e PAs.</p>
                    </div>
                </div>

                <div class="text-center" style="margin-top: 4rem;">
                    <button onclick="document.getElementById('preco').scrollIntoView({ behavior: 'smooth' })" class="btn-cta-modern" aria-label="Adquirir o pack de samples e efeitos">Garantir O Shows Pro Agora</button>
                </div>
            </div>
        </section>

        <!-- ═══ DOBRA 5: PROVA SOCIAL (Carrossel Dinâmico de Depoimentos) ═══ -->
        <section class="premium-section testimonials-module" aria-labelledby="testimonials-title-id">
            <div class="fade-edge-left"></div>
            <div class="fade-edge-right"></div>
            <div class="container" style="max-width: var(--max-w-7xl); position: relative; z-index: 6;">
                <h2 id="testimonials-title-id" class="modern-section-title">Resultados Incontestáveis</h2>
                <p class="section-subtitle">Veja o feedback real de engenheiros, produtores e músicos que transformaram seus arranjos com o pack.</p>

                <div id="premium-drag-carousel" class="testimonials-viewport" role="region" aria-label="Depoimentos de clientes">
                    <div class="testimonial-node"><img src="/assets/images/prova_social_depoimentos/d1.webp" alt="Depoimento de Cliente 1" loading="lazy"></div>
                    <div class="testimonial-node"><img src="/assets/images/prova_social_depoimentos/d3.webp" alt="Depoimento de Cliente 2" loading="lazy"></div>
                    <div class="testimonial-node"><img src="/assets/images/prova_social_depoimentos/d4.webp" alt="Depoimento de Cliente 3" loading="lazy"></div>
                    <div class="testimonial-node"><img src="/assets/images/prova_social_depoimentos/d5.webp" alt="Depoimento de Cliente 4" loading="lazy"></div>
                    <div class="testimonial-node"><img src="/assets/images/prova_social_depoimentos/d6.webp" alt="Depoimento de Cliente 5" loading="lazy"></div>
                    <div class="testimonial-node"><img src="/assets/images/prova_social_depoimentos/d7.webp" alt="Depoimento de Cliente 6" loading="lazy"></div>
                    <div class="testimonial-node"><img src="/assets/images/prova_social_depoimentos/d8.webp" alt="Depoimento de Cliente 7" loading="lazy"></div>
                    <div class="testimonial-node"><img src="/assets/images/prova_social_depoimentos/d10.webp" alt="Depoimento de Cliente 8" loading="lazy"></div>
                </div>

                <p class="text-center font-title" style="font-size: 0.65rem; letter-spacing: 0.25em; text-transform: uppercase; color: var(--text-muted); margin-top: 2rem;">
                    <i class="fa-solid fa-left-right" style="margin-right: 0.5rem;"></i> Clique e arraste para explorar
                </p>
            </div>
        </section>

        <!-- ═══ DOBRA 6: PLANOS & PREÇOS (Módulos com Borda Ativa) ═══ -->
        <section class="premium-section price-module" id="preco" aria-labelledby="price-title-id">
            <div class="container" style="max-width: var(--max-w-6xl);">
                <h2 id="price-title-id" class="modern-section-title heading-gradient">Escolha seu Plano</h2>
                <p class="section-subtitle">Acesso vitalício e download imediato após a confirmação do pagamento.</p>
                
                <div class="price-cards-layout">
                    <!-- Essential -->
                    <div class="box-tier-card">
                        <h4>Essential</h4>
                        <img src="/assets/images/shows-pro-essential.png" alt="Shows Pro Essential Package" loading="lazy" width="150" height="150">
                        <ul class="list-specs">
                            <li><i class="fa-solid fa-circle-check"></i> Intro épica pronta</li>
                            <li><i class="fa-solid fa-circle-check"></i> Stems individuais</li>
                            <li class="line-blocked"><i class="fa-solid fa-circle-xmark"></i> Arranjos mais exclusivos</li>
                            <li class="line-blocked"><i class="fa-solid fa-circle-xmark"></i> Mais opções de intro</li>
                            <li class="line-blocked"><i class="fa-solid fa-circle-xmark"></i> Bônus Pack de Samples</li>
                        </ul>
                        <div class="bottom-action-wrap">
                            <p class="value-label">R$ 127</p>
                            <a href="https://pay.kiwify.com.br/chmLFIJ" class="btn-cta-modern btn-full-width IniciateCheckout" aria-label="Comprar plano Essential">Quero o Essential</a>
                        </div>
                    </div>

                    <!-- Plus -->
                    <div class="box-tier-card">
                        <h4>Plus</h4>
                        <img src="/assets/images/shows-pro-plus.png" alt="Shows Pro Plus Package" loading="lazy" width="150" height="150">
                        <ul class="list-specs">
                            <li><i class="fa-solid fa-circle-check"></i> Intro épica pronta</li>
                            <li><i class="fa-solid fa-circle-check"></i> Stems individuais</li>
                            <li><i class="fa-solid fa-circle-check"></i> Arranjos mais exclusivos</li>
                            <li><i class="fa-solid fa-circle-check"></i> Mais opções de intro</li>
                            <li class="line-blocked"><i class="fa-solid fa-circle-xmark"></i> Bônus Pack de Samples</li>
                        </ul>
                        <div class="bottom-action-wrap">
                            <p class="value-label">R$ 167</p>
                            <a href="https://pay.kiwify.com.br/uJUgCl5" class="btn-cta-modern btn-full-width IniciateCheckout" aria-label="Comprar plano Plus">Quero o Plus</a>
                        </div>
                    </div>

                    <!-- Ultimate (Featured Card) -->
                    <div class="box-tier-card tier-featured">
                        <div class="badge-premium-orange">Recomendado</div>
                        <h4 style="background: linear-gradient(135deg, #f59e0b, #fbbf24); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Ultimate</h4>
                        <img src="/assets/images/shows-pro-ultimate.png" alt="Shows Pro Ultimate Stadium Package" loading="lazy" width="150" height="150">
                        <ul class="list-specs">
                            <li><i class="fa-solid fa-circle-check"></i> Intro épica pronta</li>
                            <li><i class="fa-solid fa-circle-check"></i> Stems individuais</li>
                            <li><i class="fa-solid fa-circle-check"></i> Arranjos mais exclusivos</li>
                            <li><i class="fa-solid fa-circle-check"></i> Mais opções de intro</li>
                            <li><i class="fa-solid fa-circle-check"></i> Bônus Pack de Samples</li>
                        </ul>
                        <div class="bottom-action-wrap">
                            <p class="value-label">R$ 197</p>
                            <a href="https://pay.kiwify.com.br/hjmY5oG" class="btn-cta-modern btn-full-width IniciateCheckout" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: #000;" aria-label="Comprar plano Ultimate">Quero o Ultimate</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ================= QUEM SOU EU ================= -->
        <section class="premium-section profile-module" aria-labelledby="profile-title-id">
            <div class="container">
                <h2 id="profile-title-id" class="modern-section-title">Quem está por trás do som</h2>
                <p class="section-subtitle">A bagagem técnica de quem vive diariamente a realidade das grandes arenas e estúdios comerciais.</p>

                <div class="profile-fluid-layout">
                    
                    <!-- Elemento Flutuante à Esquerda -->
                    <div class="profile-fluid-media">
                        <div class="profile-media-mask">
                            <img src="/assets/images/rafa-quem-sou-eu-2.jpeg" alt="Fael Castro atuando em estúdio de engenharia de áudio" loading="lazy" width="380" height="475">
                        </div>
                    </div>
                    
                    <!-- Texto Corrido que vai Contornar a Lateral e a Base da imagem -->
                    <div class="profile-fluid-text">
                        <h3>Fael Castro</h3>
                        <p>Construí minha carreira diretamente na estrada e nas estações de trabalho técnico da música sertaneja, desenhando aberturas estruturadas que marcam a identidade de turnês nacionais de grande expressão.</p>
                        <p>Como músico de palco, tive o privilégio de atuar acompanhando grandes artistas nacionais em shows por todo o país, contribuindo diretamente na performance ao vivo e na construção de experiências memoráveis para o público. Entre os nomes com quem já trabalhei nos palcos estão <strong>Diego & Victor Hugo, Ana Castela e Israel & Rodolffo</strong>.</p>
                        <p>Nos bastidores, minha atuação vai além da performance. Como produtor musical, participei da produção de aberturas e shows de artistas como <strong>Hugo & Guilherme, Felipe Araújo, Emílio & Eduardo e Rionegro & Solimões</strong>, entre outros grandes nomes do mercado musical brasileiro.</p>
                        <p>Minha trajetória ultrapassou fronteiras: realizei turnês internacionais levando a produção brasileira para os <strong>Estados Unidos e Europa</strong>. O Shows Pro compila esse ecossistema de soluções testadas e aprovadas, simplificando sua aplicação prática na sua DAW.</p>
                    </div>

                </div>
            </div>
        </section>

        <!-- ═══ DOBRA 8: FAQ (Perguntas Frequentes Glassmorphism) ═══ -->
        <section class="premium-section qa-module" aria-labelledby="faq-title-id">
            <div class="container">
                <h2 id="faq-title-id" class="modern-section-title">Perguntas Frequentes</h2>
                <p class="section-subtitle">Dúvidas rápidas sobre usabilidade, licenças de áudio e envio dos arquivos.</p>
                
                <div class="qa-stack-container">
                    <!-- Item 1 -->
                    <div class="accordion-row-node">
                        <button type="button" class="accordion-bar-button" aria-expanded="false">
                            <span>🔸 Para quem é o Shows Pro?</span>
                            <i class="fa-solid fa-plus" aria-hidden="true"></i>
                        </button>
                        <div class="accordion-dropdown-pane">
                            <div class="accordion-inner-text">
                                <p>O Shows Pro é perfeitamente indicado para <strong>Iniciantes, Intermediários e Profissionais</strong>.</p>
                                <p style="margin-top: 0.5rem;"><strong>Iniciantes:</strong> Auxilia no treino técnico, estudo detalhado sobre Stems, montagem de arranjos e produção do zero.</p>
                               <p><strong>Intermediários:</strong> Funciona como assistência criativa direta, fornecendo blocos estruturais complexos para destravar novas ideias de introdução.</p>
                               <p><strong>Profissionais:</strong> Garante agilidade de entrega no mercado corporativo através de samples limpos com pós-processamento de estúdio pronto para grandes PAs.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Item 2 -->
                    <div class="accordion-row-node">
                        <button type="button" class="accordion-bar-button" aria-expanded="false">
                            <span>🔸 Como funciona o acesso ao produto?</span>
                            <i class="fa-solid fa-plus" aria-hidden="true"></i>
                        </button>
                        <div class="accordion-dropdown-pane">
                            <div class="accordion-inner-text">
                                O processo de entrega é imediato e automatizado. Assim que o pagamento for aprovado pelo sistema de checkout seguro, os dados de login e o link direto para download de todos os arquivos do pack serão enviados instantaneamente para o endereço de e-mail cadastrado na plataforma <strong>Kiwify</strong>.
                            </div>
                        </div>
                    </div>

                    <!-- Item 3 -->
                    <div class="accordion-row-node">
                        <button type="button" class="accordion-bar-button" aria-expanded="false">
                            <span>🔸 Tenho garantia após a compra?</span>
                            <i class="fa-solid fa-plus" aria-hidden="true"></i>
                        </button>
                        <div class="accordion-dropdown-pane">
                            <div class="accordion-inner-text">
                                Sim, risco zero. Caso você analise os elementos e julgue que eles não se adequam perfeitamente ao seu modelo ou estilo de arranjo, você possui um prazo legal de garantia incondicional de até <strong>7 dias</strong> para solicitar o reembolso total do seu investmento diretamente no painel.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ═══ DOBRA 9: RODAPÉ & SUPORTE ATIVO ═══ -->
        <footer class="footer-module" aria-labelledby="footer-heading">
            <div class="container">
                <h2 id="footer-heading" class="sr-only">Suporte e Direitos Autorais</h2>
                <div style="margin-bottom: 2rem;">
                    <a href="https://wa.me/5534991256642" target="_blank" rel="noopener noreferrer" class="btn-cta-modern btn-wa-green" role="button" aria-label="Falar com suporte técnico no WhatsApp">
                        <i class="fa-brands fa-whatsapp" style="margin-right: 0.6rem; font-size: 1.25rem; vertical-align: middle;"></i> Entrar em contato via WhatsApp
                    </a>
                </div>
                <div role="contentinfo">
                    <p class="footer-copy">© 2026 RC Studio. Todos os direitos reservados. Engenharia frontend e otimização de performance premium.</p>
                </div>
            </div>
        </footer>

    </div><!-- end .page-wrapper -->

    <!-- WhatsApp Floating Action Button -->
    <a href="https://wa.me/5534991256642" target="_blank" rel="noopener noreferrer" class="fixed-sticky-wa" title="Falar com suporte no WhatsApp" aria-label="Falar com suporte no WhatsApp">
        <i class="fa-brands fa-whatsapp" aria-hidden="true"></i>
    </a>

    <!-- ═══ SISTEMA DE SCRIPTS GLOBAIS COMPACTOS ═══ -->
    <script>
        // ── 1. Gerenciador Inteligente do Acordeon (FAQ) ──
        document.querySelectorAll('.accordion-bar-button').forEach(btn => {
            btn.addEventListener('click', () => {
                const currentNode = btn.parentElement;
                const dropdownPane = currentNode.querySelector('.accordion-dropdown-pane');
                const isCurrentlyActive = currentNode.classList.contains('node-active');
                
                document.querySelectorAll('.accordion-row-node').forEach(row => {
                    row.classList.remove('node-active');
                    row.querySelector('.accordion-bar-button').setAttribute('aria-expanded', 'false');
                    row.querySelector('.accordion-dropdown-pane').style.maxHeight = null;
                });

                if (!isCurrentlyActive) {
                    currentNode.classList.add('node-active');
                    btn.setAttribute('aria-expanded', 'true');
                    dropdownPane.style.maxHeight = dropdownPane.scrollHeight + "px";
                }
            });
        });

        // ── 2. Carrossel de Vídeos (Módulo de Demonstração) ──
        function handleVideoScroll(direction) {
            const slider = document.getElementById('premium-video-slider');
            if (!slider || !slider.firstElementChild) return;
            const size = slider.firstElementChild.offsetWidth + 24; 
            slider.scrollBy({ left: direction * size, behavior: 'smooth' });
        }

        // ── 3. Carrossel Drag-to-Scroll Nativo (Módulo de Depoimentos) ──
        const scrollContainer = document.getElementById('premium-drag-carousel');
        if (scrollContainer) {
            let isDragging = false;
            let initialX, currentScrollPos;

            scrollContainer.addEventListener('mousedown', e => {
                isDragging = true;
                scrollContainer.style.cursor = 'grabbing';
                initialX = e.pageX - scrollContainer.offsetLeft;
                currentScrollPos = scrollContainer.scrollLeft;
                scrollContainer.style.scrollSnapType = 'none';
                scrollContainer.style.scrollBehavior = 'auto';
            });

            scrollContainer.addEventListener('mouseleave', () => {
                if (!isDragging) return;
                endDrag();
            });

            scrollContainer.addEventListener('mouseup', () => {
                if (!isDragging) return;
                endDrag();
            });

            scrollContainer.addEventListener('mousemove', e => {
                if (!isDragging) return;
                e.preventDefault();
                const currentX = e.pageX - scrollContainer.offsetLeft;
                const scrollOffset = (currentX - initialX) * 1.5; 
                scrollContainer.scrollLeft = currentScrollPos - scrollOffset;
            });

            function endDrag() {
                isDragging = false;
                scrollContainer.style.cursor = 'grab';
                scrollContainer.style.scrollSnapType = 'x mandatory';
                scrollContainer.style.scrollBehavior = 'smooth';
            }
        }
    </script>
</body>

</html>