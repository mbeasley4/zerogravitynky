import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl } from '@wordpress/components';
import { BRAND } from '../brand-colors';

const PhoneIcon = () => (
    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2" style={ { display: 'inline', verticalAlign: 'middle' } }>
        <path strokeLinecap="round" strokeLinejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 8V5z" />
    </svg>
);

const ArrowIcon = () => (
    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2" style={ { display: 'inline', verticalAlign: 'middle' } }>
        <path strokeLinecap="round" strokeLinejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
    </svg>
);

export default function Edit( { attributes, setAttributes } ) {
    const { question, body, ctaLabel, ctaUrl, ctaLabel2, ctaUrl2 } = attributes;

    const isTel = ctaUrl.startsWith( 'tel:' );

    const blockProps = useBlockProps( {
        style: {
            background: BRAND.heroGradient,
            padding: '2.5rem 2rem',
            borderRadius: '4px',
            position: 'relative',
            overflow: 'hidden',
        },
    } );

    return (
        <>
            <InspectorControls>
                <PanelBody title={ __( 'Callout Content', 'zerogravitynky' ) } initialOpen={ true }>
                    <TextareaControl
                        label={ __( 'Opening Question', 'zerogravitynky' ) }
                        value={ question }
                        onChange={ val => setAttributes( { question: val } ) }
                        rows={ 3 }
                        help={ __( 'Keyword-rich hook displayed in large serif text.', 'zerogravitynky' ) }
                    />
                    <TextareaControl
                        label={ __( 'Body Paragraph', 'zerogravitynky' ) }
                        value={ body }
                        onChange={ val => setAttributes( { body: val } ) }
                        rows={ 5 }
                        help={ __( 'Main SEO copy — include location, service, and brand name.', 'zerogravitynky' ) }
                    />
                </PanelBody>

                <PanelBody title={ __( 'Primary CTA', 'zerogravitynky' ) } initialOpen={ true }>
                    <TextControl
                        label={ __( 'Label', 'zerogravitynky' ) }
                        value={ ctaLabel }
                        onChange={ val => setAttributes( { ctaLabel: val } ) }
                    />
                    <TextControl
                        label={ __( 'URL (use tel: for phone)', 'zerogravitynky' ) }
                        value={ ctaUrl }
                        onChange={ val => setAttributes( { ctaUrl: val } ) }
                    />
                </PanelBody>

                <PanelBody title={ __( 'Secondary CTA (optional)', 'zerogravitynky' ) } initialOpen={ false }>
                    <TextControl
                        label={ __( 'Label', 'zerogravitynky' ) }
                        value={ ctaLabel2 }
                        onChange={ val => setAttributes( { ctaLabel2: val } ) }
                    />
                    <TextControl
                        label={ __( 'URL', 'zerogravitynky' ) }
                        value={ ctaUrl2 }
                        onChange={ val => setAttributes( { ctaUrl2: val } ) }
                    />
                </PanelBody>
            </InspectorControls>

            <div { ...blockProps }>
                {/* Dot-grid overlay */}
                <div style={ {
                    position: 'absolute', inset: 0, opacity: 0.07, pointerEvents: 'none',
                    backgroundImage: 'radial-gradient(circle, rgba(255,255,255,0.9) 1px, transparent 1px)',
                    backgroundSize: '26px 26px',
                } } />

                {/* Giant quote mark */}
                <div style={ {
                    position: 'absolute', top: '-2rem', left: '1.5rem',
                    fontFamily: '"Fraunces", Georgia, serif', fontSize: '16rem', lineHeight: 1,
                    color: 'rgba(255,255,255,0.05)', userSelect: 'none', pointerEvents: 'none',
                } }>
                    &ldquo;
                </div>

                <div style={ { position: 'relative' } }>
                    {/* Location badge */}
                    <div style={ {
                        display: 'inline-flex', alignItems: 'center', gap: '6px',
                        background: 'rgba(255,255,255,0.12)', border: '1px solid rgba(255,255,255,0.2)',
                        color: 'rgba(255,255,255,0.8)', fontSize: '10px', fontWeight: 700,
                        letterSpacing: '0.1em', textTransform: 'uppercase',
                        padding: '5px 14px', borderRadius: '9999px', marginBottom: '1.5rem',
                    } }>
                        📍 Crestview Hills, KY
                    </div>

                    {/* Question */}
                    <p style={ {
                        fontFamily: '"Fraunces", "Fraunces", Georgia, serif',
                        fontSize: '2rem', fontWeight: 700, lineHeight: 1.3,
                        color: '#ffffff', margin: '0 0 1.25rem',
                    } }>
                        { question || __( 'Enter your SEO question above…', 'zerogravitynky' ) }
                    </p>

                    {/* Divider */}
                    <div style={ {
                        width: '64px', height: '2px', borderRadius: '9999px',
                        background: 'linear-gradient(to right, #C5D1C6, transparent)',
                        marginBottom: '1.25rem',
                    } } />

                    {/* Body */}
                    { body && (
                        <p style={ {
                            color: 'rgba(255,255,255,0.80)', fontSize: '1.05rem',
                            lineHeight: 1.75, margin: '0 0 1.75rem', maxWidth: '680px',
                        } }>
                            { body }
                        </p>
                    ) }

                    {/* CTAs */}
                    <div style={ { display: 'flex', flexWrap: 'wrap', gap: '12px' } }>
                        { ctaLabel && (
                            <span style={ {
                                display: 'inline-flex', alignItems: 'center', gap: '8px',
                                padding: '14px 28px', background: '#ffffff',
                                color: BRAND.olive, fontWeight: 700, fontSize: '13px',
                                borderRadius: '9999px',
                            } }>
                                { isTel ? <PhoneIcon /> : <ArrowIcon /> }
                                { ctaLabel }
                            </span>
                        ) }
                        { ctaLabel2 && (
                            <span style={ {
                                display: 'inline-flex', alignItems: 'center', gap: '8px',
                                padding: '14px 28px', border: '2px solid rgba(255,255,255,0.55)',
                                color: '#fff', fontWeight: 600, fontSize: '13px',
                                borderRadius: '9999px',
                            } }>
                                { ctaLabel2 } <ArrowIcon />
                            </span>
                        ) }
                    </div>
                </div>
            </div>
        </>
    );
}
