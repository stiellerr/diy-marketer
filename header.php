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
	<a class="sr-only sr-only-focusable" href="#primary"><?php esc_html_e(
     'Skip to content',
     'diy-marketer'
 ); ?></a>

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

			</div>
		</div>



	
		<div class="site-branding">
			<?php
   the_custom_logo();
   if (is_front_page() && is_home()): ?>
				<h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo(
    'name'
); ?></a></h1>
				<?php else: ?>
				<p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo(
    'name'
); ?></a></p>
				<?php endif;
   $diy_marketer_description = get_bloginfo('description', 'display');
   if ($diy_marketer_description || is_customize_preview()): ?>
				<p class="site-description"><?php echo $diy_marketer_description;
       // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
       ?></p>
			<?php endif;
   ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e(
       'Primary Menu',
       'diy-marketer'
   ); ?></button>
			<?php wp_nav_menu([
       'theme_location' => 'menu-1',
       'menu_id' => 'primary-menu',
   ]); ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->