<?php
/**
 * Template part for displaying posts in single.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OmniTema
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php
        if (get_theme_mod('omnitema_single_post_title', true)) :
            the_title('<h1 class="entry-title">', '</h1>');
        endif;
        ?>
        
        <div class="entry-meta">
            <?php
            // Post meta info
            omnitema_posted_on();
            omnitema_posted_by();
            
            // Display category list
            if (get_theme_mod('omnitema_show_categories', true)) {
                omnitema_post_categories();
            }
            ?>
        </div><!-- .entry-meta -->
    </header><!-- .entry-header -->

    <?php 
    // Featured image
    if (has_post_thumbnail() && get_theme_mod('omnitema_single_featured_image', true)) : 
        $image_size = get_theme_mod('omnitema_single_image_size', 'large');
    ?>
    <div class="post-thumbnail">
        <?php the_post_thumbnail($image_size); ?>
        
        <?php if (get_the_post_thumbnail_caption() && get_theme_mod('omnitema_show_featured_caption', true)) : ?>
        <div class="post-thumbnail-caption">
            <?php the_post_thumbnail_caption(); ?>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <div class="entry-content">
        <?php
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
        ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php 
        // Show tags if enabled
        if (get_theme_mod('omnitema_show_tags', true)) {
            omnitema_post_tags();
        }
        
        // Show author bio if enabled
        if (get_theme_mod('omnitema_show_author_bio', true)) {
            omnitema_author_bio();
        }
        
        // Show edit link if user can edit and it's enabled
        if (get_edit_post_link() && get_theme_mod('omnitema_show_edit_link', true)) {
            edit_post_link(
                sprintf(
                    wp_kses(
                        /* translators: %s: Name of current post. Only visible to screen readers */
                        __('Edit <span class="screen-reader-text">%s</span>', 'omnitema'),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    wp_kses_post(get_the_title())
                ),
                '<span class="edit-link">',
                '</span>'
            );
        }
        ?>
    </footer><!-- .entry-footer -->
    
    <?php
    // Show related posts if enabled
    if (get_theme_mod('omnitema_show_related_posts', true)) {
        omnitema_related_posts();
    }
    ?>
</article><!-- #post-<?php the_ID(); ?> -->
