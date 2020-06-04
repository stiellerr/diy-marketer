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
		<div class="row site-banner border-bottom border-primary py-1">
			<div class="col-md-auto text-center align-self-center"><?php bloginfo('description'); ?></div>
			<div class="col-md text-center text-md-right">
				Call Us
			</div>
		</div>

		<!-- NAVBAR
		================================================== -->
		<div class="row border-bottom">
			<div class="col-md-auto text-center py-3">
				<?php the_custom_logo(); ?>
			</div>
			<div class="col-md align-self-center">
				<nav class="navbar navbar-expand-sm px-0" role="navigation">
					<button class="navbar-toggler bg-dark" type="button" data-toggle="collapse" data-target="#primary-menu" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php _e( 'Toggle Navigation', 'diy-marketer' ) ?>">
						<span class="navbar-toggler-icon"></span>
					</button>
					<?php
						wp_nav_menu(
							array(
								'theme_location'	=> 'menu-1',
								//'depth'			=> 2,
								'container_id'		=> 'primary-menu',
								'container_class'	=> 'collapse navbar-collapse justify-content-start justify-content-md-end',
								'menu_class'		=> 'navbar-nav nav-pills text-center bg-light bg-md-none',
							)
						);
					?>
				</nav>
			</div>
		</div>
	</header>