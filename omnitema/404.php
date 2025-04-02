<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package OmniTema
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <section class="error-404 not-found">
            <header class="page-header">
                <h1 class="page-title"><?php esc_html_e('Oops! That page can&rsquo;t be found.', 'omnitema'); ?></h1>
            </header><!-- .page-header -->

            <div class="page-content">
                <p><?php esc_html_e('It looks like nothing was found at this location. Maybe try a search?', 'omnitema'); ?></p>

                <div class="search-form-container">
                    <?php get_search_form(); ?>
                </div>

                <div class="error-suggestions">
                    <h2><?php esc_html_e('Here are some helpful links:', 'omnitema'); ?></h2>
                    <ul>
                        <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'omnitema'); ?></a></li>
                        <?php
                        // Display some recent posts
                        $recent_posts = wp_get_recent_posts(array(
                            'numberposts' => 5,
                            'post_status' => 'publish'
                        ));
                        
                        foreach ($recent_posts as $recent) {
                            echo '<li><a href="' . esc_url(get_permalink($recent['ID'])) . '">' . esc_html($recent['post_title']) . '</a></li>';
                        }
                        wp_reset_postdata();
                        ?>
                    </ul>
                </div>
            </div><!-- .page-content -->
        </section><!-- .error-404 -->
    </div>
</main><!-- #primary -->

<?php
get_footer();
