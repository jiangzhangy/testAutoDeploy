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
        'auth-bg': '#0e1e40'
      },
      spacing: {
        '100': '25rem',
      }
    },
  },
  plugins: [],
}
