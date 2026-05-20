import { __ } from '@wordpress/i18n';
import {
    useBlockProps,
    RichText,
    InspectorControls,
    MediaUpload,
    MediaUploadCheck,
} from '@wordpress/block-editor';
import { PanelBody, TextControl, Button } from '@wordpress/components';

const MapPinIcon = () => (
    <svg width="22" height="22" fill="none" stroke="#7A8F7B" strokeWidth="1.5" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
        <path strokeLinecap="round" strokeLinejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-9.5 11.25S1.5 17.642 1.5 10.5a8.5 8.5 0 0117 0z"/>
    </svg>
);

const ClockIcon = () => (
    <svg width="22" height="22" fill="none" stroke="#7A8F7B" strokeWidth="1.5" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
);

const PhoneIcon = () => (
    <svg width="22" height="22" fill="none" stroke="#7A8F7B" strokeWidth="1.5" viewBox="0 0 24 24">
        <path strokeLinecap="round" strokeLinejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
    </svg>
);

const hoursRows = [
    { label: 'Mon – Thu', value: '10:00 am – 7:00 pm' },
    { label: 'Friday',    value: '10:00 am – 6:00 pm' },
    { label: 'Saturday',  value: '10:00 am – 5:00 pm' },
    { label: 'Sunday',    value: 'Closed' },
];

