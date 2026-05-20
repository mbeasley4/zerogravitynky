import {
    useBlockProps,
    RichText,
    InspectorControls,
    MediaUpload,
    MediaUploadCheck,
} from '@wordpress/block-editor';
import { PanelBody, TextControl, Button } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

export default function Edit( { attributes, setAttributes } ) {
    const { title, subtext, ctaLabel, ctaUrl, imageId, imageUrl, imageAlt } = attributes;

    const blockProps = useBlockProps( {
        style: {
            background: 'linear-gradient(135deg, #3D4A3E 0%, #7A8F7B 50%, #94A995 100%)',
            padding: '3rem 2rem',
            borderRadius: '4px',
        },
    } );

    return (
        <>
            <InspectorControls>
                <PanelBody title={ __( 'CTA Button', 'zerogravitynky' ) } initialOpen={ false }>
                    <TextControl
                        label={ __( 'Button label', 'zerogravitynky' ) }
                        value={ ctaLabel }
                        onChange={ ( val ) => setAttributes( { ctaLabel: val } ) }
                        placeholder={ __( 'e.g. Learn more', 'zerogravitynky' ) }
                    />
                    <TextControl
                        label={ __( 'Button URL', 'zerogravitynky' ) }
                        value={ ctaUrl }
                        onChange={ ( val ) => setAttributes( { ctaUrl: val } ) }
                        placeholder="https://"
                        type="url"
                    />
                </PanelBody>

                <PanelBody title={ __( 'Hero Image', 'zerogravitynky' ) } initialOpen={ false }>
                    <MediaUploadCheck>
                        <MediaUpload
                            onSelect={ ( media ) =>
                                setAttributes( {
                                    imageId:  media.id,
                                    imageUrl: media.url,
                                    imageAlt: media.alt || '',
                                } )
                            }
                            allowedTypes={ [ 'image' ] }
                            value={ imageId }
                            render={ ( { open } ) => (
                                <div>
                                    { imageUrl ? (
                                        <>
                                            <img
                                                src={ imageUrl }
                                                alt={ imageAlt }
                                                style={ { width: '100%', borderRadius: '8px', marginBottom: '8px' } }
                                            />
                                            <Button variant="secondary" onClick={ open } style={ { marginRight: '8px' } }>
                                                { __( 'Replace image', 'zerogravitynky' ) }
                                            </Button>
                                            <Button
                                                variant="link"
                                                isDestructive
                                                onClick={ () =>
                                                    setAttributes( { imageId: undefined, imageUrl: '', imageAlt: '' } )
                                                }
                                            >
                                                { __( 'Remove', 'zerogravitynky' ) }
                                            </Button>
                                        </>
                                    ) : (
                                        <Button variant="secondary" onClick={ open }>
                                            { __( 'Upload / select image', 'zerogravitynky' ) }
                                        </Button>
                                    ) }
                                </div>
                            ) }
                        />
                    </MediaUploadCheck>
                </PanelBody>
            </InspectorControls>

            <div { ...blockProps }>
                <div style={ { display: 'flex', gap: '2rem', alignItems: 'center' } }>
                    <div style={ { flex: 1 } }>
                        <RichText
                            tagName="h1"
                            value={ title }
                            onChange={ ( val ) => setAttributes( { title: val } ) }
                            placeholder={ __( 'Title (optional — defaults to page title)', 'zerogravitynky' ) }
                            style={ { color: '#fff', fontFamily: 'serif', fontSize: '2.5rem', fontWeight: 700, margin: '0 0 0.75rem' } }
                            allowedFormats={ [] }
                        />
                        <div style={ { width: '3rem', height: '4px', background: '#B7AFA3', borderRadius: '9999px', margin: '0 0 1rem' } }></div>
                        <RichText
                            tagName="p"
                            value={ subtext }
                            onChange={ ( val ) => setAttributes( { subtext: val } ) }
                            placeholder={ __( 'Subtext (optional)', 'zerogravitynky' ) }
                            style={ { color: 'rgba(255,255,255,0.8)', fontSize: '1.125rem', margin: '0 0 1.5rem' } }
                            allowedFormats={ [ 'core/bold', 'core/italic', 'core/link' ] }
                        />
                        { ( ctaLabel || ctaUrl ) && (
                            <a
                                href={ ctaUrl || '#' }
                                style={ {
                                    display: 'inline-block',
                                    background: '#B7AFA3',
                                    color: '#fff',
                                    padding: '0.625rem 1.5rem',
                                    borderRadius: '6px',
                                    fontWeight: 600,
                                    textDecoration: 'none',
                                    fontSize: '0.95rem',
                                } }
                            >
                                { ctaLabel || __( '(enter button label in sidebar)', 'zerogravitynky' ) }
                            </a>
                        ) }
                    </div>
                    { imageUrl && (
                        <div style={ { flexShrink: 0, width: '320px' } }>
                            <img
                                src={ imageUrl }
                                alt={ imageAlt }
                                style={ { width: '100%', borderRadius: '12px', display: 'block' } }
                            />
                        </div>
                    ) }
                </div>
            </div>
        </>
    );
}
