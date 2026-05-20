import { useState, useEffect } from '@wordpress/element';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, SelectControl, RangeControl, TextControl, RadioControl, Placeholder, Spinner } from '@wordpress/components';
import apiFetch from '@wordpress/api-fetch';

export default function Edit( { attributes, setAttributes } ) {
    const { categoryId, limit, heading, colorScheme } = attributes;
    const [ categories, setCategories ] = useState( [] );
    const [ loading, setLoading ]       = useState( true );

    useEffect( () => {
        apiFetch( {
            path: '/wp/v2/product_cat?per_page=100&orderby=name&order=asc&_fields=id,name,parent',
        } )
            .then( ( cats ) => {
                // Build flat list with child categories indented
                const roots    = cats.filter( ( c ) => ! c.parent );
                const children = cats.filter( ( c ) => c.parent );
                const ordered  = [];
                roots.forEach( ( r ) => {
                    ordered.push( { value: r.id, label: r.name } );
                    children
                        .filter( ( c ) => c.parent === r.id )
                        .forEach( ( c ) => ordered.push( { value: c.id, label: `  — ${ c.name }` } ) );
                } );
                setCategories( ordered );
                setLoading( false );
            } )
            .catch( () => setLoading( false ) );
    }, [] );

    const selectedLabel = categories.find( ( c ) => c.value === categoryId )?.label?.trim() || '';

    const blockProps = useBlockProps( {
        style: { background: '#E8DED2', padding: '2rem', borderRadius: '4px' },
    } );

    return (
        <>
            <InspectorControls>
                <PanelBody title="Category" initialOpen={ true }>
                    { loading ? (
                        <Spinner />
                    ) : (
                        <SelectControl
                            label="Product category"
                            value={ categoryId }
                            options={ [
                                { value: 0, label: '— Select a category —' },
                                ...categories,
                            ] }
                            onChange={ ( v ) => setAttributes( { categoryId: parseInt( v, 10 ) } ) }
                        />
                    ) }
                </PanelBody>
                <PanelBody title="Display" initialOpen={ false }>
                    <RangeControl
                        label="Number of products"
                        value={ limit }
                        onChange={ ( v ) => setAttributes( { limit: v } ) }
                        min={ 1 }
                        max={ 6 }
                    />
                    <TextControl
                        label="Section heading (optional)"
                        help="Overrides the category name as the section title."
                        value={ heading }
                        onChange={ ( v ) => setAttributes( { heading: v } ) }
                    />
                    <RadioControl
                        label="Background style"
                        selected={ colorScheme }
                        options={ [
                            { label: 'White',        value: 'white' },
                            { label: 'Beige / Sand', value: 'lavender' },
                            { label: 'Sage',         value: 'purple' },
                        ] }
                        onChange={ ( v ) => setAttributes( { colorScheme: v } ) }
                    />
                </PanelBody>
            </InspectorControls>

            <div { ...blockProps }>
                <Placeholder
                    icon="products"
                    label="ZG Category Products"
                    instructions={
                        categoryId
                            ? `Showing top ${ limit } seller${ limit !== 1 ? 's' : '' } from: ${ selectedLabel || `Category #${ categoryId }` }`
                            : 'Select a product category in the block settings →'
                    }
                    style={ { background: 'rgba(122,143,123,0.08)', borderRadius: '8px' } }
                />
            </div>
        </>
    );
}
