// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
        cors: {
            origin: [
                'https://skyfoxmarket.my.id',
                'http://skyfoxmarket.my.id',
                'http://localhost',
                'http://127.0.0.1'
            ],
        },
    },
});
