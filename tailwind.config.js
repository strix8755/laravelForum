const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: '#EBF5FF',
                    100: '#D6EBFF',
                    200: '#A0CFFF',
                    300: '#6BB2FF',
                    400: '#3694FF', 
                    500: '#1F76F2',
                    600: '#0C59D4',
                    700: '#0A45A9',
                    800: '#07337F',
                    900: '#052154',
                    950: '#021236',
                },
                secondary: {
                    500: '#3B82F6',
                    600: '#2563EB',
                    700: '#1D4ED8',
                    800: '#1E40AF',
                }
            },
            boxShadow: {
                'smooth': '0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03)',
                'card': '0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.03)',
            },
            typography: (theme) => ({
                DEFAULT: {
                    css: {
                        maxWidth: 'none',
                        color: theme('colors.gray.700'),
                        a: {
                            color: theme('colors.primary.600'),
                            '&:hover': {
                                color: theme('colors.primary.700'),
                            },
                        },
                        'h1, h2, h3, h4': {
                            color: theme('colors.gray.900'),
                            fontWeight: theme('fontWeight.semibold'),
                        },
                    },
                },
                dark: {
                    css: {
                        color: theme('colors.gray.300'),
                        a: {
                            color: theme('colors.primary.400'),
                            '&:hover': {
                                color: theme('colors.primary.300'),
                            },
                        },
                        'h1, h2, h3, h4': {
                            color: theme('colors.gray.100'),
                        },
                        strong: {
                            color: theme('colors.gray.100'),
                        },
                    },
                },
            }),
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
    darkMode: 'class',
};
