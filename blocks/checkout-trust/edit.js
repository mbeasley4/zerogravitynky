import { useBlockProps, RichText, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

const trustPoints = [
    { label: 'SSL Encrypted',     desc: 'Your data is protected by 256-bit SSL encryption.' },
    { label: 'Secure Payment',    desc: 'Processed safely through our trusted payment gateway.' },
    { label: 'Privacy Protected', desc: 'We never sell or share your personal information.' },
    { label: 'Expert Care',       desc: 'Our nurse practitioners and RNs are here to help.' },
];

export default function Edit( { attributes, setAttributes } ) {
    const { headline, phone, note } = attributes;

    const blockProps = useBlockProps( {
        style: {
            borderRadius: '1rem',
            border: '1px solid rgba(0,0,0,0.08)',
            overflow: 'hidden',
            fontFamily: '"Plus Jakarta Sans", system-ui, sans-serif',
            maxWidth: '380px',
        },
    } );

    return (
        <>
            <InspectorControls>
                <PanelBody title={ __( 'Contact', 'zerogravitynky' ) } initialOpen>
                    <TextControl
                        label={ __( 'Phone number (display)', 'zerogravitynky' ) }
                        value={ phone }
                        onChange={ ( val ) => setAttributes( { phone: val } ) }
                        placeholder="(859) 344-3250"
                    />
                    <TextControl
                        label={ __( 'Fine-print note', 'zerogravitynky' ) }
                        value={ note }
                        onChange={ ( val ) => setAttributes( { note: val } ) }
                        help={ __( 'Small disclaimer shown at the bottom of the panel.', 'zerogravitynky' ) }
                    />
                </PanelBody>
            </InspectorControls>

            <div { ...blockProps }>
                {/* Header */}
                <div style={ { background: '#3D4A3E', padding: '1rem 1.5rem', display: 'flex', alignItems: 'center', gap: '0.625rem' } }>
                    <svg style={ { width: '1rem', height: '1rem', color: '#B7AFA3', flexShrink: 0 } } fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={ 2 } d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    <RichText
                        tagName="span"
                        value={ headline }
                        onChange={ ( val ) => setAttributes( { headline: val } ) }
                        placeholder={ __( 'Panel headline', 'zerogravitynky' ) }
                        style={ { color: '#fff', fontSize: '0.875rem', fontWeight: 600 } }
                        allowedFormats={ [] }
                    />
                </div>

                {/* Trust points preview */}
                <div style={ { borderTop: '1px solid rgba(0,0,0,0.06)' } }>
                    { trustPoints.map( ( point, i ) => (
                        <div key={ i } style={ { display: 'flex', alignItems: 'flex-start', gap: '0.75rem', padding: '0.875rem 1.25rem', borderBottom: '1px solid rgba(0,0,0,0.06)' } }>
                            <div style={ { width: '2rem', height: '2rem', borderRadius: '0.5rem', background: 'rgba(122,143,123,0.10)', display: 'flex', alignItems: 'center', justifyContent: 'center', flexShrink: 0 } }>
                                <svg style={ { width: '1rem', height: '1rem', color: '#7A8F7B' } } fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={ 2 } d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <p style={ { fontSize: '0.75rem', fontWeight: 600, color: '#3D4A3E', margin: 0 } }>{ point.label }</p>
                                <p style={ { fontSize: '0.75rem', color: 'rgba(81,81,81,0.6)', margin: '0.125rem 0 0' } }>{ point.desc }</p>
                            </div>
                        </div>
                    ) ) }
                </div>

                {/* Contact */}
                <div style={ { padding: '1rem 1.25rem', background: 'rgba(232,222,210,0.35)', borderTop: '1px solid rgba(0,0,0,0.06)' } }>
                    <p style={ { fontSize: '0.75rem', color: 'rgba(81,81,81,0.6)', margin: '0 0 0.375rem' } }>Need help?</p>
                    <p style={ { fontSize: '0.875rem', fontWeight: 600, color: '#3D4A3E', margin: 0 } }>📞 { phone || '(859) 344-3250' }</p>
                </div>

                {/* Note */}
                { note && (
                    <div style={ { padding: '0.75rem 1.25rem', borderTop: '1px solid rgba(0,0,0,0.06)' } }>
                        <p style={ { fontSize: '0.75rem', color: 'rgba(81,81,81,0.4)', margin: 0 } }>{ note }</p>
                    </div>
                ) }
            </div>
        </>
    );
}
