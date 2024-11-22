import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'public/plugins/fontawesome-free/css/all.min.css',
                'public/plugins/icheck-bootstrap/icheck-bootstrap.min.css',
                'public/dist/css/adminlte.min.css'
            ],
            refresh: true,
        }),
    ],
});
