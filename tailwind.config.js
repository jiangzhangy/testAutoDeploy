module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        transparent: 'transparent',
        current: 'currentColor',
        'auth-bg': '#0e1e40',
      },
      spacing: {
        '100': '25rem',
        '125': '31.25rem',
      },
      fontSize: {
        '3.5xl': ['32px', '38px'],
        '2.5xl': ['28px', '30px'],
      }
    },
  },
  plugins: [],
}
