import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';

import vue from "@vitejs/plugin-vue";

const env = loadEnv("all", process.cwd());

export default defineConfig({
    resolve: {
        alias: {
            "@components":  "/resources/views/components",
            "@widjets":     "/resources/views/widjets",
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/sass/app.sass',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
        vue(),
    ],
    css: {
        preprocessorOptions: {
            sass: {
                additionalData: `
                    @use '/resources/sass/abstracts/variables' as *;\n
                    @use '/resources/sass/abstracts/mixins' as *;\n
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
