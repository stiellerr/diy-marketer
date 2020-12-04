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

// global function for text sanitization of arrays.
function diym_sanitize_text( $data ) {

	foreach ( $data as $key => $value) {
		$data[ $key ] = sanitize_text_field( $value );
	}

	return $data;
}

function diym_print_title( $title ) {
    //if ( is_single() ) {
        // Get the post id using the get_the_ID(); function:
		//echo get_post_meta( get_the_ID(), 'meta-head', true );

	//$title = get_post_meta( get_the_ID(), '_diym_seo_page_title', true );
	$post_meta = get_post_meta( get_the_ID(), '_diym_post_meta', true );
	
	if ( $post_meta ) {
		$title = $post_meta['title'] ? $post_meta['title'] : '';
	}

	


        /* Or, globalize $post so that we're accessing the global $post variable: */
        //global $post;
        //echo get_post_meta( $post->ID, 'meta-head', true );

        /* Or, access the global $post variable directly: */
        // echo get_post_meta( $GLOBALS['post']->ID, 'meta-head', true );
	//}
	//write_log( $title );

	return $title;

}

add_filter( 'pre_get_document_title', 'diym_print_title' );


// print meta description for seo
function diym_print_meta_description() {

	$post_meta = get_post_meta( get_the_ID(), '_diym_post_meta', true );

	if ( $post_meta ) {
		echo $post_meta['description'] ? "<meta name='description' content='" . $post_meta['description'] . "' />" . "\n" : '';
	}

}

add_action ( 'wp_head', 'diym_print_meta_description', 1 );


//function diym_print_page_meta() {
    //if ( is_single() ) {
        // Get the post id using the get_the_ID(); function:
		//echo get_post_meta( get_the_ID(), 'meta-head', true );

		//$title = get_post_meta( get_the_ID(), '_diym_seo_page_title', true );
		
		//echo $title ? '<title>' . $title . '</title>' : '';


        /* Or, globalize $post so that we're accessing the global $post variable: */
        //global $post;
        //echo get_post_meta( $post->ID, 'meta-head', true );

        /* Or, access the global $post variable directly: */
        // echo get_post_meta( $GLOBALS['post']->ID, 'meta-head', true );
    //}
//}

//add_action ( 'wp_head', 'diym_print_page_meta', 1 );

//write_log( get_the_ID() );

//
//add_filter('xmlrpc_enabled', '__return_false');

function diym_clean_up() {
	
	// remove emoji support
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );

	// remove wp version header
	remove_action( 'wp_head', 'wp_generator' );

	// remove windows live writer tag support
	remove_action( 'wp_head', 'wlwmanifest_link' );

	// remove xml rpc link
	remove_action('wp_head', 'rsd_link');

	remove_action('wp_head', 'rest_output_link_wp_head', 10);
}

add_action( 'init', 'diym_clean_up' );


//define( "DIYM_USE_CDN", false );

//$DIYM_USE_CDN = false;

//if ( ! class_exists( 'DIYM_Google_Places' ) ) {
	//require_once( 'checker.php' );
	//require get_template_directory() . '/inc/google-places/sync.php';
//}

if ( ! class_exists( 'DIYM_Options_Page' ) ) {
	//require_once( 'checker.php' );
	require get_template_directory() . '/classes/class-diym-options-page.php';
}

$diym_google_places = new DIYM_Options_Page();

//$diym_google_places = new DIYM_Google_places();


if ( ! class_exists( 'DIYM_Image_Editor' ) ) {
	//require_once( 'checker.php' );
	require_once get_template_directory() . '/classes/class-diym-image-editor/index.php';
}

$diym_image_editor = new DIYM_Image_Editor();

//$diym_google_places = new DIYM_Google_places();

/*
add_action( 'wp_enqueue_scripts', 'dequeue_scripts' );

function use_jquery_from_microsoft () {
	if (is_admin()) {
		return;
	}

	global $wp_scripts;
	if (isset($wp_scripts->registered['jquery']->ver)) {
		$ver = $wp_scripts->registered['jquery']->ver;
				$ver = str_replace("-wp", "", $ver);
				write_log( $ver );
	} else {
		$ver = '1.12.4';
	}

	wp_deregister_script('jquery');
	//wp_register_script('jquery', "https://ajax.googleapis.com/ajax/libs/jquery/$ver/jquery.min.js", array(), $ver, true);
	wp_register_script('jquery', "https://ajax.aspnetcdn.com/ajax/jQuery/jquery-$ver.min.js", array(), $ver, false);
}

add_action('init', 'use_jquery_from_microsoft');
*/







