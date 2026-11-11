import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [react()],
  resolve: {
    tsconfigPaths: true,
  },
  // BrowserRouter: 상대경로면 /a/b 같은 깊은 경로에서 assets 404
  base: process.env.ELECTRON ? './' : '/',
  server: {
    port: 3000,
  },
});
