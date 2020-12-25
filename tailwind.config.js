module.exports = {
    purge: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {
            colors: {
                'login': '#0fb4d3',
                'color-theme': 'orangered',
                'indigo-dark': '#202e78',
            },

        },
        screens: {
            'xs': '379px',
            'sm': '639px',
            'md': '767px',
            'lg': '1023px',
            'xl': '1279px',
            '1xl': '1536px',
        },


        variants: {
            extend: {},
        },
        plugins: [],
    }
}
