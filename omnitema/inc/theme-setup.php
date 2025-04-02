<?php
/**
 * Theme Setup Functions
 *
 * @package OmniTema
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function omnitema_setup() {
    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     */
    load_theme_textdomain('omnitema', OMNITEMA_DIR . 'languages');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support('title-tag');

    /*
     * Enable support for Post Thumbnails on posts and pages.
     */
    add_theme_support('post-thumbnails');

    // Set default thumbnail size
    set_post_thumbnail_size(1200, 675, true);
    
    // Add custom image sizes
    add_image_size('omnitema-blog', 800, 450, true);
    add_image_size('omnitema-single', 1600, 900, true);

    /*
     * Register menu locations
     */
    register_nav_menus(array(
        'primary'   => esc_html__('Primary Menu', 'omnitema'),
        'mobile'    => esc_html__('Mobile Menu', 'omnitema'),
        'footer'    => esc_html__('Footer Menu', 'omnitema'),
    ));

    /*
     * Switch default core markup to output valid HTML5.
     */
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    /*
     * Enable support for Post Formats.
     */
    add_theme_support('post-formats', array(
        'aside',
        'image',
        'video',
        'quote',
        'link',
        'gallery',
        'audio',
    ));

    /*
     * Add theme support for Custom Logo.
     */
    add_theme_support('custom-logo', array(
        'height'      => 80,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
    ));

    /*
     * Add theme support for selective refresh for widgets.
     */
    add_theme_support('customize-selective-refresh-widgets');

    /*
     * WooCommerce support
     */
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    
    /*
     * Enable featured content
     */
    add_theme_support('featured-content', array(
        'filter'     => 'omnitema_get_featured_posts',
        'max_posts'  => 5,
        'post_types' => array('post'),
    ));
}
add_action('after_setup_theme', 'omnitema_setup');

/**
 * Set theme colors for WordPress customization API
 */
function omnitema_customize_register_colors($wp_customize) {
    // Add primary color setting
    $wp_customize->add_setting('omnitema_primary_color', array(
        'default'           => '#0066cc',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    
    // Add primary color control
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'omnitema_primary_color', array(
        'label'    => __('Primary Color', 'omnitema'),
        'section'  => 'colors',
        'settings' => 'omnitema_primary_color',
    )));
    
    // Add secondary color setting
    $wp_customize->add_setting('omnitema_secondary_color', array(
        'default'           => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ));
    
    // Add secondary color control
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'omnitema_secondary_color', array(
        'label'    => __('Secondary Color', 'omnitema'),
        'section'  => 'colors',
        'settings' => 'omnitema_secondary_color',
    )));
}
add_action('customize_register', 'omnitema_customize_register_colors');

/**
 * Register custom post types
 */
function omnitema_register_post_types() {
    // Register portfolio post type
    register_post_type('portfolio', array(
        'labels' => array(
            'name'               => _x('Portfolio', 'post type general name', 'omnitema'),
            'singular_name'      => _x('Portfolio Item', 'post type singular name', 'omnitema'),
            'menu_name'          => _x('Portfolio', 'admin menu', 'omnitema'),
            'name_admin_bar'     => _x('Portfolio Item', 'add new on admin bar', 'omnitema'),
            'add_new'            => _x('Add New', 'portfolio item', 'omnitema'),
            'add_new_item'       => __('Add New Portfolio Item', 'omnitema'),
            'new_item'           => __('New Portfolio Item', 'omnitema'),
            'edit_item'          => __('Edit Portfolio Item', 'omnitema'),
            'view_item'          => __('View Portfolio Item', 'omnitema'),
            'all_items'          => __('All Portfolio Items', 'omnitema'),
            'search_items'       => __('Search Portfolio Items', 'omnitema'),
            'parent_item_colon'  => __('Parent Portfolio Items:', 'omnitema'),
            'not_found'          => __('No portfolio items found.', 'omnitema'),
            'not_found_in_trash' => __('No portfolio items found in Trash.', 'omnitema')
        ),
        'public'              => true,
        'has_archive'         => true,
        'rewrite'             => array('slug' => 'portfolio'),
        'menu_icon'           => 'dashicons-portfolio',
        'supports'            => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest'        => true,
        'taxonomies'          => array('portfolio_category', 'portfolio_tag')
    ));
}
// Only register custom post types if the option is enabled
if (get_theme_mod('omnitema_enable_portfolio', false)) {
    add_action('init', 'omnitema_register_post_types');
}

/**
 * Register custom taxonomies
 */
function omnitema_register_taxonomies() {
    // Register portfolio category taxonomy
    register_taxonomy('portfolio_category', 'portfolio', array(
        'labels' => array(
            'name'              => _x('Portfolio Categories', 'taxonomy general name', 'omnitema'),
            'singular_name'     => _x('Portfolio Category', 'taxonomy singular name', 'omnitema'),
            'search_items'      => __('Search Portfolio Categories', 'omnitema'),
            'all_items'         => __('All Portfolio Categories', 'omnitema'),
            'parent_item'       => __('Parent Portfolio Category', 'omnitema'),
            'parent_item_colon' => __('Parent Portfolio Category:', 'omnitema'),
            'edit_item'         => __('Edit Portfolio Category', 'omnitema'),
            'update_item'       => __('Update Portfolio Category', 'omnitema'),
            'add_new_item'      => __('Add New Portfolio Category', 'omnitema'),
            'new_item_name'     => __('New Portfolio Category Name', 'omnitema'),
            'menu_name'         => __('Categories', 'omnitema'),
        ),
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'portfolio-category'),
        'show_in_rest'      => true,
    ));
    
    // Register portfolio tag taxonomy
    register_taxonomy('portfolio_tag', 'portfolio', array(
        'labels' => array(
            'name'              => _x('Portfolio Tags', 'taxonomy general name', 'omnitema'),
            'singular_name'     => _x('Portfolio Tag', 'taxonomy singular name', 'omnitema'),
            'search_items'      => __('Search Portfolio Tags', 'omnitema'),
            'all_items'         => __('All Portfolio Tags', 'omnitema'),
            'parent_item'       => __('Parent Portfolio Tag', 'omnitema'),
            'parent_item_colon' => __('Parent Portfolio Tag:', 'omnitema'),
            'edit_item'         => __('Edit Portfolio Tag', 'omnitema'),
            'update_item'       => __('Update Portfolio Tag', 'omnitema'),
            'add_new_item'      => __('Add New Portfolio Tag', 'omnitema'),
            'new_item_name'     => __('New Portfolio Tag Name', 'omnitema'),
            'menu_name'         => __('Tags', 'omnitema'),
        ),
        'hierarchical'      => false,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'portfolio-tag'),
        'show_in_rest'      => true,
    ));
}
// Only register custom taxonomies if the option is enabled
if (get_theme_mod('omnitema_enable_portfolio', false)) {
    add_action('init', 'omnitema_register_taxonomies');
}
