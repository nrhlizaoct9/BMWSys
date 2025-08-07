import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

// /** @type {import('tailwindcss').Config} */
// export default {
//     content: [
//         './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
//         './storage/framework/views/*.php',
//         './resources/views/**/*.blade.php',
//     ],

//     theme: {
//         extend: {
//             fontFamily: {
//                 sans: ['Figtree', ...defaultTheme.fontFamily.sans],
//             },
//         },
//     },

//     plugins: [forms],
// };

/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  safelist: [
    'group-hover:block',
    'group-hover:flex',
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}


