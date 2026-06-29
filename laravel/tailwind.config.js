import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                pcc: {
                    yellow: '#FFC60B',
                    black: '#000000',
                    white: '#FFFFFF',
                },
            },
            fontFamily: {
                sans: ['Manrope', ...defaultTheme.fontFamily.sans],
                display: ['Space Grotesk', 'Manrope', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms({ strategy: 'class' }), typography],
};
