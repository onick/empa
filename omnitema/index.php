<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
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

            <?php if (is_home() && !is_front_page()) : ?>
                <header class="page-header">
                    <h1 class="page-title"><?php single_post_title(); ?></h1>
                </header>
            <?php endif; ?>

            <div class="posts-grid">
                <?php
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
                ?>
            </div>

            <?php
            // Pagination
            echo '<div class="pagination-container">';
            the_posts_pagination(array(
                'mid_size' => 2,
                'prev_text' => '<span class="nav-prev-text">' . esc_html__('Previous', 'omnitema') . '</span>',
                'next_text' => '<span class="nav-next-text">' . esc_html__('Next', 'omnitema') . '</span>',
            ));
            echo '</div>';

        else :

            get_template_part('template-parts/content/content', 'none');

        endif;
        ?>
    </div>

    <?php
    // Only display sidebar on non-full width layouts
    $sidebar_layout = get_theme_mod('omnitema_sidebar_layout', 'right');
    if ($sidebar_layout !== 'full') {
        get_sidebar();
    }
    ?>
</main><!-- #primary -->

<?php
get_footer();
