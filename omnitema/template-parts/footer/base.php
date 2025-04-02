<?php
/**
 * Template part for displaying the base footer
 *
 * @package OmniTema
 */

// Get footer layout from theme options
$footer_layout = get_theme_mod('omnitema_footer_layout', 'standard');
$footer_columns = get_theme_mod('omnitema_footer_columns', 3);
$show_social = get_theme_mod('omnitema_footer_social', true);
$show_payment_icons = get_theme_mod('omnitema_show_payment_icons', false);

$footer_class = 'site-footer';
$footer_class .= ' layout-' . $footer_layout;
$footer_class .= ' columns-' . $footer_columns;
?>

<footer id="colophon" class="<?php echo esc_attr($footer_class); ?>">
    <?php if (is_active_sidebar('footer-1') || is_active_sidebar('footer-2') || is_active_sidebar('footer-3')) : ?>
    <div class="footer-widgets">
        <div class="container">
            <div class="footer-widgets-grid">
                <?php if (is_active_sidebar('footer-1')) : ?>
                <div class="footer-widget-area footer-1">
                    <?php dynamic_sidebar('footer-1'); ?>
                </div>
                <?php endif; ?>
                
                <?php if ($footer_columns > 1 && is_active_sidebar('footer-2')) : ?>
                <div class="footer-widget-area footer-2">
                    <?php dynamic_sidebar('footer-2'); ?>
                </div>
                <?php endif; ?>
                
                <?php if ($footer_columns > 2 && is_active_sidebar('footer-3')) : ?>
                <div class="footer-widget-area footer-3">
                    <?php dynamic_sidebar('footer-3'); ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="site-info">
        <div class="container">
            <div class="site-info-wrapper">
                <div class="copyright">
                    <?php
                    $copyright_text = get_theme_mod('omnitema_copyright_text', sprintf(
                        /* translators: %1$s: Current year, %2$s: Site name */
                        esc_html__('© %1$s %2$s. All rights reserved.', 'omnitema'),
                        date('Y'),
                        get_bloginfo('name')
                    ));
                    echo wp_kses_post($copyright_text);
                    ?>
                </div>

                <?php if ($show_social) : ?>
                <div class="footer-social">
                    <?php
                    // Display social icons from theme options
                    $social_networks = array(
                        'facebook' => get_theme_mod('omnitema_facebook'),
                        'twitter' => get_theme_mod('omnitema_twitter'),
                        'instagram' => get_theme_mod('omnitema_instagram'),
                        'linkedin' => get_theme_mod('omnitema_linkedin'),
                        'youtube' => get_theme_mod('omnitema_youtube'),
                    );

                    echo '<div class="social-icons">';
                    foreach ($social_networks as $network => $url) {
                        if (!empty($url)) {
                            echo '<a href="' . esc_url($url) . '" class="social-icon ' . esc_attr($network) . '" target="_blank" rel="noopener noreferrer">';
                            echo '<span class="screen-reader-text">' . esc_html(ucfirst($network)) . '</span>';
                            echo '</a>';
                        }
                    }
                    echo '</div>';
                    ?>
                </div>
                <?php endif; ?>

                <?php if (has_nav_menu('footer')) : ?>
                <div class="footer-links">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'menu_id'        => 'footer-menu',
                        'container'      => false,
                        'depth'          => 1,
                        'fallback_cb'    => false,
                    ));
                    ?>
                </div>
                <?php endif; ?>

                <?php if ($show_payment_icons && class_exists('WooCommerce')) : ?>
                <div class="payment-icons">
                    <?php
                    // Display payment method icons
                    $payment_methods = get_theme_mod('omnitema_payment_methods', array('visa', 'mastercard', 'paypal'));
                    if (!empty($payment_methods)) {
                        echo '<div class="payment-method-icons">';
                        foreach ($payment_methods as $method) {
                            echo '<span class="payment-icon ' . esc_attr($method) . '"></span>';
                        }
                        echo '</div>';
                    }
                    ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div><!-- .site-info -->
</footer><!-- #colophon -->
