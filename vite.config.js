import vue from "@vitejs/plugin-vue";
import laravel from "laravel-vite-plugin";
import path from "path";
import { defineConfig } from "vite";

// prettier-ignore
export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.ts', 'resources/js/game.ts'],
            refresh: true,
        }),
    ],
    css: {
        preprocessorOptions: {
            scss: {
                additionalData: `@use "resources/scss/styles/mixins.scss" as *; @use "resources/scss/styles/common.scss" as *;`
            }
        }
    },
    resolve: {
        alias: {
            '@game': path.resolve(__dirname, 'resources/js/game'),
            '@': path.resolve(__dirname, 'resources/js'),
            '@components': path.resolve(__dirname, 'resources/js/components'),
            '@utils': path.resolve(__dirname, 'resources/js/utils'),
            '@assets': path.resolve(__dirname, 'resources/assets'),
            '@public': path.resolve(__dirname, 'public/assets'),
        },
    },
});
