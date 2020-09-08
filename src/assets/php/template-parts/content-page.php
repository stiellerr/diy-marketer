<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Underscores
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php the_content(); ?>

	<?php /*  191   */

	echo "<h2>This is a test page.</h2>";
	
	//var_dump( wp_get_attachment_image_src(191, 'large' ) );
	//var_dump( wp_get_attachment_image_url(191, 'large' ) );
	//var_dump( wp_get_attachment_image_url(191, 'full' ) );
	//var_dump( wp_get_attachment_url(191 ) );
	//var_dump( wp_get_attachment_image_url( 341, 'diym-custom-size' ) );
	var_dump( wp_get_attachment_image( 343, 'diym-custom-size' ) );
	?>
	
	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="sr-only sr-only-focusable">%s</span>', 'diy-marketer' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->