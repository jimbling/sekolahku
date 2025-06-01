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

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from 'tailwindcss';

export default defineConfig(({ command }) => {
  // Ambil tema aktif dari env variable, default 'default'
  const activeTheme = process.env.MIX_ACTIVE_THEME || 'default';

  // Input default untuk tema utama
  let input = [
    'resources/css/app.css',
    'resources/js/app.js',
    'resources/js/backend/pd_non_active.js',
    'resources/js/backend/daftar-pd.js',
    'resources/js/backend/gtk.js',
  ];

  // Jika sedang develop dan tema bukan default, tambahkan file tema aktif supaya bisa hot reload juga
  if (command === 'serve' && activeTheme !== 'default') {
    input.push(
      `resources/themes/${activeTheme}/app.css`,
      `resources/themes/${activeTheme}/app.js`
    );
  }

  return {
    plugins: [
      laravel({
        input: input,
        refresh: true,
      }),
    ],
    css: {
      postcss: {
        plugins: [tailwindcss()],
      },
    },
  };
});

