<?php
/**
 * DIY Marketer functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package DIY_Marketer
 */

 // useful function for witing to the log

write_log('sss');


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
	wp_enqueue_script( 'diym-color-calculations', DIYM_JS_URL . 'color-calculations.js', array( 'wp-color-picker' ), DIYM_VER, false );

	// Add script for controls.
	wp_enqueue_script( 'diym-customize-controls', DIYM_JS_URL . 'customize-controls.js', array( 'diym-color-calculations', 'customize-controls', 'underscore', 'jquery' ), DIYM_VER, false );
	//wp_enqueue_script( 'diym-customize-controls', DIYM_JS_URL . 'customize-controls.js', array( 'customize-controls', 'underscore', 'jquery' ), DIYM_VER, false );
	wp_localize_script( 'diym-customize-controls', 'diymBgColors', diym_get_customizer_color_vars() );

}

add_action( 'customize_controls_enqueue_scripts', 'diym_customize_controls_enqueue_scripts' );

/*
function diym_assets() {
	wp_enqueue_style('diym-stylesheet', DIYM_CSS_URL . 'bundle.css', array('dashicons'), DIYM_VER, 'all');

	require DIYM_DIR . 'inc/inline-css.php';
	
	wp_add_inline_style('diym-stylesheet', $diym_inline_styles);

    wp_enqueue_script('diym-scripts', DIYM_JS_URL . 'bundle.js', array('jquery'), DIYM_VER, true);
}
*/

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
		),
		'header-footer' => array(
			'setting' => 'header_footer_background_color',
		),
	);
	return $colors;
}


?>
