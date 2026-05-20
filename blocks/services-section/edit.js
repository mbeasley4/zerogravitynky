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
    SelectControl,
} from '@wordpress/components';

const blankService = {
    imageUrl: '',
    imageAlt: '',
    imageId: 0,
    title: 'New Service',
    description: 'Brief description of this service.',
    linkUrl: '#',
    linkText: 'Learn More',
};

// Maps each background option to { sectionBg, headingColor, cardBg, descColor, linkColor }
const BG_STYLES = {
    white: {
        sectionBg:    '#ffffff',
        headingColor: '#3D4A3E',
        cardBg:       'rgba(122,143,123,0.08)',
        descColor:    '#515151',
        linkColor:    '#7A8F7B',
    },
    sand: {
        sectionBg:    '#E8DED2',
        headingColor: '#3D4A3E',
        cardBg:       '#ffffff',
        descColor:    '#515151',
        linkColor:    '#7A8F7B',
    },
    dark: {
        sectionBg:    '#3D4A3E',
        headingColor: '#ffffff',
        cardBg:       'rgba(255,255,255,0.10)',
        descColor:    'rgba(255,255,255,0.80)',
        linkColor:    '#B7AFA3',
    },
};

export default function Edit( { attributes, setAttributes } ) {
    const { sectionTitle, backgroundColor, services, ctaLabel, ctaUrl } = attributes;
    const theme = BG_STYLES[ backgroundColor ] ?? BG_STYLES.white;

    const updateService = ( i, patch ) => {
        const updated = services.map( ( s, idx ) =>
            idx === i ? { ...s, ...patch } : s
        );
        setAttributes( { services: updated } );
    };

    const removeService = ( i ) =>
        setAttributes( { services: services.filter( ( _, idx ) => idx !== i ) } );

    const addService = () =>
        setAttributes( { services: [ ...services, { ...blankService } ] } );

    const blockProps = useBlockProps( {
        style: { padding: '24px', background: theme.sectionBg, borderRadius: '4px', transition: 'background 0.2s' },
    } );

    return (
        <>
            <InspectorControls>
                <PanelBody title={ __( 'Section Settings', 'zerogravitynky' ) } initialOpen={ true }>
                    <TextControl
                        label={ __( 'Section Title', 'zerogravitynky' ) }
                        value={ sectionTitle }
                        onChange={ val => setAttributes( { sectionTitle: val } ) }
                        help={ __( 'Displayed as the section heading (hidden if blank).', 'zerogravitynky' ) }
                    />
                    <SelectControl
                        label={ __( 'Background Color', 'zerogravitynky' ) }
                        value={ backgroundColor }
                        options={ [
                            { label: __( 'White', 'zerogravitynky' ),        value: 'white' },
                            { label: __( 'Beige / Sand', 'zerogravitynky' ),  value: 'sand' },
                            { label: __( 'Olive (Dark)', 'zerogravitynky' ),  value: 'dark' },
                        ] }
                        onChange={ val => setAttributes( { backgroundColor: val } ) }
                    />
                    <TextControl
                        label={ __( 'Button Label', 'zerogravitynky' ) }
                        value={ ctaLabel }
                        onChange={ val => setAttributes( { ctaLabel: val } ) }
                        help={ __( 'Leave blank to hide the button.', 'zerogravitynky' ) }
                    />
                    <TextControl
                        label={ __( 'Button URL', 'zerogravitynky' ) }
                        value={ ctaUrl }
                        onChange={ val => setAttributes( { ctaUrl: val } ) }
                    />
                </PanelBody>
                <PanelBody title={ __( 'Tips', 'zerogravitynky' ) } initialOpen={ false }>
                    <p style={ { fontSize: '12px', color: '#555', lineHeight: 1.5 } }>
                        { __( 'Click the image area on any card to upload a photo. Edit title, description, URL, and link text inline on each card below.', 'zerogravitynky' ) }
                    </p>
                </PanelBody>
            </InspectorControls>

            <div { ...blockProps }>
                { sectionTitle && (
                    <h2 style={ {
                        fontFamily: 'serif',
                        fontSize: '1.75rem',
                        fontWeight: 700,
                        color: theme.headingColor,
                        marginBottom: '20px',
                    } }>
                        { sectionTitle }
                    </h2>
                ) }

                <div style={ {
                    display: 'grid',
                    gridTemplateColumns: 'repeat(auto-fill, minmax(260px, 1fr))',
                    gap: '16px',
                } }>
                    { services.map( ( service, i ) => (
                        <div
                            key={ i }
                            style={ {
                                border: '1px solid rgba(122,143,123,0.20)',
                                borderRadius: '14px',
                                overflow: 'hidden',
                                background: theme.cardBg,
                            } }
                        >
                            { /* Image upload area */ }
                            <MediaUploadCheck>
                                <MediaUpload
                                    onSelect={ media => updateService( i, {
                                        imageId:  media.id,
                                        imageUrl: media.url,
                                        imageAlt: media.alt || media.title,
                                    } ) }
                                    allowedTypes={ [ 'image' ] }
                                    value={ service.imageId }
                                    render={ ( { open } ) => (
                                        <div
                                            onClick={ open }
                                            title={ __( 'Click to upload image', 'zerogravitynky' ) }
                                            style={ {
                                                height: '130px',
                                                background: service.imageUrl
                                                    ? `url(${ service.imageUrl }) center/cover no-repeat`
                                                    : 'linear-gradient(135deg, #E8DED2, #D4CCC4)',
                                                cursor: 'pointer',
                                                display: 'flex',
                                                alignItems: 'center',
                                                justifyContent: 'center',
                                                position: 'relative',
                                            } }
                                        >
                                            { ! service.imageUrl && (
                                                <span style={ { color: '#7A8F7B', fontSize: '13px', fontWeight: 600 } }>
                                                    + Upload Image
                                                </span>
                                            ) }
                                            { service.imageUrl && (
                                                <span style={ {
                                                    position: 'absolute',
                                                    bottom: '6px',
                                                    right: '8px',
                                                    background: 'rgba(0,0,0,0.5)',
                                                    color: '#fff',
                                                    fontSize: '10px',
                                                    padding: '2px 7px',
                                                    borderRadius: '999px',
                                                } }>
                                                    Change
                                                </span>
                                            ) }
                                        </div>
                                    ) }
                                />
                            </MediaUploadCheck>

                            { /* Fields */ }
                            <div style={ { padding: '12px 14px 14px' } }>
                                <TextControl
                                    label={ __( 'Title', 'zerogravitynky' ) }
                                    value={ service.title }
                                    onChange={ val => updateService( i, { title: val } ) }
                                />
                                <TextareaControl
                                    label={ __( 'Description', 'zerogravitynky' ) }
                                    value={ service.description }
                                    onChange={ val => updateService( i, { description: val } ) }
                                    rows={ 3 }
                                />
                                <TextControl
                                    label={ __( 'Link URL', 'zerogravitynky' ) }
                                    value={ service.linkUrl }
                                    onChange={ val => updateService( i, { linkUrl: val } ) }
                                />
                                <TextControl
                                    label={ __( 'Link Text', 'zerogravitynky' ) }
                                    value={ service.linkText }
                                    onChange={ val => updateService( i, { linkText: val } ) }
                                />
                                <Button
                                    isDestructive
                                    variant="tertiary"
                                    size="small"
                                    onClick={ () => removeService( i ) }
                                    style={ { marginTop: '4px' } }
                                >
                                    { __( 'Remove', 'zerogravitynky' ) }
                                </Button>
                            </div>
                        </div>
                    ) ) }

                    { /* Add new card */ }
                    <button
                        onClick={ addService }
                        style={ {
                            border: '2px dashed #B7AFA3',
                            borderRadius: '14px',
                            background: 'transparent',
                            cursor: 'pointer',
                            minHeight: '200px',
                            display: 'flex',
                            flexDirection: 'column',
                            alignItems: 'center',
                            justifyContent: 'center',
                            gap: '8px',
                            color: '#7A8F7B',
                            fontSize: '14px',
                            fontWeight: 600,
                        } }
                    >
                        <span style={ { fontSize: '24px', lineHeight: 1 } }>+</span>
                        { __( 'Add Service', 'zerogravitynky' ) }
                    </button>
                </div>

                { ctaLabel && (
                    <div style={ { textAlign: 'center', marginTop: '32px' } }>
                        <a
                            href={ ctaUrl }
                            onClick={ e => e.preventDefault() }
                            style={ {
                                display: 'inline-block',
                                padding: '14px 36px',
                                background: '#7A8F7B',
                                color: '#ffffff',
                                borderRadius: '999px',
                                fontWeight: 700,
                                fontSize: '15px',
                                textDecoration: 'none',
                            } }
                        >
                            { ctaLabel }
                        </a>
                    </div>
                ) }
            </div>
        </>
    );
}
