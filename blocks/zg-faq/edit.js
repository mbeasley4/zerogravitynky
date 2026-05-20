import { InspectorControls, MediaUpload, MediaUploadCheck, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, TextareaControl, Button } from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
    const { sectionTitle, faqs } = attributes;

    const blockProps = useBlockProps( {
        style: {
            background: '#E8DED2',
            padding: '3rem 2rem',
            borderRadius: '4px',
        },
    } );

    function updateFaq( index, field, value ) {
        const updated = faqs.map( ( item, i ) =>
            i === index ? { ...item, [ field ]: value } : item
        );
        setAttributes( { faqs: updated } );
    }

    function addFaq() {
        setAttributes( { faqs: [ ...faqs, { question: '', answer: '', imageId: 0, imageUrl: '' } ] } );
    }

    function removeFaq( index ) {
        setAttributes( { faqs: faqs.filter( ( _, i ) => i !== index ) } );
    }

    return (
        <>
            <InspectorControls>
                <PanelBody title="Section Settings" initialOpen={ true }>
                    <TextControl
                        label="Section Title"
                        value={ sectionTitle }
                        onChange={ ( value ) => setAttributes( { sectionTitle: value } ) }
                    />
                </PanelBody>

                <PanelBody title="FAQ Items" initialOpen={ true }>
                    { faqs.map( ( faq, index ) => (
                        <div key={ index } style={ { marginBottom: '1.5rem', padding: '1rem', background: 'rgba(122,143,123,0.08)', borderRadius: '6px' } }>
                            <p style={ { fontWeight: 600, marginBottom: '0.5rem', color: '#3D4A3E' } }>
                                FAQ { index + 1 }
                            </p>
                            <TextControl
                                label="Question"
                                value={ faq.question }
                                onChange={ ( value ) => updateFaq( index, 'question', value ) }
                            />
                            <TextareaControl
                                label="Answer"
                                value={ faq.answer }
                                onChange={ ( value ) => updateFaq( index, 'answer', value ) }
                                rows={ 50 }
                            />

                            <p style={ { fontWeight: 600, fontSize: '0.75rem', textTransform: 'uppercase', letterSpacing: '0.05em', color: '#3D4A3E', marginBottom: '0.5rem' } }>
                                Answer Image (optional)
                            </p>
                            { faq.imageUrl && (
                                <img
                                    src={ faq.imageUrl }
                                    alt=""
                                    style={ { width: '100%', height: '100px', objectFit: 'cover', borderRadius: '4px', marginBottom: '0.5rem' } }
                                />
                            ) }
                            <MediaUploadCheck>
                                <MediaUpload
                                    onSelect={ ( media ) => {
                                        updateFaq( index, 'imageId', media.id );
                                        updateFaq( index, 'imageUrl', media.url );
                                    } }
                                    allowedTypes={ [ 'image' ] }
                                    value={ faq.imageId || 0 }
                                    render={ ( { open } ) => (
                                        <Button
                                            variant="secondary"
                                            onClick={ open }
                                            style={ { marginBottom: '0.25rem', width: '100%' } }
                                        >
                                            { faq.imageUrl ? 'Replace Image' : 'Select Image' }
                                        </Button>
                                    ) }
                                />
                            </MediaUploadCheck>
                            { faq.imageUrl && (
                                <Button
                                    variant="tertiary"
                                    onClick={ () => {
                                        updateFaq( index, 'imageId', 0 );
                                        updateFaq( index, 'imageUrl', '' );
                                    } }
                                    style={ { color: '#cc1818', marginBottom: '0.5rem' } }
                                >
                                    Remove Image
                                </Button>
                            ) }

                            <Button
                                isDestructive
                                variant="tertiary"
                                onClick={ () => removeFaq( index ) }
                                style={ { marginTop: '0.25rem' } }
                            >
                                Remove FAQ
                            </Button>
                        </div>
                    ) ) }
                    <Button variant="secondary" onClick={ addFaq }>
                        + Add FAQ
                    </Button>
                </PanelBody>
            </InspectorControls>

            <div { ...blockProps }>
                { /* Section heading area */ }
                <div style={ { textAlign: 'center', marginBottom: '2rem' } }>
                    <p style={ {
                        fontSize: '11px', fontWeight: 700, letterSpacing: '0.12em',
                        textTransform: 'uppercase', color: '#7A8F7B', margin: '0 0 0.5rem',
                    } }>
                        QUESTIONS &amp; ANSWERS
                    </p>
                    <h2 style={ {
                        fontFamily: '"Fraunces", Georgia, serif', fontWeight: 700,
                        fontSize: '1.75rem', color: '#3D4A3E', margin: 0,
                    } }>
                        { sectionTitle || 'Frequently Asked Questions' }
                    </h2>
                </div>

                { /* FAQ accordion cards */ }
                <div style={ { display: 'flex', flexDirection: 'column', gap: '10px', maxWidth: '760px', margin: '0 auto' } }>
                    { faqs.map( ( faq, index ) => (
                        <div key={ index } style={ {
                            background: '#ffffff',
                            borderRadius: '16px',
                            padding: '16px 20px',
                            border: '1px solid rgba(61,74,62,0.10)',
                            boxShadow: '0 1px 3px rgba(0,0,0,0.06)',
                        } }>
                            <div style={ { display: 'flex', alignItems: 'center', justifyContent: 'space-between', gap: '12px' } }>
                                <p style={ {
                                    fontFamily: '"Fraunces", Georgia, serif',
                                    fontWeight: 600, fontSize: '16px',
                                    color: '#3D4A3E', margin: 0, flex: 1,
                                } }>
                                    { faq.question || <span style={ { color: '#aaa', fontStyle: 'italic' } }>Question text…</span> }
                                </p>
                                <span style={ {
                                    display: 'inline-flex', alignItems: 'center', justifyContent: 'center',
                                    width: '28px', height: '28px', borderRadius: '50%', flexShrink: 0,
                                    background: 'rgba(122,143,123,0.15)', color: '#7A8F7B',
                                    fontSize: '18px', lineHeight: 1, fontWeight: 400,
                                } }>
                                    +
                                </span>
                            </div>
                            { faq.answer && (
                                <p style={ {
                                    color: '#515151', fontSize: '14px', lineHeight: 1.65,
                                    margin: '10px 0 0', overflow: 'hidden',
                                    display: '-webkit-box', WebkitLineClamp: 2, WebkitBoxOrient: 'vertical',
                                } }>
                                    { faq.answer }
                                </p>
                            ) }
                        </div>
                    ) ) }
                    { faqs.length === 0 && (
                        <div style={ {
                            background: '#ffffff', borderRadius: '16px', padding: '16px 20px',
                            border: '1px solid rgba(61,74,62,0.10)', color: '#aaa',
                            fontSize: '14px', fontStyle: 'italic', textAlign: 'center',
                        } }>
                            Add FAQ items in the sidebar panel.
                        </div>
                    ) }
                </div>
            </div>
        </>
    );
}
