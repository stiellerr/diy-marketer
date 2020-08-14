<?php
/**
 * Customizer settings for this theme.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

if ( ! class_exists( 'DIYM_Customize' ) ) {
	/**
	 * CUSTOMIZER SETTINGS
	 */
	class DIYM_Customize {

		/**
		 * Register customizer options.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 */
		public static function register( $wp_customize ) {

			/**
			 * Site Title & Description.
			 * */
			$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
			$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

			$wp_customize->selective_refresh->add_partial(
				'diym_instagram',
				array(
					'settings' => array(
						'diym_instagram',
						'diym_twitter',
					),
					'selector' => '.site-socials',
					'container_inclusive'=> true,
					'render_callback' => function() {
						get_template_part( 'template-parts/socials' );
					}
			));

			/*
			$wp_customize->selective_refresh->add_partial(
				'blogname',
				array(
					'selector'        => '.site-title a',
					'render_callback' => 'twentytwenty_customize_partial_blogname',
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'blogdescription',
				array(
					'selector'        => '.site-description',
					'render_callback' => 'twentytwenty_customize_partial_blogdescription',
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'custom_logo',
				array(
					'selector'        => '.header-titles [class*=site-]:not(.site-description)',
					'render_callback' => 'twentytwenty_customize_partial_site_logo',
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'retina_logo',
				array(
					'selector'        => '.header-titles [class*=site-]:not(.site-description)',
					'render_callback' => 'twentytwenty_customize_partial_site_logo',
				)
			);
			*/

			/**
			 * Site Identity
			 */

			
			/*
			$wp_customize->add_setting(
				'retina_logo',
				array(
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'retina_logo',
				array(
					'type'        => 'checkbox',
					'section'     => 'title_tagline',
					'priority'    => 10,
					'label'       => __( 'Retina logo', 'twentytwenty' ),
					'description' => __( 'Scales the logo to half its uploaded size, making it sharp on high-res screens.', 'twentytwenty' ),
				)
			);
			*/

			// Update background color with postMessage, so inline CSS output is updated as well.
			//$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';

			/**
			 * Typography
			 */
			$wp_customize->add_section(
				'typography',
				array(
					'title'      => esc_html__( 'Typography', 'diy-marketer' ),
					'priority'   => 40,
					'capability' => 'edit_theme_options',
				)
			);
			/* Enable Header Search ----------------------------------------------- */
			$wp_customize->add_setting(
				'font_family',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => 'default',
					'sanitize_callback' => array( __CLASS__, 'sanitize_select_font' ),
					'transport'			=> 'postMessage'
				)
			);

			$wp_customize->add_control(
				'font_family',
				array(
					'type'     => 'select',
					'section'  => 'typography',
					'label'    => esc_html__( 'Font family', 'diy-marketer' ),
					'choices'	=> diym_customize_font_family()
				)
			);

			// Banner & Footer Background Color.
			$wp_customize->add_setting(
				'banner_footer_background_color',
				array(
					'default'           => '#ffffff',
					'sanitize_callback' => 'sanitize_hex_color',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'banner_footer_background_color',
					array(
						'label'   => __( 'Banner &amp; Footer Background Color', 'diy-marketer' ),
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
				'accent_color',
				array(
					'default'           => '#ffffff',
					'sanitize_callback' => 'sanitize_hex_color',
					'transport'         => 'postMessage',
				)
			);
			
			// Add setting to hold colors derived from the accent color.
			$wp_customize->add_setting(
				'custom_colors',
				array(
					'default'           => array(
						'content'       => array(
							'text'      => '#000000',
							'accent'    => '#cd2653'
						),
						'banner-footer' => array(
							'text'      => '#000000',
							'accent'    => '#cd2653'
						),
					),
					'type'              => 'theme_mod',
					'transport'         => 'postMessage',
					'sanitize_callback' => array( __CLASS__, 'sanitize_accent_accessible_colors' ),
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'accent_color',
					array(
						'label'   => __( 'Accent Color.', 'diy-marketer' ),
						'description'     => __( 'Apply a custom color for links, buttons, featured images.', 'diy-marketer' ),
						'section' => 'colors',
					)
				)
			);

			$wp_customize->add_setting(
				'background_pattern',
				array(
					'default'           => 'pattern12',
					'sanitize_callback' => array( __CLASS__, 'sanitize_select' ),
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				new DIYM_Image_Radio_Control(
					$wp_customize,
					'background_pattern',
					array(
						'label'   => __( 'Background Pattern.', 'diy-marketer' ),
						'section' => 'colors',
						'choices' => diym_customize_background_pattern()
					)
				)
			);

			/**
			 * Contact Details
			 */
			$wp_customize->add_section(
				'contact_details',
				array(
					'title'      => esc_html__( 'Contact Details', 'diy-marketer' ),
					//'description' => esc_html__( "Enter your business' contact details below.", 'diy-marketer' ),
					//'priority'   => 40,
					'capability' => 'edit_theme_options'
				)
			);
			/* Phone Number ----------------------------------------------- */
			$wp_customize->add_setting(
				'diym_phoneNumber',
				array(
					//'default' => '',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'sanitize_text_field',
					'transport' => 'postMessage'
				)
			);

			$wp_customize->add_control(
				'diym_phoneNumber',
				array(
					'type' => 'text',
					'section' => 'contact_details',
					//'priority'    => 10,
					'label' => esc_html__( 'Phone Number', 'diy-marketer' )
				)
			);

			/* Business Name ----------------------------------------------- */
			$wp_customize->add_setting(
				'diym_businessName'
			);

			$wp_customize->add_control(
				'diym_businessName',
				array(
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
					'section' => 'contact_details',
					'input_attrs' => array(
						'placeholder' => get_bloginfo( 'name' ),
						'readonly' => true
					 ),
				)
			);

			/**
			 * Social Media
			 */
			$wp_customize->add_section(
				'social_media',
				array(
					'title'      => esc_html__( 'Social Media', 'diy-marketer' ),
					'description' => esc_html__( 'Enter your social media details below.', 'diy-marketer' ),
					//'priority'   => 40,
					'capability' => 'edit_theme_options'
				)
			);
			
			/* Facebook ----------------------------------------------- */
			$wp_customize->add_setting(
				'diym_facebook',
				array(
					'default' => 'facebook.com/facebook',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'esc_url_raw',
					//'transport' => 'postMessage'
					//'transport' => is_active_widget( false, false, 'diym_facebook', true ) ? 'refresh' : 'postMessage'
				)
			);

			$wp_customize->add_control(
				'diym_facebook',
				array(
					'type'     => 'url',
					'section'  => 'social_media',
					//'priority' => 10,
					'label'    => esc_html__( 'Facebook url', 'diy-marketer' ),
					//'description' => esc_html__( 'Enter you facebook url below...', 'diy-marketer' )
				)
			);

			/* Instagram ----------------------------------------------- */
			$wp_customize->add_setting(
				'diym_instagram',
				array(
					'default' => 'instagram.com/instagram',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'esc_url_raw',
					'transport' => 'postMessage'
					//'transport' => is_active_widget( false, false, 'diym_facebook', true ) ? 'refresh' : 'postMessage'
				)
			);

			$wp_customize->add_control(
				'diym_instagram',
				array(
					'type'     => 'url',
					'section'  => 'social_media',
					//'priority' => 10,
					'label'    => esc_html__( 'Instagram url', 'diy-marketer' ),
					//'description' => esc_html__( 'Enter you facebook url below...', 'diy-marketer' )
				)
			);

			/* Twitter ----------------------------------------------- */
			$wp_customize->add_setting(
				'diym_twitter',
				array(
					'default' => 'twitter.com/twitter',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => 'esc_url_raw',
					'transport' => 'postMessage'
					//'transport' => is_active_widget( false, false, 'diym_facebook', true ) ? 'refresh' : 'postMessage'
				)
			);

			$wp_customize->add_control(
				'diym_twitter',
				array(
					'type'     => 'url',
					'section'  => 'social_media',
					//'priority' => 10,
					'label'    => esc_html__( 'Twitter url', 'diy-marketer' ),
					//'description' => esc_html__( 'Enter you facebook url below...', 'diy-marketer' )
				)
			);

			/*
			$wp_customize->add_control(
				'diym_phoneNumber',
				array(
					'type' => 'text',
					'section' => 'contact_details',
					//'priority'    => 10,
					'label' => esc_html__( 'Phone Number', 'diy-marketer' )
				)
			);
			*/
			/*
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
			*/

			/*
			$wp_customize->add_setting(
				'enable_header_search',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => true,
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'enable_header_search',
				array(
					'type'     => 'checkbox',
					'section'  => 'options',
					'priority' => 10,
					'label'    => __( 'Show search in header', 'twentytwenty' ),
				)
			);
			*/
			/* Show author bio ---------------------------------------------------- */
			/*
			$wp_customize->add_setting(
				'show_author_bio',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => true,
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
				)
			);

			$wp_customize->add_control(
				'show_author_bio',
				array(
					'type'     => 'checkbox',
					'section'  => 'options',
					'priority' => 10,
					'label'    => __( 'Show author bio', 'twentytwenty' ),
				)
			);
			*/
			/* Display full content or excerpts on the blog and archives --------- */
			/*
			$wp_customize->add_setting(
				'blog_content',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => 'full',
					'sanitize_callback' => array( __CLASS__, 'sanitize_select' ),
				)
			);

			$wp_customize->add_control(
				'blog_content',
				array(
					'type'     => 'radio',
					'section'  => 'options',
					'priority' => 10,
					'label'    => __( 'On archive pages, posts show:', 'twentytwenty' ),
					'choices'  => array(
						'full'    => __( 'Full text', 'twentytwenty' ),
						'summary' => __( 'Summary', 'twentytwenty' ),
					),
				)
			);
			*/
			/**
			 * Template: Cover Template.
			 */
			/*
			$wp_customize->add_section(
				'cover_template_options',
				array(
					'title'       => __( 'Cover Template', 'twentytwenty' ),
					'capability'  => 'edit_theme_options',
					'description' => __( 'Settings for the "Cover Template" page template. Add a featured image to use as background.', 'twentytwenty' ),
					'priority'    => 42,
				)
			);
			*/
			/* Overlay Fixed Background ------ */
			/*
			$wp_customize->add_setting(
				'cover_template_fixed_background',
				array(
					'capability'        => 'edit_theme_options',
					'default'           => true,
					'sanitize_callback' => array( __CLASS__, 'sanitize_checkbox' ),
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'cover_template_fixed_background',
				array(
					'type'        => 'checkbox',
					'section'     => 'cover_template_options',
					'label'       => __( 'Fixed Background Image', 'twentytwenty' ),
					'description' => __( 'Creates a parallax effect when the visitor scrolls.', 'twentytwenty' ),
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'cover_template_fixed_background',
				array(
					'selector' => '.cover-header',
					'type'     => 'cover_fixed',
				)
			);
			*/
			/* Separator --------------------- */
			/*
			$wp_customize->add_setting(
				'cover_template_separator_1',
				array(
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				)
			);

			$wp_customize->add_control(
				new TwentyTwenty_Separator_Control(
					$wp_customize,
					'cover_template_separator_1',
					array(
						'section' => 'cover_template_options',
					)
				)
			);
			*/
			/* Overlay Background Color ------ */
			/*
			$wp_customize->add_setting(
				'cover_template_overlay_background_color',
				array(
					'default'           => twentytwenty_get_color_for_area( 'content', 'accent' ),
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'cover_template_overlay_background_color',
					array(
						'label'       => __( 'Overlay Background Color', 'twentytwenty' ),
						'description' => __( 'The color used for the overlay. Defaults to the accent color.', 'twentytwenty' ),
						'section'     => 'cover_template_options',
					)
				)
			);
			*/
			/* Overlay Text Color ------------ */
			/*
			$wp_customize->add_setting(
				'cover_template_overlay_text_color',
				array(
					'default'           => '#ffffff',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					'cover_template_overlay_text_color',
					array(
						'label'       => __( 'Overlay Text Color', 'twentytwenty' ),
						'description' => __( 'The color used for the text in the overlay.', 'twentytwenty' ),
						'section'     => 'cover_template_options',
					)
				)
			);
			*/
			/* Overlay Color Opacity --------- */
			/*
			$wp_customize->add_setting(
				'cover_template_overlay_opacity',
				array(
					'default'           => 80,
					'sanitize_callback' => 'absint',
					'transport'         => 'postMessage',
				)
			);

			$wp_customize->add_control(
				'cover_template_overlay_opacity',
				array(
					'label'       => __( 'Overlay Opacity', 'twentytwenty' ),
					'description' => __( 'Make sure that the contrast is high enough so that the text is readable.', 'twentytwenty' ),
					'section'     => 'cover_template_options',
					'type'        => 'range',
					'input_attrs' => twentytwenty_customize_opacity_range(),
				)
			);

			$wp_customize->selective_refresh->add_partial(
				'cover_template_overlay_opacity',
				array(
					'selector' => '.cover-color-overlay',
					'type'     => 'cover_opacity',
				)
			);
			*/
		}

		/**
		 * Sanitization callback for the "accent_accessible_colors" setting.
		 *
		 * @static
		 * @access public
		 * @since Twenty Twenty 1.0
		 * @param array $value The value we want to sanitize.
		 * @return array       Returns sanitized value. Each item in the array gets sanitized separately.
		 */
		/*
		public static function sanitize_accent_accessible_colors( $value ) {

			// Make sure the value is an array. Do not typecast, use empty array as fallback.
			$value = is_array( $value ) ? $value : array();

			// Loop values.
			foreach ( $value as $area => $values ) {
				foreach ( $values as $context => $color_val ) {
					$value[ $area ][ $context ] = sanitize_hex_color( $color_val );
				}
			}

			return $value;
		}
		*/
		public static function sanitize_accent_accessible_colors( $value ) {

			// Make sure the value is an array. Do not typecast, use empty array as fallback.
			$value = is_array( $value ) ? $value : array();

			// Loop values.
			foreach ( $value as $area => $values ) {
				foreach ( $values as $context => $color_val ) {
					// if color val is array, iterate through its elements
					if ( is_array( $color_val ) ) {
						foreach ( $color_val as $i => $shade  ) {
							$value[ $area ][ $context ][ $i ] = sanitize_hex_color( $shade );
							continue 2;
						}
					} 
					$value[ $area ][ $context ] = sanitize_hex_color( $color_val );
				}
			}

			return $value;
		}

		/**
		 * Sanitize select.
		 *
		 * @param string $input The input from the setting.
		 * @param object $setting The selected setting.
		 *
		 * @return string $input|$setting->default The input from the setting or the default setting.
		 */
		public static function sanitize_select( $input, $setting ) {
			$input   = sanitize_key( $input );
			$choices = $setting->manager->get_control( $setting->id )->choices;
			return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
		}

		/**
		 * Sanitize font.
		 *
		 * @param string $input The input from the setting.
		 * @param object $setting The selected setting.
		 *
		 * @return string $input|$setting->default The input from the setting or the default setting.
		 */
		public static function sanitize_select_font( $input, $setting ) {
			$choices = $setting->manager->get_control( $setting->id )->choices;
			return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
		}

		/**
		 * Sanitize boolean for checkbox.
		 *
		 * @param bool $checked Whether or not a box is checked.
		 *
		 * @return bool
		 */
		public static function sanitize_checkbox( $checked ) {
			return ( ( isset( $checked ) && true === $checked ) ? true : false );
		}

	}

	// Setup the Theme Customizer settings and controls.
	add_action( 'customize_register', array( 'DIYM_Customize', 'register' ) );

}

/**
 * PARTIAL REFRESH FUNCTIONS
 * */
if ( ! function_exists( 'twentytwenty_customize_partial_blogname' ) ) {
	/**
	 * Render the site title for the selective refresh partial.
	 */
	function twentytwenty_customize_partial_blogname() {
		bloginfo( 'name' );
	}
}

if ( ! function_exists( 'twentytwenty_customize_partial_blogdescription' ) ) {
	/**
	 * Render the site description for the selective refresh partial.
	 */
	function twentytwenty_customize_partial_blogdescription() {
		bloginfo( 'description' );
	}
}

if ( ! function_exists( 'twentytwenty_customize_partial_site_logo' ) ) {
	/**
	 * Render the site logo for the selective refresh partial.
	 *
	 * Doing it this way so we don't have issues with `render_callback`'s arguments.
	 */
	function twentytwenty_customize_partial_site_logo() {
		//twentytwenty_site_logo();
	}
}


/**
 * Input attributes for cover overlay opacity option.
 *
 * @return array Array containing attribute names and their values.
 */
function twentytwenty_customize_opacity_range() {
	/**
	 * Filter the input attributes for opacity
	 *
	 * @param array $attrs {
	 *     The attributes
	 *
	 *     @type int $min Minimum value
	 *     @type int $max Maximum value
	 *     @type int $step Interval between numbers
	 * }
	 */
	return apply_filters(
		'twentytwenty_customize_opacity_range',
		array(
			'min'  => 0,
			'max'  => 90,
			'step' => 5,
		)
	);
}

/**
 * Input attributes for cover overlay opacity option.
 *
 * @return array Array containing attribute names and their values.
 */
function diym_customize_font_family() {
	/**
	 * Filter the input attributes for opacity
	 *
	 * @param array $attrs {
	 *     The attributes
	 *
	 *     @type int $min Minimum value
	 *     @type int $max Maximum value
	 *     @type int $step Interval between numbers
	 * }
	 */
	return array(
		'default' => esc_html__( 'Default', 'diy-marketer' ),
		// Sans Serif
		'Arial,"Helvetica Neue",Helvetica,sans-serif' => esc_html__( 'Arial', 'diy-marketer' ),
		'"Arial Black","Arial Bold",Gadget,sans-serif' => esc_html__( 'Arial Black', 'diy-marketer' ),
		'Calibri,Candara,Segoe,"Segoe UI",Optima,Arial,sans-serif' => esc_html__( 'Calibri', 'diy-marketer' ),
		'Candara,Calibri,Segoe,"Segoe UI",Optima,Arial,sans-serif' => esc_html__( 'Candara', 'diy-marketer' ),
		//'"Century Gothic",CenturyGothic,AppleGothic,sans-serif' => 'Century Gothic',
		'"Franklin Gothic Medium","Franklin Gothic","ITC Franklin Gothic",Arial,sans-serif' => esc_html__( 'Franklin Gothic Medium', 'diy-marketer' ),
		'Impact,Charcoal,sans-serif' => esc_html__( 'Impact', 'diy-marketer' ),
		'"Lucida Grande","Lucida Sans Unicode","Lucida Sans",Geneva,Verdana,sans-serif' => esc_html__( 'Lucida Grande', 'diy-marketer' ),
		'"Segoe UI",Frutiger,"Frutiger Linotype","Dejavu Sans","Helvetica Neue",Arial,sans-serif' => esc_html__( 'Segoe UI', 'diy-marketer' ),
		'Tahoma,Verdana,Segoe,sans-serif' => esc_html__( 'Tahoma', 'diy-marketer' ),		
		'"Trebuchet MS","Lucida Grande","Lucida Sans Unicode","Lucida Sans",Tahoma,sans-serif' => esc_html__( 'Trebuchet MS', 'diy-marketer' ),
		'Verdana,Geneva,sans-serif' => esc_html__( 'Verdana', 'diy-marketer' ),	
		
		// Serif
		'Cambria,Georgia,serif' => esc_html__( 'Cambria', 'diy-marketer' ),
		'Georgia,Times,"Times New Roman",serif' => esc_html__( 'Georgia', 'diy-marketer' ),
		'Palatino,"Palatino Linotype","Palatino LT STD","Book Antiqua",Georgia,serif' => esc_html__( 'Palatino', 'diy-marketer' ),
		'TimesNewRoman,"Times New Roman",Times,Baskerville,Georgia,serif' => esc_html__( 'Times New Roman', 'diy-marketer' ),

		// Monospaced
		'Consolas,monaco,monospace' => esc_html__( 'Consola', 'diy-marketer' ),
		'"Courier New",Courier,"Lucida Sans Typewriter","Lucida Typewriter",monospace' => esc_html__( 'Courier New', 'diy-marketer' ),			
		'"Lucida Console","Lucida Sans Typewriter",monaco,"Bitstream Vera Sans Mono",monospace' => esc_html__( 'Lucida Console', 'diy-marketer' ),

		// Script
		'"Comic Sans MS","Comic Sans",cursive,sans-serif' => esc_html__( 'Comic Sans MS', 'diy-marketer' ),
	);
}

/**
 * Input attributes for cover overlay opacity option.
 *
 * @return array Array containing attribute names and their values.
 */
function diym_customize_background_pattern() {
	/**
	 * Filter the input attributes for opacity
	 *
	 * @param array $attrs {
	 *     The attributes
	 *
	 *     @type int $min Minimum value
	 *     @type int $max Maximum value
	 *     @type int $step Interval between numbers
	 * }
	 */
	return array(
		'pattern1' => array(
			'image' => get_template_directory_uri() . '/dist/assets/images/bg/pattern1.png',
			'name' => __( 'Pattern 1', 'diy-marketer' )
		),
		'pattern2' => array(
			'image' => get_template_directory_uri() . '/dist/assets/images/bg/pattern2.png',
			'name' => __( 'Pattern 2', 'diy-marketer' )
		),
		'pattern3' => array(
			'image' => get_template_directory_uri() . '/dist/assets/images/bg/pattern3.png',
			'name' => __( 'Pattern 3', 'diy-marketer' )
		),
		'pattern4' => array(
			'image' => get_template_directory_uri() . '/dist/assets/images/bg/pattern4.png',
			'name' => __( 'Pattern 4', 'diy-marketer' )
		),
		'pattern5' => array(
			'image' => get_template_directory_uri() . '/dist/assets/images/bg/pattern5.png',
			'name' => __( 'Pattern 5', 'diy-marketer' )
		),
		'pattern6' => array(
			'image' => get_template_directory_uri() . '/dist/assets/images/bg/pattern6.png',
			'name' => __( 'Pattern 6', 'diy-marketer' )
		),
		'pattern7' => array(
			'image' => get_template_directory_uri() . '/dist/assets/images/bg/pattern7.png',
			'name' => __( 'Pattern 7', 'diy-marketer' )
		),
		'pattern8' => array(
			'image' => get_template_directory_uri() . '/dist/assets/images/bg/pattern8.png',
			'name' => __( 'Pattern 8', 'diy-marketer' )
		),
		'pattern9' => array(
			'image' => get_template_directory_uri() . '/dist/assets/images/bg/pattern9.png',
			'name' => __( 'Pattern 9', 'diy-marketer' )
		),
		'pattern10' => array(
			'image' => get_template_directory_uri() . '/dist/assets/images/bg/pattern10.png',
			'name' => __( 'Pattern 10', 'diy-marketer' )
		),
		'pattern11' => array(
			'image' => get_template_directory_uri() . '/dist/assets/images/bg/pattern11.png',
			'name' => __( 'Pattern 11', 'diy-marketer' )
		),
		'pattern12' => array(
			'image' => get_template_directory_uri() . '/dist/assets/images/bg/pattern12.png',
			'name' => __( 'Pattern 12', 'diy-marketer' )
		)
	);
}