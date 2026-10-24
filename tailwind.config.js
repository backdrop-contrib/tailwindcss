/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'selector',
  content: [
    "./**/*.tpl.php",
    "./*.info",
    "./template.php",
    "./js/**/*.js"
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}

