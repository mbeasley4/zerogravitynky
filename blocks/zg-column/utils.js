/**
 * Builds the className string from block attributes.
 * Shared between edit.js and save.js.
 */
export function buildClasses( { padding, background, rounded, bordered, shadow } ) {
    const classes = [ 'zg-column', 'max-w-7xl', 'mx-auto', 'px-5', 'lg:px-8' ];

    // Vertical padding (horizontal handled by px-5 lg:px-8 above)
    const paddingMap = {
        none: '',
        sm:   'py-8',
        md:   'py-12',
        lg:   'py-20',
    };
    if ( paddingMap[ padding ] ) classes.push( paddingMap[ padding ] );

    // Background
    const bgMap = {
        none:     '',
        white:    'zg-column--bg-white',
        sand:     'zg-column--bg-sand',
        dark:     'zg-column--bg-dark',
        sage:     'zg-column--bg-sage',
    };
    if ( bgMap[ background ] ) classes.push( bgMap[ background ] );

    // Modifiers
    if ( rounded )  classes.push( 'zg-column--rounded' );
    if ( bordered ) classes.push( 'zg-column--bordered' );
    if ( shadow )   classes.push( 'zg-column--shadow' );

    return classes.join( ' ' );
}
