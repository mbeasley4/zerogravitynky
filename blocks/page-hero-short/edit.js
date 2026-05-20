import { useBlockProps, RichText, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

const wrapperStyle = {
    background: 'linear-gradient(135deg, #3D4A3E 0%, #7A8F7B 50%, #94A995 100%)',
    padding: '3.5rem 2rem 2.5rem',
    textAlign: 'center',
    borderRadius: '4px',
    position: 'relative',
    overflow: 'hidden',
};

const shimmerStyle = {
    background: 'linear-gradient(90deg, #6B6560 0%, #B7AFA3 30%, #E8DED2 50%, #B7AFA3 70%, #6B6560 100%)',
    WebkitBackgroundClip: 'text',
    WebkitTextFillColor: 'transparent',
    backgroundClip: 'text',
};

export default function Edit( { attributes, setAttributes } ) {
    const { eyebrow, headingBefore, headingShimmer, subtext } = attributes;

    const blockProps = useBlockProps( { style: wrapperStyle } );

    return (
        <>
            <InspectorControls>
                <PanelBody title={ __( 'Headline', 'zerogravitynky' ) } initialOpen>
                    <TextControl
                        label={ __( 'Eyebrow label', 'zerogravitynky' ) }
                        value={ eyebrow }
                        onChange={ ( val ) => setAttributes( { eyebrow: val } ) }
                        placeholder="Zero Gravity Aesthetics &amp; Wellness"
                    />
                    <TextControl
                        label={ __( 'Heading — regular text', 'zerogravitynky' ) }
                        value={ headingBefore }
                        onChange={ ( val ) => setAttributes( { headingBefore: val } ) }
                        placeholder="Secure"
                        help={ __( 'The plain white part of the h1.', 'zerogravitynky' ) }
                    />
                    <TextControl
                        label={ __( 'Heading — shimmer (gold) text', 'zerogravitynky' ) }
                        value={ headingShimmer }
                        onChange={ ( val ) => setAttributes( { headingShimmer: val } ) }
                        placeholder="Checkout"
                        help={ __( 'Rendered with the animated gold shimmer effect.', 'zerogravitynky' ) }
                    />
                </PanelBody>
            </InspectorControls>

            <div { ...blockProps }>
                {/* Decorative blobs (simplified) */}
                <div style={ { position: 'absolute', top: '-3rem', right: '-3rem', width: '10rem', height: '10rem', background: 'rgba(183,175,163,0.25)', borderRadius: '9999px', filter: 'blur(40px)', pointerEvents: 'none' } } />
                <div style={ { position: 'absolute', bottom: '-2rem', left: '-3rem', width: '12rem', height: '12rem', background: 'rgba(148,169,149,0.25)', borderRadius: '9999px', filter: 'blur(40px)', pointerEvents: 'none' } } />

                <div style={ { position: 'relative' } }>
                    {/* Eyebrow */}
                    <RichText
                        tagName="p"
                        value={ eyebrow }
                        onChange={ ( val ) => setAttributes( { eyebrow: val } ) }
                        placeholder={ __( 'Eyebrow label…', 'zerogravitynky' ) }
                        style={ { textTransform: 'uppercase', letterSpacing: '0.15em', color: '#E8DED2', fontSize: '0.75rem', fontWeight: 600, marginBottom: '1rem' } }
                        allowedFormats={ [] }
                    />

                    {/* Heading */}
                    <div style={ { fontFamily: '"Fraunces", "Fraunces", Georgia, serif', fontSize: '3rem', fontWeight: 700, lineHeight: 1.2, marginBottom: '1rem', color: '#fff' } }>
                        { headingBefore && <span>{ headingBefore } </span> }
                        { headingShimmer && <span style={ shimmerStyle }>{ headingShimmer }</span> }
                        { ! headingBefore && ! headingShimmer && (
                            <span style={ { opacity: 0.4 } }>{ __( 'Heading text…', 'zerogravitynky' ) }</span>
                        ) }
                    </div>

                    {/* Subtext */}
                    <RichText
                        tagName="p"
                        value={ subtext }
                        onChange={ ( val ) => setAttributes( { subtext: val } ) }
                        placeholder={ __( 'Subtext…', 'zerogravitynky' ) }
                        style={ { color: 'rgba(255,255,255,0.7)', fontSize: '1.125rem', maxWidth: '28rem', margin: '0 auto' } }
                        allowedFormats={ [ 'core/bold', 'core/italic', 'core/link' ] }
                    />
                </div>
            </div>
        </>
    );
}
