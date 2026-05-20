import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl, SelectControl } from '@wordpress/components';

const COLOR_OPTIONS = [
    { label: 'Sage',        value: 'brand-sage' },
    { label: 'Taupe',       value: 'brand-taupe'   },
    { label: 'Sage Light',  value: 'brand-mid'    },
];

const COLOR_HEX = {
    'brand-sage': '#7A8F7B',
    'brand-taupe':   '#B7AFA3',
    'brand-mid':    '#94A995',
};

const StarIcon = () => (
    <svg width="14" height="14" fill="#B7AFA3" viewBox="0 0 20 20" style={ { display: 'inline' } }>
        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
    </svg>
);

function TestimonialPreview( { quote, name, type, initials, color } ) {
    const hex = COLOR_HEX[ color ] || COLOR_HEX['brand-sage'];
    return (
        <div style={ { background: '#fff', borderRadius: '12px', padding: '20px', flex: '1 1 0', minWidth: 0 } }>
            <div style={ { display: 'flex', gap: '2px', marginBottom: '12px' } }>
                { Array.from( { length: 5 } ).map( ( _, i ) => <StarIcon key={ i } /> ) }
            </div>
            <p style={ { color: 'rgba(81,81,81,0.8)', fontSize: '12px', lineHeight: 1.6, fontStyle: 'italic', marginBottom: '14px' } }>
                &ldquo;{ quote || 'Enter a quote in the Settings panel →' }&rdquo;
            </p>
            <div style={ { display: 'flex', alignItems: 'center', gap: '10px' } }>
                <div style={ { width: '36px', height: '36px', borderRadius: '50%', background: hex + '20', display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 } }>
                    <span style={ { color: hex, fontWeight: 600, fontSize: '12px' } }>{ initials || '??' }</span>
                </div>
                <div>
                    <div style={ { color: '#3D4A3E', fontWeight: 600, fontSize: '12px' } }>{ name || 'Client Name' }</div>
                    <div style={ { color: 'rgba(81,81,81,0.5)', fontSize: '11px' } }>{ type || 'Service Client' }</div>
                </div>
            </div>
        </div>
    );
}

