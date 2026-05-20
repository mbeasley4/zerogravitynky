import { __ } from '@wordpress/i18n';
import {
    useBlockProps,
    InspectorControls,
    MediaUpload,
    MediaUploadCheck,
    RichText,
} from '@wordpress/block-editor';
import {
    PanelBody,
    TextControl,
    SelectControl,
    Button,
} from '@wordpress/components';

// ── Theme tokens (mirrors render.php logic) ──────────────────────────────────
const THEMES = {
    dark:     { sectionBg: '#3D4A3E', headingColor: '#ffffff',  bodyColor: 'rgba(255,255,255,0.70)', cta1Bg: '#B7AFA3', cta1Color: '#3D4A3E', cta2Border: 'rgba(255,255,255,0.7)', cta2Color: '#fff' },
    olive:    { sectionBg: '#7A8F7B', headingColor: '#ffffff',  bodyColor: 'rgba(255,255,255,0.75)', cta1Bg: '#ffffff', cta1Color: '#3D4A3E', cta2Border: 'rgba(255,255,255,0.7)', cta2Color: '#fff' },
    lavender: { sectionBg: '#E8DED2', headingColor: '#3D4A3E',  bodyColor: 'rgba(61,74,62,0.70)',   cta1Bg: '#7A8F7B', cta1Color: '#fff',    cta2Border: '#3D4A3E',               cta2Color: '#3D4A3E' },
    white:    { sectionBg: '#ffffff', headingColor: '#3D4A3E',  bodyColor: 'rgba(61,74,62,0.70)',   cta1Bg: '#7A8F7B', cta1Color: '#fff',    cta2Border: '#3D4A3E',               cta2Color: '#3D4A3E' },
};

