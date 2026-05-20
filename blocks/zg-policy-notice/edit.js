import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl } from '@wordpress/components';

function CardPreview( { title, items, headerBg } ) {
    const list = items ? items.split( '\n' ).filter( Boolean ) : [];
    return (
        <div style={ { background: '#fff', borderRadius: '12px', overflow: 'hidden', boxShadow: '0 1px 4px rgba(0,0,0,0.08)' } }>
            <div style={ { background: headerBg, padding: '12px 16px', display: 'flex', alignItems: 'center', gap: '8px' } }>
                <span style={ { color: '#fff', fontWeight: 700, fontSize: '13px' } }>{ title }</span>
            </div>
            <ul style={ { padding: '14px 16px', margin: 0, listStyle: 'none', display: 'flex', flexDirection: 'column', gap: '10px' } }>
                { list.map( ( item, i ) => (
                    <li key={ i } style={ { display: 'flex', alignItems: 'flex-start', gap: '8px', fontSize: '12px', color: '#515151', lineHeight: 1.5 } }>
                        <span style={ { color: headerBg, fontWeight: 700, flexShrink: 0, marginTop: '1px' } }>—</span>
                        { item }
                    </li>
                ) ) }
            </ul>
        </div>
    );
}

export default function Edit( { attributes, setAttributes } ) {
    const { sectionLabel, sectionTitle, card1Title, card1Items, card2Title, card2Items } = attributes;

    const blockProps = useBlockProps( {
        style: { background: '#E8DED2', padding: '2rem', borderRadius: '4px' },
    } );

    return (
        <>
            <InspectorControls>
                <PanelBody title={ __( 'Section Heading', 'zerogravitynky' ) } initialOpen={ true }>
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
                </PanelBody>

                <PanelBody title={ __( 'Cancellation Policy Card', 'zerogravitynky' ) } initialOpen={ true }>
                    <TextControl
                        label={ __( 'Card Title', 'zerogravitynky' ) }
                        value={ card1Title }
                        onChange={ val => setAttributes( { card1Title: val } ) }
                    />
                    <TextareaControl
                        label={ __( 'Policy Items (one per line)', 'zerogravitynky' ) }
                        value={ card1Items }
                        onChange={ val => setAttributes( { card1Items: val } ) }
                        rows={ 5 }
                        help={ __( 'Each line becomes a bullet. Dollar amounts are auto-highlighted.', 'zerogravitynky' ) }
                    />
                </PanelBody>

                <PanelBody title={ __( 'Consultation Policy Card', 'zerogravitynky' ) } initialOpen={ true }>
                    <TextControl
                        label={ __( 'Card Title', 'zerogravitynky' ) }
                        value={ card2Title }
                        onChange={ val => setAttributes( { card2Title: val } ) }
                    />
                    <TextareaControl
                        label={ __( 'Policy Items (one per line)', 'zerogravitynky' ) }
                        value={ card2Items }
                        onChange={ val => setAttributes( { card2Items: val } ) }
                        rows={ 5 }
                        help={ __( 'Each line becomes a bullet.', 'zerogravitynky' ) }
                    />
                </PanelBody>
            </InspectorControls>

            <div { ...blockProps }>
                {/* Section header */}
                <div style={ { textAlign: 'center', marginBottom: '1.5rem' } }>
                    <div style={ { color: '#7A8F7B', fontSize: '11px', fontWeight: 700, textTransform: 'uppercase', letterSpacing: '0.12em', display: 'flex', alignItems: 'center', justifyContent: 'center', gap: '8px', marginBottom: '8px' } }>
                        <span style={ { width: '28px', height: '1px', background: '#7A8F7B', display: 'inline-block' } }></span>
                        { sectionLabel }
                        <span style={ { width: '28px', height: '1px', background: '#7A8F7B', display: 'inline-block' } }></span>
                    </div>
                    <h2 style={ { fontFamily: 'serif', fontSize: '1.5rem', fontWeight: 700, color: '#3D4A3E', margin: 0 } }>
                        { sectionTitle }
                    </h2>
                </div>

                {/* Cards */}
                <div style={ { display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1.25rem' } }>
                    <CardPreview title={ card1Title } items={ card1Items } headerBg="#3D4A3E" />
                    <CardPreview title={ card2Title } items={ card2Items } headerBg="#7A8F7B" />
                </div>
            </div>
        </>
    );
}
