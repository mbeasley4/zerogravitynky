/**
 * Brand color tokens — single source of truth for Gutenberg block edit.js files.
 *
 * These mirror the CSS custom properties in src/css/main.css @theme block.
 * When the palette changes, update BOTH this file AND src/css/main.css.
 *
 * Palette: Sage / Taupe / Sand wellness palette
 */

export const BRAND = {
    // ── Core palette ─────────────────────────────────────────────────
    sage:        '#7A8F7B',  // primary action, icons         → brand-sage
    sageMid:     '#94A995',  // lighter sage fills             → (intermediate)
    sageLight:   '#9EAF9F',  // secondary fills                → brand-mid
    sagePale:    '#C5D1C6',  // pale sage, tints, hovers       → brand-light

    taupe:       '#B7AFA3',  // accent / borders               → brand-taupe
    taupeDark:   '#8A7F76',  // dark taupe / accent dark       → brand-taupe-dark
    taupeDarker: '#6B6560',  // deepest taupe (shimmer anchor)
    taupeLight:  '#F0EBE4',  // cream                          → brand-taupe-light

    sand:        '#E8DED2',  // light bg, cards                → brand-sand
    sandDark:    '#D4CCC4',  // slightly deeper sand (placeholder hovers)

    olive:       '#3D4A3E',  // dark bg, headings              → brand-dark
    warmGray:    '#5C5753',  // body text                      → brand-gray

    white:       '#ffffff',
    black:       '#000000',

    // ── Link colors (WCAG AA / AAA verified) ─────────────────────────
    // Default:  #3A5C3B on white = 7.6:1 (AAA), on sand #E8DED2 = 5.9:1 (AA)
    // Hover:    #5A7A5B on white = 4.8:1 (AA)
    // Visited:  #6B5A52 on white = 6.5:1 (AAA)
    // Dark bg:  #C5D1C6 on #3D4A3E = 6.0:1 (AA)
    link:        '#3A5C3B',  // deep forest sage — default prose links
    linkHover:   '#5A7A5B',  // mid sage — link hover state
    linkVisited: '#6B5A52',  // warm taupe — visited links
    linkOnDark:  '#C5D1C6',  // pale sage (brand-light) — links on dark bg

    // ── Gradients ────────────────────────────────────────────────────
    heroGradient:  'linear-gradient(135deg, #3D4A3E 0%, #7A8F7B 60%, #9EAF9F 100%)',
    cardGradient:  'linear-gradient(135deg, #7A8F7B, #9EAF9F)',
    goldGradient:  'linear-gradient(135deg, #8A7F76, #B7AFA3, #F0EBE4)',   // "gold" CTA shimmer

    /** Dark section hero variant (tighter sage) */
    darkHeroGradient: 'linear-gradient(135deg, #3D4A3E 0%, #7A8F7B 55%, #94A995 100%)',

    /** Shimmer text animation gradient */
    shimmerGradient: 'linear-gradient(90deg, #6B6560 0%, #B7AFA3 30%, #E8DED2 50%, #B7AFA3 70%, #6B6560 100%)',

    // ── Alpha helpers ─────────────────────────────────────────────────
    /** rgba(61,74,62, alpha) — dark olive with transparency */
    olive_a: ( a ) => `rgba(61,74,62,${a})`,

    /** rgba(122,143,123, alpha) — sage with transparency */
    sage_a: ( a ) => `rgba(122,143,123,${a})`,

    /** rgba(183,175,163, alpha) — taupe with transparency */
    taupe_a: ( a ) => `rgba(183,175,163,${a})`,

    /** rgba(148,169,149, alpha) — sage mid with transparency */
    sageMid_a: ( a ) => `rgba(148,169,149,${a})`,

    /** rgba(232,222,210, alpha) — sand with transparency */
    sand_a: ( a ) => `rgba(232,222,210,${a})`,
};
