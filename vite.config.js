import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/main.js',
                'resources/sass/_variables.scss',
                'resources/css/app.css',
                'resources/css/themes.css',
                'resources/css/mediaQuery.css',
                'resources/js/chat.js',
                'resources/js/esp.js',
                'resources/js/ita.js',
                 'resources/js/servers.js'
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
});
