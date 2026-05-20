import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, SelectControl } from '@wordpress/components';

function isExternal( url ) {
    if ( ! url ) return false;
    try {
        return new URL( url ).hostname !== window.location.hostname;
    } catch {
        return false;
    }
}

const ExternalIcon = () => (
    <svg width="12" height="12" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24"
         style={ { display: 'inline', marginLeft: '4px', verticalAlign: 'middle' } }>
        <path strokeLinecap="round" strokeLinejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
    </svg>
);

const VARIANTS = {
    gold: {
        label:       'Warm Taupe',
        bg:          'linear-gradient(135deg, #5C5248 0%, #7A7068 30%, #A09690 58%, #B7AFA3 78%, #CFC5BA 100%)',
        blob1:       'rgba(255,255,255,0.22)',
        blob2:       'rgba(232,222,210,0.28)',
        dotOpacity:  0.10,
        btn1Bg:      '#ffffff',
        btn1Color:   '#5C5248',
    },
    purple: {
        label:       'Sage Gradient',
        bg:          'linear-gradient(135deg, #3D4A3E 0%, #58775A 40%, #7A8F7B 70%, #94A995 100%)',
        blob1:       '#B7AFA3',
        blob2:       '#94A995',
        dotOpacity:  0.08,
        btn1Bg:      '#ffffff',
        btn1Color:   '#3D4A3E',
    },
    dark: {
        label:       'Deep Olive',
        bg:          'linear-gradient(135deg, #0C1510 0%, #162018 30%, #243527 58%, #344A36 80%, #3D4A3E 100%)',
        blob1:       '#2A3D2C',
        blob2:       '#1A2A1C',
        dotOpacity:  0.06,
        btn1Bg:      'linear-gradient(135deg, #8A8178 0%, #B7AFA3 50%, #E8DED2 100%)',
        btn1Color:   '#1C2B1E',
    },
};

export default function Edit( { attributes, setAttributes } ) {
    const { headline, subtext, ctaLabel1, ctaUrl1, ctaLabel2, ctaUrl2, variant } = attributes;
    const v = VARIANTS[ variant ] ?? VARIANTS.gold;

    const blockProps = useBlockProps( {
        style: {
            background:   v.bg,
            padding:      '3.5rem 2rem',
            borderRadius: '4px',
            position:     'relative',
            overflow:     'hidden',
        },
    } );

    return (
        <>
            <InspectorControls>
                <PanelBody title="Banner Settings" initialOpen={ true }>
                    <SelectControl
                        label="Color Variation"
                        value={ variant }
                        options={ [
                            { label: 'Warm Taupe',    value: 'gold'   },
                            { label: 'Sage Gradient', value: 'purple' },
                            { label: 'Deep Olive',    value: 'dark'   },
                        ] }
                        onChange={ ( value ) => setAttributes( { variant: value } ) }
                    />
                    <TextControl
                        label="Headline"
                        value={ headline }
                        onChange={ ( value ) => setAttributes( { headline: value } ) }
                    />
                    <TextControl
                        label="Subtext"
                        value={ subtext }
                        onChange={ ( value ) => setAttributes( { subtext: value } ) }
                    />
                </PanelBody>
                <PanelBody title="Primary Button" initialOpen={ true }>
                    <TextControl
                        label="Label"
                        value={ ctaLabel1 }
                        onChange={ ( value ) => setAttributes( { ctaLabel1: value } ) }
                    />
                    <TextControl
                        label="URL"
                        value={ ctaUrl1 }
                        onChange={ ( value ) => setAttributes( { ctaUrl1: value } ) }
                    />
                </PanelBody>
                <PanelBody title="Secondary Button" initialOpen={ true }>
                    <TextControl
                        label="Label"
                        value={ ctaLabel2 }
                        onChange={ ( value ) => setAttributes( { ctaLabel2: value } ) }
                    />
                    <TextControl
                        label="URL"
                        value={ ctaUrl2 }
                        onChange={ ( value ) => setAttributes( { ctaUrl2: value } ) }
                    />
                </PanelBody>
            </InspectorControls>

            <div { ...blockProps }>

                { /* Dot grid */ }
                <div style={ {
                    position: 'absolute', inset: 0, pointerEvents: 'none',
                    opacity: v.dotOpacity,
                    backgroundImage: 'radial-gradient(circle, rgba(255,255,255,0.7) 1px, transparent 1px)',
                    backgroundSize: '28px 28px',
                } } />

                { /* Blobs */ }
                <div style={ {
                    position: 'absolute', top: '-6rem', left: '-6rem',
                    width: '24rem', height: '24rem', borderRadius: '9999px',
                    background: v.blob1, opacity: 0.30, filter: 'blur(60px)', pointerEvents: 'none',
                } } />
                <div style={ {
                    position: 'absolute', bottom: '-6rem', right: '-6rem',
                    width: '32rem', height: '32rem', borderRadius: '9999px',
                    background: v.blob2, opacity: 0.25, filter: 'blur(70px)', pointerEvents: 'none',
                } } />

                { /* Content */ }
                <div style={ { position: 'relative', textAlign: 'center', maxWidth: '720px', margin: '0 auto' } }>

                    <p style={ {
                        fontFamily: '"Fraunces", Georgia, serif',
                        fontSize: '2.5rem', fontWeight: 700,
                        color: '#fff', lineHeight: 1.2,
                        margin: '0 0 0.75rem',
                    } }>
                        { headline }
                    </p>

                    <p style={ { color: 'rgba(255,255,255,0.80)', fontSize: '1rem', lineHeight: 1.7, margin: '0 0 1.75rem' } }>
                        { subtext }
                    </p>

                    <div style={ { display: 'flex', gap: '1rem', justifyContent: 'center', flexWrap: 'wrap' } }>
                        { ctaLabel1 && (
                            <span style={ {
                                display: 'inline-flex', alignItems: 'center',
                                padding: '0.75rem 2rem',
                                background: v.btn1Bg, color: v.btn1Color,
                                borderRadius: '9999px', fontWeight: 700, fontSize: '0.875rem',
                                boxShadow: '0 8px 24px rgba(0,0,0,0.25)',
                            } }>
                                { ctaLabel1 }{ isExternal( ctaUrl1 ) && <ExternalIcon /> }
                            </span>
                        ) }
                        { ctaLabel2 && (
                            <span style={ {
                                display: 'inline-flex', alignItems: 'center',
                                padding: '0.75rem 2rem',
                                border: '2px solid rgba(255,255,255,0.70)', color: '#fff',
                                borderRadius: '9999px', fontWeight: 600, fontSize: '0.875rem',
                            } }>
                                { ctaLabel2 }{ isExternal( ctaUrl2 ) && <ExternalIcon /> }
                            </span>
                        ) }
                    </div>

                </div>
            </div>
        </>
    );
}
