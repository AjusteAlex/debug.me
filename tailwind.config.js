/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./assets/**/*.js", "./templates/**/*.html.twig"],
  theme: {
    extend: {
      backgroundImage: (theme) => ({
        "connexion-pattern": "url('/public/img/img_connexion.png')",
      }),
    },
    colors: {
      primary_color: "#1e1e1e",
      pink: "#ff5555",
      purple: "#4507a4",
      white_transparent: "#f7f7f7d9",
    },
    fontFamily: {
      serif: ["Lato"],
    },
  },
  plugins: [],
};