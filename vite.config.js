import { defineConfig } from 'vite';
import { resolve } from 'path';

export default defineConfig({
  // پوشه اصلی پروژه
  root: 'assets/src',
  
  // تنظیمات build
  build: {
    // پوشه خروجی
    outDir: '../dist',
    emptyOutDir: true,
    
    // فایل‌های ورودی
    rollupOptions: {
      input: {
        main: resolve(__dirname, 'assets/src/js/main.js'),
        style: resolve(__dirname, 'assets/src/scss/main.scss'),
      },
      output: {
        // نام فایل‌های JS
        entryFileNames: 'js/[name].js',
        // نام فایل‌های CSS
        assetFileNames: (assetInfo) => {
          if (assetInfo.name.endsWith('.css')) {
            return 'css/[name][extname]';
          }
          return 'assets/[name][extname]';
        },
      },
    },
    
    // Minify در production
    minify: 'terser',
    
    // Source maps برای debug
    sourcemap: true,
  },
  
  // تنظیمات CSS
  css: {
    devSourcemap: true,
  },
  
  // تنظیمات dev server
  server: {
    // برای کار با وردپرس لوکال
    cors: true,
    port: 3000,
  },
});
