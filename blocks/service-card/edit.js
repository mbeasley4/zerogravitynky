import { useBlockProps } from '@wordpress/block-editor';
import { Placeholder } from '@wordpress/components';

export default function Edit() {
    const blockProps = useBlockProps( {
        style: {
            background: 'linear-gradient(135deg, #3D4A3E 0%, #7A8F7B 50%, #94A995 100%)',
            padding: '2rem',
            borderRadius: '4px',
        },
    } );
    return (
        <div { ...blockProps }>
            <Placeholder
                icon="layout"
                label="ZG Service Card"
                instructions="This block is rendered via the page template. Preview on the front end."
                style={ { background: 'rgba(255,255,255,0.08)', color: '#fff', borderRadius: '8px' } }
            />
        </div>
    );
}
