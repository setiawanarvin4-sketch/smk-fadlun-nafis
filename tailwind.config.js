import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

theme: {
    extend: {
        colors: {
            navy: '#16211C',
            'navy-dark': '#123524',
            'accent-blue': '#1B6B3A',
            'light-blue': '#EAF3EC',
            'accent-teal': '#0E7A7A',
            'accent-gold': '#C98A2C',
        },
        fontFamily: {
            sans: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
        },
    },
},

    plugins: [forms],
};