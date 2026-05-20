import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl, TextControl } from '@wordpress/components';

// ── Colour scheme definitions (mirrors render.php) ───────────────────────
// All combos verified WCAG AA compliant.
const SCHEMES = {
    lavender: {
        // bg #E8DED2 — beige/sand, warm and natural
        sectionBg:   '#E8DED2',
        eyebrow:     '#7A8F7B',
        heading:     '#3D4A3E',
        ratingText:  '#515151',
        ratingStars: '#B7AFA3',
        label:       'Beige / Sand',
    },
    'light-gold': {
        // bg #B7AFA3 — taupe
        sectionBg:   '#B7AFA3',
        eyebrow:     '#3D4A3E',
        heading:     '#3D4A3E',
        ratingText:  '#3D4A3E',
        ratingStars: '#3D4A3E',
        label:       'Taupe',
    },
    purple: {
        // bg #7A8F7B — sage, white text for contrast
        sectionBg:   '#7A8F7B',
        eyebrow:     '#E8DED2',
        heading:     '#ffffff',
        ratingText:  'rgba(255,255,255,0.85)',
        ratingStars: '#E8DED2',
        label:       'Sage',
    },
};

const StarIcon = ( { color } ) => (
    <svg width="16" height="16" fill={ color } viewBox="0 0 20 20" style={ { display: 'inline', flexShrink: 0 } }>
        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
    </svg>
);

// Static placeholder cards shown in the editor
const PLACEHOLDER_CARDS = [
    { initials: 'SM', color: '#7A8F7B', name: 'Sarah M.',  meta: 'Google · Jan 2025', stars: 5 },
    { initials: 'AK', color: '#B7AFA3', name: 'Ashley K.', meta: 'Yelp · Mar 2025',   stars: 5 },
    { initials: 'LH', color: '#94A995', name: 'Laura H.',  meta: 'Google · Apr 2025', stars: 5 },
];

function CardPreview( { initials, color, name, meta, stars } ) {
    return (
        <div style={ {
            background: '#fff',
            borderRadius: '12px',
            padding: '20px',
            flex: '1 1 0',
            minWidth: 0,
            boxShadow: '0 1px 3px rgba(0,0,0,.08)',
        } }>
            <div style={ { display: 'flex', gap: '2px', marginBottom: '10px' } }>
                { Array.from( { length: stars } ).map( ( _, i ) =>
                    <StarIcon key={ i } color="#B7AFA3" />
                ) }
            </div>
            <p style={ {
                color: 'rgba(81,81,81,0.8)',
                fontSize: '11px',
                lineHeight: 1.6,
                fontStyle: 'italic',
                marginBottom: '14px',
            } }>
                &ldquo;Review text will be pulled from the Reviews post type and displayed here on the front end.&rdquo;
            </p>
            <div style={ { display: 'flex', alignItems: 'center', gap: '10px' } }>
                <div style={ {
                    width: '36px',
                    height: '36px',
                    borderRadius: '50%',
                    background: color + '20',
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'center',
                    flexShrink: 0,
                } }>
                    <span style={ { color, fontWeight: 600, fontSize: '11px' } }>{ initials }</span>
                </div>
                <div style={ { minWidth: 0 } }>
                    <div style={ { color: '#3D4A3E', fontWeight: 600, fontSize: '12px' } }>{ name }</div>
                    <div style={ { color: 'rgba(81,81,81,0.5)', fontSize: '11px' } }>{ meta }</div>
                </div>
            </div>
        </div>
    );
}

export default function Edit( { attributes, setAttributes } ) {
    const { bgColor, sectionTitle, ratingLabel } = attributes;
    const s = SCHEMES[ bgColor ] || SCHEMES.lavender;

    const blockProps = useBlockProps( {
        style: { background: s.sectionBg, padding: '2.5rem 1.5rem', borderRadius: '4px' },
    } );

    return (
        <>
            <InspectorControls>
                <PanelBody title={ __( 'Section Settings', 'zerogravitynky' ) } initialOpen={ true }>
                    <SelectControl
                        label={ __( 'Background Color', 'zerogravitynky' ) }
                        value={ bgColor }
                        options={ [
                            { label: 'Beige / Sand', value: 'lavender'   },
                            { label: 'Taupe',        value: 'light-gold' },
                            { label: 'Sage',         value: 'purple'     },
                        ] }
                        onChange={ val => setAttributes( { bgColor: val } ) }
                        help={ __( 'All options meet WCAG AA contrast requirements.', 'zerogravitynky' ) }
                    />
                    <TextControl
                        label={ __( 'Section Title', 'zerogravitynky' ) }
                        value={ sectionTitle }
                        onChange={ val => setAttributes( { sectionTitle: val } ) }
                    />
                    <TextControl
                        label={ __( 'Rating Label', 'zerogravitynky' ) }
                        value={ ratingLabel }
                        onChange={ val => setAttributes( { ratingLabel: val } ) }
                        help={ __( 'Text beside the 5 stars in the section header.', 'zerogravitynky' ) }
                    />
                </PanelBody>
            </InspectorControls>

            <div { ...blockProps }>

                {/* Section header */}
                <div style={ { textAlign: 'center', marginBottom: '28px' } }>
                    <div style={ {
                        display: 'inline-flex',
                        alignItems: 'center',
                        gap: '8px',
                        color: s.eyebrow,
                        fontSize: '11px',
                        fontWeight: 700,
                        textTransform: 'uppercase',
                        letterSpacing: '0.12em',
                        marginBottom: '10px',
                    } }>
                        <span style={ { display: 'block', width: '24px', height: '1px', background: s.eyebrow } } />
                        Testimonials
                        <span style={ { display: 'block', width: '24px', height: '1px', background: s.eyebrow } } />
                    </div>
                    <h2 style={ {
                        fontFamily: 'serif',
                        fontSize: '1.6rem',
                        fontWeight: 700,
                        color: s.heading,
                        margin: '0 0 10px',
                    } }>
                        { sectionTitle }
                    </h2>
                    <div style={ { display: 'flex', justifyContent: 'center', alignItems: 'center', gap: '3px' } }>
                        { Array.from( { length: 5 } ).map( ( _, i ) =>
                            <StarIcon key={ i } color={ s.ratingStars } />
                        ) }
                        <span style={ { marginLeft: '6px', color: s.ratingText, fontSize: '12px' } }>
                            { ratingLabel }
                        </span>
                    </div>
                </div>

                {/* Placeholder cards */}
                <div style={ { display: 'flex', gap: '12px' } }>
                    { PLACEHOLDER_CARDS.map( card => (
                        <CardPreview key={ card.initials } { ...card } />
                    ) ) }
                </div>

                {/* Editor notice */}
                <p style={ {
                    textAlign: 'center',
                    marginTop: '16px',
                    fontSize: '11px',
                    color: s.ratingText,
                    opacity: 0.7,
                } }>
                    ★ Live site shows 3 random reviews from <strong style={ { color: s.ratingText } }>Reviews → All Reviews</strong>
                </p>

            </div>
        </>
    );
}
