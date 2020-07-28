<?php
/**
 * DIY Marketer functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package DIY_Marketer
 */

 // useful function for witing to the log
if ( ! function_exists('write_log')) {
    function write_log ( $log )  {
       if ( is_array( $log ) || is_object( $log ) ) {
          error_log( print_r( $log, true ) );
       } else {
          error_log( $log );
       }
    }
 }

 /**
 * Strip heading tags and their content from the excerpt
 */
function diym_wp_strip_header_tags_only( $excerpt ) {
	
	error_log($excerpt);

	//$regex = '#(<h([1-6])[^>]*>)\s?(.*)?\s?(<\/h\2>)#';
	$regex = '#(<h([1-6])[^>]*>)\s?(.*)?\s?(<\/h\2>)#';
    $excerpt = preg_replace($regex,'', $excerpt);
     
	return $excerpt;
	//return 'hello world';
}

add_filter( 'get_the_excerpt', 'diym_wp_strip_header_tags_only', 0);





if (!defined('DIYM_VER')) {
    // Replace the version number of the theme on each release.
    define('DIYM_VER', '1.0.0');
}

define('DIYM_URL', trailingslashit(get_template_directory_uri()));
define('DIYM_DIR', trailingslashit(get_template_directory()));

define('DIYM_JS_URL', trailingslashit(DIYM_URL . 'dist/assets/js'));
define('DIYM_CSS_URL', trailingslashit(DIYM_URL . 'dist/assets/css'));
define('DIYM_IMG_URL', trailingslashit(DIYM_URL . 'dist/assets/images'));

if (!function_exists('diym_setup')):
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function diym_setup()
    {
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Navbar', 'diy-marketer' ),
				'menu-2' => esc_html__( 'Footer', 'diy-marketer' ),
				//'menu-3' => esc_html__( 'Widget', 'diy-marketer' ),
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			//apply_filters(
				//'underscores_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => DIYM_IMG_URL . 'bg/pattern6.png',
				)
			//)
		);
		
		// Set up excerpt support for pages.
		add_post_type_support( 'page', 'excerpt' );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support('custom-logo', [
            'height' => 80,
            'width' => 80,
            'flex-width' => true,
            'flex-height' => false,
            'header-text' => ['#site-banner'],
        ]);
    }
endif;
add_action('after_setup_theme', 'diym_setup');

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function diym_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 1', 'diy-marketer' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Add widgets here.', 'diy-maketer' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h5 class="widget-title">',
			'after_title'   => '</h5>',
		)
	);
}
add_action( 'widgets_init', 'diym_widgets_init' );



function diym_assets() {
	wp_enqueue_style('diym-stylesheet', DIYM_CSS_URL . 'bundle.css', array('dashicons'), DIYM_VER, 'all');

	require DIYM_DIR . 'inc/inline-css.php';
	
	wp_add_inline_style('diym-stylesheet', $diym_inline_styles);

    wp_enqueue_script('diym-scripts', DIYM_JS_URL . 'bundle.js', array('jquery'), DIYM_VER, true);
}

add_action('wp_enqueue_scripts', 'diym_assets');

function diym_admin_assets()
{
    wp_enqueue_style('diym-admin-stylesheet', DIYM_CSS_URL . 'admin.css', [], DIYM_VER, 'all');

    wp_enqueue_script('diym-admin-scripts', DIYM_JS_URL . 'admin.js', [], DIYM_VER, true);
}

add_action('admin_enqueue_scripts', 'diym_admin_assets');



/**
 * Customizer additions.
 */
require DIYM_DIR . 'inc/customizer.php';

// navigation
function diym_nav_menu_css_class( $classes, $item, $args, $depth ) {

	if ( $args->theme_location == 'menu-1' ) {
		$classes[] = 'nav-item';
		if ( in_array( 'menu-item-has-children', $classes ) ) {
			$classes[] = 'dropdown';
		}
	}
	return $classes;
}

add_filter( 'nav_menu_css_class', 'diym_nav_menu_css_class', 10, 4 ); 

