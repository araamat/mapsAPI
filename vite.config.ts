import vue from '@vitejs/plugin-vue';
import autoprefixer from 'autoprefixer';
import laravel from 'laravel-vite-plugin';
import { resolve } from 'node:path';
import path from 'path';
import tailwindcss from 'tailwindcss';
import { defineConfig } from 'vite';

export default defineConfig({
    base: '/build/', // ✅ tagab õiged suhtelised teed

    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.ts'],
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        vue(),
    ],

    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/js'),
            'ziggy-js': resolve(__dirname, 'vendor/tightenco/ziggy'),
        },
    },

    css: {
        postcss: {
            plugins: [tailwindcss, autoprefixer],
        },
    },

    build: {
        manifest: true,
        outDir: 'public/build',
    },
});
