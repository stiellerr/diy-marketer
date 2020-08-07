<?php
/**
 * DIY Marketer functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package DIY_Marketer
 */

error_log( 'hello world!' );

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
    }
}

add_action('after_setup_theme', 'diym_setup');



if ( ! defined( 'DIYM_VER' ) ) {
	// Replace the version number of the theme on each release.
	$theme_version = wp_get_theme()->get( 'Version' );
	define( 'DIYM_VER', $theme_version );
}

define( 'DIYM_URL', trailingslashit( get_template_directory_uri() ) );
define( 'DIYM_DIR', trailingslashit( get_template_directory() ) );

define( 'DIYM_CSS_URL', trailingslashit( DIYM_URL . 'dist/assets/css' ) );
define( 'DIYM_JS_URL', trailingslashit( DIYM_URL . 'dist/assets/js' ) );

/**
 * REQUIRED FILES
 * Include required files.
 */

// Handle Customizer settings.
require get_template_directory() . '/classes/class-diym-customize.php';

// Custom CSS.
require get_template_directory() . '/inc/custom-css.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

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
 * Register and Enqueue Scripts.
 */
function diym_register_scripts() {

	$theme_version = wp_get_theme()->get( 'Version' );

	//if ( ( ! is_admin() ) && is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		//wp_enqueue_script( 'comment-reply' );
    //}
    
    wp_enqueue_script( 'diym-js', get_template_directory_uri() . '/dist/assets/js/bundle.js', array( 'jquery' ), $theme_version, true );
    wp_script_add_data( 'diym-js', 'async', true );

	//wp_enqueue_script( 'twentytwenty-js', get_template_directory_uri() . '/assets/js/index.js', array(), $theme_version, false );
    
    //$wp_scripts()->add_data( 'diym-js', 'async', true );
    //error_log( 'hello!' );

}

add_action( 'wp_enqueue_scripts', 'diym_register_scripts' );

function diym_admin_assets() {
    //
    wp_enqueue_style( 'diym-admin-style', DIYM_CSS_URL . 'admin.css', array(), DIYM_VER, 'all' );

    wp_enqueue_script( 'diym-admin-js', DIYM_JS_URL . 'admin.js', array(), DIYM_VER, true );
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
}
add_action( 'widgets_init', 'diym_widgets_init' );

/**
 * Add boostrap classes to menu elements.
 */
function diym_nav_menu_css_class( $classes, $item, $args, $depth ) {

	if ( $args->theme_location == 'primary' ) {
		$classes[] = 'nav-item';
		if ( in_array( 'menu-item-has-children', $classes ) ) {
			$classes[] = 'dropdown';
		}
	}
	return $classes;
}

add_filter( 'nav_menu_css_class', 'diym_nav_menu_css_class', 10, 4 );

function diym_nav_menu_link_attributes($atts, $item, $args, $depth) {

	if ( $args->theme_location == 'primary' ) {

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
	if ( $args->theme_location == 'primary' ) {
		$classes[] = 'dropdown-menu';
	}
	return $classes;
}

add_filter( 'nav_menu_submenu_css_class', 'diym_nav_menu_submenu_css_class', 10, 3 );



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
	//wp_localize_script( 'diym-customize-controls', 'diymBackgroudColors', diym_get_customizer_color_vars() );

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
 * Get accessible color for an area.
 *
 * @since Twenty Twenty 1.0
 *
 * @param string $area The area we want to get the colors for.
 * @param string $context Can be 'text' or 'accent'.
 * @return string Returns a HEX color.
 */
function diym_get_color_for_area( $area = 'content', $context = 'text', $index = 0 ) {

	// Get the value from the theme-mod.
	$settings = get_theme_mod(
		'custom_colors',
		array(
			'content'       => array(
				'text'      => '#000000',
				'accent'    => '#cd2653',
				'test'    => array(
					7.0 => '#1',
					7.5 => '#2',
					8.0 => '#3',
				),
				//'secondary' => '#6d6d6d',
				//'borders'   => '#dcd7ca',
			),
			'banner-footer' => array(
				'text'      => '#000000',
				'accent'    => '#cd2653',
				//'secondary' => '#6d6d6d',
				//'borders'   => '#dcd7ca',
			),
		)
	);

	//
	//error_log( $area );
	//error_log( $context );

	// If we have a value return it.
	if ( isset( $settings[ $area ] ) && isset( $settings[ $area ][ $context ] ) ) {

		error_log( $area );
		error_log( $context );
		// Check if subkey exists
		if ( is_array( $settings[ $area ][ $context ] ) ) {
			//error_log('true');
			return $settings[ $area ][ $context ][ $index ];
		} else {
			//error_log('false');
			return $settings[ $area ][ $context ];
		}
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
				*/
			),
		),
		'banner-footer' => array(
			'accent' => array(
				array(
					'background-color' => array(
						'selector' => array( '#site-footer .btn-primary')
					)
				),
				array(
					'border-color' => array(
						'selector' => array( '#site-footer .btn-primary')
					)
				)
			),
			'accent' => array(
				array(
					'border-color' => array(
						'selector' => array( '#site-footer .btn-primary:hover'),
						'rgb' => true,
						'prefix' => 'rgba(',
						'suffix' => ', 0.5)',
					)
				)
			),
			'accent_43' => array(
				array(
					'background-color' => array(
						'selector' => array( '#site-footer .btn-primary:hover')
					)
				)
			),
			'accentRgb' => array(
				array(
					'box-shadow' => array(
						'selector' => array( '#site-footer .btn:focus', '#site-footer .btn.focus', '#site-footer .form-control:focus' ),
						'prefix' => '0 0 0 0.2rem rgba(',
						'suffix' => ', 0.25)',
					)
				)
			),
			'background' => array(
				array(
                    'background-color' => array(
						'selector' => array( '#site-footer' )
                    )
				),
				array(
                    'color' => array(
						'selector' => array( '#site-footer .btn-primary' )
                    )
				)
			),
			/*
			'accent' => array(
				array(
					'color' => array(
						'selector' => array( '.site-banner a' , '#site-footer a'),
					),
				),
			),
			'accentLight' => array(
				array(
					'border-color' => array(
						'selector' => array( '.form-control:focus' ),
					),
				),
			),
			//
			'accentRgb' => array(
				array(
					'box-shadow' => array(
						'selector' => array( '.form-control:focus', '.btn:focus', '.btn.focus' ),
						'prefix' => '0 0 0 0.2rem rgba(',
						'suffix' => ', 0.25)',
					),
				),
			),
			'accentDark' => array(
				array(
					'background-color' => array(
						'selector' => array( '.btn-primary:hover' ),
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
			*/
		),
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

//error_log( 'color for area' );
//error_log( diym_get_color_for_area( 'content', 'test' ) );


//error_log( 'custom_colors' );
//			error_log( print_r( get_theme_mod( 'custom_colors' ), true ) );

			?>