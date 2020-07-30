<?php
/**
 * DIY Marketer Theme Customizer
 *
 * @package DIY_Marketer
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function diym_customize_register( $wp_customize ) {

	$wp_customize->get_setting('blogdescription')->transport = 'postMessage';

	$wp_customize->get_setting('blogname')->transport = 'postMessage';

	// Contact Details.
    $wp_customize->add_section('diym_contact_details', array(
        'title' => esc_html__( 'Contact Details', 'diy-marketer' ),
        'description' => esc_html__( "Enter your business' contact details below.", 'diy-marketer' ),
        //'priority' => 1
	));

    $wp_customize->add_setting( 'diym_business_name' );

    $wp_customize->add_control('diym_business_name', array(
        'type' => 'text',
		'label' => esc_html__( 'Business Name', 'diy-marketer' ),
		'description' => sprintf(
			wp_kses(
				__( 'edit <a href="%s">here</a> under Site Title.', 'diy-marketer' ),
				array(
					'a' => array(
						'href' => array(),
					)
				)
			),
			'javascript: wp.customize.section( \'title_tagline\' ).focus();'
		),
		'section' => 'diym_contact_details',
		'input_attrs' => array(
			'placeholder' => get_bloginfo( 'name' ),
			'readonly' => true
		 ),
	));

    $wp_customize->add_setting('diym_street_address', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage'
	));
	
    $wp_customize->add_control('diym_street_address', array(
        'type' => 'text',
        'label' => esc_html__( 'Street Address', 'diy-marketer' ),
        'section' => 'diym_contact_details',
	));

    $wp_customize->add_setting('diym_suburb', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage'
	));
	
    $wp_customize->add_control('diym_suburb', array(
        'type' => 'text',
        'label' => esc_html__( 'Suburb', 'diy-marketer' ),
        'section' => 'diym_contact_details',
	));

    $wp_customize->add_setting('diym_city', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage'
	));
	
    $wp_customize->add_control('diym_city', array(
        'type' => 'text',
        'label' => esc_html__( 'City', 'diy-marketer' ),
        'section' => 'diym_contact_details',
    ));
	
    $wp_customize->add_setting('diym_postal_code', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage'
	));
	
    $wp_customize->add_control('diym_postal_code', array(
        'type' => 'text',
        'label' => esc_html__( 'Postal Code', 'diy-marketer' ),
        'section' => 'diym_contact_details',
    ));
	
    $wp_customize->add_setting('diym_phone_number', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage'
	));
	
    $wp_customize->add_control('diym_phone_number', array(
        'type' => 'text',
        'label' => esc_html__( 'Phone Number', 'diy-marketer' ),
        'section' => 'diym_contact_details',
	));
	
    $wp_customize->add_setting( 'diym_email' );

    $wp_customize->add_control('diym_email', array(
        'type' => 'text',
		'label' => esc_html__( 'Email', 'diy-marketer' ),
		'description' => wp_kses(
			__( 'edit <a href="options-general.php">here</a> under Administration Email Address.', 'diy-marketer' ),
			array(
				'a' => array(
					'href' => array(),
				)
			)
		),
		'section' => 'diym_contact_details',
		'input_attrs' => array(
			'placeholder' => get_bloginfo( 'admin_email' ),
			'readonly' => true
		 ),
	));

    $wp_customize->add_setting( 'diym_website' );

    $wp_customize->add_control('diym_website', array(
        'type' => 'text',
		'label' => esc_html__( 'Website URL', 'diy-marketer' ),
		'description' => wp_kses(
			__( 'edit <a href="options-general.php">here</a> under Site Address (URL).', 'diy-marketer' ),
			array(
				'a' => array(
					'href' => array(),
				)
			)
		),
		'section' => 'diym_contact_details',
		'input_attrs' => array(
			'placeholder' => get_bloginfo( 'url' ),
			'readonly' => true
		 ),
	));

	function diym_sanitize_google_map( $input ) {
		$allowed = array(
			'iframe' => array(
				'src'				=> array(),
				'frameborder'		=> array(),
				'style'				=> array(),
				'allowfullscreen'	=> array(),
				'aria-hidden'		=> array(),
				'tabindex'			=> array()
			)
		);
		return wp_kses( $input, $allowed );
	}

    $wp_customize->add_setting('diym_google_map', array(
        'default' => '',
        'sanitize_callback' => 'diym_sanitize_google_map',
        'transport' => 'postMessage'
	));
	
    $wp_customize->add_control('diym_google_map', array(
        'type' => 'text',
		'label' => esc_html__( 'Google Map', 'diy-marketer' ),
		'description' => esc_html__( 'HTML embed code.', 'diy-marketer' ),
        'section' => 'diym_contact_details',
	));
/*
    $wp_customize->selective_refresh->add_partial('diym_google_map', array(
        'settings' => array(
            'diym_google_map',
			//'diym_twitter',
            //'diym_facebook'
        ),
        'selector' => '.widget_diym_google_map > iframe',
        'container_inclusive'=> true,
        'render_callback' => function() {
			$diym_google_map = get_theme_mod( 'diym_google_map', '' );
			echo diym_sanitize_google_map( $diym_google_map );
		},
		'fallback_refresh' => false
	));
*/
	
    $wp_customize->add_section('diym_typography', array(
        'title' => esc_html__( 'Typography', 'diy-marketer' ),
        'description' => esc_html__( 'Select you typograpghy settings from the fields below.', 'diy-marketer' ),
        //'priority' => 1
	));
	
    $wp_customize->add_setting('diym_font_select', array(
        'default' => 'default',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage'
	));
	
    $wp_customize->add_control('diym_font_select', array(
        'type' => 'select',
		'label' => esc_html__( 'Font Select', 'diy-marketer' ),
		'description' => esc_html__( 'Choose your web site, page font below...', 'diy-marketer' ),
		'section' => 'diym_typography',
		'choices'        => array(
			'default' => 'Default',
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

    $wp_customize->selective_refresh->add_partial('diym_instagram', array(
        'settings' => array(
            'diym_instagram',
			'diym_twitter',
            //'diym_facebook'
        ),
        'selector' => '.site-socials',
        'container_inclusive'=> true,
        'render_callback' => function() {
            get_template_part( 'template-parts/socials' );
        }
	));

    $wp_customize->selective_refresh->add_partial('diym_phone_number', array(
        'settings' => array(
			'blogname',
            'diym_street_address',
			'diym_suburb',
			'diym_city',
			'diym_postal_code',
			'diym_phone_number'
        ),
        'selector' => '.contact-details',
        'container_inclusive'=> true,
        'render_callback' => function() {
            get_template_part( 'template-parts/contact-details' );
        }
	));
	
	// social media //
    $wp_customize->add_section('diym_social', array(
        'title' => esc_html__( 'Social Media', 'diy-marketer' ),
        'description' => esc_html__( 'Enter your social media details below.', 'diy-marketer' ),
        //'priority' => 1
	));

    $wp_customize->add_setting('diym_facebook', array(
    	'default' => 'facebook.com/facebook',
        'sanitize_callback' => 'esc_url_raw',
		//'transport' => 'postMessage'
		//'transport' => is_active_widget( false, false, 'diym_facebook', true ) ? 'refresh' : 'postMessage'
	));
	
    $wp_customize->add_control('diym_facebook', array(
        'type' => 'url',
		'label' => esc_html__( 'Facebook url', 'diy-marketer' ),
		'description' => esc_html__( 'Enter you facebook url below...', 'diy-marketer' ),
		'section' => 'diym_social',
	));

    $wp_customize->add_setting('diym_instagram', array(
    	'default' => 'instagram.com/instagram',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'postMessage'
	));
	
    $wp_customize->add_control('diym_instagram', array(
        'type' => 'url',
		'label' => esc_html__( 'Instagram url', 'diy-marketer' ),
		'description' => esc_html__( 'Enter you instagram url below...', 'diy-marketer' ),
		'section' => 'diym_social',
	));

    $wp_customize->add_setting('diym_twitter', array(
    	'default' => 'twitter.com/twitter',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'postMessage'
	));
	
    $wp_customize->add_control('diym_twitter', array(
        'type' => 'url',
		'label' => esc_html__( 'Twitter url', 'diy-marketer' ),
		'description' => esc_html__( 'Enter you twitter url below...', 'diy-marketer' ),
		'section' => 'diym_social',
	));

	// Banner & Footer Background Color.
    $wp_customize->add_setting(
		'diym_banner_footer_bg',
		array(
			'default' => '#343a40',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' => 'postMessage'
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'diym_banner_footer_bg',
			array(
				'label' => __( 'Banner & Footer Background Colour', 'diy-marketer' ),
				'section' => 'colors',
			)
		)
	);

	// Header & Footer Text Color.
    $wp_customize->add_setting(
		'diym_banner_footer_text',
		array(
			'default' => '#fff',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport' => 'postMessage'
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'diym_banner_footer_text',
			array(
				'label' => __( 'Banner & Footer Text Colour', 'diy-marketer' ),
				'section' => 'colors',
			)
		)
	);

	// Theme Primary Color.
    $wp_customize->add_setting('diym_primary_color', array(
        'default' => '#007bff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage'
	));
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'diym_primary_color', array(
		'label' => __( 'Theme Primary Color', 'diy-marketer' ),
		'section' => 'colors',
	)));

	// Theme Primary Color.
    $wp_customize->add_setting('diym_primary_color_hue', array(
        'default' => 211,
        'sanitize_callback' => 'absint',
        'transport' => 'postMessage'
	));
	
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'diym_primary_color_hue', array(
		'label' => __( 'Theme Primary Color Hue', 'diy-marketer' ),
		'section' => 'colors',
		'mode' => 'hue'
	)));

	// Header & Footer Background Color.
	$wp_customize->add_setting(
		'header_footer_background_color',
		array(
			'default'           => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'header_footer_background_color',
			array(
				'label'   => __( 'Header &amp; Footer Background Color', 'diy-marketer' ),
				'section' => 'colors',
			)
		)
	);

	/**
	 * Implementation for the accent color.
	 * This is different to all other color options because of the accessibility enhancements.
	 * The control is a hue-only colorpicker, and there is a separate setting that holds values
	 * for other colors calculated based on the selected hue and various background-colors on the page.
	 *
	 * @since Twenty Twenty 1.0
	 */

	// Add the setting for the hue colorpicker.
	$wp_customize->add_setting(
		'accent_hue',
		array(
			'default'           => 344,
			'type'              => 'theme_mod',
			'sanitize_callback' => 'absint',
			'transport'         => 'postMessage',
		)
	);

	// Add setting to hold colors derived from the accent hue.
	/*
	$wp_customize->add_setting(
		'accent_accessible_colors',
		array(
			'default'           => array(
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
			),
			'type'              => 'theme_mod',
			'transport'         => 'postMessage',
			'sanitize_callback' => array( __CLASS__, 'sanitize_accent_accessible_colors' ),
		)
	);
	*/

	// Add the hue-only colorpicker for the accent color.
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'accent_hue',
			array(
				'section'         => 'colors',
				'settings'        => 'accent_hue',
				'description'     => __( 'Apply a custom color for links, buttons, featured images.', 'diy-marketer' ),
				'mode'            => 'hue'
				//'active_callback' => function() use ( $wp_customize ) {
					//return ( 'custom' === $wp_customize->get_setting( 'accent_hue_active' )->value() );
				//},
			)
		)
	);

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

	require DIYM_DIR . 'inc/inline-css.php';

	wp_localize_script('diym-customizer-preview', 'diy_marketer', array($diym_inline_selectors));
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