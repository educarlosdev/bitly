import { defineConfig, splitVendorChunkPlugin } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'

export default defineConfig({
    plugins: [
        splitVendorChunkPlugin(),
        vue({
            template: {
                compilerOptions: {
                    isCustomElement: (tag) => ['lottie-player'].includes(tag),
                }
            }
        }),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
