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

    

    theme: {
        extend: {
                    colors: {
                        primary: '#4F46E5',
                        secondary: '#10B981',
                        accent: '#F59E0B',
                        dark: '#1F2937',
                        light: '#F9FAFB',
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },

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
