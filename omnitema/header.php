<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @package OmniTema
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'omnitema' ); ?></a>

    <?php 
    // Check if Elementor header template exists
    if (omnitema_is_elementor_active() && omnitema_is_elementor_pro_active()) {
        if (function_exists('elementor_theme_do_location') && elementor_theme_do_location('header')) {
            // Elementor header template will be displayed
        } else {
            // If no Elementor header template, use the default header
            get_template_part('template-parts/header/base');
        }
    } else {
        // Use the default header
        get_template_part('template-parts/header/base');
    }
    ?>

    <div id="content" class="site-content">
