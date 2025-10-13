/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.php",
    "./**/*.php",
    "./*.html",
    "./**/*.html",
  ],
  theme: {
    extend: {
      fontFamily: {
        retro: ['Orbitron', 'sans-serif'],       // Overskrifter, labels, knapper
        console: ['VT323', 'monospace'],         // Brødtekst
      },
      colors: {
        neon: '#00e7ec',        // Blå neonfarve
        retroYellow: '#FFDF00',
        retroPink: '#FE04FF',
        retroError: '#FFB3B3',
      },
    },
  },
  plugins: [],
}
