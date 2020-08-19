<?php
/**
 * DIY Marketer functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package DIY_Marketer
 */

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
	define( 'DIYM_VER', wp_get_theme()->get( 'Version' ) );
}

if ( ! function_exists( 'diym_setup' ) ) {
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function diym_setup() {
        
        // Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
            array(
                'default-color' => 'ffffff',
                'default-image' => ''
                //'default-image' => DIYM_IMG_URL . 'bg/pattern6.png',
            )
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
            'height'     => 80,
            'width'      => 80,
            'flex-width' => true,
            'flex-height' => false,
            'header-text' => array( '#site-banner' ),
		]);
		
		$mailer = new DIYM_Send_Mail();
    }
}

add_action('after_setup_theme', 'diym_setup');

/**
 * REQUIRED FILES
 * Include required files.
 */
require get_template_directory() . '/inc/template-tags.php';

// Handle Customizer settings.
require get_template_directory() . '/classes/class-diym-customize.php';

// Require Image Radio Control class.
require get_template_directory() . '/classes/class-diym-image-radio-control.php';

// Require Send Mail class.
require get_template_directory() . '/classes/class-diym-send-mail.php';

// Custom CSS.
require get_template_directory() . '/inc/custom-css.php';

/**
 * Customizer additions.
 */
//require get_template_directory() . '/inc/customizer.php';

/**
 * Register and Enqueue Styles.
 */
function diym_register_styles() {

	wp_enqueue_style( 'diym-style', get_template_directory_uri() . '/dist/assets/css/bundle.css', array( 'dashicons' ), DIYM_VER, 'all' );

	// Add output of Customizer settings as inline style.
	wp_add_inline_style( 'diym-style', diym_get_customizer_css( 'front-end' ) );
}

add_action( 'wp_enqueue_scripts', 'diym_register_styles' );

/**
 * Register and Enqueue Scripts.
 */
function diym_register_scripts() {
    
    wp_enqueue_script( 'diym-js', get_template_directory_uri() . '/dist/assets/js/bundle.js', array( 'jquery' ), DIYM_VER, true );
    wp_script_add_data( 'diym-js', 'async', true );
}

add_action( 'wp_enqueue_scripts', 'diym_register_scripts' );

function diym_admin_assets() {

    wp_enqueue_style( 'diym-admin-style', get_template_directory_uri() . '/dist/assets/css/admin.css', array(), DIYM_VER, 'all' );

    wp_enqueue_script( 'diym-admin-js', get_template_directory_uri() . '/dist/assets/js/admin.js', array(), DIYM_VER, true );
}

add_action('admin_enqueue_scripts', 'diym_admin_assets');

/**
 * Register navigation menus uses wp_nav_menu in two places.
 */
function diym_menus() {

	$locations = array(
        'primary' => esc_html__( 'Primary Menu', 'diy-marketer' ),
        'footer' => esc_html__( 'Footer Menu', 'diy-marketer' ),
	);

	register_nav_menus( $locations );
}

add_action( 'init', 'diym_menus' );

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

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 2', 'diy-marketer' ),
			'id'            => 'footer-2',
			'description'   => esc_html__( 'Add widgets here.', 'diy-maketer' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h5 class="widget-title">',
			'after_title'   => '</h5>',
		)
	);

}
add_action( 'widgets_init', 'diym_widgets_init' );

/**
 * Enqueues scripts for customizer controls & settings.
 *
 * @since Twenty Twenty 1.0
 *
 * @return void
 */
function diym_customize_controls_enqueue_scripts() {

	// Add script for controls.
	wp_enqueue_script( 'diym-customize-controls', get_template_directory_uri() . '/dist/assets/js/customize-controls.js', array( 'customize-controls', 'wp-color-picker', 'underscore' ), DIYM_VER, false );
	wp_localize_script( 'diym-customize-controls', 'diymBgColors', diym_get_customizer_color_vars() );

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

	wp_enqueue_script( 'diym-customize-preview', get_template_directory_uri() . '/dist/assets/js/customize-preview.js', array( 'customize-preview', 'underscore', 'jquery' ), DIYM_VER, true );
	wp_localize_script( 'diym-customize-preview', 'diymBgColors', diym_get_customizer_color_vars() );
	wp_localize_script( 'diym-customize-preview', 'diymPreviewEls', diym_get_elements_array() );

}

add_action( 'customize_preview_init', 'diym_customize_preview_init' );

function diym_excerpt_allowed_blocks( $allowed_blocks ) {
	
	$allowed_blocks = array(
        'core/paragraph',
        //'core/quote',
	);
	
	return $allowed_blocks;
}

add_filter( 'excerpt_allowed_blocks', 'diym_excerpt_allowed_blocks' );

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
			//'setting' => 'background_color',
			// hard code background color to white...
			'color' => '#ffffff'
		),
		'banner-footer' => array(
			'setting' => 'banner_footer_background_color',
		),
	);
	return $colors;
}

/**
 * Get accessible color for an area.
 *
 * @since Twenty Twenty 1.0
 *
 * @param string $area The area we want to get the colors for.
 * @param string $context Can be 'text' or 'accent'.
 * @return string Returns a HEX color.
 */
