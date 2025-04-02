<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OmniTema
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <?php
        while (have_posts()) :
            the_post();

            // Check if Elementor is being used for this page
            if (omnitema_is_elementor_active()) {
                if (omnitema_is_elementor_pro_active() && function_exists('elementor_theme_do_location') && elementor_theme_do_location('single')) {
                    // Elementor template will be displayed
                } else {
                    // If Elementor editor is active but no theme location is set
                    get_template_part('template-parts/content/content', 'page');

                    // If comments are open or we have at least one comment, load up the comment template.
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                }
            } else {
                // Use the regular template
                get_template_part('template-parts/content/content', 'page');

                // If comments are open or we have at least one comment, load up the comment template.
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
            }

        endwhile; // End of the loop.
        ?>
    </div>

    <?php
    // Only display sidebar on non-full width layouts and if not overridden by Elementor
    $sidebar_layout = get_theme_mod('omnitema_page_sidebar', 'none');
    if ($sidebar_layout !== 'none' && $sidebar_layout !== 'full' && (!omnitema_is_elementor_active() || !omnitema_is_elementor_pro_active() || !function_exists('elementor_theme_do_location') || !elementor_theme_do_location('single'))) {
        get_sidebar();
    }
    ?>
</main><!-- #primary -->

<?php
get_footer();
