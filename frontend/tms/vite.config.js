import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueDevTools from 'vite-plugin-vue-devtools'

// https://vite.dev/config/
export default defineConfig({
  plugins: [
    vue(),
    vueDevTools(),
  ],
  server: {
    proxy: {
      // Proxy any request starting with /api
      '/api': {
        target: 'http://127.0.0.1:8000',
        changeOrigin: true,
        // leave the path as-is: /api/login → http://127.0.0.1:8000/api/login
        rewrite: (path) => path
      }
    }
  },
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    },
  },
})
