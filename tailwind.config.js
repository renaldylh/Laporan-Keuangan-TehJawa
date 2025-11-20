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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'teh-jawa-gold': '#D4AF37',
                'teh-jawa-gold-dark': '#B8941F',
                'teh-jawa-gold-light': '#E6C547',
                'teh-jawa-gold-accent': '#F4E4B1',
                'teh-jawa-green-dark': '#2D5016',
                'teh-jawa-green': '#4A7C28',
                'teh-jawa-cream': '#FFF8E7',
                'teh-jawa-brown': '#8B4513',
                'teh-jawa-black': '#1A1A1A',
                'teh-jawa-gray': '#6B7280',
            },
            keyframes: {
                'teh-float': {
                    '0%, 100%': { transform: 'translateY(0px)' },
                    '50%': { transform: 'translateY(-20px)' },
                },
            },
            animation: {
                'teh-float': 'teh-float 6s ease-in-out infinite',
            },
        },
    },

    plugins: [forms],
};
