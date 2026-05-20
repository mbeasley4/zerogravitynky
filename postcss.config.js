// PostCSS config — used by both production build and postcss-cli.
// Pipeline: tailwindcss v4 → autoprefixer → cssnano (prod only)

const isProd = process.env.NODE_ENV === 'production';

module.exports = {
  plugins: [
    // Tailwind v4 PostCSS plugin — processes @import "tailwindcss", local @import,
    // @theme, @layer, @source, etc. Uses its own bundler; no postcss-import needed.
    require('@tailwindcss/postcss'),

    // Add vendor prefixes for target browsers (see .browserslistrc)
    require('autoprefixer'),

    // Minify in production
    ...(isProd ? [require('cssnano')({ preset: 'default' })] : []),
  ],
};
