import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import Icons from 'unplugin-icons/vite';

export default defineConfig({
  plugins: [vue(), Icons({ compiler: 'vue3' })],
  define: {
    'process.env.NODE_ENV': JSON.stringify('production'),
  },
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