export default function Edit( { attributes, setAttributes } ) {
    const {
        sectionTitle, ratingLabel,
        t1Quote, t1Name, t1Type, t1Initials, t1Color,
        t2Quote, t2Name, t2Type, t2Initials, t2Color,
        t3Quote, t3Name, t3Type, t3Initials, t3Color,
    } = attributes;

    const blockProps = useBlockProps( {
        style: { background: '#E8DED2', padding: '2rem', borderRadius: '4px' },
    } );

    return (
        <>
            <InspectorControls>
                {/* ── Section header ──────────────────────── */}
                <PanelBody title={ __( 'Section Header', 'zerogravitynky' ) } initialOpen={ true }>
                    <TextControl
                        label={ __( 'Section Title', 'zerogravitynky' ) }
                        value={ sectionTitle }
                        onChange={ val => setAttributes( { sectionTitle: val } ) }
                    />
                    <TextControl
                        label={ __( 'Rating Label', 'zerogravitynky' ) }
                        value={ ratingLabel }
                        onChange={ val => setAttributes( { ratingLabel: val } ) }
                        help={ __( 'Appears beside the 5 gold stars.', 'zerogravitynky' ) }
                    />
                </PanelBody>

                {/* ── Testimonial 1 ───────────────────────── */}
                <PanelBody title={ __( 'Testimonial 1', 'zerogravitynky' ) } initialOpen={ true }>
                    <TextareaControl
                        label={ __( 'Quote', 'zerogravitynky' ) }
                        value={ t1Quote }
                        onChange={ val => setAttributes( { t1Quote: val } ) }
                        rows={ 4 }
                    />
                    <TextControl
                        label={ __( 'Name', 'zerogravitynky' ) }
                        value={ t1Name }
                        onChange={ val => setAttributes( { t1Name: val } ) }
                    />
                    <TextControl
                        label={ __( 'Service / Type', 'zerogravitynky' ) }
                        value={ t1Type }
                        onChange={ val => setAttributes( { t1Type: val } ) }
                    />
                    <TextControl
                        label={ __( 'Initials (avatar)', 'zerogravitynky' ) }
                        value={ t1Initials }
                        onChange={ val => setAttributes( { t1Initials: val } ) }
                        help={ __( '2 characters shown in the avatar circle.', 'zerogravitynky' ) }
                    />
                    <SelectControl
                        label={ __( 'Avatar Color', 'zerogravitynky' ) }
                        value={ t1Color }
                        options={ COLOR_OPTIONS }
                        onChange={ val => setAttributes( { t1Color: val } ) }
                    />
                </PanelBody>

                {/* ── Testimonial 2 ───────────────────────── */}
                <PanelBody title={ __( 'Testimonial 2', 'zerogravitynky' ) } initialOpen={ false }>
                    <TextareaControl
                        label={ __( 'Quote', 'zerogravitynky' ) }
                        value={ t2Quote }
                        onChange={ val => setAttributes( { t2Quote: val } ) }
                        rows={ 4 }
                    />
                    <TextControl
                        label={ __( 'Name', 'zerogravitynky' ) }
                        value={ t2Name }
                        onChange={ val => setAttributes( { t2Name: val } ) }
                    />
                    <TextControl
                        label={ __( 'Service / Type', 'zerogravitynky' ) }
                        value={ t2Type }
                        onChange={ val => setAttributes( { t2Type: val } ) }
                    />
                    <TextControl
                        label={ __( 'Initials (avatar)', 'zerogravitynky' ) }
                        value={ t2Initials }
                        onChange={ val => setAttributes( { t2Initials: val } ) }
                    />
                    <SelectControl
                        label={ __( 'Avatar Color', 'zerogravitynky' ) }
                        value={ t2Color }
                        options={ COLOR_OPTIONS }
                        onChange={ val => setAttributes( { t2Color: val } ) }
                    />
                </PanelBody>

                {/* ── Testimonial 3 ───────────────────────── */}
                <PanelBody title={ __( 'Testimonial 3', 'zerogravitynky' ) } initialOpen={ false }>
                    <TextareaControl
                        label={ __( 'Quote', 'zerogravitynky' ) }
                        value={ t3Quote }
                        onChange={ val => setAttributes( { t3Quote: val } ) }
                        rows={ 4 }
                    />
                    <TextControl
                        label={ __( 'Name', 'zerogravitynky' ) }
                        value={ t3Name }
                        onChange={ val => setAttributes( { t3Name: val } ) }
                    />
                    <TextControl
                        label={ __( 'Service / Type', 'zerogravitynky' ) }
                        value={ t3Type }
                        onChange={ val => setAttributes( { t3Type: val } ) }
                    />
                    <TextControl
                        label={ __( 'Initials (avatar)', 'zerogravitynky' ) }
                        value={ t3Initials }
                        onChange={ val => setAttributes( { t3Initials: val } ) }
                    />
                    <SelectControl
                        label={ __( 'Avatar Color', 'zerogravitynky' ) }
                        value={ t3Color }
                        options={ COLOR_OPTIONS }
                        onChange={ val => setAttributes( { t3Color: val } ) }
                    />
                </PanelBody>
            </InspectorControls>

            {/* ── Editor preview ─────────────────────────────────────── */}
            <div { ...blockProps }>
                {/* Section header */}
                <div style={ { textAlign: 'center', marginBottom: '24px' } }>
                    <div style={ { color: '#7A8F7B', fontSize: '11px', fontWeight: 600, textTransform: 'uppercase', letterSpacing: '0.12em', marginBottom: '8px' } }>
                        — Testimonials —
                    </div>
                    <h2 style={ { fontFamily: 'serif', fontSize: '1.6rem', fontWeight: 700, color: '#3D4A3E', margin: '0 0 8px' } }>
                        { sectionTitle }
                    </h2>
                    <div style={ { display: 'flex', justifyContent: 'center', alignItems: 'center', gap: '3px' } }>
                        { Array.from( { length: 5 } ).map( ( _, i ) => <StarIcon key={ i } /> ) }
                        <span style={ { marginLeft: '6px', color: '#515151', fontSize: '12px' } }>{ ratingLabel }</span>
                    </div>
                </div>

                {/* Cards */}
                <div style={ { display: 'flex', gap: '14px', alignItems: 'stretch' } }>
                    <TestimonialPreview quote={ t1Quote } name={ t1Name } type={ t1Type } initials={ t1Initials } color={ t1Color } />
                    <TestimonialPreview quote={ t2Quote } name={ t2Name } type={ t2Type } initials={ t2Initials } color={ t2Color } />
                    <TestimonialPreview quote={ t3Quote } name={ t3Name } type={ t3Type } initials={ t3Initials } color={ t3Color } />
                </div>
            </div>
        </>
    );
}
