<?php
/**
 * DIY Marketer functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package DIY_Marketer
 */

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


/*
function diym_assets() {
	wp_enqueue_style('diym-stylesheet', DIYM_CSS_URL . 'bundle.css', array('dashicons'), DIYM_VER, 'all');

	require DIYM_DIR . 'inc/inline-css.php';
	
	wp_add_inline_style('diym-stylesheet', $diym_inline_styles);

    wp_enqueue_script('diym-scripts', DIYM_JS_URL . 'bundle.js', array('jquery'), DIYM_VER, true);
}
*/

/**
 * Get accessible color for an area.
 *
 * @since Twenty Twenty 1.0
 *
 * @param string $area The area we want to get the colors for.
 * @param string $context Can be 'text' or 'accent'.
 * @return string Returns a HEX color.
 */
function diym_get_color_for_area( $area = 'content', $context = 'text' ) {

	// Get the value from the theme-mod.
	$settings = get_theme_mod(
		'accent_accessible_colors',
		array(
			'content'       => array(
				'text'      => '#000000',
				'accent'    => '#cd2653',
				'secondary' => '#6d6d6d',
				'borders'   => '#dcd7ca',
			),
			'header-footer' => array(
				'text'      => '#000000',
				'accent'    => '#cd2653',
				'secondary' => '#6d6d6d',
				'borders'   => '#dcd7ca',
			),
		)
	);

	// If we have a value return it.
	if ( isset( $settings[ $area ] ) && isset( $settings[ $area ][ $context ] ) ) {
		return $settings[ $area ][ $context ];
	}

	// Return false if the option doesn't exist.
	return false;
}

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
function diym_get_elements_array2() {

	// The array is formatted like this:
	// [key-in-saved-setting][sub-key-in-setting][css-property] = [elements].
	$elements = array(
		'content'       => array(
			'accent'     => array(
				//'color'            => array( '.color-accent', '.color-accent-hover:hover', '.color-accent-hover:focus', ':root .has-accent-color', '.has-drop-cap:not(:focus):first-letter', '.wp-block-button.is-style-outline', 'a' ),
				//'border-color'     => array( 'blockquote', '.border-color-accent', '.border-color-accent-hover:hover', '.border-color-accent-hover:focus' ),
				//'background-color' => array( 'button:not(.toggle)', '.button', '.faux-button', '.wp-block-button__link', '.wp-block-file .wp-block-file__button', 'input[type="button"]', 'input[type="reset"]', 'input[type="submit"]', '.bg-accent', '.bg-accent-hover:hover', '.bg-accent-hover:focus', ':root .has-accent-background-color', '.comment-reply-link' ),
				//'fill'             => array( '.fill-children-accent', '.fill-children-accent *' ),
			),
			/*
			'accent'     => array(
				array( 
					'color' => array( '.color-accent', '.color-accent-hover:hover', '.color-accent-hover:focus', ':root .has-accent-color', '.has-drop-cap:not(:focus):first-letter', '.wp-block-button.is-style-outline', 'a' ),
					'prefix' => '',
					'suffix' => '',
			),
			*/
			'background' => array(
				//'color'            => array( ':root .has-background-color', 'button', '.button', '.faux-button', '.wp-block-button__link', '.wp-block-file__button', 'input[type="button"]', 'input[type="reset"]', 'input[type="submit"]', '.wp-block-button', '.comment-reply-link', '.has-background.has-primary-background-color:not(.has-text-color)', '.has-background.has-primary-background-color *:not(.has-text-color)', '.has-background.has-accent-background-color:not(.has-text-color)', '.has-background.has-accent-background-color *:not(.has-text-color)' ),
				//'background-color' => array( ':root .has-background-background-color' ),
			),
			'text'       => array(
				//'color'            => array( 'body', '.entry-title a', ':root .has-primary-color' ),
				//'background-color' => array( ':root .has-primary-background-color' ),
			),
			'secondary'  => array(
				//'color'            => array( 'cite', 'figcaption', '.wp-caption-text', '.post-meta', '.entry-content .wp-block-archives li', '.entry-content .wp-block-categories li', '.entry-content .wp-block-latest-posts li', '.wp-block-latest-comments__comment-date', '.wp-block-latest-posts__post-date', '.wp-block-embed figcaption', '.wp-block-image figcaption', '.wp-block-pullquote cite', '.comment-metadata', '.comment-respond .comment-notes', '.comment-respond .logged-in-as', '.pagination .dots', '.entry-content hr:not(.has-background)', 'hr.styled-separator', ':root .has-secondary-color' ),
				//'background-color' => array( ':root .has-secondary-background-color' ),
			),
			'borders'    => array(
				//'border-color'        => array( 'pre', 'fieldset', 'input', 'textarea', 'table', 'table *', 'hr' ),
				//'background-color'    => array( 'caption', 'code', 'code', 'kbd', 'samp', '.wp-block-table.is-style-stripes tbody tr:nth-child(odd)', ':root .has-subtle-background-background-color' ),
				//'border-bottom-color' => array( '.wp-block-table.is-style-stripes' ),
				//'border-top-color'    => array( '.wp-block-latest-posts.is-grid li' ),
				//'color'               => array( ':root .has-subtle-background-color' ),
			),
		),
		'header-footer' => array(
			'accent'     => array(
				//'color'            => array( 'body:not(.overlay-header) .primary-menu > li > a', 'body:not(.overlay-header) .primary-menu > li > .icon', '.modal-menu a', '.footer-menu a, .footer-widgets a', '#site-footer .wp-block-button.is-style-outline', '.wp-block-pullquote:before', '.singular:not(.overlay-header) .entry-header a', '.archive-header a', '.header-footer-group .color-accent', '.header-footer-group .color-accent-hover:hover' ),
				'color'			   => array( '.site-banner a' , '#site-footer a'),
				//'background-color' => array( '.social-icons a', '#site-footer button:not(.toggle)', '#site-footer .button', '#site-footer .faux-button', '#site-footer .wp-block-button__link', '#site-footer .wp-block-file__button', '#site-footer input[type="button"]', '#site-footer input[type="reset"]', '#site-footer input[type="submit"]' ),
				'border-color'		=> array( '.border-accent' ),
			),
			'background' => array(
				//'color'            => array( '.social-icons a', 'body:not(.overlay-header) .primary-menu ul', '.header-footer-group button', '.header-footer-group .button', '.header-footer-group .faux-button', '.header-footer-group .wp-block-button:not(.is-style-outline) .wp-block-button__link', '.header-footer-group .wp-block-file__button', '.header-footer-group input[type="button"]', '.header-footer-group input[type="reset"]', '.header-footer-group input[type="submit"]' ),
				//'background-color' => array( '#site-header', '.footer-nav-widgets-wrapper', '#site-footer', '.menu-modal', '.menu-modal-inner', '.search-modal-inner', '.archive-header', '.singular .entry-header', '.singular .featured-media:before', '.wp-block-pullquote:before' ),
				'background-color' => array( '.site-banner' ),
				'background-color' => array( '#site-footer' ),
			),
			'text'       => array(
				//'color'               => array( '.header-footer-group', 'body:not(.overlay-header) #site-header .toggle', '.menu-modal .toggle' ),
				'color' => array( '.site-banner' , '#site-footer'),
				//'background-color'    => array( 'body:not(.overlay-header) .primary-menu ul' ),
				//'border-bottom-color' => array( 'body:not(.overlay-header) .primary-menu > li > ul:after' ),
				//'border-left-color'   => array( 'body:not(.overlay-header) .primary-menu ul ul:after' ),
			),
			'secondary'  => array(
				//'color' => array( '.site-description', 'body:not(.overlay-header) .toggle-inner .toggle-text', '.widget .post-date', '.widget .rss-date', '.widget_archive li', '.widget_categories li', '.widget cite', '.widget_pages li', '.widget_meta li', '.widget_nav_menu li', '.powered-by-wordpress', '.to-the-top', '.singular .entry-header .post-meta', '.singular:not(.overlay-header) .entry-header .post-meta a' ),
			),
			'borders'    => array(
				//'border-color'     => array( '.header-footer-group pre', '.header-footer-group fieldset', '.header-footer-group input', '.header-footer-group textarea', '.header-footer-group table', '.header-footer-group table *', '.footer-nav-widgets-wrapper', '#site-footer', '.menu-modal nav *', '.footer-widgets-outer-wrapper', '.footer-top' ),
				//'background-color' => array( '.header-footer-group table caption', 'body:not(.overlay-header) .header-inner .toggle-wrapper::before' ),
			),
		),
	);
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
						//'selector' => array( 'navbar-nav .nav-item .nav-link:hover', '.btn-primary' ),
						//'suffix'	=> '!important',
					),
				),
				array(
					'background-color' => array(
						'selector' => array( '.nav-pills .nav-link.active', '.nav-pills .show > .nav-link', '.dropdown-item.active', '.dropdown-item:active', 'btn-primary' ),
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
						'selector' => array( '.site-banner' ),
                    ),
				),
				array(
                    'background-color' => array(
                    	'selector' => array( '#site-footer' ),
                        //'suffix'=> '!important',
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
		/*
		'header-footer' => array(
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
						'selector' => array( '.site-banner' ),
                    ),
				),
				array(
                    'background-color' => array(
                    	'selector' => array( '#site-footer' ),
                        //'suffix'=> '!important',
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
		*/
	);

	return $elements;
}


?>
