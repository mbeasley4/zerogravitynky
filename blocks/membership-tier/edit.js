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

const CheckIcon = () => (
    <svg width="16" height="16" fill="none" stroke="#7A8F7B" strokeWidth="2" viewBox="0 0 24 24" style={ { flexShrink: 0 } }>
        <path strokeLinecap="round" strokeLinejoin="round" d="M5 13l4 4L19 7" />
    </svg>
);

function TierCard( { label, name, desc, variant } ) {
    const isVip      = variant === 'vip';
    const isFeatured = variant === 'featured';
    const borderColor = isVip ? '#B7AFA366' : isFeatured ? '#7A8F7B' : '#E8DED2';
    const labelColor  = isVip ? '#B7AFA3'   : '#7A8F7B';
    const bg          = isFeatured ? 'rgba(122,143,123,0.06)' : isVip ? 'linear-gradient(135deg, rgba(183,175,163,0.08), transparent)' : 'transparent';

    return (
        <div style={ { border: `2px solid ${ borderColor }`, borderRadius: '12px', padding: '16px', background: bg, position: 'relative' } }>
            { isFeatured && (
                <div style={ { position: 'absolute', top: '-10px', right: '16px', background: '#B7AFA3', color: '#fff', fontSize: '10px', fontWeight: 700, padding: '2px 10px', borderRadius: '999px', textTransform: 'uppercase', letterSpacing: '0.05em' } }>
                    Popular
                </div>
            ) }
            <div style={ { color: labelColor, fontSize: '10px', fontWeight: 700, textTransform: 'uppercase', letterSpacing: '0.1em', marginBottom: '4px' } }>
                { label || 'Tier Label' }
            </div>
            <div style={ { fontFamily: 'serif', fontSize: '1rem', fontWeight: 600, color: '#3D4A3E', marginBottom: '6px' } }>
                { name || 'Tier Name' }
            </div>
            <p style={ { color: 'rgba(81,81,81,0.7)', fontSize: '12px', lineHeight: 1.5, margin: 0 } }>
                { desc || 'Tier description…' }
            </p>
        </div>
    );
}

