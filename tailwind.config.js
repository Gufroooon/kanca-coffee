import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    darkMode: 'class',

    theme: {
        extend: {
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', 'Poppins', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                kanca: {
                    orange: '#EB5724',
                    orangeHover: '#d44716',
                    teal: '#28A096',
                    tealHover: '#1e837a',
                    bg: '#FFF8F5',
                    dark: '#232323',
                }
            }
        },
    },

    plugins: [forms],
};
