/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'false',
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        screens: {
            sm: '640px',
            md: '780px',
            lg: '1024px',
            xl: '1280px',
        },

        extend: {
            boxShadow: {
                '2xl': '0px 25px 30px -12px rgb(0 0 0 / 0.25)',
                'inner': '0px 0px 0 0 rgb(0 0 0 / 0.25)',
            },
            textColor: {
                'blue': ' #2e5e91',
                'black': '#121212',
                'blue-50': '#e9ebf3',
                'blue-500': '#1e3a8a',
                'white': '#ffffff',
                'blue-2': '#273034',
                'blue-50': '#e9ebf3',
                'blue-100': '#b9c2db',
                'blue-200': '#98a4c9',
                'blue-300': '#687bb1',
                'blue-400': '#4b61a1',
                'blue-500': '#1e3a8a',
                'blue-600': '#1b357e',
                'blue-700': '#152962',
                'blue-800': '#11204c',
                'blue-900': '#0d183a',
                'blue-950': '#0d183a',
               
            },
            backgroundColor: {
                'azure': '#ECF8F8',
                'blue': '#2e5e91',
                'blue-2': '#273034',
                'black': '#121212',
                'blue-50': '#e9ebf3',
                'blue-100': '#b9c2db',
                'blue-200': '#98a4c9',
                'blue-300': '#687bb1',
                'blue-400': '#4b61a1',
                'blue-500': '#1e3a8a',
                'blue-600': '#1b357e',
                'blue-700': '#152962',
                'blue-800': '#11204c',
                'blue-900': '#0d183a',
            },
            fontFamily: {
                geist: ['Geist Sans', 'sans-serif']
            },
            borderRadius: {

            }
        },
    },
    plugins: [],
}