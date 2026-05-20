import { useBlockProps, InnerBlocks } from '@wordpress/block-editor';
import { buildClasses } from './utils';

// Current save: only inner content is stored.
// The outer wrapper is server-rendered by render.php.
export default function Save() {
    return <InnerBlocks.Content />;
}

// v1 — saved a static wrapper div with BEM/Tailwind classes.
// Kept here so WordPress can migrate existing blocks without showing
// a validation error in the editor.
export const deprecated = [
    {
        attributes: {
            padding:    { type: 'string',  default: 'md'   },
            background: { type: 'string',  default: 'none' },
            rounded:    { type: 'boolean', default: true   },
            bordered:   { type: 'boolean', default: false  },
            shadow:     { type: 'boolean', default: false  },
        },
        save( { attributes } ) {
            const { padding, background, rounded, bordered, shadow } = attributes;
            const blockProps = useBlockProps.save( {
                className: buildClasses( { padding, background, rounded, bordered, shadow } ),
            } );
            return (
                <div { ...blockProps }>
                    <InnerBlocks.Content />
                </div>
            );
        },
    },
];
