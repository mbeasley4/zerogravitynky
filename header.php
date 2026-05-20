<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php wp_head(); ?>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-58VL76ZXLF"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-58VL76ZXLF');
    </script>
        
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-PZSGTJG');</script>
    <!-- End Google Tag Manager -->

</head>
<body <?php body_class( 'font-sans bg-white text-brand-dark antialiased' ); ?>>
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PZSGTJG"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php wp_body_open(); ?>

<a class="skip-link" href="#main-content"><?php esc_html_e( 'Skip to main content', 'zerogravitynky' ); ?></a>

<?php get_template_part( 'template-parts/header/topbar' ); ?>
<?php get_template_part( 'template-parts/header/navbar' ); ?>