export default function Edit({ attributes, setAttributes }) {
    const {
        sectionTitle,
        locationTitle,
        address,
        phone,
        mapImageId,
        mapImageUrl,
        mapImageAlt,
        mapImageLink,
        exteriorImageId,
        exteriorImageUrl,
        exteriorImageAlt,
        exteriorImageLink,
    } = attributes;

    const blockProps = useBlockProps({
        style: { background: '#ffffff', padding: '48px 24px', borderRadius: '4px' },
    });

    const iconCircle = {
        display: 'flex', alignItems: 'center', justifyContent: 'center',
        width: '44px', height: '44px', borderRadius: '50%',
        background: 'rgba(122,143,123,0.12)', marginBottom: '12px', flexShrink: 0,
    };

    const cardBase = {
        background: '#E8DED2', borderRadius: '16px', padding: '28px',
    };

    const h3Style = {
        fontFamily: '"Fraunces", Georgia, serif', fontWeight: 700,
        fontSize: '1.1rem', color: '#3D4A3E', margin: '0 0 10px',
    };

    return (
        <>
            <InspectorControls>
                <PanelBody title={ __( 'Contact Settings', 'zerogravitynky' ) } initialOpen={ true }>
                    <TextControl
                        label={ __( 'Section Title', 'zerogravitynky' ) }
                        value={ sectionTitle }
                        onChange={ ( val ) => setAttributes( { sectionTitle: val } ) }
                    />
                    <TextControl
                        label={ __( 'Location Title', 'zerogravitynky' ) }
                        value={ locationTitle }
                        onChange={ ( val ) => setAttributes( { locationTitle: val } ) }
                    />
                    <TextControl
                        label={ __( 'Address', 'zerogravitynky' ) }
                        value={ address }
                        onChange={ ( val ) => setAttributes( { address: val } ) }
                    />
                    <TextControl
                        label={ __( 'Phone', 'zerogravitynky' ) }
                        value={ phone }
                        onChange={ ( val ) => setAttributes( { phone: val } ) }
                    />
                </PanelBody>

                <PanelBody title={ __( 'Images', 'zerogravitynky' ) } initialOpen={ true }>

                    <p style={ { fontSize: '11px', fontWeight: 600, textTransform: 'uppercase', letterSpacing: '0.05em', marginBottom: '6px' } }>
                        { __( 'Map Image', 'zerogravitynky' ) }
                    </p>
                    { mapImageUrl && (
                        <img
                            src={ mapImageUrl }
                            alt={ mapImageAlt }
                            style={ { width: '100%', height: '100px', objectFit: 'cover', borderRadius: '6px', marginBottom: '6px' } }
                        />
                    ) }
                    <MediaUploadCheck>
                        <MediaUpload
                            onSelect={ ( media ) => setAttributes( {
                                mapImageId:  media.id,
                                mapImageUrl: media.url,
                                mapImageAlt: media.alt || media.title,
                            } ) }
                            allowedTypes={ [ 'image' ] }
                            value={ mapImageId }
                            render={ ( { open } ) => (
                                <Button variant="secondary" onClick={ open } style={ { marginBottom: '16px' } }>
                                    { mapImageId
                                        ? __( 'Replace Map Image', 'zerogravitynky' )
                                        : __( 'Select Map Image', 'zerogravitynky' ) }
                                </Button>
                            ) }
                        />
                    </MediaUploadCheck>
                    <TextControl
                        label={ __( 'Map Image Alt Text', 'zerogravitynky' ) }
                        value={ mapImageAlt }
                        onChange={ ( val ) => setAttributes( { mapImageAlt: val } ) }
                    />
                    <TextControl
                        label={ __( 'Map Image Link URL', 'zerogravitynky' ) }
                        value={ mapImageLink }
                        onChange={ ( val ) => setAttributes( { mapImageLink: val } ) }
                        help={ __( 'Opens in a new tab. Leave blank to disable.', 'zerogravitynky' ) }
                    />

                    <p style={ { fontSize: '11px', fontWeight: 600, textTransform: 'uppercase', letterSpacing: '0.05em', marginBottom: '6px', marginTop: '8px' } }>
                        { __( 'Exterior Image', 'zerogravitynky' ) }
                    </p>
                    { exteriorImageUrl && (
                        <img
                            src={ exteriorImageUrl }
                            alt={ exteriorImageAlt }
                            style={ { width: '100%', height: '100px', objectFit: 'cover', borderRadius: '6px', marginBottom: '6px' } }
                        />
                    ) }
                    <MediaUploadCheck>
                        <MediaUpload
                            onSelect={ ( media ) => setAttributes( {
                                exteriorImageId:  media.id,
                                exteriorImageUrl: media.url,
                                exteriorImageAlt: media.alt || media.title,
                            } ) }
                            allowedTypes={ [ 'image' ] }
                            value={ exteriorImageId }
                            render={ ( { open } ) => (
                                <Button variant="secondary" onClick={ open } style={ { marginBottom: '16px' } }>
                                    { exteriorImageId
                                        ? __( 'Replace Exterior Image', 'zerogravitynky' )
                                        : __( 'Select Exterior Image', 'zerogravitynky' ) }
                                </Button>
                            ) }
                        />
                    </MediaUploadCheck>
                    <TextControl
                        label={ __( 'Exterior Image Alt Text', 'zerogravitynky' ) }
                        value={ exteriorImageAlt }
                        onChange={ ( val ) => setAttributes( { exteriorImageAlt: val } ) }
                    />
                    <TextControl
                        label={ __( 'Exterior Image Link URL', 'zerogravitynky' ) }
                        value={ exteriorImageLink }
                        onChange={ ( val ) => setAttributes( { exteriorImageLink: val } ) }
                        help={ __( 'Opens in a new tab. Leave blank to disable.', 'zerogravitynky' ) }
                    />

                </PanelBody>
            </InspectorControls>

            <section { ...blockProps }>

                { /* Section heading */ }
                <div style={ { textAlign: 'center', marginBottom: '32px' } }>
                    <span style={ {
                        display: 'inline-block',
                        fontSize: '11px', fontWeight: 700, letterSpacing: '0.12em',
                        textTransform: 'uppercase', color: '#7A8F7B',
                        background: 'rgba(122,143,123,0.12)',
                        padding: '5px 16px', borderRadius: '9999px', marginBottom: '12px',
                    } }>
                        FIND US
                    </span>
                    <h2 style={ {
                        fontFamily: '"Fraunces", Georgia, serif', fontWeight: 700,
                        fontSize: '2rem', color: '#3D4A3E', margin: 0,
                    } }>
                        { sectionTitle || 'Visit Zero Gravity' }
                    </h2>
                </div>

                { /* 3 Column cards */ }
                <div style={ {
                    display: 'grid',
                    gridTemplateColumns: 'repeat(3, 1fr)',
                    gap: '16px',
                    marginBottom: '24px',
                } }>

                    { /* Location card */ }
                    <div style={ cardBase }>
                        <div style={ iconCircle }><MapPinIcon /></div>
                        <h3 style={ h3Style }>Location</h3>
                        <RichText
                            tagName="p"
                            value={ address }
                            onChange={ ( val ) => setAttributes( { address: val } ) }
                            placeholder="Address..."
                            style={ { fontSize: '14px', color: '#5a6b5b', lineHeight: 1.6, margin: 0 } }
                        />
                    </div>

                    { /* Hours card */ }
                    <div style={ cardBase }>
                        <div style={ iconCircle }><ClockIcon /></div>
                        <h3 style={ h3Style }>Hours</h3>
                        <div style={ { display: 'flex', flexDirection: 'column', gap: '4px' } }>
                            { hoursRows.map( ( row ) => (
                                <div key={ row.label } style={ { display: 'flex', justifyContent: 'space-between', fontSize: '13px', color: '#5a6b5b' } }>
                                    <span style={ { fontWeight: 500 } }>{ row.label }</span>
                                    <span>{ row.value }</span>
                                </div>
                            ) ) }
                        </div>
                        <p style={ { fontSize: '11px', color: '#aaa', fontStyle: 'italic', marginTop: '10px', marginBottom: 0 } }>
                            Managed in Site Settings → Hours
                        </p>
                    </div>

                    { /* Contact card */ }
                    <div style={ cardBase }>
                        <div style={ iconCircle }><PhoneIcon /></div>
                        <h3 style={ h3Style }>Contact</h3>
                        <RichText
                            tagName="p"
                            value={ phone }
                            onChange={ ( val ) => setAttributes( { phone: val } ) }
                            placeholder="Phone number..."
                            style={ { fontSize: '14px', color: '#7A8F7B', fontWeight: 500, margin: 0 } }
                        />
                    </div>

                </div>

                { /* Image previews */ }
                <div style={ {
                    display: 'grid',
                    gridTemplateColumns: '1fr 1fr',
                    gap: '16px',
                } }>
                    { mapImageUrl
                        ? <img src={ mapImageUrl } alt={ mapImageAlt } style={ { height: '220px', width: '100%', objectFit: 'cover', borderRadius: '16px' } } />
                        : <div style={ { height: '220px', borderRadius: '16px', background: '#eee', display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: '12px', color: '#666' } }>Map Image — select in sidebar</div>
                    }
                    { exteriorImageUrl
                        ? <img src={ exteriorImageUrl } alt={ exteriorImageAlt } style={ { height: '220px', width: '100%', objectFit: 'cover', borderRadius: '16px' } } />
                        : <div style={ { height: '220px', borderRadius: '16px', background: '#eee', display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: '12px', color: '#666' } }>Exterior Image — select in sidebar</div>
                    }
                </div>

            </section>
        </>
    );
}
