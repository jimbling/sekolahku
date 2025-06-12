import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js', // Tambahkan path jika Anda menggunakan file JS
    ],

    safelist: [
        {
            pattern: /bg-(blue|green|red|yellow|purple|pink|indigo|teal|orange|sky|emerald|cyan|rose|lime)-(50|100)/,
        },
        {
            pattern: /text-(blue|green|red|yellow|purple|pink|indigo|teal|orange|sky|emerald|cyan|rose|lime)-(600|700)/,
        },
        {
            pattern: /hover:bg-(blue|green|red|yellow|purple|pink|indigo|teal|orange|sky|emerald|cyan|rose|lime)-100/,
        },
        {
            pattern: /group-hover:text-(blue|green|red|yellow|purple|pink|indigo|teal|orange|sky|emerald|cyan|rose|lime)-700/,
        },
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    daisyui: {
        themes: ["light", "dark"],
    },

    variants: {
        extend: {
            scale: ['hover', 'focus'],
        },
    },

    plugins: [
        forms,
        require('daisyui'),
        require('@tailwindcss/line-clamp'),
    ],
};



// KONFIGURASI DASAR

// import defaultTheme from 'tailwindcss/defaultTheme';
// import forms from '@tailwindcss/forms';

// /** @type {import('tailwindcss').Config} */
// export default {
//     content: [
//         './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
//         './storage/framework/views/*.php',
//         './resources/views/**/*.blade.php',
//         './resources/js/**/*.js', // Tambahkan path jika Anda menggunakan file JS
//     ],

//     theme: {
//         extend: {
//             fontFamily: {
//                 sans: ['Figtree', ...defaultTheme.fontFamily.sans],
//             },
//         },
//     },

//     daisyui: {
//         themes: ["light", "dark"],
//     },

//     variants: {
//         extend: {
//             scale: ['hover', 'focus'],
//         },
//     },

//     plugins: [
//         forms,
//         require('daisyui'),
//         require('@tailwindcss/line-clamp'),
//     ],

// };