//global $_wp_additional_image_sizes;
//print_r( get_intermediate_image_sizes() );
//write_log( get_option( 'medium_size_w' ) );


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

		// Set content-width.
		// TO DO
		// this needs to be changed dynamically, dependant on wether a side bar is visible or not...
		global $content_width;
		if ( ! isset( $content_width ) ) {
			$content_width = 1140;
		}
		
		// Set up excerpt support for pages.
		add_post_type_support( 'page', 'excerpt' );

		add_theme_support( 'title-tag' );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add theme support for post thumbnails.
		//add_theme_support( 'post-thumbnails' );
		// Add custom image size used in Cover Template.
		add_image_size( 'diym-custom-size', 780, 0 );
		//add_image_size('medium', get_option( 'medium_size_w' ), get_option( 'medium_size_h' ), true 
		
		// unsure if ill need this ?? its for gutenberg
		//add_theme_support( 'align-wide' ); 
		//add_theme_support( 'responsive-embeds' );

		add_theme_support( 'editor-styles' );

		add_editor_style( 'assets/css/editor.css' );

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support('custom-logo', [
			'height'     => 80,
			// to do
            'width'      => 80,
            'flex-width' => true,
            'flex-height' => false
            //'header-text' => array( '#site-banner' ),
		]);
		
		$mailer = new DIYM_Send_Mail();

		$block_editor = new DIYM_Block_Editor();
    }
}

add_action('after_setup_theme', 'diym_setup');



//require get_template_directory() . '/customizer-repeater/functions.php';

//require get_template_directory() . '/inc/blocks.php';

/**
 * REQUIRED FILES
 * Include required files.
 */
require get_template_directory() . '/inc/template-tags.php';

// Handle Customizer settings.
require get_template_directory() . '/classes/class-diym-customize.php';

// Require Image Radio Control class.
require get_template_directory() . '/classes/class-diym-image-radio-control.php';

// Require Image Radio Control class.
require get_template_directory() . '/classes/class-diym-repeater-control.php';

// Require Send Mail class.
require get_template_directory() . '/classes/class-diym-send-mail.php';

// Require block editor class.
require get_template_directory() . '/classes/class-diym-block-editor.php';

// Custom CSS.
require get_template_directory() . '/inc/custom-css.php';

/**
 * Customizer additions.
 */
//require get_template_directory() . '/inc/customizer.php';

/**
 * Register and Enqueue Styles.
 */



/**
 * Register and Enqueue Styles.
 */
function diym_register_styles() {

	/*
	if ( DIYM_USE_CDN ) {
		wp_enqueue_style( 'bootstrap', 'https://ajax.aspnetcdn.com/ajax/bootstrap/4.5.2/css/bootstrap.min.css', array(), '4.5.2', 'all'  );
		wp_enqueue_style( 'diym', get_template_directory_uri() . '/assets/css/slim.css', array( 'bootstrap' ), false, 'all' );
	} else {
		*/
		wp_enqueue_style( 'diym', get_template_directory_uri() . '/assets/css/bundle.css', array(), false, 'all' );
	//}

	wp_add_inline_style( 'diym', diym_get_customizer_css( 'front-end' ) );


/*
	$production = true;

	if ( $production ) {
		//wp_enqueue_style( 'diym-bs', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css', array(), false, 'all'  );
		//wp_enqueue_style( 'diym-style', get_template_directory_uri() . '/assets/css/bundle.css', array( 'diym-bs' ), filemtime( get_template_directory() . '/assets/css/bundle.css' ), 'all' );
		wp_enqueue_style( 'bs-style', 'https://ajax.aspnetcdn.com/ajax/bootstrap/4.5.2/css/bootstrap.min.css', array(), '4.5.2', 'all'  );
		wp_enqueue_style( 'diym-style', get_template_directory_uri() . '/assets/css/bundle.css', array( 'bs-style' ), false, 'all' );
		
		wp_enqueue_style( 'fa-style', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css', array(), '5.15.1', 'all'  );
	} else {
		wp_enqueue_style( 'diym-style', get_template_directory_uri() . '/assets/css/bundle.css', array(), filemtime( get_template_directory() . '/assets/css/bundle.css' ), 'all' );
	}

	//wp_enqueue_style( 'diym-style', get_template_directory_uri() . '/assets/css/bundle.css', array( 'dashicons' ), DIYM_VER, 'all' );
	//wp_enqueue_style( 'diym-style', get_template_directory_uri() . '/assets/css/bundle.css', array( 'dashicons' ), filemtime( get_template_directory() . '/assets/css/bundle.css' ), 'all' );

	// Add output of Customizer settings as inline style.
	wp_add_inline_style( 'diym-style', diym_get_customizer_css( 'front-end' ) );
	*/

	wp_dequeue_style( 'wp-block-library' );

}

