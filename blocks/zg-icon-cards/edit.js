import { useState } from '@wordpress/element';
import {
    InspectorControls,
    useBlockProps,
    MediaUpload,
    MediaUploadCheck,
    RichText,
    BlockControls,
    AlignmentControl,
} from '@wordpress/block-editor';
import { PanelBody, TextControl, RangeControl, Button } from '@wordpress/components';

const SparkleIcon = () => (
    <svg width="24" height="24" fill="none" stroke="#7A8F7B" strokeWidth="1.5" viewBox="0 0 24 24" aria-hidden="true">
        <path strokeLinecap="round" strokeLinejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z" />
    </svg>
);

export default function Edit( { attributes, setAttributes } ) {
    const { sectionHeadline, sectionContent, sectionContentAlign, columnCount, cards } = attributes;

    // Tracks which RichText is active so the toolbar AlignmentControl knows what to target.
    // 'section' = intro text; 'card-N' = card N content.
    const [ activeField, setActiveField ] = useState( 'section' );

    const updateCard = ( i, field, value ) =>
        setAttributes( {
            cards: cards.map( ( card, idx ) => idx === i ? { ...card, [ field ]: value } : card ),
        } );

    const activeAlignValue = () => {
        if ( activeField === 'section' ) return sectionContentAlign || 'center';
        const idx = parseInt( activeField.replace( 'card-', '' ), 10 );
        return cards[ idx ]?.align || '';
    };

    const handleAlignChange = ( value ) => {
        if ( activeField === 'section' ) {
            setAttributes( { sectionContentAlign: value || 'center' } );
        } else {
            const idx = parseInt( activeField.replace( 'card-', '' ), 10 );
            updateCard( idx, 'align', value || '' );
        }
    };

    const activeCards = cards.slice( 0, columnCount );

    const blockProps = useBlockProps( {
        style: { background: '#ffffff', padding: '64px 24px', borderRadius: '4px' },
    } );

    return (
        <>
            <BlockControls group="block">
                <AlignmentControl
                    value={ activeAlignValue() }
                    onChange={ handleAlignChange }
                />
            </BlockControls>

            <InspectorControls>
                <PanelBody title="Layout" initialOpen={ true }>
                    <RangeControl
                        label="Number of Cards"
                        value={ columnCount }
                        onChange={ ( value ) => setAttributes( { columnCount: value } ) }
                        min={ 2 }
                        max={ 4 }
                    />
                </PanelBody>

                <PanelBody title="Section" initialOpen={ true }>
                    <TextControl
                        label="Headline"
                        value={ sectionHeadline }
                        onChange={ ( val ) => setAttributes( { sectionHeadline: val } ) }
                    />
                    <p style={ { fontSize: '12px', color: '#757575', marginTop: 0 } }>
                        Edit intro text and alignment directly on the canvas.
                    </p>
                </PanelBody>

                { activeCards.map( ( card, i ) => (
                    <PanelBody key={ i } title={ `Card ${ i + 1 }` } initialOpen={ false }>
                        <p style={ { fontSize: '11px', fontWeight: 600, textTransform: 'uppercase', letterSpacing: '0.05em', marginBottom: '6px', color: '#555' } }>
                            Icon Image
                        </p>
                        { card.iconUrl && (
                            <img
                                src={ card.iconUrl }
                                alt={ card.iconAlt }
                                style={ { width: '48px', height: '48px', objectFit: 'cover', borderRadius: '8px', marginBottom: '6px' } }
                            />
                        ) }
                        <MediaUploadCheck>
                            <MediaUpload
                                onSelect={ ( media ) => setAttributes( {
                                    cards: cards.map( ( c, idx ) => idx === i
                                        ? { ...c, iconId: media.id, iconUrl: media.url, iconAlt: media.alt || media.title }
                                        : c
                                    ),
                                } ) }
                                allowedTypes={ [ 'image' ] }
                                value={ card.iconId }
                                render={ ( { open } ) => (
                                    <Button variant="secondary" onClick={ open } style={ { marginBottom: '12px' } }>
                                        { card.iconId ? 'Replace Icon' : 'Select Icon' }
                                    </Button>
                                ) }
                            />
                        </MediaUploadCheck>
                        <TextControl
                            label="Headline"
                            value={ card.headline }
                            onChange={ ( val ) => updateCard( i, 'headline', val ) }
                        />
                        <p style={ { fontSize: '12px', color: '#757575', marginTop: 0 } }>
                            Edit card content and alignment directly on the canvas.
                        </p>
                        <TextControl
                            label="Button Label (optional)"
                            value={ card.ctaLabel }
                            onChange={ ( val ) => updateCard( i, 'ctaLabel', val ) }
                        />
                        { card.ctaLabel && (
                            <TextControl
                                label="Button URL"
                                value={ card.ctaUrl }
                                onChange={ ( val ) => updateCard( i, 'ctaUrl', val ) }
                            />
                        ) }
                    </PanelBody>
                ) ) }
            </InspectorControls>

            <div { ...blockProps }>

                { /* Section header */ }
                <div style={ { textAlign: sectionContentAlign || 'center', maxWidth: '720px', margin: '0 auto 48px' } }>
                    { sectionHeadline && (
                        <h2 style={ {
                            fontFamily: '"Fraunces", Georgia, serif', fontWeight: 700,
                            fontSize: '2.25rem', color: '#3D4A3E',
                            margin: '0 0 16px', lineHeight: 1.2,
                        } }>
                            { sectionHeadline }
                        </h2>
                    ) }
                    <RichText
                        tagName="p"
                        value={ sectionContent }
                        onChange={ ( val ) => setAttributes( { sectionContent: val } ) }
                        onFocus={ () => setActiveField( 'section' ) }
                        placeholder="Add intro text…"
                        style={ { color: '#6B7A6C', fontSize: '1rem', lineHeight: 1.75, margin: 0 } }
                    />
                </div>

                { /* Card grid */ }
                <div style={ {
                    display: 'grid',
                    gridTemplateColumns: `repeat(${ columnCount }, 1fr)`,
                    gap: '20px',
                    maxWidth: '1100px',
                    margin: '0 auto',
                } }>
                    { activeCards.map( ( card, i ) => (
                        <div key={ i } style={ {
                            background: '#ffffff',
                            borderRadius: '20px',
                            padding: '32px 28px',
                            boxShadow: '0 2px 20px rgba(61,74,62,0.07)',
                            border: '1px solid rgba(61,74,62,0.08)',
                            display: 'flex',
                            flexDirection: 'column',
                        } }>

                            { /* Icon */ }
                            <div style={ {
                                width: '52px', height: '52px', borderRadius: '14px',
                                background: 'rgba(122,143,123,0.12)',
                                display: 'flex', alignItems: 'center', justifyContent: 'center',
                                marginBottom: '20px', flexShrink: 0,
                            } }>
                                { card.iconUrl
                                    ? <img src={ card.iconUrl } alt={ card.iconAlt } style={ { width: '28px', height: '28px', objectFit: 'contain' } } />
                                    : <SparkleIcon />
                                }
                            </div>

                            { /* Headline */ }
                            <h3 style={ {
                                fontFamily: '"Fraunces", Georgia, serif', fontWeight: 700,
                                fontSize: '1.125rem', color: '#3D4A3E',
                                margin: '0 0 10px', lineHeight: 1.3,
                            } }>
                                { card.headline || 'Card Title' }
                            </h3>

                            { /* Content — RichText with alignment */ }
                            <RichText
                                tagName="div"
                                value={ card.content }
                                onChange={ ( val ) => updateCard( i, 'content', val ) }
                                onFocus={ () => setActiveField( `card-${ i }` ) }
                                placeholder="Card description…"
                                style={ {
                                    fontSize: '0.875rem', color: '#6B7A6C', lineHeight: 1.7,
                                    margin: card.ctaLabel ? '0 0 20px' : '0', flexGrow: 1,
                                    textAlign: card.align || 'left',
                                } }
                            />

                            { /* CTA button */ }
                            { card.ctaLabel && (
                                <span style={ {
                                    display: 'inline-flex', alignItems: 'center',
                                    padding: '0.5rem 1.25rem',
                                    background: '#7A8F7B', color: '#ffffff',
                                    borderRadius: '9999px', fontWeight: 600, fontSize: '0.8125rem',
                                    alignSelf: 'flex-start',
                                } }>
                                    { card.ctaLabel }
                                </span>
                            ) }
                        </div>
                    ) ) }
                </div>

            </div>
        </>
    );
}
