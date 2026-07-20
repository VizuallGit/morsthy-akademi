import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import statamic from '@statamic/cms/vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        tailwindcss(),
        statamic(),
        laravel({
            input: [
                'resources/css/cp.css',
            ],
            buildDirectory: 'vendor/app',
            hotFile: 'public/cp.hot',
        }),
    ],
});
