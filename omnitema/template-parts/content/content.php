<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OmniTema
 */

$post_layout = get_theme_mod('omnitema_blog_layout', 'grid');
$post_class = 'post-item post-layout-' . $post_layout;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($post_class); ?>>
    <?php if (has_post_thumbnail()) : ?>
    <div class="post-thumbnail">
        <a href="<?php the_permalink(); ?>">
            <?php 
            // Use appropriate image size based on layout
            if ($post_layout == 'grid') {
                the_post_thumbnail('omnitema-grid');
            } elseif ($post_layout == 'list') {
                the_post_thumbnail('omnitema-list');
            } else {
                the_post_thumbnail();
            }
            ?>
        </a>
    </div><!-- .post-thumbnail -->
    <?php endif; ?>

    <div class="post-content">
        <header class="entry-header">
            <?php
            if (is_sticky() && is_home() && !is_paged()) {
                echo '<span class="sticky-post">' . esc_html__('Featured', 'omnitema') . '</span>';
            }
            
            if (is_singular()) :
                the_title('<h1 class="entry-title">', '</h1>');
            else :
                the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
            endif;
            ?>
            
            <div class="entry-meta">
                <?php
                omnitema_posted_on();
                omnitema_posted_by();
                ?>
            </div><!-- .entry-meta -->
        </header><!-- .entry-header -->

        <div class="entry-content">
            <?php
            if (is_singular() || get_theme_mod('omnitema_blog_content', 'excerpt') === 'full') :
                the_content(
                    sprintf(
                        wp_kses(
                            /* translators: %s: Name of current post. Only visible to screen readers */
                            __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'omnitema'),
                            array(
                                'span' => array(
                                    'class' => array(),
                                ),
                            )
                        ),
                        wp_kses_post(get_the_title())
                    )
                );

                wp_link_pages(
                    array(
                        'before' => '<div class="page-links">' . esc_html__('Pages:', 'omnitema'),
                        'after'  => '</div>',
                    )
                );
            else :
                the_excerpt();
            endif;
            ?>
        </div><!-- .entry-content -->

        <footer class="entry-footer">
            <?php omnitema_entry_footer(); ?>
        </footer><!-- .entry-footer -->
    </div><!-- .post-content -->
</article><!-- #post-<?php the_ID(); ?> -->
