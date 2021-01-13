const plugin = require('tailwindcss/plugin')


module.exports = {
    purge: [
        './resources/index/*.blade.php',
        './resources/index/*.js',
    ],
    important: true,
    darkMode: false, // or 'media' or 'class'
    theme: {
        fontFamily: {
            'sans': ['Roboto', 'Helvetica', 'Arial', 'sans-serif']
        },
        extend: {
            colors: {
                'login': '#0fb4d3',
                'color-theme': 'orangered',
                'bg-cnt': '#202e78',
                'card-color': '#F1F5F8',
                theme: {
                    1: '#1C3FAA',
                    2: '#F1F5F8',
                    3: '#2e51bb',
                    4: '#3151BC',
                    5: '#dee7ef',
                    6: '#D32929',
                    7: '#365A74',
                    8: '#D2DFEA',
                    9: '#91C714',
                    10: '#3160D8',
                    11: '#F78B00',
                    12: '#FBC500',
                    13: '#7F9EB9',
                    14: '#E6F3FF',
                    15: '#8DA9BE',
                    16: '#607F96',
                    17: '#FFEFD9',
                    18: '#D8F8BC',
                    19: '#E6F3FF',
                    20: '#2449AF',
                    21: '#284EB2',
                    22: '#395EC1',
                    23: '#D6E1FF',
                    24: '#2e51bb',
                    25: '#C6D4FD',
                    26: '#E8EEFF',
                    27: '#98AFF5',
                    28: '#1A389F',
                    29: '#142C91',
                    30: '#8da3e6',
                    31: '#ffd8d8',
                    32: '#3b5998',
                    33: '#4ab3f4',
                    34: '#517fa4',
                    35: '#0077b5',
                    36: '#d18d96',
                    37: '#c7d2ff',
                    38: '#15329A',
                    40: '#203FAD',
                    41: '#BBC8FD'
                },
                dark: {
                    1: '#293145',
                    2: '#232a3b',
                    3: '#313a55',
                    4: '#1e2533',
                    5: '#3f4865',
                    6: '#2b3348',
                    7: '#181f29'
                },
            },
            borderWidth: {
                DEFAULT: '1px',
                '1': '1px',
            },
            width: {
                "3/10": "30%",
                "7/10": "70%",
                '72%': '72%'
            },
            transitionProperty: {
                'height': 'height'
            },
            transitionDuration: {
                '0': '0ms',
                '2000': '2000ms',
            },
            flex: {
                '1.5': '1.5 1.5 0%',
                '2': '2 2 0%',
                '3': '3 3 0%',
            },
            maxWidth: {
                "1xl": "1348px",
                '1/4': '25%',
                '1/2': '50%',
                '3/4': '75%',
            }

        },
        screens: {
            'xs': '379px',
            'sm': '639px',
            'md': '767px',
            "mdc": "829px",
            'lg': '1023px',
            'xl': '1279px',
            'xxl': '1536px',
        },


        variants: {
            extend: {
                borderStyle: ['hover', 'focus'],
                fontWeight: ['hover', 'focus'],
                borderWidth: ['hover', 'focus'],
            },

        },
        plugins: [],
    }
}
