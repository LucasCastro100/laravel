import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    base: '/build/', // Caminho público dos assets (HTML <script src="/build/xxx.js">)
    publicDir: false, // Evita cópia automática de arquivos de 'public' (a Laravel já gerencia isso)
    build: {
        outDir: '../public_html/build', // Onde os arquivos compilados serão gerados
        emptyOutDir: true, // Limpa a pasta antes de construir
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    optimizeDeps: {
        include: ['@alpinejs/collapse'], // Adiciona o plugin à otimização de dependências
      },
});
