<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package OmniTema
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php 
        // Check if header should be displayed (can be disabled in Customizer)
        if (get_theme_mod('omnitema_page_title', true)) :
            the_title('<h1 class="entry-title">', '</h1>'); 
        endif;
        ?>
    </header><!-- .entry-header -->

    <?php if (has_post_thumbnail() && get_theme_mod('omnitema_page_featured_image', true)) : ?>
    <div class="post-thumbnail">
        <?php the_post_thumbnail('omnitema-page-header'); ?>
    </div>
    <?php endif; ?>

    <div class="entry-content">
        <?php
        the_content();

        wp_link_pages(
            array(
                'before' => '<div class="page-links">' . esc_html__('Pages:', 'omnitema'),
                'after'  => '</div>',
            )
        );
        ?>
    </div><!-- .entry-content -->

    <?php if (get_edit_post_link() && get_theme_mod('omnitema_show_edit_link', true)) : ?>
    <footer class="entry-footer">
        <?php
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
        ?>
    </footer><!-- .entry-footer -->
    <?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
