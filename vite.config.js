import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
  server: {
    hmr: {
      overlay: false,
    },
  },
  plugins: [
    laravel({
      input: ['resources/js/app.jsx', 'resources/css/app.css'],
      refresh: true,
    }),
    react(),
  ],
});
