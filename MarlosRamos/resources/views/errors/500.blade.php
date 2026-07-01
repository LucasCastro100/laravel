<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>500 — Erro Interno</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #030712; color: #e5e7eb; font-family: ui-sans-serif, system-ui, sans-serif; display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 1.5rem; }
        .card { background: #111827; border: 1px solid #1f2937; border-radius: 1.25rem; padding: 3rem 2.5rem; max-width: 460px; width: 100%; text-align: center; }
        .icon { width: 72px; height: 72px; background: rgba(245,158,11,0.1); border: 1px solid rgba(245,158,11,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; }
        .icon i { font-size: 1.75rem; color: #fbbf24; }
        .code { font-size: 4rem; font-weight: 700; color: #374151; line-height: 1; margin-bottom: 0.5rem; }
        h1 { font-size: 1.25rem; font-weight: 600; color: #f9fafb; margin-bottom: 0.75rem; }
        p { font-size: 0.875rem; color: #6b7280; line-height: 1.6; margin-bottom: 2rem; }
        .btn { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.625rem 1.25rem; background: #2563eb; color: #fff; border-radius: 0.625rem; font-size: 0.875rem; font-weight: 500; text-decoration: none; transition: background 0.15s; }
        .btn:hover { background: #1d4ed8; }
        .btn-sec { background: transparent; border: 1px solid #374151; color: #9ca3af; margin-left: 0.5rem; }
        .btn-sec:hover { background: #1f2937; color: #e5e7eb; }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
        <div class="code">500</div>
        <h1>Erro Interno</h1>
        <p>Ocorreu um erro no servidor. Nossa equipe já foi notificada. Por favor, tente novamente em instantes.</p>
        <div>
            <a href="javascript:history.back()" class="btn"><i class="fa-solid fa-arrow-left"></i> Voltar</a>
            <a href="/" class="btn btn-sec"><i class="fa-solid fa-house"></i> Início</a>
        </div>
    </div>
</body>
</html>
