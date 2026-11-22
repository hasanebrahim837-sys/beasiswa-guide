import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Open Sans', 'IBM Plex Sans Arabic', ...defaultTheme.fontFamily.sans],
                heading: ['Open Sans', 'Amiri', ...defaultTheme.fontFamily.serif],
                tagline: ['Roboto Slab', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                brand: {
                    olive: '#6B6947',
                    burgundy: '#4B1A24',
                    beige: '#E5DFD3',
                    paper: '#FAF7F2',
                    orange: '#D07830', // attention buttons only
                    dark: '#2B211C',
                },
            },
        },
    },

    plugins: [forms],
};