add_action( 'wp_enqueue_scripts', 'diym_register_styles' );

/**
 * Register and Enqueue Scripts.
 */
function diym_enqueue_scripts() {
/*
	if ( DIYM_USE_CDN || is_customize_preview() ) {

		global $wp_scripts;
		
		if ( isset( $wp_scripts->registered['jquery']->ver) ) {
			$ver = $wp_scripts->registered['jquery']->ver;
			$ver = str_replace("-wp", "", $ver);
		} else {
			$ver = '1.12.4';
		}

		wp_deregister_script('jquery');

		wp_register_script('jquery', "https://ajax.aspnetcdn.com/ajax/jQuery/jquery-$ver.min.js", array(), $ver, false);
		wp_enqueue_script( 'bootstrap', 'https://ajax.aspnetcdn.com/ajax/bootstrap/4.5.2/bootstrap.bundle.min.js', array( 'jquery' ), '4.5.2', false );
		wp_enqueue_script( 'diym', get_template_directory_uri() . '/assets/js/slim.js', array( 'bootstrap' ), false, false );
	} else {
		//wp_deregister_script('jquery');
		*/
		wp_enqueue_script( 'diym', get_template_directory_uri() . '/assets/js/bundle.js', array(), false, false );
	//}

	wp_localize_script( 'diym', 'diymMailVars',
		array( 
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'ajax_nonce' => wp_create_nonce( 'secure_nonce_name' )
		)
	);

	// deregister unused scripts to speed up wp.
	wp_deregister_script( 'wp-embed' );
	//wp_dequeue_script( 'wp-embed' );

	//write_log( DIYM_USE_CDN );
	
	
	//<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	//<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	//wp_enqueue_script( 'diym-fa', 'https://kit.fontawesome.com/e2e75b056d.js', array(), false, true );
	//wp_enqueue_script( 'diym-popper', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.1/umd/popper.min.js', array( 'jquery' ), false, true );
	//wp_enqueue_script( 'diym-bs', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array( 'diym-popper' ), false, true );
	//wp_enqueue_script( 'diym', get_template_directory_uri() . '/assets/js/bundle.js', array( 'jquery' ), filemtime( get_template_directory() . '/assets/js/bundle.js'), true );
	//wp_enqueue_script( 'diym', get_template_directory_uri() . '/assets/js/bundle.js', array( 'jquery' ), false, true );
	//wp_enqueue_script( 'diym-js', get_template_directory_uri() . '/assets/js/bundle.js', array( 'jquery' ), false, false );
	
	//wp_enqueue_script( 'diym-js', get_template_directory_uri() . '/assets/js/bundle.js', array( 'jquery' ), DIYM_VER, true );
	//wp_enqueue_script( 'diym-js', get_template_directory_uri() . '/assets/js/bundle.js', array( 'jquery' ), filemtime( get_template_directory() . '/assets/js/bundle.js'), true );
    //wp_script_add_data( 'diym-js', 'async/defer', true );
}

add_action( 'wp_enqueue_scripts', 'diym_enqueue_scripts' );

function diym_admin_assets() {

    wp_enqueue_style( 'diym-admin-style', get_template_directory_uri() . '/assets/css/admin.css', array(), DIYM_VER, 'all' );

    wp_enqueue_script( 'diym-admin-js', get_template_directory_uri() . '/assets/js/admin.js', array(), DIYM_VER, true );
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
			'name'          => esc_html__( 'Sidebar 1', 'diy-marketer' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'diy-maketer' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h5 class="widget-title">',
			'after_title'   => '</h5>',
		)
	);

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

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 3', 'diy-marketer' ),
			'id'            => 'footer-3',
			'description'   => esc_html__( 'Add widgets here.', 'diy-maketer' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h5 class="widget-title">',
			'after_title'   => '</h5>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 4', 'diy-marketer' ),
			'id'            => 'footer-4',
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
 * Enqueue supplemental block editor assets.
 */
