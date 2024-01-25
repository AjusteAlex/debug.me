/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./assets/**/*.js", "./templates/**/*.html.twig"],
  theme: {
    extend: {
      backgroundImage: (theme) => ({
        "home-pattern": "url('/public/img/img-home.svg')",
        "register-pattern": "url('/public/img/img-inscription.svg')",
        "login-pattern": "url('/public/img/img-connexion.svg')",
      }),
      colors: {
        "primary-color": "#1e1e1e",
        pink: "#ff5555",
        purple: "#4507a4",
        "white-transparent": "#f7f7f7d9",
      },
    },
    fontFamily: {
      serif: ["Lato"],
    },
  },
  plugins: [],
};
