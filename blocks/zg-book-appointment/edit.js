import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, ToggleControl, TextControl, TextareaControl } from '@wordpress/components';

const CalendarIcon = () => (
    <svg width="24" height="24" fill="none" stroke="currentColor" strokeWidth="1.5" viewBox="0 0 24 24">
        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
        <line x1="16" y1="2" x2="16" y2="6"/>
        <line x1="8" y1="2" x2="8" y2="6"/>
        <line x1="3" y1="10" x2="21" y2="10"/>
    </svg>
);

export default function Edit( { attributes, setAttributes } ) {
    const { headline, subtext, ctaLabel, ctaUrl, variant } = attributes;
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
                    <TextControl
                        label="Button URL"
                        value={ ctaUrl }
                        onChange={ ( value ) => setAttributes( { ctaUrl: value } ) }
                    />
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
                                <CalendarIcon />
                            </div>
                            <h2 style={ {
                                fontFamily: '"Fraunces", Georgia, serif', fontWeight: 700,
                                fontSize: '2rem', color: '#ffffff', margin: '0 0 0.75rem',
                            } }>
                                { headline || 'Request an Appointment' }
                            </h2>
                            <p style={ { color: 'rgba(255,255,255,0.80)', fontSize: '1rem', lineHeight: 1.7, margin: '0 0 1.75rem' } }>
                                { subtext || 'Schedule your visit online.' }
                            </p>
                            <span style={ {
                                display: 'inline-flex', alignItems: 'center', gap: '8px',
                                padding: '14px 32px',
                                background: 'linear-gradient(135deg, #8A8178, #B7AFA3, #E8DED2)',
                                color: '#3D4A3E', fontWeight: 700, fontSize: '14px',
                                borderRadius: '9999px',
                            } }>
                                { ctaLabel || 'Book Now' }
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
                                    <CalendarIcon />
                                </div>
                                <div>
                                    <h2 style={ {
                                        fontFamily: '"Fraunces", Georgia, serif', fontWeight: 700,
                                        fontSize: '1.5rem', color: '#3D4A3E', margin: '0 0 0.25rem',
                                    } }>
                                        { headline || 'Request an Appointment' }
                                    </h2>
                                    <p style={ { color: '#5a6b5b', fontSize: '0.9rem', lineHeight: 1.6, margin: 0 } }>
                                        { subtext || 'Schedule your visit online.' }
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
                                { ctaLabel || 'Book Now' }
                            </span>
                        </div>
                    </>
                ) }

            </div>
        </>
    );
}
