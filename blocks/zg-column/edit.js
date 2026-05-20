import { useBlockProps, InnerBlocks, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl, ToggleControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { buildClasses } from './utils';

export default function Edit( { attributes, setAttributes } ) {
    const { padding, background, rounded, bordered, shadow } = attributes;

    const blockProps = useBlockProps( {
        className: buildClasses( { padding, background, rounded, bordered, shadow } ),
        style: { minHeight: '60px' },
    } );

    return (
        <>
            <InspectorControls>
                <PanelBody title={ __( 'Layout', 'zerogravitynky' ) } initialOpen>
                    <SelectControl
                        label={ __( 'Padding', 'zerogravitynky' ) }
                        value={ padding }
                        options={ [
                            { label: 'None',   value: 'none' },
                            { label: 'Small',  value: 'sm'   },
                            { label: 'Medium', value: 'md'   },
                            { label: 'Large',  value: 'lg'   },
                        ] }
                        onChange={ ( val ) => setAttributes( { padding: val } ) }
                    />
                    <SelectControl
                        label={ __( 'Background', 'zerogravitynky' ) }
                        value={ background }
                        options={ [
                            { label: 'None',        value: 'none'     },
                            { label: 'White',       value: 'white'    },
                            { label: 'Sand',        value: 'sand'     },
                            { label: 'Dark',        value: 'dark'     },
                            { label: 'Sage',        value: 'sage'     },
                        ] }
                        onChange={ ( val ) => setAttributes( { background: val } ) }
                    />
                </PanelBody>
                <PanelBody title={ __( 'Style', 'zerogravitynky' ) } initialOpen={ false }>
                    <ToggleControl
                        label={ __( 'Rounded corners', 'zerogravitynky' ) }
                        checked={ rounded }
                        onChange={ ( val ) => setAttributes( { rounded: val } ) }
                    />
                    <ToggleControl
                        label={ __( 'Border', 'zerogravitynky' ) }
                        checked={ bordered }
                        onChange={ ( val ) => setAttributes( { bordered: val } ) }
                    />
                    <ToggleControl
                        label={ __( 'Shadow', 'zerogravitynky' ) }
                        checked={ shadow }
                        onChange={ ( val ) => setAttributes( { shadow: val } ) }
                    />
                </PanelBody>
            </InspectorControls>

            <div { ...blockProps }>
                <InnerBlocks />
            </div>
        </>
    );
}
