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
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
			<div class="col-md-auto text-center align-self-center">
				<?php
					// unsure what the display argument does exactly, further investigation required.
					$diym_description = get_bloginfo( 'description', 'display' );
					if ( $diym_description || is_customize_preview() ) :
						?>
						<span class="blog-description"><?php echo $diym_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<?php endif; ?>
			</div>
			<div class="col-md text-center text-md-right">
				<?php
					$diym_phoneNumber  = get_theme_mod( 'diym_phoneNumber' );
					if ( $diym_phoneNumber || is_customize_preview() ) :
						// echo phone number...
						echo $diym_phoneNumber ? 'Call Now.' : ''; ?>
						<a class="font-weight-bold phone-number text-nowrap" href="tel:<?php echo $diym_phoneNumber; ?>"><?php echo $diym_phoneNumber; ?></a>
					<?php endif; ?>
				<?php get_template_part( 'template-parts/socials' ); ?>
			</div>
		</div>

		<!-- NAVBAR
		================================================== -->
		<div class="row border-bottom">
			<div class="col">
				<nav class="navbar navbar-expand-sm flex-sm-column flex-md-row px-0" role="navigation">
					<div class="d-flex flex-fill">
						<div class="flex-grow-1 text-center text-md-left align-self-center">
							<?php 
								if ( has_custom_logo() ) {
									the_custom_logo();
								} else {
									echo '<h1 class="site-name my-2 my-md-3">'. get_bloginfo( 'name' ) .'</h1>';
								}
							?>
						</div>
						<button class="navbar-toggler px-0" type="button" data-toggle="collapse" data-target="#menu-navbar" aria-controls="menu-navbar" aria-expanded="false" aria-label="<?php _e( 'Toggle Navigation', 'diy-marketer' ) ?>">
							<span class="navbar-toggler-icon"></span>
						</button>
					</div>
					<?php
						wp_nav_menu(
							array(
								'theme_location'	=> 'primary',
								'depth'			=> 2,
								'container_id'		=> 'menu-navbar',
								'container_class'	=> 'collapse navbar-collapse mr-auto justify-content-end',
								//'menu_id'			=> 'main-nav',
								//'menu_class'		=> 'navbar-nav nav-pills text-center bg-light bg-md-none',
								'menu_class'		=> 'navbar-nav nav-pills text-center',
								'fallback_cb'		=> false
							)
						);
					?>
				</nav>
			</div>
		</div>

	</header>