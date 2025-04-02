<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
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

            // Check if Elementor is being used for this post
            if (omnitema_is_elementor_active() && omnitema_is_elementor_pro_active()) {
                if (function_exists('elementor_theme_do_location') && elementor_theme_do_location('single')) {
                    // Elementor template will be displayed
                } else {
                    // If no Elementor template, use the regular template
                    get_template_part('template-parts/content/content', 'single');

                    // If comments are open or we have at least one comment, load up the comment template.
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;

                    // Post navigation
                    the_post_navigation(
                        array(
                            'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous:', 'omnitema') . '</span> <span class="nav-title">%title</span>',
                            'next_text' => '<span class="nav-subtitle">' . esc_html__('Next:', 'omnitema') . '</span> <span class="nav-title">%title</span>',
                        )
                    );
                }
            } else {
                // Use the regular template
                get_template_part('template-parts/content/content', 'single');

                // If comments are open or we have at least one comment, load up the comment template.
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;

                // Post navigation
                the_post_navigation(
                    array(
                        'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous:', 'omnitema') . '</span> <span class="nav-title">%title</span>',
                        'next_text' => '<span class="nav-subtitle">' . esc_html__('Next:', 'omnitema') . '</span> <span class="nav-title">%title</span>',
                    )
                );
            }

        endwhile; // End of the loop.
        ?>
    </div>

    <?php
    // Only display sidebar on non-full width layouts and if not overridden by Elementor
    $sidebar_layout = get_theme_mod('omnitema_single_post_sidebar', 'right');
    if ($sidebar_layout !== 'full' && (!omnitema_is_elementor_active() || !omnitema_is_elementor_pro_active() || !function_exists('elementor_theme_do_location') || !elementor_theme_do_location('single'))) {
        get_sidebar();
    }
    ?>
</main><!-- #primary -->

<?php
get_footer();
