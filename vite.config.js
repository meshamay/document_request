import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import react from '@vitejs/plugin-react'; // Optional: only if using React

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',   // SCSS entry
                'resources/js/app.js',       // JS entry
            ],
            refresh: true,                  // Hot reload on Blade/PHP changes
        }),
        react(), // Optional: remove if not using React
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'), // Allows imports like "@/components/MyComponent"
        },
    },
    css: {
        preprocessorOptions: {
            scss: {
                additionalData: `@import "resources/sass/_variables.scss";` // Optional: global SCSS variables
            },
        },
    },
    server: {
        host: '0.0.0.0', // Allows access via network
        port: 5173,      // Default Vite dev port
        strictPort: true,
    },
    build: {
        outDir: 'public/build',
        emptyOutDir: true,
        rollupOptions: {
            output: {
                manualChunks: undefined, // Keeps all JS in one chunk for simplicity
            },
        },
    },
});