export default function Edit( { attributes, setAttributes } ) {
    const {
        sectionLabel, sectionTitle, sectionBody, perks,
        ctaLabel, ctaUrl,
        imageId, imageUrl, imageAlt,
        tier1Label, tier1Name, tier1Desc, tier1Badge,
        tier2Label, tier2Name, tier2Desc,
        bgColor,
    } = attributes;

    const BG_MAP = {
        white:    '#ffffff',
        lavender: '#E8DED2',
        purple:   '#7A8F7B',
        gold:     '#B7AFA3',
    };

    const blockProps = useBlockProps( {
        style: { background: BG_MAP[ bgColor ] || '#fff', padding: '2rem', borderRadius: '4px', border: '1px solid #e5e7eb' },
    } );

    const perkList = perks ? perks.split( '\n' ).filter( Boolean ) : [];

    return (
        <>
            <InspectorControls>
                {/* ── Section copy ────────────────────────── */}
                <PanelBody title={ __( 'Section Copy', 'zerogravitynky' ) } initialOpen={ true }>
                    <TextControl
                        label={ __( 'Badge Label', 'zerogravitynky' ) }
                        value={ sectionLabel }
                        onChange={ val => setAttributes( { sectionLabel: val } ) }
                    />
                    <TextControl
                        label={ __( 'Section Title', 'zerogravitynky' ) }
                        value={ sectionTitle }
                        onChange={ val => setAttributes( { sectionTitle: val } ) }
                    />
                    <TextareaControl
                        label={ __( 'Body Paragraph', 'zerogravitynky' ) }
                        value={ sectionBody }
                        onChange={ val => setAttributes( { sectionBody: val } ) }
                        rows={ 4 }
                    />
                    <TextareaControl
                        label={ __( 'Perks List (one per line)', 'zerogravitynky' ) }
                        value={ perks }
                        onChange={ val => setAttributes( { perks: val } ) }
                        rows={ 5 }
                        help={ __( 'Each line becomes a checkmark bullet.', 'zerogravitynky' ) }
                    />
                </PanelBody>

                {/* ── CTA ─────────────────────────────────── */}
                <PanelBody title={ __( 'CTA Button', 'zerogravitynky' ) } initialOpen={ false }>
                    <TextControl
                        label={ __( 'Label', 'zerogravitynky' ) }
                        value={ ctaLabel }
                        onChange={ val => setAttributes( { ctaLabel: val } ) }
                    />
                    <TextControl
                        label={ __( 'URL', 'zerogravitynky' ) }
                        value={ ctaUrl }
                        onChange={ val => setAttributes( { ctaUrl: val } ) }
                    />
                </PanelBody>

                {/* ── Image ───────────────────────────────── */}
                <PanelBody title={ __( 'Section Image', 'zerogravitynky' ) } initialOpen={ false }>
                    <MediaUploadCheck>
                        <MediaUpload
                            onSelect={ media => setAttributes( { imageId: media.id, imageUrl: media.url, imageAlt: media.alt || media.title } ) }
                            allowedTypes={ [ 'image' ] }
                            value={ imageId }
                            render={ ( { open } ) => (
                                <div>
                                    { imageUrl && (
                                        <img src={ imageUrl } alt={ imageAlt }
                                             style={ { width: '100%', marginBottom: '8px', borderRadius: '8px', maxHeight: '100px', objectFit: 'cover' } } />
                                    ) }
                                    <Button onClick={ open } variant="secondary" style={ { width: '100%' } }>
                                        { imageUrl ? __( 'Change Image', 'zerogravitynky' ) : __( 'Upload / Select Image', 'zerogravitynky' ) }
                                    </Button>
                                    { imageUrl && (
                                        <Button onClick={ () => setAttributes( { imageId: 0, imageUrl: '', imageAlt: '' } ) }
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


                {/* ── Background Color ────────────────────── */}
                <PanelBody title={ __( 'Background Color', 'zerogravitynky' ) } initialOpen={ false }>
                    <SelectControl
                        label={ __( 'Section Background', 'zerogravitynky' ) }
                        value={ bgColor }
                        options={ [
                            { label: 'White',       value: 'white' },
                            { label: 'Beige / Sand', value: 'lavender' },
                            { label: 'Sage',         value: 'purple' },
                            { label: 'Taupe',        value: 'gold' },
                        ] }
                        onChange={ val => setAttributes( { bgColor: val } ) }
                    />
                </PanelBody>

                {/* ── Tier 1 (featured) ───────────────────── */}
                <PanelBody title={ __( 'Tier 1 (Featured / Popular)', 'zerogravitynky' ) } initialOpen={ false }>
                    <TextControl
                        label={ __( 'Category Label', 'zerogravitynky' ) }
                        value={ tier1Label }
                        onChange={ val => setAttributes( { tier1Label: val } ) }
                    />
                    <TextControl
                        label={ __( 'Tier Name', 'zerogravitynky' ) }
                        value={ tier1Name }
                        onChange={ val => setAttributes( { tier1Name: val } ) }
                    />
                    <TextareaControl
                        label={ __( 'Description', 'zerogravitynky' ) }
                        value={ tier1Desc }
                        onChange={ val => setAttributes( { tier1Desc: val } ) }
                        rows={ 3 }
                    />
                    <TextControl
                        label={ __( 'Badge Text (leave blank to hide)', 'zerogravitynky' ) }
                        value={ tier1Badge }
                        onChange={ val => setAttributes( { tier1Badge: val } ) }
                    />
                </PanelBody>

                {/* ── Tier 3 (VIP) ────────────────────────── */}
                <PanelBody title={ __( 'Tier 2 (VIP / Gold)', 'zerogravitynky' ) } initialOpen={ false }>
                    <TextControl
                        label={ __( 'Category Label', 'zerogravitynky' ) }
                        value={ tier2Label }
                        onChange={ val => setAttributes( { tier2Label: val } ) }
                    />
                    <TextControl
                        label={ __( 'Tier Name', 'zerogravitynky' ) }
                        value={ tier2Name }
                        onChange={ val => setAttributes( { tier2Name: val } ) }
                    />
                    <TextareaControl
                        label={ __( 'Description', 'zerogravitynky' ) }
                        value={ tier2Desc }
                        onChange={ val => setAttributes( { tier2Desc: val } ) }
                        rows={ 3 }
                    />
                </PanelBody>
            </InspectorControls>

            {/* ── Editor preview ─────────────────────────────────────── */}
            <div { ...blockProps }>
                <div style={ { display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '2rem', alignItems: 'start' } }>

                    {/* Left: copy */}
                    <div>
                        <div style={ { color: '#7A8F7B', fontSize: '11px', fontWeight: 700, textTransform: 'uppercase', letterSpacing: '0.12em', display: 'flex', alignItems: 'center', gap: '8px', marginBottom: '10px' } }>
                            <span style={ { width: '28px', height: '1px', background: '#7A8F7B', display: 'inline-block' } }></span>
                            { sectionLabel }
                        </div>
                        <h2 style={ { fontFamily: 'serif', fontSize: '1.6rem', fontWeight: 700, color: '#3D4A3E', margin: '0 0 10px', lineHeight: 1.3 } }>
                            { sectionTitle }
                        </h2>
                        { sectionBody && (
                            <p style={ { color: 'rgba(81,81,81,0.7)', fontSize: '13px', lineHeight: 1.6, marginBottom: '12px' } }>
                                { sectionBody }
                            </p>
                        ) }
                        { perkList.length > 0 && (
                            <ul style={ { listStyle: 'none', padding: 0, margin: '0 0 14px', display: 'flex', flexDirection: 'column', gap: '8px' } }>
                                { perkList.map( ( p, i ) => (
                                    <li key={ i } style={ { display: 'flex', alignItems: 'center', gap: '8px', color: '#515151', fontSize: '12px' } }>
                                        <CheckIcon /> { p }
                                    </li>
                                ) ) }
                            </ul>
                        ) }
                        { ctaLabel && (
                            <span style={ { display: 'inline-flex', alignItems: 'center', gap: '6px', padding: '10px 22px', background: '#7A8F7B', color: '#fff', borderRadius: '9999px', fontWeight: 600, fontSize: '13px' } }>
                                { ctaLabel } →
                            </span>
                        ) }
                    </div>

                    {/* Right: image + tier cards */}
                    <div style={ { display: 'flex', flexDirection: 'column', gap: '10px' } }>
                        { imageUrl && (
                            <img src={ imageUrl } alt={ imageAlt }
                                 style={ { width: '100%', borderRadius: '10px', maxHeight: '120px', objectFit: 'cover', objectPosition: 'center top' } } />
                        ) }
                        <TierCard label={ tier1Label } name={ tier1Name } desc={ tier1Desc } variant="featured" />
                        <TierCard label={ tier2Label } name={ tier2Name } desc={ tier2Desc } variant="vip" />
                    </div>
                </div>
            </div>
        </>
    );
}
