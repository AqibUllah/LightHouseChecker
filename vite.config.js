import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from "@vitejs/plugin-vue";
import tailwindcss from "tailwindcss";
import path from 'path';

export default defineConfig({
    plugins: [
        tailwindcss(),
        vue(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            vue: "vue/dist/vue.esm-bundler.js",
            '@composables': path.resolve(__dirname, '/resources/js/composables'),
            '@stores': path.resolve(__dirname, '/resources/js/stores'),

        },
    },
});
