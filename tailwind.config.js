/** @type {import('tailwindcss').Config} */

module.exports = {
  content: [
    "./*.php", // Root-level PHP files
    "./src/**/*.{php,html}", // Subdirectory PHP/HTML files
  ],
  theme: {
    extend: {},
  },
  plugins: [require("@tailwindcss/aspect-ratio")],
};
