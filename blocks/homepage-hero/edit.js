import { __ } from '@wordpress/i18n';
import {
    useBlockProps,
    InspectorControls,
    MediaUpload,
    MediaUploadCheck,
} from '@wordpress/block-editor';
import {
    PanelBody,
    TextControl,
    TextareaControl,
    Button,
} from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
    const {
        badge,
        headlineLine1, headlineAccent, headlineLine3,
        subheadline,
        ctaLabel1, ctaUrl1,
        ctaLabel2, ctaUrl2,
        imageId, imageUrl, imageAlt,
    } = attributes;

    const blockProps = useBlockProps( {
        style: {
            background: 'linear-gradient(135deg, #3D4A3E 0%, #7A8F7B 50%, #94A995 100%)',
            padding: '2rem',
            borderRadius: '4px',
            color: '#fff',
        },
    } );

    return (
        <>
            <InspectorControls>
                <PanelBody title={ __( 'Badge & Headline', 'zerogravitynky' ) } initialOpen={ true }>
                    <TextControl
                        label={ __( 'Badge Text', 'zerogravitynky' ) }
                        value={ badge }
                        onChange={ val => setAttributes( { badge: val } ) }
                    />
                    <TextControl
                        label={ __( 'Headline — Line 1', 'zerogravitynky' ) }
                        value={ headlineLine1 }
                        onChange={ val => setAttributes( { headlineLine1: val } ) }
                        help={ __( 'e.g. "Reveal Your"', 'zerogravitynky' ) }
                    />
                    <TextControl
                        label={ __( 'Headline — Accent (shimmer)', 'zerogravitynky' ) }
                        value={ headlineAccent }
                        onChange={ val => setAttributes( { headlineAccent: val } ) }
                        help={ __( 'e.g. "Most Radiant" — rendered with gold shimmer', 'zerogravitynky' ) }
                    />
                    <TextControl
                        label={ __( 'Headline — Line 3', 'zerogravitynky' ) }
                        value={ headlineLine3 }
                        onChange={ val => setAttributes( { headlineLine3: val } ) }
                        help={ __( 'e.g. "Self"', 'zerogravitynky' ) }
                    />
                    <TextareaControl
                        label={ __( 'Subheadline', 'zerogravitynky' ) }
                        value={ subheadline }
                        onChange={ val => setAttributes( { subheadline: val } ) }
                        rows={ 3 }
                    />
                </PanelBody>

                <PanelBody title={ __( 'Primary CTA Button', 'zerogravitynky' ) } initialOpen={ false }>
                    <TextControl
                        label={ __( 'Button Label', 'zerogravitynky' ) }
                        value={ ctaLabel1 }
                        onChange={ val => setAttributes( { ctaLabel1: val } ) }
                    />
                    <TextControl
                        label={ __( 'Button URL', 'zerogravitynky' ) }
                        value={ ctaUrl1 }
                        onChange={ val => setAttributes( { ctaUrl1: val } ) }
                    />
                </PanelBody>

                <PanelBody title={ __( 'Secondary CTA Button', 'zerogravitynky' ) } initialOpen={ false }>
                    <TextControl
                        label={ __( 'Button Label', 'zerogravitynky' ) }
                        value={ ctaLabel2 }
                        onChange={ val => setAttributes( { ctaLabel2: val } ) }
                    />
                    <TextControl
                        label={ __( 'Button URL', 'zerogravitynky' ) }
                        value={ ctaUrl2 }
                        onChange={ val => setAttributes( { ctaUrl2: val } ) }
                    />
                </PanelBody>

                <PanelBody title={ __( 'Hero Image', 'zerogravitynky' ) } initialOpen={ false }>
                    <MediaUploadCheck>
                        <MediaUpload
                            onSelect={ media => setAttributes( {
                                imageId:  media.id,
                                imageUrl: media.url,
                                imageAlt: media.alt || media.title,
                            } ) }
                            allowedTypes={ [ 'image' ] }
                            value={ imageId }
                            render={ ( { open } ) => (
                                <div>
                                    { imageUrl && (
                                        <img
                                            src={ imageUrl }
                                            alt={ imageAlt }
                                            style={ {
                                                width: '100%',
                                                marginBottom: '8px',
                                                borderRadius: '8px',
                                                maxHeight: '160px',
                                                objectFit: 'cover',
                                            } }
                                        />
                                    ) }
                                    <Button
                                        onClick={ open }
                                        variant="secondary"
                                        style={ { width: '100%' } }
                                    >
                                        { imageUrl
                                            ? __( 'Change Image', 'zerogravitynky' )
                                            : __( 'Upload Hero Image', 'zerogravitynky' ) }
                                    </Button>
                                    { imageUrl && (
                                        <Button
                                            onClick={ () => setAttributes( { imageId: 0, imageUrl: '', imageAlt: '' } ) }
                                            variant="link"
                                            isDestructive
                                            style={ { marginTop: '4px' } }
                                        >
                                            { __( 'Remove Image', 'zerogravitynky' ) }
                                        </Button>
                                    ) }
                                </div>
                            ) }
                        />
                    </MediaUploadCheck>
                </PanelBody>
            </InspectorControls>

            <div { ...blockProps }>
                <div style={ {
                    display: 'grid',
                    gridTemplateColumns: imageUrl ? '1fr 1fr' : '1fr',
                    gap: '2rem',
                    alignItems: 'center',
                } }>
                    <div>
                        <div style={ {
                            display: 'inline-block',
                            background: 'rgba(255,255,255,0.1)',
                            padding: '4px 14px',
                            borderRadius: '999px',
                            fontSize: '11px',
                            textTransform: 'uppercase',
                            letterSpacing: '0.1em',
                            marginBottom: '12px',
                        } }>
                            ✦ { badge }
                        </div>
                        <h1 style={ {
                            fontFamily: 'serif',
                            fontSize: '2.5rem',
                            fontWeight: 700,
                            lineHeight: 1.15,
                            marginBottom: '12px',
                            margin: '0 0 12px',
                        } }>
                            { headlineLine1 }<br />
                            <em style={ {
                                fontStyle: 'normal',
                                background: 'linear-gradient(90deg, #8A8178, #E8DED2, #8A8178)',
                                WebkitBackgroundClip: 'text',
                                WebkitTextFillColor: 'transparent',
                            } }>
                                { headlineAccent }
                            </em><br />
                            { headlineLine3 }
                        </h1>
                        <p style={ { opacity: 0.7, marginBottom: '16px', lineHeight: 1.6, fontSize: '15px' } }>
                            { subheadline }
                        </p>
                        <div style={ { display: 'flex', gap: '12px', flexWrap: 'wrap' } }>
                            <span style={ {
                                background: '#B7AFA3',
                                padding: '10px 22px',
                                borderRadius: '999px',
                                fontSize: '14px',
                                fontWeight: 600,
                            } }>
                                { ctaLabel1 }
                            </span>
                            <span style={ {
                                border: '1px solid rgba(255,255,255,0.3)',
                                padding: '10px 22px',
                                borderRadius: '999px',
                                fontSize: '14px',
                            } }>
                                { ctaLabel2 }
                            </span>
                        </div>
                    </div>

                    { imageUrl && (
                        <div>
                            <img
                                src={ imageUrl }
                                alt={ imageAlt }
                                style={ {
                                    width: '100%',
                                    borderRadius: '16px',
                                    maxHeight: '320px',
                                    objectFit: 'cover',
                                    border: '1px solid rgba(255,255,255,0.15)',
                                } }
                            />
                        </div>
                    ) }
                </div>
                <p style={ { opacity: 0.4, fontSize: '11px', marginTop: '12px', marginBottom: 0 } }>
                    ZG Homepage Hero — edit all fields in the Settings panel →
                </p>
            </div>
        </>
    );
}
