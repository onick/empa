<?php
/**
 * OmniTema functions and definitions
 *
 * @package OmniTema
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define theme version
define('OMNITEMA_VERSION', '1.0.0');

// Define theme directory path and URI for easier access
define('OMNITEMA_DIR', trailingslashit(get_template_directory()));
define('OMNITEMA_URI', trailingslashit(get_template_directory_uri()));

/**
 * Include necessary files
 */
require_once OMNITEMA_DIR . 'inc/theme-setup.php';       // Theme setup and support
require_once OMNITEMA_DIR . 'inc/assets.php';            // Scripts and styles
require_once OMNITEMA_DIR . 'inc/template-functions.php'; // Template related functions
require_once OMNITEMA_DIR . 'inc/template-tags.php';     // Custom template tags
require_once OMNITEMA_DIR . 'inc/utilities.php';         // Helper functions

// Add Customizer functionality
require_once OMNITEMA_DIR . 'inc/customizer/customizer.php';

// Conditional includes
if (class_exists('WooCommerce')) {
    require_once OMNITEMA_DIR . 'inc/woocommerce/woocommerce-setup.php';
}

// Check if Elementor is active
function omnitema_is_elementor_active() {
    return did_action('elementor/loaded');
}

// Check if Elementor Pro is active
function omnitema_is_elementor_pro_active() {
    return class_exists('\ElementorPro\Plugin');
}

/**
 * Initialize Omnitema Theme
 */
function omnitema_init() {
    // Nothing here yet, but can be used for theme initialization
}
add_action('after_setup_theme', 'omnitema_init');

/**
 * Set the content width in pixels
 */
function omnitema_content_width() {
    $GLOBALS['content_width'] = apply_filters('omnitema_content_width', 1200);
}
add_action('after_setup_theme', 'omnitema_content_width', 0);

/**
 * Register widget areas
 */
function omnitema_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Main Sidebar', 'omnitema'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here to appear in your sidebar.', 'omnitema'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer 1', 'omnitema'),
        'id'            => 'footer-1',
        'description'   => esc_html__('Add widgets here to appear in footer column 1.', 'omnitema'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer 2', 'omnitema'),
        'id'            => 'footer-2',
        'description'   => esc_html__('Add widgets here to appear in footer column 2.', 'omnitema'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar(array(
        'name'          => esc_html__('Footer 3', 'omnitema'),
        'id'            => 'footer-3',
        'description'   => esc_html__('Add widgets here to appear in footer column 3.', 'omnitema'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'omnitema_widgets_init');

/**
 * Integration with Elementor
 */
function omnitema_register_elementor_locations($elementor_theme_manager) {
    // Register location for header
    $elementor_theme_manager->register_location('header');
    
    // Register location for footer
    $elementor_theme_manager->register_location('footer');
    
    // Register location for single content
    $elementor_theme_manager->register_location('single');
    
    // Register location for archive content
    $elementor_theme_manager->register_location('archive');
}
add_action('elementor/theme/register_locations', 'omnitema_register_elementor_locations');

/**
 * Add support for the Block Editor
 */
function omnitema_block_editor_support() {
    // Add support for block styles
    add_theme_support('wp-block-styles');
    
    // Add support for full-width blocks
    add_theme_support('align-wide');
    
    // Add support for editor styles
    add_theme_support('editor-styles');
    
    // Add support for responsive embeds
    add_theme_support('responsive-embeds');
}
add_action('after_setup_theme', 'omnitema_block_editor_support');
