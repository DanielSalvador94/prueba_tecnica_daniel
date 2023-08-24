import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import ViteVuetifyPlugin from 'vite-plugin-vuetify';

export default defineConfig({
  build: {
    sourcemap: true
  },
  optimizeDeps: {
    include: ['vuetify'],
  },
  plugins: [
    laravel({
      input: ['resources/js/app.js'],
      refresh: true,
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
    ViteVuetifyPlugin(),
  ],
  server: {
    hmr: {
      host: 'localhost',
    },
  },
});
