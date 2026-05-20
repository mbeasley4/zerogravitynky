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
    SelectControl,
    Button,
} from '@wordpress/components';

const BG_STYLES = {
    primary:   { background: '#3D4A3E', color: '#fff', accentColor: '#B7AFA3' },
    secondary: { background: '#B7AFA3', color: '#3D4A3E', accentColor: '#3D4A3E' },
    white:     { background: '#ffffff', color: '#3D4A3E', accentColor: '#7A8F7B', border: '1px solid #e5e7eb' },
};

export default function Edit( { attributes, setAttributes } ) {
    const {
        background,
        badgeLabel,
        headingLine1, headingLine2, headingLine3,
        paragraph1, paragraph2,
        tags,
        ctaLabel, ctaUrl,
        founderImageId, founderImageUrl, founderImageAlt,
        founderName1, founderTitle1,
        founderName2, founderTitle2,
        exteriorImageId, exteriorImageUrl, exteriorImageAlt, exteriorCaption,
        reasons,
    } = attributes;

    const theme = BG_STYLES[ background ] || BG_STYLES.primary;

    const blockProps = useBlockProps( {
        style: {
            background: theme.background,
            color: theme.color,
            padding: '2rem',
            borderRadius: '4px',
            ...(theme.border ? { border: theme.border } : {}),
        },
    } );

    const labelStyle = { color: theme.accentColor, fontSize: '11px', textTransform: 'uppercase', letterSpacing: '0.1em', fontWeight: 600, marginBottom: '4px' };
    const mutedStyle = { opacity: 0.65, fontSize: '14px', lineHeight: 1.6 };
    const h2Style    = { fontFamily: 'serif', fontSize: '1.8rem', fontWeight: 700, margin: '8px 0 12px', lineHeight: 1.3 };
    const accentStyle = { color: theme.accentColor };

    return (
        <>
            <InspectorControls>
                {/* ── Appearance ───────────────────────────── */}
                <PanelBody title={ __( 'Appearance', 'zerogravitynky' ) } initialOpen={ true }>
                    <SelectControl
                        label={ __( 'Background', 'zerogravitynky' ) }
                        value={ background }
                        options={ [
                            { label: 'Primary (Dark Olive)', value: 'primary'   },
                            { label: 'Secondary (Taupe)',    value: 'secondary' },
                            { label: 'White',                value: 'white'     },
                        ] }
                        onChange={ val => setAttributes( { background: val } ) }
                    />
                </PanelBody>

                {/* ── Copy ─────────────────────────────────── */}
                <PanelBody title={ __( 'Badge & Heading', 'zerogravitynky' ) } initialOpen={ true }>
                    <TextControl
                        label={ __( 'Badge Label', 'zerogravitynky' ) }
                        value={ badgeLabel }
                        onChange={ val => setAttributes( { badgeLabel: val } ) }
                    />
                    <TextControl
                        label={ __( 'Heading — Line 1', 'zerogravitynky' ) }
                        value={ headingLine1 }
                        onChange={ val => setAttributes( { headingLine1: val } ) }
                    />
                    <TextControl
                        label={ __( 'Heading — Line 2 (accent / shimmer)', 'zerogravitynky' ) }
                        value={ headingLine2 }
                        onChange={ val => setAttributes( { headingLine2: val } ) }
                    />
                    <TextControl
                        label={ __( 'Heading — Line 3', 'zerogravitynky' ) }
                        value={ headingLine3 }
                        onChange={ val => setAttributes( { headingLine3: val } ) }
                    />
                    <TextareaControl
                        label={ __( 'Paragraph 1', 'zerogravitynky' ) }
                        value={ paragraph1 }
                        onChange={ val => setAttributes( { paragraph1: val } ) }
                        rows={ 4 }
                    />
                    <TextareaControl
                        label={ __( 'Paragraph 2', 'zerogravitynky' ) }
                        value={ paragraph2 }
                        onChange={ val => setAttributes( { paragraph2: val } ) }
                        rows={ 4 }
                    />
                    <TextareaControl
                        label={ __( 'Credential Tags (one per line)', 'zerogravitynky' ) }
                        value={ tags }
                        onChange={ val => setAttributes( { tags: val } ) }
                        rows={ 5 }
                        help={ __( 'e.g. APRN Led', 'zerogravitynky' ) }
                    />
                </PanelBody>

                {/* ── CTA ──────────────────────────────────── */}
                <PanelBody title={ __( 'CTA Button', 'zerogravitynky' ) } initialOpen={ false }>
                    <TextControl
                        label={ __( 'Button Label', 'zerogravitynky' ) }
                        value={ ctaLabel }
                        onChange={ val => setAttributes( { ctaLabel: val } ) }
                    />
                    <TextControl
                        label={ __( 'Button URL', 'zerogravitynky' ) }
                        value={ ctaUrl }
                        onChange={ val => setAttributes( { ctaUrl: val } ) }
                    />
                </PanelBody>

                {/* ── Founder Image ─────────────────────────── */}
                <PanelBody title={ __( 'Founder Photo', 'zerogravitynky' ) } initialOpen={ false }>
                    <MediaUploadCheck>
                        <MediaUpload
                            onSelect={ media => setAttributes( {
                                founderImageId:  media.id,
                                founderImageUrl: media.url,
                                founderImageAlt: media.alt || media.title,
                            } ) }
                            allowedTypes={ [ 'image' ] }
                            value={ founderImageId }
                            render={ ( { open } ) => (
                                <div>
                                    { founderImageUrl && (
                                        <img src={ founderImageUrl } alt={ founderImageAlt }
                                             style={ { width: '100%', marginBottom: '8px', borderRadius: '8px', maxHeight: '120px', objectFit: 'cover' } } />
                                    ) }
                                    <Button onClick={ open } variant="secondary" style={ { width: '100%' } }>
                                        { founderImageUrl ? __( 'Change Photo', 'zerogravitynky' ) : __( 'Upload Founder Photo', 'zerogravitynky' ) }
                                    </Button>
                                    { founderImageUrl && (
                                        <Button onClick={ () => setAttributes( { founderImageId: 0, founderImageUrl: '', founderImageAlt: '' } ) }
                                                variant="link" isDestructive style={ { marginTop: '4px' } }>
                                            { __( 'Remove Photo', 'zerogravitynky' ) }
                                        </Button>
                                    ) }
                                </div>
                            ) }
                        />
                    </MediaUploadCheck>
                    <TextControl
                        label={ __( 'Person 1 — Name', 'zerogravitynky' ) }
                        value={ founderName1 }
                        onChange={ val => setAttributes( { founderName1: val } ) }
                    />
                    <TextControl
                        label={ __( 'Person 1 — Title', 'zerogravitynky' ) }
                        value={ founderTitle1 }
                        onChange={ val => setAttributes( { founderTitle1: val } ) }
                    />
                    <TextControl
                        label={ __( 'Person 2 — Name', 'zerogravitynky' ) }
                        value={ founderName2 }
                        onChange={ val => setAttributes( { founderName2: val } ) }
                    />
                    <TextControl
                        label={ __( 'Person 2 — Title', 'zerogravitynky' ) }
                        value={ founderTitle2 }
                        onChange={ val => setAttributes( { founderTitle2: val } ) }
                    />
                </PanelBody>

                {/* ── Exterior Image ────────────────────────── */}
                <PanelBody title={ __( 'Exterior / Location Photo', 'zerogravitynky' ) } initialOpen={ false }>
                    <MediaUploadCheck>
                        <MediaUpload
                            onSelect={ media => setAttributes( {
                                exteriorImageId:  media.id,
                                exteriorImageUrl: media.url,
                                exteriorImageAlt: media.alt || media.title,
                            } ) }
                            allowedTypes={ [ 'image' ] }
                            value={ exteriorImageId }
                            render={ ( { open } ) => (
                                <div>
                                    { exteriorImageUrl && (
                                        <img src={ exteriorImageUrl } alt={ exteriorImageAlt }
                                             style={ { width: '100%', marginBottom: '8px', borderRadius: '8px', maxHeight: '100px', objectFit: 'cover' } } />
                                    ) }
                                    <Button onClick={ open } variant="secondary" style={ { width: '100%' } }>
                                        { exteriorImageUrl ? __( 'Change Photo', 'zerogravitynky' ) : __( 'Upload Exterior Photo', 'zerogravitynky' ) }
                                    </Button>
                                    { exteriorImageUrl && (
                                        <Button onClick={ () => setAttributes( { exteriorImageId: 0, exteriorImageUrl: '', exteriorImageAlt: '' } ) }
                                                variant="link" isDestructive style={ { marginTop: '4px' } }>
                                            { __( 'Remove Photo', 'zerogravitynky' ) }
                                        </Button>
                                    ) }
                                </div>
                            ) }
                        />
                    </MediaUploadCheck>
                    <TextControl
                        label={ __( 'Location Caption', 'zerogravitynky' ) }
                        value={ exteriorCaption }
                        onChange={ val => setAttributes( { exteriorCaption: val } ) }
                    />
                </PanelBody>

                {/* ── Why Choose Us ─────────────────────────── */}
                <PanelBody title={ __( '"Why Patients Choose Us" List', 'zerogravitynky' ) } initialOpen={ false }>
                    <TextareaControl
                        label={ __( 'Reasons (one per line)', 'zerogravitynky' ) }
                        value={ reasons }
                        onChange={ val => setAttributes( { reasons: val } ) }
                        rows={ 6 }
                    />
                </PanelBody>
            </InspectorControls>

            {/* ── Editor Preview ────────────────────────────── */}
            <div { ...blockProps }>
                <div style={ { display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '2rem', alignItems: 'start' } }>

                    {/* Left column */}
                    <div>
                        <div style={ { ...labelStyle, display: 'flex', alignItems: 'center', gap: '6px', marginBottom: '12px' } }>
                            <span style={ { width: '28px', height: '1px', background: theme.accentColor, display: 'inline-block' } }></span>
                            { badgeLabel }
                        </div>
                        <h2 style={ h2Style }>
                            { headingLine1 }<br />
                            <span style={ accentStyle }>{ headingLine2 }</span><br />
                            { headingLine3 }
                        </h2>
                        { paragraph1 && <p style={ mutedStyle }>{ paragraph1 }</p> }
                        { paragraph2 && <p style={ { ...mutedStyle, marginTop: '8px' } }>{ paragraph2 }</p> }
                        { tags && (
                            <div style={ { display: 'flex', flexWrap: 'wrap', gap: '6px', margin: '12px 0' } }>
                                { tags.split('\n').filter(Boolean).map( ( t, i ) => (
                                    <span key={ i } style={ {
                                        padding: '3px 12px',
                                        borderRadius: '999px',
                                        fontSize: '11px',
                                        fontWeight: 500,
                                        background: 'rgba(255,255,255,0.15)',
                                        color: theme.color,
                                        border: '1px solid rgba(255,255,255,0.2)',
                                    } }>{ t }</span>
                                ) ) }
                            </div>
                        ) }
                        <span style={ {
                            display: 'inline-block',
                            background: theme.accentColor,
                            color: '#fff',
                            padding: '8px 20px',
                            borderRadius: '999px',
                            fontSize: '13px',
                            fontWeight: 600,
                            marginTop: '8px',
                        } }>{ ctaLabel } →</span>
                    </div>

                    {/* Right column */}
                    <div style={ { display: 'flex', flexDirection: 'column', gap: '10px' } }>
                        { founderImageUrl && (
                            <img src={ founderImageUrl } alt={ founderImageAlt }
                                 style={ { width: '100%', borderRadius: '12px', maxHeight: '160px', objectFit: 'cover', objectPosition: 'top' } } />
                        ) }
                        { exteriorImageUrl && (
                            <img src={ exteriorImageUrl } alt={ exteriorImageAlt }
                                 style={ { width: '100%', borderRadius: '12px', maxHeight: '120px', objectFit: 'cover' } } />
                        ) }
                        { reasons && (
                            <div style={ { background: 'rgba(255,255,255,0.1)', borderRadius: '12px', padding: '14px' } }>
                                <div style={ labelStyle }>Why Patients Choose Us</div>
                                { reasons.split('\n').filter(Boolean).map( ( r, i ) => (
                                    <div key={ i } style={ { display: 'flex', gap: '8px', alignItems: 'flex-start', marginTop: '8px', fontSize: '12px', opacity: 0.8 } }>
                                        <span style={ { color: theme.accentColor, fontWeight: 700 } }>✓</span> { r }
                                    </div>
                                ) ) }
                            </div>
                        ) }
                    </div>
                </div>
                <p style={ { opacity: 0.35, fontSize: '10px', marginTop: '10px', marginBottom: 0 } }>
                    ZG About / Team — edit all fields in the Settings panel →
                </p>
            </div>
        </>
    );
}