export default function Edit( { attributes, setAttributes } ) {
    const {
        imageUrl, imageAlt, imageId,
        imagePosition, background,
        heading, content,
        ctaLabel1, ctaUrl1,
        ctaLabel2, ctaUrl2,
    } = attributes;

    const theme = THEMES[ background ] || THEMES.lavender;

    const blockProps = useBlockProps( {
        style: { background: theme.sectionBg, padding: '2rem', borderRadius: '4px' },
    } );

    // Grid: swap column order when imagePosition === 'right'
    const isRight      = imagePosition === 'right';
    const gridStyle    = { display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '2rem', alignItems: 'center' };
    const imgOrder     = isRight ? 2 : 1;
    const contentOrder = isRight ? 1 : 2;
    const cellStyle    = {};

    return (
        <>
            <InspectorControls>
                {/* ── Appearance ─────────────────────────── */}
                <PanelBody title={ __( 'Layout & Appearance', 'zerogravitynky' ) } initialOpen={ true }>
                    <SelectControl
                        label={ __( 'Image Position', 'zerogravitynky' ) }
                        value={ imagePosition }
                        options={ [
                            { label: 'Left',  value: 'left'  },
                            { label: 'Right', value: 'right' },
                        ] }
                        onChange={ val => setAttributes( { imagePosition: val } ) }
                    />
                    <SelectControl
                        label={ __( 'Background', 'zerogravitynky' ) }
                        value={ background }
                        options={ [
                            { label: 'Beige / Sand (default)', value: 'lavender' },
                            { label: 'Olive',                  value: 'olive'    },
                            { label: 'Dark Olive',             value: 'dark'     },
                            { label: 'White',                  value: 'white'    },
                        ] }
                        onChange={ val => setAttributes( { background: val } ) }
                    />
                </PanelBody>

                {/* ── Image ──────────────────────────────── */}
                <PanelBody title={ __( 'Image', 'zerogravitynky' ) } initialOpen={ true }>
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
                                        <img src={ imageUrl } alt={ imageAlt }
                                             style={ { width: '100%', marginBottom: '8px', borderRadius: '8px', maxHeight: '120px', objectFit: 'cover' } } />
                                    ) }
                                    <Button onClick={ open } variant="secondary" style={ { width: '100%' } }>
                                        { imageUrl
                                            ? __( 'Change Image', 'zerogravitynky' )
                                            : __( 'Upload / Select Image', 'zerogravitynky' ) }
                                    </Button>
                                    { imageUrl && (
                                        <Button
                                            onClick={ () => setAttributes( { imageId: 0, imageUrl: '', imageAlt: '' } ) }
                                            variant="link" isDestructive style={ { marginTop: '4px' } }>
                                            { __( 'Remove Image', 'zerogravitynky' ) }
                                        </Button>
                                    ) }
                                </div>
                            ) }
                        />
                    </MediaUploadCheck>
                    { imageUrl && (
                        <TextControl
                            label={ __( 'Alt Text', 'zerogravitynky' ) }
                            value={ imageAlt }
                            onChange={ val => setAttributes( { imageAlt: val } ) }
                        />
                    ) }
                </PanelBody>

                {/* ── Content ────────────────────────────── */}
                <PanelBody title={ __( 'Content', 'zerogravitynky' ) } initialOpen={ true }>
                    <p style={ { fontSize: '11px', color: '#757575', margin: '0 0 4px' } }>
                        { __( 'Click the heading or body text in the canvas to edit.', 'zerogravitynky' ) }
                    </p>
                </PanelBody>

                {/* ── CTAs ───────────────────────────────── */}
                <PanelBody title={ __( 'Primary CTA Button', 'zerogravitynky' ) } initialOpen={ false }>
                    <TextControl
                        label={ __( 'Label', 'zerogravitynky' ) }
                        value={ ctaLabel1 }
                        onChange={ val => setAttributes( { ctaLabel1: val } ) }
                    />
                    <TextControl
                        label={ __( 'URL', 'zerogravitynky' ) }
                        value={ ctaUrl1 }
                        onChange={ val => setAttributes( { ctaUrl1: val } ) }
                    />
                </PanelBody>
                <PanelBody title={ __( 'Secondary CTA Button', 'zerogravitynky' ) } initialOpen={ false }>
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

            {/* ── Editor preview ─────────────────────────────────────────── */}
            <div { ...blockProps }>
                <div style={ gridStyle }>

                    {/* Image cell */}
                    <div style={ { ...cellStyle, order: imgOrder, borderRadius: '12px', overflow: 'hidden', background: 'rgba(0,0,0,0.08)', aspectRatio: '4/3' } }>
                        { imageUrl
                            ? <img src={ imageUrl } alt={ imageAlt }
                                   style={ { width: '100%', height: '100%', objectFit: 'cover', display: 'block' } } />
                            : <div style={ { width: '100%', height: '100%', display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'rgba(0,0,0,0.25)', fontSize: '12px' } }>
                                  No image — select in Settings panel
                              </div>
                        }
                    </div>

                    {/* Content cell */}
                    <div style={ { ...cellStyle, order: contentOrder } }>
                        <RichText
                            tagName="h2"
                            value={ heading }
                            onChange={ val => setAttributes( { heading: val } ) }
                            allowedFormats={ [] }
                            placeholder={ __( 'Heading…', 'zerogravitynky' ) }
                            style={ { fontFamily: 'serif', fontSize: '1.75rem', fontWeight: 700, lineHeight: 1.3, color: theme.headingColor, margin: '0 0 12px' } }
                        />
                        <RichText
                            tagName="div"
                            value={ content }
                            onChange={ val => setAttributes( { content: val } ) }
                            allowedFormats={ [ 'core/bold', 'core/italic', 'core/link', 'core/strikethrough', 'core/underline' ] }
                            placeholder={ __( 'Write body text… (Enter for new paragraph)', 'zerogravitynky' ) }
                            style={ { color: theme.bodyColor, fontSize: '14px', lineHeight: 1.7, marginBottom: '16px' } }
                        />
                        <div style={ { display: 'flex', flexWrap: 'wrap', gap: '10px' } }>
                            { ctaLabel1 && (
                                <span style={ { display: 'inline-flex', alignItems: 'center', gap: '6px', padding: '10px 22px', background: theme.cta1Bg, color: theme.cta1Color, borderRadius: '9999px', fontWeight: 600, fontSize: '13px' } }>
                                    { ctaLabel1 }
                                </span>
                            ) }
                            { ctaLabel2 && (
                                <span style={ { display: 'inline-flex', alignItems: 'center', padding: '10px 22px', border: `2px solid ${ theme.cta2Border }`, color: theme.cta2Color, borderRadius: '9999px', fontWeight: 600, fontSize: '13px' } }>
                                    { ctaLabel2 }
                                </span>
                            ) }
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
