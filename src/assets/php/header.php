<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package DIY_Marketer
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="container shadow bg-white">
	<a class="sr-only sr-only-focusable" href="#primary"><?php esc_html_e('Skip to content', 'diy-marketer'); ?></a>

	<!-- HEADER
	================================================== -->
	<header role="banner">
		<div class="row site-banner border-bottom border-thick border-primary py-1">
			<div class="col-md-auto text-center align-self-center site-tagline"><?php bloginfo('description'); ?></div>
			<!--<div class="col-md text-center text-md-right">-->
			<div class="col-md">
				<?php
					get_template_part( 'template-parts/socials' );
				?>
			</div>
		</div>

		<!-- NAVBAR
		================================================== 
		<div class="row border-bottom">
			<div class="col-md-auto text-center py-1 py-md-3">
				<?php 
					if ( has_custom_logo() ) {
						the_custom_logo();
					} else {
						echo '<h1 class="site-name my-2">'. get_bloginfo( 'name' ) .'</h1>';
					}
				?>
			</div>
			<div class="col-md align-self-center">
				<nav class="navbar navbar-expand-sm px-0" role="navigation">				
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#primary-menu" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php _e( 'Toggle Navigation', 'diy-marketer' ) ?>">
						<span class="navbar-toggler-icon"></span>
					</button>
					<?php
						wp_nav_menu(
							array(
								'theme_location'	=> 'menu-1',
								//'depth'			=> 2,
								'container_id'		=> 'primary-menu',
								'container_class'	=> 'collapse navbar-collapse justify-content-start justify-content-md-end w-100',
								'menu_class'		=> 'navbar-nav nav-pills text-center bg-light bg-md-none',
								'fallback_cb'		=> false
							)
						);
					?>
				</nav>
			</div>
		</div>
		-->
		<nav class="navbar navbar-expand-sm flex-column px-0" role="navigation">
			<?php /*the_custom_logo();*/ ?>
			<h1>Hello World</h1>
			<!--<a class="navbar-brand bg-info" href="#">Navbar</a>		-->	
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#primary-menu" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php _e( 'Toggle Navigation', 'diy-marketer' ) ?>">
				<span class="navbar-toggler-icon"></span>
			</button>
			<?php
				wp_nav_menu(
					array(
						'theme_location'	=> 'menu-1',
						//'depth'			=> 2,
						'container_id'		=> 'primary-menu',
						'container_class'	=> 'collapse navbar-collapse mr-auto',
						'menu_class'		=> 'navbar-nav nav-pills text-center bg-md-none justify-content-start',
						'fallback_cb'		=> false
					)
				);
			?>
		</nav>

	</header>