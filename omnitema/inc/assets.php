<?php
/**
 * Assets management for OmniTema
 *
 * @package OmniTema
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue scripts and styles for the front end.
 */
function omnitema_scripts() {
    // Main stylesheet
    wp_enqueue_style(
        'omnitema-style',
        get_stylesheet_uri(),
        array(),
        OMNITEMA_VERSION
    );

    // Main CSS
    wp_enqueue_style(
        'omnitema-main',
        OMNITEMA_URI . 'assets/css/main.css',
        array('omnitema-style'),
        OMNITEMA_VERSION
    );

    // WooCommerce styles (only if active)
    if (class_exists('WooCommerce')) {
        wp_enqueue_style(
            'omnitema-woocommerce',
            OMNITEMA_URI . 'assets/css/woocommerce.css',
            array('omnitema-main'),
            OMNITEMA_VERSION
        );
    }

    // Navigation JavaScript
    wp_enqueue_script(
        'omnitema-navigation',
        OMNITEMA_URI . 'assets/js/navigation.js',
        array(),
        OMNITEMA_VERSION,
        true
    );

    // Main JavaScript
    wp_enqueue_script(
        'omnitema-main',
        OMNITEMA_URI . 'assets/js/main.js',
        array('jquery'),
        OMNITEMA_VERSION,
        true
    );

    // AOS (Animate On Scroll) - Optional animation library
    $enable_animations = get_theme_mod('omnitema_enable_animations', true);
    if ($enable_animations) {
        wp_enqueue_style(
            'aos-css',
            'https://unpkg.com/aos@next/dist/aos.css',
            array(),
            '2.3.1'
        );
        
        wp_enqueue_script(
            'aos-js',
            'https://unpkg.com/aos@next/dist/aos.js',
            array(),
            '2.3.1',
            true
        );
        
        // Initialize AOS
        wp_add_inline_script('aos-js', 'AOS.init({
            offset: 120,
            delay: 0,
            duration: 800,
            easing: "ease-in-out",
            once: true,
        });');
    }

    // Lightbox - Optional for images and galleries
    $enable_lightbox = get_theme_mod('omnitema_enable_lightbox', true);
    if ($enable_lightbox) {
        wp_enqueue_style(
            'lightbox-css',
            'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css',
            array(),
            '2.11.3'
        );
        
        wp_enqueue_script(
            'lightbox-js',
            'https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js',
            array('jquery'),
            '2.11.3',
            true
        );
    }

    // Skip link focus
    wp_enqueue_script(
        'omnitema-skip-link-focus-fix',
        OMNITEMA_URI . 'assets/js/skip-link-focus-fix.js',
        array(),
        OMNITEMA_VERSION,
        true
    );

    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    // Localize script for passing variables to JavaScript
    wp_localize_script('omnitema-main', 'omnitemaSiteData', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'themeUrl' => OMNITEMA_URI,
        'siteUrl' => get_site_url(),
        'isElementorActive' => omnitema_is_elementor_active(),
        'isMobile' => wp_is_mobile(),
        'isRtl' => is_rtl(),
    ));
}
add_action('wp_enqueue_scripts', 'omnitema_scripts');

/**
 * Enqueue scripts and styles for the admin area.
 */
function omnitema_admin_scripts($hook) {
    // Only load on certain admin pages
    $screen = get_current_screen();
    
    // Admin CSS
    wp_enqueue_style(
        'omnitema-admin',
        OMNITEMA_URI . 'assets/css/admin.css',
        array(),
        OMNITEMA_VERSION
    );

    // Admin JavaScript
    wp_enqueue_script(
        'omnitema-admin',
        OMNITEMA_URI . 'assets/js/admin.js',
        array('jquery'),
        OMNITEMA_VERSION,
        true
    );

    // Localize admin script
    wp_localize_script('omnitema-admin', 'omnitemAdminData', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('omnitema_admin_nonce'),
        'themeUri' => OMNITEMA_URI,
    ));
}
add_action('admin_enqueue_scripts', 'omnitema_admin_scripts');

/**
 * Add preconnect for external resources.
 */
function omnitema_resource_hints($urls, $relation_type) {
    if ('preconnect' === $relation_type) {
        // Add preconnect for Google Fonts if used
        if (get_theme_mod('omnitema_use_google_fonts', true)) {
            $urls[] = array(
                'href' => 'https://fonts.gstatic.com',
                'crossorigin',
            );
        }
        
        // Add preconnect for CDNs
        if (get_theme_mod('omnitema_enable_lightbox', true)) {
            $urls[] = array(
                'href' => 'https://cdnjs.cloudflare.com',
                'crossorigin',
            );
        }
        
        if (get_theme_mod('omnitema_enable_animations', true)) {
            $urls[] = array(
                'href' => 'https://unpkg.com',
                'crossorigin',
            );
        }
    }
    
    return $urls;
}
add_filter('wp_resource_hints', 'omnitema_resource_hints', 10, 2);

/**
 * Add async/defer attributes to enqueued scripts where needed.
 */
function omnitema_script_loader_tag($tag, $handle, $src) {
    // Add async attribute to certain scripts
    $async_scripts = array(
        'omnitema-skip-link-focus-fix',
        'aos-js',
    );
    
    if (in_array($handle, $async_scripts)) {
        return str_replace(' src', ' async src', $tag);
    }
    
    // Add defer attribute to certain scripts
    $defer_scripts = array(
        'omnitema-navigation',
        'lightbox-js',
    );
    
    if (in_array($handle, $defer_scripts)) {
        return str_replace(' src', ' defer src', $tag);
    }
    
    return $tag;
}
add_filter('script_loader_tag', 'omnitema_script_loader_tag', 10, 3);

/**
 * Add custom inline CSS for customizations from theme options.
 */
function omnitema_customizer_inline_css() {
    $css = '';
    
    // Add custom accent color
    $accent_color = get_theme_mod('omnitema_accent_color', '#4a6df5');
    if ($accent_color) {
        $css .= "
            :root {
                --omnitema-accent-color: {$accent_color};
            }
        ";
    }
    
    // Add custom typography settings
    $body_font = get_theme_mod('omnitema_body_font_family', 'system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif');
    $heading_font = get_theme_mod('omnitema_heading_font_family', 'system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif');
    
    if ($body_font || $heading_font) {
        $css .= "
            :root {
                --omnitema-body-font: {$body_font};
                --omnitema-heading-font: {$heading_font};
            }
        ";
    }
    
    // Add container width
    $container_width = get_theme_mod('omnitema_container_width', '1200');
    if ($container_width) {
        $css .= "
            :root {
                --omnitema-container-width: {$container_width}px;
            }
        ";
    }
    
    // Output the CSS
    if (!empty($css)) {
        wp_add_inline_style('omnitema-style', $css);
    }
}
add_action('wp_enqueue_scripts', 'omnitema_customizer_inline_css', 20);
