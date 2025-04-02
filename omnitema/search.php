<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package OmniTema
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <?php if (have_posts()) : ?>

            <header class="page-header">
                <h1 class="page-title">
                    <?php
                    /* translators: %s: search query. */
                    printf(esc_html__('Search Results for: %s', 'omnitema'), '<span>' . get_search_query() . '</span>');
                    ?>
                </h1>
            </header><!-- .page-header -->

            <div class="posts-grid">
                <?php
                /* Start the Loop */
                while (have_posts()) :
                    the_post();

                    /**
                     * Run the loop for the search to output the results.
                     * If you want to overload this in a child theme then include a file
                     * called content-search.php and that will be used instead.
                     */
                    get_template_part('template-parts/content/content', 'search');

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
    $sidebar_layout = get_theme_mod('omnitema_search_sidebar', 'right');
    if ($sidebar_layout !== 'full') {
        get_sidebar();
    }
    ?>
</main><!-- #primary -->

<?php
get_footer();
