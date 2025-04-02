<?php
/**
 * Template part for displaying the base header
 *
 * @package OmniTema
 */

// Get header layout from theme options
$header_layout = get_theme_mod('omnitema_header_layout', 'standard');
$enable_sticky = get_theme_mod('omnitema_sticky_header', true);
$show_search = get_theme_mod('omnitema_header_search', true);

$header_class = 'site-header';
if ($enable_sticky) {
    $header_class .= ' sticky-header';
}
$header_class .= ' layout-' . $header_layout;
?>

<header id="masthead" class="<?php echo esc_attr($header_class); ?>">
    <div class="container header-container">
        <div class="site-branding">
            <?php
            if (has_custom_logo()) :
                the_custom_logo();
            else :
            ?>
                <div class="site-title-container">
                    <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
                    <?php
                    $omnitema_description = get_bloginfo('description', 'display');
                    if ($omnitema_description || is_customize_preview()) :
                    ?>
                        <p class="site-description"><?php echo esc_html($omnitema_description); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div><!-- .site-branding -->

        <nav id="site-navigation" class="main-navigation">
            <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                <span class="menu-toggle-text"><?php esc_html_e('Menu', 'omnitema'); ?></span>
                <div class="menu-toggle-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_id'        => 'primary-menu',
                'fallback_cb'    => 'omnitema_primary_menu_fallback',
                'container'      => false,
            ));
            ?>
        </nav><!-- #site-navigation -->

        <?php if ($show_search) : ?>
        <div class="header-search">
            <button class="search-toggle" aria-expanded="false">
                <span class="screen-reader-text"><?php esc_html_e('Search', 'omnitema'); ?></span>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </button>
            <div class="search-dropdown">
                <?php get_search_form(); ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if (class_exists('WooCommerce')) : ?>
        <div class="header-cart">
            <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="cart-contents">
                <span class="screen-reader-text"><?php esc_html_e('Cart', 'omnitema'); ?></span>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                <span class="cart-count"><?php echo esc_html(WC()->cart->get_cart_contents_count()); ?></span>
            </a>
        </div>
        <?php endif; ?>
    </div>
</header><!-- #masthead -->
