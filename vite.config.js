import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        react(),
        laravel([
            'resources/react-app/index.css',
            'resources/react-app/main.tsx',
        ]),
    ],
});
