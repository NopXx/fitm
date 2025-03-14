import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'public/assets/scss/style.scss',
                'resources/css/carousel.css',
                'resources/css/department.css',
                'resources/css/new.css',
                'resources/css/tinymce-content.css',
            ],
            refresh: true,
        }),
    ],
});
