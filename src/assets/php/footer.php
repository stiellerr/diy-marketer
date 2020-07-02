<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package DIY_Marketer
 */
?>
	<!-- FOOTER
	================================================== -->
	<footer>
		<div id="site-footer" class="row border-primary border-thick border-top">
			<div class="col-12 col-md-6 col-lg-3 pt-4">
				<?php
					if ( is_active_sidebar( 'footer-1' ) ) {
						dynamic_sidebar( 'footer-1' );
					}
				?>
			</div>
			<div class="col-12 col-md-6 col-lg-3 pt-4">
				<?php
					if ( is_active_sidebar( 'footer-2' ) ) {
						dynamic_sidebar( 'footer-2' );
					}
				?>
			</div>
			<div class="col-12 col-md-6 col-lg-3 pt-4">
				<?php
					if ( is_active_sidebar( 'footer-3' ) ) {
						dynamic_sidebar( 'footer-3' );
					}
				?>
			</div>
			<div class="col-12 col-md-6 col-lg-3 pt-4">
				<?php
					if ( is_active_sidebar( 'footer-4' ) ) {
						dynamic_sidebar( 'footer-4' );
					}
				?>
			</div>

			<div class="col py-1 align-self-center">
				<?php
					wp_nav_menu(
						array(
							'theme_location'=> 'menu-2',
							'depth'			=> 1,
							'fallback_cb'	=> false,
							'menu_class'	=> 'nav',
							'menu_id'	=> 'footer-nav'
						)
					);
				?>
			</div>
			<div class="col-lg-auto py-1 text-center text-sm-left">
				<?php
					printf( 
						wp_kses(
							__( 'Powered by <a href="%1$s">DIY Marketer</a> &copy; <span id="current-year">%2$d</span>', 'diy-marketer' ),
							array(
								'a' => array(
									'href' => array(),
								),
								'span' => array(
									'id' => array(),
								)
							)
						),
						esc_url( __( 'https://stieller.com/', 'diy-marketer' ) ),
						esc_html__( '2020', 'diy-marketer' ) 
					); 
				?>
			</div>
		</div>
		<!--
		<div class="row">
		
		</div>
				-->
	</footer>

<?php wp_footer(); ?>

</div>
</body>
</html>