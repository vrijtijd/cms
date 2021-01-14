const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                'vt-blue': {
                    100: '#e6f3f4',
                    200: '#cee8e9',
                    300: '#b5dcde',
                    400: '#9dd1d3',
                    500: '#84c5c8',
                    600: '#77b1b4',
                    700: '#6a9ea0',
                    800: '#5c8a8c',
                    900: '#4f7678',
                },
                'vt-pink': {
                    100: '#faece7',
                    200: '#f6d9cf',
                    300: '#f1c7b8',
                    400: '#edb4a0',
                    500: '#e8a188',
                    600: '#d1917a',
                    700: '#ba816d',
                    800: '#a2715f',
                    900: '#8b6152',
                },
                'vt-darkGray': {
                    100: '#d9d8d8',
                    200: '#b3b1b0',
                    300: '#8c8b89',
                    400: '#666461',
                    500: '#403d3a',
                    600: '#3a3734',
                    700: '#33312e',
                    800: '#2d2b29',
                    900: '#262523',
                },
                'vt-lightGray': {
                    100: '#f9f9f9',
                    200: '#f3f3f3',
                    300: '#eeeeee',
                    400: '#e8e8e8',
                    500: '#e2e2e2',
                    600: '#cbcbcb',
                    700: '#b5b5b5',
                    800: '#9e9e9e',
                    900: '#888888',
                },
            },
            fontFamily: {
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
            cursor: {
                grab: 'grab',
                grabbing: 'grabbing',
            },
        },
    },

    variants: {
        extend: {
            opacity: ['responsive', 'hover', 'focus', 'disabled'],
            padding: ['last'],
        }
    },

    plugins: [
        require('@tailwindcss/ui'),
        require('@tailwindcss/forms'),
    ],
};
