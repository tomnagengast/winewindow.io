const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    mode: 'jit',
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                // sans: ['Nunito', ...defaultTheme.fontFamily.sans],
                sans: ['Inter var', ...defaultTheme.fontFamily.sans],
            },
            textColor: {
                'brand-primary': '#1f2937', // '#292929'
                'brand-secondary': '#ffffff',
                'brand-highlight': '#ffffff',
            },
            backgroundColor: {
                'brand-primary': '#1f2937',
                'brand-secondary': '#ffffff',
            },
            minHeight: {
                '15': '15em',
            },
            borderWidth: {
                '3': '3px',
                '6': '6px',
            }
        },
    },
    // important: true,
    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
