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

    $wp_customize->add_setting('diym_font_select', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh'
	));
	
    $wp_customize->add_control('diym_font_select', array(
        'type' => 'select',
		'label' => esc_html__( 'Font Select', 'diy-marketer' ),
		'description' => esc_html__( 'All Fonts are sorted alphabetically', 'diy-marketer' ),
		'section' => 'diym_test',
		'choices'        => array(
			'"Andale Mono",AndaleMono,monospace' => 'Andale Mono',
			'Arial,"Helvetica Neue",Helvetica,sans-serif' => 'Arial',
			'"Arial Black","Arial Bold",Gadget,sans-serif' => 'Arial Black',
			'"Arial Narrow",Arial,sans-serif' => 'Arial Narrow',
			'"Arial Rounded MT Bold","Helvetica Rounded",Arial,sans-serif' => 'Arial Rounded MT Bold',
			'"Big Caslon","Book Antiqua","Palatino Linotype",Georgia,serif' => 'Big Caslon',
			'"Bodoni MT",Didot,"Didot LT STD","Hoefler Text",Garamond,"Times New Roman",serif' => 'Bodoni MT',			
			'"Bookman Old Style",serif' => 'Bookman Old Style',
			'"Brush Script MT", cursive' => 'Brush Script MT',
			'Calibri,Candara,Segoe,"Segoe UI",Optima,Arial,sans-serif' => 'Calibri',
			'"Calisto MT","Bookman Old Style",Bookman,"Goudy Old Style",Garamond,"Hoefler Text","Bitstream Charter",Georgia,serif' => 'Calisto MT',
			'Cambria, Georgia, serif' => 'Cambria',
			'Candara,Calibri,Segoe,"Segoe UI",Optima,Arial,sans-serif' => 'Candara',
			'"Century Gothic",CenturyGothic,AppleGothic,sans-serif' => 'Century Gothic',
			'"Comic Sans MS",cursive,sans-serif' => 'Comic Sans MS',
			'Consolas, monaco, monospace' => 'Consolas',
			'Copperplate, "Copperplate Gothic Light", fantasy' => 'Copperplate',
			'"Courier New", Courier, "Lucida Sans Typewriter", "Lucida Typewriter", monospace' => 'Courier New',
			'Didot, "Didot LT STD", "Hoefler Text", "Garamond", "Times New Roman", serif' => 'Didot',
			'"Franklin Gothic Medium","Franklin Gothic","ITC Franklin Gothic",Arial,sans-serif' => "Franklin Gothic Medium",
			'Futura,"Trebuchet MS",Arial,sans-serif' => 'Futura',
			'Garamond, Baskerville, "Baskerville Old Face", "Hoefler Text", "Times New Roman", serif' => 'Garamond',
			'Geneva,Tahoma,Verdana,sans-serif' => 'Geneva',
			'Georgia, Times,"Times New Roman", serif' => 'Georgia',
			'"Gill Sans","Gill Sans MT",Calibri,sans-serif' => 'Gill Sans',			
			'"Helvetica Neue", Helvetica, Arial, sans-serif' => 'Helvetica',
			'Impact,Charcoal,sans-serif' =>'Impact',
			'"Lucida Bright",Georgia,serif' => 'Lucida Bright',
			'"Lucida Console", "Lucida Sans Typewriter", monaco, ""Bitstream Vera Sans Mono", monospace' =>'Lucida Console',
			'"Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Geneva, Verdana, sans-serif' => 'Lucida Grande',			
			'"Lucida Sans Typewriter","Lucida Console",monaco,"Bitstream Vera Sans Mono",monospace' => 'Lucida Sans Typewriter',
			'"Lucida Sans Unicode","Lucida Grande",sans-serif' => 'Lucida Sans Unicode',
			'monaco,Consolas,"Lucida Console",monospace' => 'monaco',
			'"MS Sans Serif",Geneva,sans-serif' =>'MS Sans Serif',
			'"MS Serif","New York",sans-serif' =>'MS Serif',
			'Optima,Segoe,"Segoe UI",Candara,Calibri,Arial,sans-serif' => 'Optima',
			'Palatino,"Palatino Linotype","Palatino LT STD","Book Antiqua",Georgia,serif' => 'Palatino',
			'Papyrus,fantasy' => 'Papyrus',
			'Perpetua, Baskerville, Big Caslon, "Palatino Linotype", Palatino, "URW Palladio L", "Nimbus Roman No9 L", serif'=>'Perpetua',
			'Rockwell, "Courier Bold", Courier, Georgia, Times, "Times New Roman", serif' => 'Rockwell',
			'"Rockwell Extra Bold","Rockwell Bold",monospace' => 'Rockwell Extra Bold',
			'"Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif' => 'Segoe UI',
			'Tahoma, Verdana,Segoe, sans-serif' => 'Tahoma',
			'TimesNewRoman, "Times New Roman", Times, Baskerville, Georgia, serif' => 'Times New Roman',			
			'"Trebuchet MS","Lucida Grande","Lucida Sans Unicode","Lucida Sans",Tahoma,sans-serif' => 'Trebuchet MS',
			'Verdana,Geneva,sans-serif' => 'Verdana',	
		)
	));

/*
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
				
			)
		) );
*/
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