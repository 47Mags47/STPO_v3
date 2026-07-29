import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

import vue from "@vitejs/plugin-vue";

const env = loadEnv("all", process.cwd());

export default defineConfig({
    resolve: {
        alias: {
            "@components":  "/resources/views/components",
            "@widjets":     "/resources/views/widjets",
            "@layouts":     "/resources/views/layouts",
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/css/main.css',
                'resources/sass2/app.sass',
                'resources/js/app.js'
            ],
            refresh: false,
        }),
        vue(),
        tailwindcss()
    ],
    css: {
        preprocessorOptions: {
            sass: {
                additionalData: `
                    @use '/resources/sass2/abstracts' as *
                `,
            },
        },
    },
    server: {
        host: true,
        port: env.VITE_ASSET_PORT,
        strictPort: true,
        hmr: {
            host: env.VITE_ASSET_HOST,
            port: env.VITE_ASSET_PORT,
        },
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