function diym_get_color_for_area( $area = 'content', $context = 'text', $shade = 0 ) {

	// Get the value from the theme-mod.
	$settings = get_theme_mod(
		'custom_colors',
		array(
			'content'       => array(
				'text'      => '#000000',
				//'accent'    => '#cd2653',
			),
			'banner-footer' => array(
				'text'      => '#000000',
				'accent'    => '#cd2653',
			),
		)
	);

	// If we have a value return it.
	if ( isset( $settings[ $area ] ) && isset( $settings[ $area ][ $context ] ) ) {

		if ( is_array( $settings[ $area ][ $context ] ) ) {
			if ( ! isset( $settings[ $area ][ $context ][ $shade ] ) ) {
				return false;
			}
			return $settings[ $area ][ $context ][ $shade ];
		} elseif ( $shade ) {
			return false;
		}
		
		return $settings[ $area ][ $context ];
	}

	// Return false if the option doesn't exist.
	return false;
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
				/*
				array(
					'border-color' => array(
						'selector' => array( '.border-primary' ),
						'suffix'	=> '!important',
					),
				),
				*/
				array(
					'border-color' => array(
						'selector' => array( '.navbar-nav .nav-item .nav-link:hover', '.border-primary' ),
						'suffix' => '!important'
					),
				),	
				array(
					'background-color' => array(
						//'selector' => array( '.nav-pills .nav-link.active', '.nav-pills .show > .nav-link', '.dropdown-item.active', '.dropdown-item:active', '.btn-primary' ),
						'selector' => array( '.nav-pills .nav-link.active', '.nav-pills .show > .nav-link' ),
					),
				),
				array(
					'color' => array(
						'selector' => array( '.nav-link', '.nav-link:hover' )
						//'selector' => array( 'a', '.nav-link:hover', '#menu-widget .current-menu-item a', '#menu-footer .current-menu-item a' ),
					)
				),
				/*
				array(
					'color' => array(
						'selector' => array( 'a', '.nav-link:hover', '#menu-widget .current-menu-item a', '#menu-footer .current-menu-item a' ),
					),
				),
				*/
			),
		),
		'banner-footer' => array(
			'accent' => array(
				array(
					'color' => array(
						'selector' => array( '.site-banner a', '#site-footer a' )
					)
				),
				array(
					'color' => array(
						'selector' => array( '.site-banner a:hover', '#site-footer a:hover' ),
						'shade' => 'link_hover'
					)
				),
				array(
					'background-color' => array(
						'selector' => array( '#site-footer .btn-primary')
					)
				),
				array(
					'border-color' => array(
						'selector' => array( '#site-footer .btn-primary')
					)
				),
				array(
					'border-color' => array(
						'selector' => array( '#site-footer .btn-primary:hover'),
						'shade' => 40
					)
				),
				array(
					'background-color' => array(
						'selector' => array( '#site-footer .btn-primary:hover'),
						'shade' => 43
					)
				),
				array(
					'box-shadow' => array(
						'selector' => array( '#site-footer .btn:focus','#site-footer .btn.focus' ),
						'rgb' => true,
						'prefix' => '0 0 0 0.2rem rgba(',
						'suffix' => ', 0.25)'
					)
				),
				array(
					'box-shadow' => array(
						'selector' => array( '#site-footer .btn-primary:focus','#site-footer .btn-primary.focus' ),
						'rgb' => true,
						'shade' => 57,
						'prefix' => '0 0 0 0.2rem rgba(',
						'suffix' => ', 0.5)'
					)
				),
				array(
					'border-color' => array(
						'selector' => array( '#site-footer .form-control:focus' ),
						'shade' => 75,
					)
				),
				array(
					'box-shadow' => array(
						'selector' => array( '#site-footer .form-control:focus' ),
						'rgb' => true,
						'prefix' => '0 0 0 0.2rem rgba(',
						'suffix' => ', 0.25)'
					)
				),
			),
			'background' => array(
				array(
                    'background-color' => array(
						'selector' => array( '#site-footer', '.site-banner' )
                    )
				)
			),
			'text' => array(
				array(
                    'color' => array(
						'selector' => array( '.site-banner', '#site-footer' )
                    )
				)
			)
		)
	);

	return $elements;
}

/**
 * Contact Details Widget
 */
require get_template_directory() . '/inc/widget-contact-details.php';

/**
 * Business Hours Widget
 */
require get_template_directory() . '/inc/widget-business-hours.php';

/**
 * Social Media Widget
 */
require get_template_directory() . '/inc/widget-social-media.php';

/**
 * Facebook Widget
 */
require get_template_directory() . '/inc/widget-facebook.php';

/**
 * Google Map Widget
 */
require get_template_directory() . '/inc/widget-google-map.php';

/**
 * Business Page Excerpt Widget
 */
require get_template_directory() . '/inc/widget-page-excerpt.php';

/**
 * Business Contact Form Widget
 */
require get_template_directory() . '/inc/widget-contact-form.php';

?>