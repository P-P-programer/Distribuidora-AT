import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  build: { outDir: 'public/build', emptyOutDir: true },
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/js/modules/search.js',
        'resources/js/modules/cart-badge-reset.js',
        'resources/js/modules/cart-buy.js',
        'resources/js/modules/user-management.js',
        'resources/js/modules/analytics.js',
      ],
      refresh: true,
    }),
  ],
});
