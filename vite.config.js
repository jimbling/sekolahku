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
  const env = loadEnv(mode, process.cwd(), '');
  const activeTheme = env.VITE_ACTIVE_THEME || 'default';

  console.log('🧩 Active Theme:', activeTheme);

  const themeInputPath = `resources/themes/${activeTheme}/src`;

  const input = [
    `${themeInputPath}/app.css`,
    `${themeInputPath}/app.js`,
    'resources/js/backend/pd_non_active.js',
    'resources/js/backend/daftar-pd.js',
    'resources/js/backend/gtk.js',
  ];

  return {
    plugins: [
      laravel({
        input,
        refresh: true,
        buildDirectory: `build-themes/${activeTheme}`,
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
        '~theme': path.resolve(__dirname, themeInputPath),
      },
    },
    build: {
  outDir: `public/build-themes/${activeTheme}`,
  rollupOptions: {
    output: {
      entryFileNames: `assets/[name].js`,
      chunkFileNames: `assets/[name]-[hash].js`,
      assetFileNames: `assets/[name].[ext]`,
    },
  },
},

  };
});

