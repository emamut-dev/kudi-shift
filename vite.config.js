import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
  plugins: [vue()],
  build: {
    outDir: 'build',
    emptyOutDir: true,
    lib: {
      entry: 'src/main.js',
      name: 'KudiShiftApp',
      formats: ['iife'],
      fileName: () => 'app.js',
    },
  },
});
