/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
  ],
  theme: {
    screens: {
      'xxs': {'max': '480px'},
      'sm': {'min':'640px'},
      'md': {'min' :'1024px'},
      'lg': {'min':'1080px'},
      'xl': {'min':'1280px'},
      '2xl': {'min':'1536px'},
    },
    extend: {},
  },
  plugins: [
    require('tailwind-scrollbar-hide')
    // ...
  ],
}
