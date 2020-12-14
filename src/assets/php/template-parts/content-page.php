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

	<?php
		//
		$blocks = parse_blocks( get_the_content() );
		
		foreach ( $blocks as $block ) {
			//write_log( 'attrs' );
			write_log( $block[ 'attrs' ] );
		}

		//write_log( 'blocks' );
		//write_log( $blocks );
		
	?>


<!--
	<img
		width="825"
		height="300"
		src="https://via.placeholder.com/825x300"
		srcset="https://via.placeholder.com/546x300 546w, https://via.placeholder.com/510x300 510w, https://via.placeholder.com/450x300 450w, https://via.placeholder.com/690x300 690w, https://via.placeholder.com/825x300 825w"
		sizes="(max-width: 575px) calc(100vw - 30px), (max-width: 767px) 510px, (max-width: 991px) 450px, (max-width: 1199px) 690px, 825px">
-->

	<?php /*  191   */
	//srcset="https://via.placeholder.com/546x300 546w, https://via.placeholder.com/510x300 510w, https://via.placeholder.com/690x300 690w, https://via.placeholder.com/930x300 930w, https://via.placeholder.com/1110x300 1110w"
//(max-width: 575px) calc(100vw - 30px), (max-width: 767px) 510px, (max-width: 991px) 450px, (max-width: 1199px) 690px, 825px
//(max-width: 575px) calc(100vw - 30px), (max-width: 767px) 510px, (max-width: 991px) 690px, (max-width: 1199px) 930px, 1110px
	//echo "<h2>This is a test page.</h2>";
	
	//var_dump( wp_get_attachment_image_src(454, 'large' ) );
	//var_dump( wp_get_attachment_image_url(454, 'large' ) );
	//var_dump( wp_get_attachment_image_url(191, 'full' ) );
	//var_dump( wp_get_attachment_url( 454 ) );
	//var_dump( wp_get_attachment_image_url( 348 ) );
	//var_dump( wp_get_attachment_url( 348 ) );

	//echo wp_get_attachment_image( 348, 'diym-custom-size' );
	//echo wp_get_attachment_image( 553, 'medium' );

	//echo wp_get_attachment_image($attachment_id, $size, $icon, $attr)
	//echo wp_get_attachment_image_sizes($attachment_id, $size, $image_meta)
	//echo wp_get_attachment_image_srcset($attachment_id, $size, $image_meta)
	//echo wp_get_attachment_image_srcset($attachment_id, $size, $image_meta)
	//echo wp_get_attachment_image_url($attachment_id, $size, $icon)
	//echo wp_get_attachment_image_srcset($attachment_id, $size, $image_meta)
	?>
	<!--
	<img class="img-fluid" src="<?php echo wp_get_attachment_url( 454 ); ?>" />
	-->
	<?php

	//wp_get_attachment_image_srcset
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