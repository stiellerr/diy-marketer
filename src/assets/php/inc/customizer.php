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
	
    $wp_customize->add_section('diym_typography', array(
        'title' => esc_html__( 'Typography', 'diy-marketer' ),
        'description' => esc_html__( 'Select you typograpghy settings from the fields below.', 'diy-marketer' ),
        //'priority' => 1
	));
	
    $wp_customize->add_setting('diym_font_select', array(
        'default' => 'Arial',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh'
	));
	
    $wp_customize->add_control('diym_font_select', array(
        'type' => 'select',
		'label' => esc_html__( 'Font Select', 'diy-marketer' ),
		'description' => esc_html__( 'Choose your web site, page font below...', 'diy-marketer' ),
		'section' => 'diym_typography',
		'choices'        => array(
			// Sans Serif
			'Arial,"Helvetica Neue",Helvetica,sans-serif' => 'Arial',
			'"Arial Black","Arial Bold",Gadget,sans-serif' => 'Arial Black',
			'Calibri,Candara,Segoe,"Segoe UI",Optima,Arial,sans-serif' => 'Calibri',
			'Candara,Calibri,Segoe,"Segoe UI",Optima,Arial,sans-serif' => 'Candara',
			//'"Century Gothic",CenturyGothic,AppleGothic,sans-serif' => 'Century Gothic',
			'"Franklin Gothic Medium","Franklin Gothic","ITC Franklin Gothic",Arial,sans-serif' => "Franklin Gothic Medium",
			'Impact,Charcoal,sans-serif' =>'Impact',
			'"Lucida Grande","Lucida Sans Unicode","Lucida Sans",Geneva,Verdana,sans-serif' => 'Lucida Grande',
			'"Segoe UI",Frutiger,"Frutiger Linotype","Dejavu Sans","Helvetica Neue",Arial,sans-serif' => 'Segoe UI',
			'Tahoma,Verdana,Segoe,sans-serif' => 'Tahoma',//			
			'"Trebuchet MS","Lucida Grande","Lucida Sans Unicode","Lucida Sans",Tahoma,sans-serif' => 'Trebuchet MS',//	
			'Verdana,Geneva,sans-serif' => 'Verdana',//			
			
			// Serif
			'Cambria,Georgia,serif' => 'Cambria',
			'Georgia,Times,"Times New Roman",serif' => 'Georgia',
			'Palatino,"Palatino Linotype","Palatino LT STD","Book Antiqua",Georgia,serif' => 'Palatino',
			'TimesNewRoman,"Times New Roman",Times,Baskerville,Georgia,serif' => 'Times New Roman',

			// Monospaced
			'Consolas,monaco,monospace' => 'Consolas',
			'"Courier New",Courier,"Lucida Sans Typewriter","Lucida Typewriter",monospace' => 'Courier New',			
			'"Lucida Console","Lucida Sans Typewriter",monaco,"Bitstream Vera Sans Mono",monospace' =>'Lucida Console',

			// Script
			'"Comic Sans MS","Comic Sans",cursive,sans-serif' => 'Comic Sans MS',
		)
	));
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
//require_once DIYM_DIR . 'inc/custom-controls.php';

/**
 * End of file.
 */
?>