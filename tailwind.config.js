const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            brightness: {
                25: '.25',
            }
        },
    },

    plugins: [require('@tailwindcss/forms')],

    safelist: [
        'text-red-500',
        'grayscale',
        'brightness-25',
    ],
};
