/** @type {import('tailwindcss').Config} */
export default {
  darkMode: 'false',
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      boxShadow:{
        '2xl':'0px 25px 30px -12px rgb(0 0 0 / 0.25)',
        'inner':'0px 0px 0 0 rgb(0 0 0 / 0.25)',
      },
      textColor:{
        'black':'#121212',
        'yellow':'#facc15',
        'blue-50':'#e9ebf3',
        'blue-500':'#1e3a8a',
        'white':'#ffffff'
      },
      backgroundColor:{
        'azure':'#ECF8F8',
        'black':'#121212',
        'yellow':'#FACC15',
        'blue-50':'#e9ebf3',
        'blue-100':'#b9c2db',
        'blue-200':'#98a4c9',
        'blue-300':'#687bb1',
        'blue-400':'#4b61a1',
        'blue-500':'#1e3a8a',
        'blue-600':'#1b357e',
        'blue-700':'#152962',
        'blue-800':'#11204c',
        'blue-900':'#0d183a',
      },
      fontFamily:{
        geist: ['Geist Sans', 'sans-serif']
      },
      borderRadius:{
        'md':'10px',
      }
    },
  },
  plugins: [],
}