function diym_nav_menu_link_attributes($atts, $item, $args, $depth) {

	if ( $args->theme_location == 'menu-1' ) {

		if ( in_array( 'menu-item-has-children', $item->classes ) && 0 === $depth && $args->depth > 1 ) {
	
			$atts['href']          = '#';
			$atts['data-toggle']   = 'dropdown';
			$atts['aria-haspopup'] = 'true';
			$atts['aria-expanded'] = 'false';
			$atts['class']         = 'nav-link dropdown-toggle';
			//$atts['id']            = 'menu-item-dropdown-' . $item->ID;

		} else {
			if ( $depth > 0 ) {
				$atts['class'] = 'dropdown-item';
			} else {
				$atts['class'] = 'nav-link';
			}
		}
	
		if ( $item->current ) {
			$atts['class'] .= ' active';
		}

	}
    return $atts;
}

add_filter( 'nav_menu_link_attributes', 'diym_nav_menu_link_attributes', 10, 4 );

function diym_nav_menu_submenu_css_class( $classes, $args, $depth ) {
	if ( $args->theme_location == 'menu-1' ) {
		$classes[] = 'dropdown-menu';
	}
	return $classes;
}

add_filter( 'nav_menu_submenu_css_class', 'diym_nav_menu_submenu_css_class', 10, 4 );

function diym_widget_nav_menu_args( $nav_menu_args, $nav_menu, $args, $instance ) {

	//$nav_menu_args['fallback_cb'] =  0;

	//write_log($nav_menu_args);

	return $nav_menu_args;
}

add_filter( 'widget_nav_menu_args', 'diym_widget_nav_menu_args', 10, 4 );

// define the widget_title callback 
function diym_widget_title( $title, $instance, $id_base ) {
	
    // make filter magic happen here... 
    return $title; 
}; 
         
// add the filter 
add_filter( 'widget_title', 'diym_widget_title', 10, 3 ); 

function diym_wp_nav_menu_args( $args ) {

	if ( $args['theme_location'] == '' ) {
		
		$args['depth'] 		= 1;
		$args['menu_class'] = 'nav flex-column';
		$args['menu_id'] 	= 'menu-widget';
	}
	return $args;
}

add_filter( 'wp_nav_menu_args', 'diym_wp_nav_menu_args' );


function bac_wp_strip_header_tags_keep_other_formatting( $text ) {
 
	$raw_excerpt = $text;
	if ( '' == $text ) {
		//Retrieve the post content.
		$text = get_the_content(''); 
		//remove shortcode tags from the given content.
		$text = strip_shortcodes( $text );
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]&gt;', $text);
		 
		//Regular expression that removes the h1-h6 tags with their content.
		$regex = '#(<h([1-6])[^>]*>)\s?(.*)?\s?(<\/h\2>)#';
		$text = preg_replace($regex,'', $text);
		 
		/***Add the allowed HTML tags separated by a comma. 
		h1-h6 header tags are NOT allowed. DO NOT add h1,h2,h3,h4,h5,h6 tags here.***/
		$allowed_tags = '<p>,<em>,<strong>';  //I added p, em, and strong tags.
		$text = strip_tags($text, $allowed_tags);
	 
		/***Change the excerpt word count.***/
		$excerpt_word_count = 55; //This is WP default.
		$excerpt_length = apply_filters('excerpt_length', $excerpt_word_count);
		 
		/*** Change the excerpt ending.***/
		$excerpt_end = '[...]'; //This is the WP default.
		$excerpt_more = apply_filters('excerpt_more', ' ' . $excerpt_end);
		 
		$words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
			if ( count($words) > $excerpt_length ) {
				array_pop($words);
				$text = implode(' ', $words);
				$text = $text . $excerpt_more;
			} else {
				$text = implode(' ', $words);
			}
		}
		return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
	}

remove_filter('get_the_excerpt', 'wp_trim_excerpt');

add_filter( 'get_the_excerpt', 'bac_wp_strip_header_tags_keep_other_formatting', 5);


/**
 * Contact Details Widget
 */
require_once('inc/widget-contact-details.php');

/**
 * Business Hours Widget
 */
require_once('inc/widget-business-hours.php');

/**
 * Social Media Widget
 */
require_once('inc/widget-social-media.php');

/**
 * Facebook Widget
 */
require_once('inc/widget-facebook.php');

/**
 * Google Map Widget
 */
require_once('inc/widget-google-map.php');

/**
 * Business Page Excerpt Widget
 */
require_once('inc/widget-page-excerpt.php');

/**
 * Business Contact Form Widget
 */
require_once('inc/widget-contact-form.php');


?>
