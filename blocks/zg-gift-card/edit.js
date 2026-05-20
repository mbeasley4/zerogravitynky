import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, ToggleControl, TextControl, TextareaControl } from '@wordpress/components';

const GiftIcon = () => (
    <svg width="24" height="24" fill="none" stroke="currentColor" strokeWidth="1.5" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" d="M20 12v10H4V12M22 7H2v5h20V7zM12 22V7M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7zM12 7h4.5a2.5 2.5 0 000-5C13 2 12 7 12 7z"/>
    </svg>
);

const ArrowIcon = () => (
    <svg width="16" height="16" fill="none" stroke="currentColor" strokeWidth="2" viewBox="0 0 24 24" style={ { display: 'inline', verticalAlign: 'middle' } }>
        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
    </svg>
);

export default function Edit( { attributes, setAttributes } ) {
    const { headline, subtext, ctaLabel, variant } = attributes;
    const isDark = variant === 'dark';

    const blockProps = useBlockProps( {
        style: {
            background: isDark
                ? 'linear-gradient(135deg, #3D4A3E 0%, #7A8F7B 55%, #94A995 100%)'
                : '#E8DED2',
            padding: '3rem 2rem',
            borderRadius: '4px',
            position: 'relative',
            overflow: 'hidden',
        },
    } );

    return (
        <>
            <InspectorControls>
                <PanelBody title="Background Style" initialOpen={ true }>
                    <ToggleControl
                        label={ isDark ? 'Dark (sage gradient)' : 'Light (beige)' }
                        checked={ isDark }
                        onChange={ ( value ) => setAttributes( { variant: value ? 'dark' : 'light' } ) }
                    />
                </PanelBody>
                <PanelBody title="Content" initialOpen={ true }>
                    <TextControl
                        label="Headline"
                        value={ headline }
                        onChange={ ( value ) => setAttributes( { headline: value } ) }
                    />
                    <TextareaControl
                        label="Subtext"
                        value={ subtext }
                        onChange={ ( value ) => setAttributes( { subtext: value } ) }
                        rows={ 3 }
                    />
                    <TextControl
                        label="Button Label"
                        value={ ctaLabel }
                        onChange={ ( value ) => setAttributes( { ctaLabel: value } ) }
                    />
                    <p style={ { fontSize: '11px', color: '#888', marginTop: '4px' } }>
                        Links to /product/gift-card/ automatically
                    </p>
                </PanelBody>
            </InspectorControls>

            <div { ...blockProps }>

                { isDark ? (
                    <>
                        { /* Decorative blobs */ }
                        <div style={ {
                            position: 'absolute', top: '-60px', right: '-60px',
                            width: '260px', height: '260px', borderRadius: '50%',
                            background: 'rgba(183,175,163,0.18)', filter: 'blur(60px)', pointerEvents: 'none',
                        } } />
                        <div style={ {
                            position: 'absolute', bottom: '-40px', left: '-40px',
                            width: '200px', height: '200px', borderRadius: '50%',
                            background: 'rgba(148,169,149,0.20)', filter: 'blur(50px)', pointerEvents: 'none',
                        } } />

                        { /* Dot-grid overlay */ }
                        <div style={ {
                            position: 'absolute', inset: 0, opacity: 0.06, pointerEvents: 'none',
                            backgroundImage: 'radial-gradient(circle, rgba(255,255,255,0.5) 1px, transparent 1px)',
                            backgroundSize: '32px 32px',
                        } } />

                        { /* Centered content */ }
                        <div style={ { position: 'relative', maxWidth: '640px', margin: '0 auto', textAlign: 'center' } }>
                            <div style={ {
                                display: 'inline-flex', alignItems: 'center', justifyContent: 'center',
                                width: '56px', height: '56px', borderRadius: '16px',
                                background: 'rgba(255,255,255,0.12)', color: '#fff',
                                marginBottom: '1.5rem',
                            } }>
                                <GiftIcon />
                            </div>
                            <h2 style={ {
                                fontFamily: '"Fraunces", Georgia, serif', fontWeight: 700,
                                fontSize: '2rem', color: '#ffffff', margin: '0 0 0.75rem',
                            } }>
                                { headline || 'Give the Gift of Wellness' }
                            </h2>
                            <p style={ { color: 'rgba(255,255,255,0.80)', fontSize: '1rem', lineHeight: 1.7, margin: '0 0 1.75rem' } }>
                                { subtext || 'Gift cards available for any service or amount.' }
                            </p>
                            <span style={ {
                                display: 'inline-flex', alignItems: 'center', gap: '8px',
                                padding: '14px 32px',
                                background: 'linear-gradient(135deg, #8A8178, #B7AFA3, #E8DED2)',
                                color: '#3D4A3E', fontWeight: 700, fontSize: '14px',
                                borderRadius: '9999px',
                            } }>
                                { ctaLabel || 'Shop Gift Cards' } <ArrowIcon />
                            </span>
                        </div>
                    </>
                ) : (
                    <>
                        { /* Soft blobs for light variant */ }
                        <div style={ {
                            position: 'absolute', top: '-40px', right: '-40px',
                            width: '200px', height: '200px', borderRadius: '50%',
                            background: 'rgba(122,143,123,0.12)', filter: 'blur(50px)', pointerEvents: 'none',
                        } } />
                        <div style={ {
                            position: 'absolute', bottom: '-30px', left: '-30px',
                            width: '160px', height: '160px', borderRadius: '50%',
                            background: 'rgba(148,169,149,0.14)', filter: 'blur(40px)', pointerEvents: 'none',
                        } } />

                        { /* Horizontal flex row */ }
                        <div style={ {
                            position: 'relative',
                            display: 'flex', alignItems: 'center', justifyContent: 'space-between',
                            flexWrap: 'wrap', gap: '1.5rem',
                        } }>
                            <div style={ { display: 'flex', alignItems: 'center', gap: '1.25rem', flex: '1 1 300px' } }>
                                <div style={ {
                                    display: 'flex', alignItems: 'center', justifyContent: 'center',
                                    width: '52px', height: '52px', borderRadius: '14px', flexShrink: 0,
                                    background: 'rgba(122,143,123,0.18)', color: '#7A8F7B',
                                } }>
                                    <GiftIcon />
                                </div>
                                <div>
                                    <h2 style={ {
                                        fontFamily: '"Fraunces", Georgia, serif', fontWeight: 700,
                                        fontSize: '1.5rem', color: '#3D4A3E', margin: '0 0 0.25rem',
                                    } }>
                                        { headline || 'Give the Gift of Wellness' }
                                    </h2>
                                    <p style={ { color: '#5a6b5b', fontSize: '0.9rem', lineHeight: 1.6, margin: 0 } }>
                                        { subtext || 'Gift cards available for any service or amount.' }
                                    </p>
                                </div>
                            </div>
                            <span style={ {
                                display: 'inline-flex', alignItems: 'center', gap: '8px',
                                padding: '14px 32px',
                                background: 'linear-gradient(135deg, #5a6b5b, #7A8F7B, #94A995)',
                                color: '#fff', fontWeight: 700, fontSize: '14px',
                                borderRadius: '9999px', flexShrink: 0,
                            } }>
                                { ctaLabel || 'Shop Gift Cards' } <ArrowIcon />
                            </span>
                        </div>
                    </>
                ) }

            </div>
        </>
    );
}
