import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    base: 'https://permutabrasil.com.br/',
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/js/dashboard.js',
                'resources/js/web.js'
            ],
            refresh: true,
        }),
    ],
    css: {
        preprocessorOptions: {
            css: {                
                additionalData: `
                    @import "resources/css/page/variables.css";
                    @import "resources/css/page/responsive.css";
                    @import "resources/css/page/standard.css";
                    @import "resources/css/elements/alert.css";
                    @import "resources/css/elements/button.css";
                    @import "resources/css/elements/carousel.css";
                    @import "resources/css/elements/details.css";
                    @import "resources/css/elements/form.css";
                    @import "resources/css/elements/modal.css";
                    @import "resources/css/elements/pagination.css";
                    @import "resources/css/elements/table.css";
                `,
            },
        },
    },
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources'),
        },
    },
});