<?php
/**
 * DIY Marketer Theme Customizer
 *
 * @package DIY_Marketer HELLO WORLD2
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function diym_customize_register( $wp_customize ) {

	
    $wp_customize->add_setting('diym_phone_number', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage'
	));
	
    $wp_customize->add_control('diym_phone_number', array(
        'type' => 'text',
        'label' => esc_html__( 'Phone Number', 'diy-marketer' ),
        'section' => 'title_tagline',
    ));
	
    $wp_customize->add_section('diym_test', array(
        'title' => esc_html__( 'Test', 'diy-marketer' ),
        'description' => esc_html__( 'Enter your social media information below.', 'diym' ),
        //'priority' => 1
	));
	
    $wp_customize->add_setting('diym_phone_number2', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage'
	));
	
    $wp_customize->add_control('diym_phone_number2', array(
        'type' => 'text',
        'label' => esc_html__( 'Phone Number', 'diy-marketer' ),
        'section' => 'diym_test',
	));

    $wp_customize->add_setting('diym_phone_number3', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage'
	));
	
    $wp_customize->add_control('diym_phone_number3', array(
        'type' => 'select',
        'label' => esc_html__( 'Phone Number', 'diy-marketer' ),
		'section' => 'diym_test',
		'choices'        => array(
			'dark'   => __( 'Dark' ),
			'light'  => __( 'Light' )
		)
	));



		// Test of Google Font Select Control
		$wp_customize->add_setting( 'diym_google_font_select2',
			array(
				//'default' => $this->defaults['sample_google_font_select'],
				//'sanitize_callback' => 'skyrocket_google_font_sanitization',
				'transport' => 'refresh',
			)
		);
		$wp_customize->add_control( new DIYM_Google_Font_Select2( $wp_customize, 'diym_google_font_select2',
			array(
				'label' => __( 'Google Font Control', 'skyrocket' ),
				'description' => esc_html__( 'All Google Fonts sorted alphabeticall', 'skyrocket' ),
				'section' => 'diym_test',
				/*
				'input_attrs' => array(
					'font_count' => 'all',
					'orderby' => 'alpha',
				),
				*/
			)
		) );

	/*
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'underscores_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'underscores_customize_partial_blogdescription',
			)
		);
	}
	*/
}
add_action( 'customize_register', 'diym_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
/*
function underscores_customize_partial_blogname() {
	bloginfo( 'name' );
}
*/
/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
/*
function underscores_customize_partial_blogdescription() {
	bloginfo( 'description' );
}
*/
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function diym_customize_preview_js() {
	wp_enqueue_script( 'diym-customizer-preview', DIYM_JS_URL . 'customizer-preview.js', ['customize-preview', 'jquery'], DIYM_VER, true );
}
add_action( 'customize_preview_init', 'diym_customize_preview_js' );

/**
 * Load all our Customizer Custom Controls
 */
require_once DIYM_DIR . 'inc/custom-controls.php';

/**
 * End of file.
 */
?>