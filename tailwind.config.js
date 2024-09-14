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
        '2xl':'0px 25px 30px -12px rgb(0 0 0 / 0.25);'
      },
      textColor:{
        'primary':'',
        'secondary':'',
        'tertiary':'',
      },
      
    },
  },
  plugins: [],
}