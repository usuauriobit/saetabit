const defaultTheme = require('tailwindcss/defaultTheme');
const { mytheme } = require('./theme.js');
const theme = require('./theme.js')
module.exports = {
    mode: 'jit',
    purge: [
        // './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        // './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
    ],
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
        maxHeight: {
            '5/6': '83.333333%',
        },
        container: {
            padding: {
              DEFAULT: '1rem',
              sm: '2rem',
              lg: '4rem',
              xl: '4rem',
              '2xl': '6rem',
            },
          },
    },
    plugins: [
        // require('@tailwindcss/forms'),
        // require('@tailwindcss/typography'),
        require('daisyui'),
    ],
    daisyui: {
        styled: true,
        themes: mytheme,
        base: true,
        utils: true,
        logs: true,
        rtl: false,
    },
};