//function diym_block_editor_assets() {

	// Enqueue the editor styles.
	//wp_enqueue_style( 'twentytwenty-block-editor-styles', get_theme_file_uri( '/assets/css/editor-style-block.css' ), array(), wp_get_theme()->get( 'Version' ), 'all' );
	//wp_enqueue_style( 'diym-block-editor-styles', get_theme_file_uri( '/assets/css/editor.css' ), array( ), filemtime( get_template_directory() . '/assets/css/editor.css' ), 'all' );
	//wp_style_add_data( 'twentytwenty-block-editor-styles', 'rtl', 'replace' );

	// Add inline style from the Customizer.


	// Add inline style for non-latin fonts.
	//wp_add_inline_style( 'twentytwenty-block-editor-styles', TwentyTwenty_Non_Latin_Languages::get_non_latin_css( 'block-editor' ) );

	// Enqueue the editor script.
	//wp_enqueue_script( 'twentytwenty-block-editor-script', get_theme_file_uri( '/assets/js/editor-script-block.js' ), array( 'wp-blocks', 'wp-dom' ), wp_get_theme()->get( 'Version' ), true );
//}

//add_action( 'enqueue_block_editor_assets', 'diym_block_editor_assets', 1, 1 );

/**
 * Block Editor Settings.
 * Add custom colors and font sizes to the block editor.
 */
function diym_block_editor_settings() {

	// Block Editor Palette.
	$editor_color_palette = array(
		array(
			'name'  => __( 'Accent Color', 'diy-marketer' ),
			'slug'  => 'accent',
			'color' => diym_get_color_for_area( 'body', 'accent' ),
		),
		array(
			'name'  => __( 'Content Color', 'diy-marketer' ),
			'slug'  => 'content',
			'color' => diym_get_color_for_area( 'body', 'content' ),
		)
		/*
		array(
			'name'  => __( 'Secondary', 'twentytwenty' ),
			'slug'  => 'secondary',
			'color' => twentytwenty_get_color_for_area( 'content', 'secondary' ),
		),
		array(
			'name'  => __( 'Subtle Background', 'twentytwenty' ),
			'slug'  => 'subtle-background',
			'color' => twentytwenty_get_color_for_area( 'content', 'borders' ),
		),
		*/
	);

	//write_log( $editor_color_palette );

	// Add the background option.
	/*
	$background_color = get_theme_mod( 'background_color' );
	if ( ! $background_color ) {
		$background_color_arr = get_theme_support( 'custom-background' );
		$background_color     = $background_color_arr[0]['default-color'];
	}
	$editor_color_palette[] = array(
		'name'  => __( 'Background Color', 'twentytwenty' ),
		'slug'  => 'background',
		'color' => '#' . $background_color,
	);
	*/

	write_log( $editor_color_palette );
	// If we have accent colors, add them to the block editor palette.
	if ( $editor_color_palette ) {
		add_theme_support( 'editor-color-palette', $editor_color_palette );
	}

	// Block Editor Font Sizes.
	/*
	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name'      => _x( 'Small', 'Name of the small font size in the block editor', 'twentytwenty' ),
				'shortName' => _x( 'S', 'Short name of the small font size in the block editor.', 'twentytwenty' ),
				'size'      => 18,
				'slug'      => 'small',
			),
			array(
				'name'      => _x( 'Regular', 'Name of the regular font size in the block editor', 'twentytwenty' ),
				'shortName' => _x( 'M', 'Short name of the regular font size in the block editor.', 'twentytwenty' ),
				'size'      => 21,
				'slug'      => 'normal',
			),
			array(
				'name'      => _x( 'Large', 'Name of the large font size in the block editor', 'twentytwenty' ),
				'shortName' => _x( 'L', 'Short name of the large font size in the block editor.', 'twentytwenty' ),
				'size'      => 26.25,
				'slug'      => 'large',
			),
			array(
				'name'      => _x( 'Larger', 'Name of the larger font size in the block editor', 'twentytwenty' ),
				'shortName' => _x( 'XL', 'Short name of the larger font size in the block editor.', 'twentytwenty' ),
				'size'      => 32,
				'slug'      => 'larger',
			),
		)
	);

	add_theme_support( 'editor-styles' );

	// If we have a dark background color then add support for dark editor style.
	// We can determine if the background color is dark by checking if the text-color is white.
	if ( '#ffffff' === strtolower( twentytwenty_get_color_for_area( 'content', 'text' ) ) ) {
		add_theme_support( 'dark-editor-style' );
	}
	*/
}

