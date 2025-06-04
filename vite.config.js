// import { defineConfig } from 'vite';
// import laravel from 'laravel-vite-plugin';
// import tailwindcss from 'tailwindcss';

// export default defineConfig({
//   plugins: [
//     laravel({
//         input: [
//             'resources/css/app.css',
//             'resources/js/app.js',
//             'resources/js/backend/pd_non_active.js',
//             'resources/js/backend/daftar-pd.js',
//             'resources/js/backend/gtk.js',
//           ],
//       refresh: true,
//     }),
//   ],
//   css: {
//     postcss: {
//       plugins: [tailwindcss()],
//     },
//   },
// });

import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from 'tailwindcss';
import path from 'path';

export default defineConfig(({ command, mode }) => {
  // 🔥 Load env variables dari .env file
  const env = loadEnv(mode, process.cwd(), '');
  const activeTheme = env.VITE_ACTIVE_THEME || 'default';

  console.log('Active Theme:', activeTheme); // ✅ Untuk debug

  const themePath = path.resolve(__dirname, `resources/themes/${activeTheme}`);

  let input = [
    'resources/css/app.css',
    'resources/js/app.js',
    'resources/js/backend/pd_non_active.js',
    'resources/js/backend/daftar-pd.js',
    'resources/js/backend/gtk.js',
  ];

  if (command === 'serve' || command === 'build') {
    if (activeTheme !== 'default') {
      input.push(
        path.join(themePath, 'src/app.css'),
        path.join(themePath, 'src/app.js')
      );
    }
  }

  return {
    plugins: [
      laravel({
        input,
        refresh: true,
      }),
    ],
    css: {
      postcss: {
        plugins: [tailwindcss()],
      },
    },
    resolve: {
      alias: {
        '@': path.resolve(__dirname, 'resources/js'),
        '~theme': path.resolve(themePath, 'src'),
      },
    },
    build: {
      rollupOptions: {
        output: {
          entryFileNames: `themes/${activeTheme}/assets/[name].js`,
          chunkFileNames: `themes/${activeTheme}/assets/[name].js`,
          assetFileNames: `themes/${activeTheme}/assets/[name].[ext]`,
        },
      },
    },
  };
});
