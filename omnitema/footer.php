<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @package OmniTema
 */

?>
    </div><!-- #content -->

    <?php 
    // Check if Elementor footer template exists
    if (omnitema_is_elementor_active() && omnitema_is_elementor_pro_active()) {
        if (function_exists('elementor_theme_do_location') && elementor_theme_do_location('footer')) {
            // Elementor footer template will be displayed
        } else {
            // If no Elementor footer template, use the default footer
            get_template_part('template-parts/footer/base');
        }
    } else {
        // Use the default footer
        get_template_part('template-parts/footer/base');
    }
    ?>

</div><!-- #page -->

<?php if (get_theme_mod('omnitema_back_to_top', true)) : ?>
    <button id="back-to-top" class="back-to-top" aria-label="<?php esc_attr_e('Back to top', 'omnitema'); ?>">
        <span class="screen-reader-text"><?php esc_html_e('Back to top', 'omnitema'); ?></span>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="18 15 12 9 6 15"></polyline>
        </svg>
    </button>
<?php endif; ?>

<?php if (get_theme_mod('omnitema_cookie_notice', false)) : ?>
    <div id="cookie-notice" class="cookie-notice">
        <div class="cookie-notice-container">
            <p><?php echo wp_kses_post(get_theme_mod('omnitema_cookie_text', esc_html__('This website uses cookies to ensure you get the best experience on our website.', 'omnitema'))); ?></p>
            <div class="cookie-notice-buttons">
                <button id="cookie-notice-accept" class="button cookie-notice-accept"><?php esc_html_e('Accept', 'omnitema'); ?></button>
                <?php if (get_theme_mod('omnitema_privacy_page')) : ?>
                    <a href="<?php echo esc_url(get_permalink(get_theme_mod('omnitema_privacy_page'))); ?>" class="button cookie-notice-learn-more"><?php esc_html_e('Learn more', 'omnitema'); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php wp_footer(); ?>

</body>
</html>