add_action( 'after_setup_theme', 'diym_block_editor_settings' );


/**
 * Enqueues scripts for customizer controls & settings.
 *
 * @since Twenty Twenty 1.0
 *
 * @return void
 */
function diym_customize_controls_enqueue_scripts() {

	// Add script for controls.
	wp_enqueue_script( 'diym-customize-controls', get_template_directory_uri() . '/assets/js/customize-controls.js', array( 'customize-controls', 'wp-color-picker', 'media-editor', 'underscore' ), DIYM_VER, false );
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

	wp_enqueue_script( 'diym-customize-preview', get_template_directory_uri() . '/assets/js/customize-preview.js', array( 'customize-preview', 'underscore', 'jquery' ), DIYM_VER, true );
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
		'body'       => array(
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
function diym_get_color_for_area( $area = 'body', $context = 'content', $shade = 0 ) {

	// Get the value from the theme-mod.
	$settings = get_theme_mod(
		'custom_colors',
		array(
			'body'       => array(
				'content'      => '#000000',
				//'accent'    => '#cd2653',
			),
			'banner-footer' => array(
				'content'      => '#000000',
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
		'body' => array(
			'accent' => array(
				array(
					'background-color' => array(
						'selector' => array( 'aside .btn-primary')
					)
				),
				array(
					'border-color' => array(
						'selector' => array( 'aside .btn-primary')
					)
				),
				array(
					'border-color' => array(
						'selector' => array( 'aside .btn-primary:hover'),
						'shade' => 40
					)
				),
				array(
					'background-color' => array(
						'selector' => array( 'aside .btn-primary:hover'),
						'shade' => 43
					)
				),
				array(
					'box-shadow' => array(
						'selector' => array( 'aside .btn:focus','aside .btn.focus' ),
						'rgb' => true,
						'prefix' => '0 0 0 0.2rem rgba(',
						'suffix' => ', 0.25)'
					)
				),
				array(
					'box-shadow' => array(
						'selector' => array( 'aside .btn-primary:focus','aside .btn-primary.focus' ),
						'rgb' => true,
						'shade' => 57,
						'prefix' => '0 0 0 0.2rem rgba(',
						'suffix' => ', 0.5)'
					)
				),
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
						'selector' => array( '.nav-link', '.nav-link:hover', '.text-bd-accent' )
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
			'content' => array(
				array(
					'color' => array(
						'selector' => array( '.text-bd-content' )
					)
				)
			)
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
				),
				array(
					'color' => array(
						'selector' => array( '#site-footer .btn-primary')
					)
				)
			),
			'content' => array(
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

// set responsize image sizes...
function diym_calculate_image_sizes( $sizes, $size, $image_src, $image_meta, $attachment_id ) {
	//return $sizes;
	//sizes="(max-width: 575px) 546px, (max-width: 767px) 510px, (max-width: 991px) 690px, (max-width: 1199px) 930px, 1110px"
	
	//write_log( $image_meta );

	if ( is_active_sidebar( 'sidebar-1' ) ) {
		// sidebar sizes...
		$sizes = "(max-width: 575px) calc(100vw - 30px), (max-width: 767px) 510px, (max-width: 991px) 450px, (max-width: 1199px) 690px, 825px";
	} else {
		$sizes = "(max-width: 575px) calc(100vw - 30px), (max-width: 767px) 510px, (max-width: 991px) 690px, (max-width: 1199px) 930px, 1110px";
	}

	return $sizes;

	//return 

}

add_filter( 'wp_calculate_image_sizes', 'diym_calculate_image_sizes', 10, 5 );

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

//defer scripts
function diym_defer_scripts( $tag, $handle, $src ) {

	if ( is_customize_preview() ) {
		return $tag;
	}
	
	$defer = array( 
		//'jquery',
		//'bootstrap',
		'diym'
	);
	
	if ( in_array( $handle, $defer ) ) {
		return str_replace(' src', ' defer src', $tag );
	}

	return $tag;
} 

add_filter( 'script_loader_tag', 'diym_defer_scripts', 10, 3 );

?>