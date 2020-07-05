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
				'menu-3' => esc_html__( 'Widget', 'diy-marketer' ),
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
			'name'          => esc_html__( 'Sidebar', 'diy-marketer' ),
			'id'            => 'sidebar-1',
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

		if ( in_array( 'menu-item-has-children', $item->classes ) ) {
	
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

?>
