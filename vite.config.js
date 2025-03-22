import { defineConfig } from 'vite';
import path from 'path'
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap')
        }
    },
    server:{
        host: 'form.p.az',
        port: 5199
    },
    plugins: [
        laravel({
            input: ['resources/js/app.js'],
            refresh: true,
        }),
    ],
});
