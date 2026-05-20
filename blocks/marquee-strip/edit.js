import { __ } from '@wordpress/i18n';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, Button } from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
    const { items } = attributes;

    const addItem = () =>
        setAttributes( { items: [ ...items, 'New Item' ] } );

    const removeItem = ( i ) =>
        setAttributes( { items: items.filter( ( _, idx ) => idx !== i ) } );

    const updateItem = ( i, val ) =>
        setAttributes( { items: items.map( ( item, idx ) => ( idx === i ? val : item ) ) } );

    const blockProps = useBlockProps( {
        style: {
            background: '#E8DED2',
            padding: '12px 16px',
            borderRadius: '4px',
            overflow: 'hidden',
        },
    } );

    return (
        <>
            <InspectorControls>
                <PanelBody title={ __( 'Marquee Items', 'zerogravitynky' ) } initialOpen={ true }>
                    <p style={ { fontSize: '12px', color: '#555', marginBottom: '12px' } }>
                        { __( 'Add, edit, or remove items from the scrolling strip. Each item is separated by a ✦ divider.', 'zerogravitynky' ) }
                    </p>
                    { items.map( ( item, i ) => (
                        <div
                            key={ i }
                            style={ { display: 'flex', gap: '6px', alignItems: 'flex-start', marginBottom: '4px' } }
                        >
                            <div style={ { flex: 1 } }>
                                <TextControl
                                    value={ item }
                                    onChange={ val => updateItem( i, val ) }
                                    hideLabelFromVision
                                    label={ `Item ${ i + 1 }` }
                                />
                            </div>
                            <Button
                                icon="trash"
                                isDestructive
                                variant="tertiary"
                                onClick={ () => removeItem( i ) }
                                label={ __( 'Remove item', 'zerogravitynky' ) }
                                style={ { marginTop: '2px' } }
                            />
                        </div>
                    ) ) }
                    <Button
                        variant="secondary"
                        onClick={ addItem }
                        style={ { width: '100%', marginTop: '4px' } }
                    >
                        { __( '+ Add Item', 'zerogravitynky' ) }
                    </Button>
                </PanelBody>
            </InspectorControls>

            <div { ...blockProps }>
                <div style={ { display: 'flex', gap: '32px', alignItems: 'center', flexWrap: 'nowrap', overflow: 'hidden' } }>
                    { items.map( ( item, i ) => (
                        <span
                            key={ i }
                            style={ {
                                whiteSpace: 'nowrap',
                                color: i % 2 === 0 ? '#7A8F7B' : '#3D4A3E',
                                fontWeight: i % 2 === 0 ? 600 : 400,
                                fontSize: '14px',
                            } }
                        >
                            ✦ { item }
                        </span>
                    ) ) }
                </div>
                <p style={ { opacity: 0.4, fontSize: '11px', marginTop: '6px', marginBottom: 0 } }>
                    Marquee Strip — manage items in the Settings panel →
                </p>
            </div>
        </>
    );
}
