<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OmniTema
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <?php if (have_posts()) : ?>

            <header class="page-header">
                <?php
                the_archive_title('<h1 class="page-title">', '</h1>');
                the_archive_description('<div class="archive-description">', '</div>');
                ?>
            </header><!-- .page-header -->

            <?php
            // Check if Elementor is being used for archives
            if (omnitema_is_elementor_active() && omnitema_is_elementor_pro_active()) {
                if (function_exists('elementor_theme_do_location') && elementor_theme_do_location('archive')) {
                    // Elementor template will be displayed
                } else {
                    // If no Elementor template, use the regular template structure
                    echo '<div class="posts-grid">';
                    /* Start the Loop */
                    while (have_posts()) :
                        the_post();

                        /*
                         * Include the Post-Type-specific template for the content.
                         * If you want to override this in a child theme, then include a file
                         * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                         */
                        get_template_part('template-parts/content/content', get_post_type());

                    endwhile;
                    echo '</div>';

                    // Pagination
                    echo '<div class="pagination-container">';
                    the_posts_pagination(array(
                        'mid_size' => 2,
                        'prev_text' => '<span class="nav-prev-text">' . esc_html__('Previous', 'omnitema') . '</span>',
                        'next_text' => '<span class="nav-next-text">' . esc_html__('Next', 'omnitema') . '</span>',
                    ));
                    echo '</div>';
                }
            } else {
                // Use the regular template structure
                echo '<div class="posts-grid">';
                /* Start the Loop */
                while (have_posts()) :
                    the_post();

                    /*
                     * Include the Post-Type-specific template for the content.
                     * If you want to override this in a child theme, then include a file
                     * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                     */
                    get_template_part('template-parts/content/content', get_post_type());

                endwhile;
                echo '</div>';

                // Pagination
                echo '<div class="pagination-container">';
                the_posts_pagination(array(
                    'mid_size' => 2,
                    'prev_text' => '<span class="nav-prev-text">' . esc_html__('Previous', 'omnitema') . '</span>',
                    'next_text' => '<span class="nav-next-text">' . esc_html__('Next', 'omnitema') . '</span>',
                ));
                echo '</div>';
            }

        else :

            get_template_part('template-parts/content/content', 'none');

        endif;
        ?>
    </div>

    <?php
    // Only display sidebar on non-full width layouts
    $sidebar_layout = get_theme_mod('omnitema_archive_sidebar', 'right');
    if ($sidebar_layout !== 'full' && (!omnitema_is_elementor_active() || !omnitema_is_elementor_pro_active() || !function_exists('elementor_theme_do_location') || !elementor_theme_do_location('archive'))) {
        get_sidebar();
    }
    ?>
</main><!-- #primary -->

<?php
get_footer();
