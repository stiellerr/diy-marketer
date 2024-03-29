<?php
/**
 * DIY Marketer functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package DIY_Marketer
 */

error_log( 'hello world!' );

 // useful function for witing to the log
if ( ! function_exists( 'write_log ') ) {
	function write_log ( $log )  {
       if ( is_array( $log ) || is_object( $log ) ) {
          error_log( print_r( $log, true ) );
       } else {
          error_log( $log );
       }
    }
}

if ( ! defined( 'DIYM_VER' ) ) {
	// Replace the version number of the theme on each release.
	$theme_version = wp_get_theme()->get( 'Version' );
	define( 'DIYM_VER', $theme_version );
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
 * REQUIRED FILES
 * Include required files.
 */

// Handle Customizer settings.
require get_template_directory() . '/classes/class-diym-customize.php';

 // Custom CSS.
require get_template_directory() . '/inc/custom-css.php';

/**
 * Register and Enqueue Styles.
 */
function diym_register_styles() {

	//$theme_version = wp_get_theme()->get( 'Version' );

	//wp_enqueue_style( 'twentytwenty-style', get_stylesheet_uri(), array(), DIYM_VER );
	//wp_style_add_data( 'twentytwenty-style', 'rtl', 'replace' );
	wp_enqueue_style( 'diym-style', DIYM_CSS_URL . 'bundle.css', array( 'dashicons' ), DIYM_VER, 'all' );

	// Add output of Customizer settings as inline style.
	wp_add_inline_style( 'diym-style', diym_get_customizer_css( 'front-end' ) );

	// Add print CSS.
	//wp_enqueue_style( 'twentytwenty-print-style', get_template_directory_uri() . '/print.css', null, $theme_version, 'print' );

}

add_action( 'wp_enqueue_scripts', 'diym_register_styles' );

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
	//wp_enqueue_style('diym-stylesheet', DIYM_CSS_URL . 'bundle.css', array('dashicons'), DIYM_VER, 'all');

	//require DIYM_DIR . 'inc/inline-css.php';
	
	//wp_add_inline_style('diym-stylesheet', $diym_inline_styles);

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

function zzz_wp_trim_excerpt( $text = '', $post = null ) {
	$raw_excerpt = $text;
	if ( '' == $text ) {
		$post = get_post( $post );
		$text = get_the_content( '', false, $post );

		$text = strip_shortcodes( $text );
		$text = excerpt_remove_blocks( $text );

		/** This filter is documented in wp-includes/post-template.php */
		$text = apply_filters( 'the_content', $text );
		$text = str_replace( ']]>', ']]&gt;', $text );

		/* translators: Maximum number of words used in a post excerpt. */
		$excerpt_length = intval( _x( '55', 'excerpt_length' ) );

		/**
		 * Filters the maximum number of words in a post excerpt.
		 *
		 * @since 2.7.0
		 *
		 * @param int $number The maximum number of words. Default 55.
		 */
		$excerpt_length = (int) apply_filters( 'excerpt_length', $excerpt_length );

		/**
		 * Filters the string in the "more" link displayed after a trimmed excerpt.
		 *
		 * @since 2.9.0
		 *
		 * @param string $more_string The string shown within the more link.
		 */
		$excerpt_more = apply_filters( 'excerpt_more', ' ' . '[&hellip;]' );
		$text         = wp_trim_words( $text, $excerpt_length, $excerpt_more );
	}

	/**
	 * Filters the trimmed excerpt string.
	 *
	 * @since 2.8.0
	 *
	 * @param string $text        The trimmed text.
	 * @param string $raw_excerpt The text prior to trimming.
	 */
	return apply_filters( 'wp_trim_excerpt', $text, $raw_excerpt );
}

function diym_excerpt_allowed_blocks( $allowed_blocks ) {
	
	/*
	// These the the defaults.
    $allowed_inner_blocks = array(
        // Classic blocks have their blockName set to null.
        null,
        'core/freeform',
        'core/heading',
        'core/html',
        'core/list',
        'core/media-text',
        'core/paragraph',
        'core/preformatted',
        'core/pullquote',
        'core/quote',
        'core/table',
        'core/verse',
    );
 
	$allowed_blocks = array_merge( $allowed_inner_blocks, array( 'core/columns' ) );
	*/
	$allowed_blocks = array(
        'core/paragraph',
        'core/quote',
	);
	
	return $allowed_blocks;
}

add_filter( 'excerpt_allowed_blocks', 'diym_excerpt_allowed_blocks' );


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


/**
 * zzz functions_2
 */
//require('functions_2.php');


/**
 * Enqueues scripts for customizer controls & settings.
 *
 * @since Twenty Twenty 1.0
 *
 * @return void
 */
function diym_customize_controls_enqueue_scripts() {
	// Add main customizer js file.
	//wp_enqueue_script( 'diym-customize', DIYM_JS_URL . 'customize.js', array( 'jquery' ), DIYM_VER, false );

	// Add script for color calculations.
	//wp_enqueue_script( 'diym-color-calculations', DIYM_JS_URL . 'color-calculations.js', array( 'wp-color-picker' ), DIYM_VER, false );

	// Add script for controls.
	//wp_enqueue_script( 'diym-customize-controls', DIYM_JS_URL . 'customize-controls.js', array( 'diym-color-calculations', 'customize-controls', 'underscore', 'jquery' ), DIYM_VER, false );
	wp_enqueue_script( 'diym-customize-controls', DIYM_JS_URL . 'customize-controls.js', array( 'customize-controls', 'wp-color-picker', 'underscore', 'jquery' ), DIYM_VER, false );
	wp_localize_script( 'diym-customize-controls', 'diymBgColors', diym_get_customizer_color_vars() );
	wp_localize_script( 'diym-customize-controls', 'diymBackgroudColors', diym_get_customizer_color_vars() );

}

add_action( 'customize_controls_enqueue_scripts', 'diym_customize_controls_enqueue_scripts' );

/**
 * Enqueue scripts for the customizer preview.
 *
 * @since Twenty Twenty 1.0
 *
 * @return void
 */
function diym_customize_preview_init() {
	//$theme_version = wp_get_theme()->get( 'Version' );//get_theme_file_uri(

	//wp_enqueue_script( 'twentytwenty-customize-preview', get_theme_file_uri( '/assets/js/customize-preview.js' ), array( 'customize-preview', 'customize-selective-refresh', 'jquery' ), $theme_version, true );
	wp_enqueue_script( 'diym-customize-preview', DIYM_JS_URL . 'customize-preview.js', array( 'customize-preview', 'customize-selective-refresh', 'jquery' ), DIYM_VER, true );
	wp_localize_script( 'diym-customize-preview', 'diymBgColors', diym_get_customizer_color_vars() );
	wp_localize_script( 'diym-customize-preview', 'diymPreviewEls', diym_get_elements_array() );

	/*
	wp_add_inline_script(
		'twentytwenty-customize-preview',
		sprintf(
			'wp.customize.selectiveRefresh.partialConstructor[ %1$s ].prototype.attrs = %2$s;',
			wp_json_encode( 'cover_opacity' ),
			wp_json_encode( twentytwenty_customize_opacity_range() )
		)
	);
	*/
}

add_action( 'customize_preview_init', 'diym_customize_preview_init' );




/**
 * Returns an array of variables for the customizer preview.
 *
 * @since Twenty Twenty 1.0
 *
 * @return array
 */
function diym_get_customizer_color_vars() {
	$colors = array(
		'content'       => array(
			'setting' => 'background_color',
			// hard code background color to white...
			'color' => '#ffffff'
		),
		//'header-footer' => array(
		'banner-footer' => array(
			//'setting' => 'header_footer_background_color',
			'setting' => 'banner_footer_background_color',
		),
	);
	return $colors;
}


/**
 * Get an array of elements.
 *
 * @since Twenty Twenty 1.0
 *
 * @return array
 */
function diym_get_elements_array() {

	// The array is formatted like this:
	// [key-in-saved-setting][sub-key-in-setting][index][css-property][selector] = [elements].
	$elements = array(
		'content' => array(
			'accent' => array(
				array(
					'border-color' => array(
						'selector' => array( '.border-primary' ),
						'suffix'	=> '!important',
					),
				),
				array(
					'border-color' => array(
						'selector' => array( '.navbar-nav .nav-item .nav-link:hover', '.btn-primary' ),
					),
				),
				array(
					'background-color' => array(
						'selector' => array( '.nav-pills .nav-link.active', '.nav-pills .show > .nav-link', '.dropdown-item.active', '.dropdown-item:active', '.btn-primary' ),
					),
				),
				array(
					'color' => array(
						'selector' => array( 'a', '.nav-link:hover', '#menu-widget .current-menu-item a', '#menu-footer .current-menu-item a' ),
					),
				),
			),
		),
		'banner-footer' => array(
			'accent' => array(
				array(
					'color' => array(
						'selector' => array( '.site-banner a' , '#site-footer a'),
					),
				),
			),
			'background' => array(
				array(
                    'background-color' => array(
						'selector' => array( '.site-banner', '#site-footer' ),
                    ),
				),
			),
			'text' => array(
				array(
					'color' => array(
						'selector' => array( '.site-banner', '#site-footer' ),
					),
				),
			),
		),
	);

	return $elements;
}

?>
