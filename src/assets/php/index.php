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
 * @package DIY_Marketer
 */

get_header(); ?>
    <!--<main id="primary" class="site-main"> border-top -->
    <div class="cover row flex-grow-1 py-3">
        <main id="primary" class="col">
            <?php
                if ( have_posts() ) {
                    while ( have_posts() ) {
                        the_post();
                        /*
                        * Include the Post-Type-specific template for the content.
                        * If you want to override this in a child theme, then include a file
                        * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                        */
                        get_template_part( 'template-parts/content', get_post_type() );
                    }
                } else { echo '<p>No content to display</p>'; }
            ?>
        </main><!-- #main -->
        <?php get_sidebar(); ?>
    </div>
<?php get_footer(); ?>

