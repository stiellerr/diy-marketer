<?php
class DIYM_Options_Page {
	
	//private $diym_api_endpoint = 'https://stieller.com/api/diy-license-manager/v1/info';

	public function __construct() {
		
		if ( is_admin() ) {
			// Add the menu screen for inserting license information
            add_action( 'admin_menu', array( &$this, 'add_menu' ) );
            add_action( 'admin_init', array( &$this, 'admin_init' ) );

            // enqueue admin scripts
            add_action( 'admin_enqueue_scripts', array( &$this, 'enqueue' ) );

            add_action('wp_ajax_sync_data', array( &$this, 'sync_data' ) ); // This is for authenticated users
            add_action('wp_ajax_nopriv_sync_data', array( &$this, 'sync_data') ); // This is for unauthenticated users.

            //add_action('admin_menu', array(&$this, 'add_menu'));

			//add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
			//add_action( 'admin_init', array( $this, 'diym_add_license_settings_fields' ) );
			
			// Add a nag text for reminding the user to save the license information
			//add_action( 'admin_notices', array( $this, 'diym_show_admin_notices' ) );
			
			// Check for updates (for themes)
			//add_filter( 'pre_set_site_transient_update_themes', array( $this, 'diym_check_updates' ) );
            //add_action('wp_ajax_sync_data', array( $this, 'sync_data' ) ); // This is for authenticated users
            //add_action('wp_ajax_nopriv_sync_data', array( $this, 'sync_data') ); // This is for unauthenticated users.
		}
    }

	public function enqueue() {
        //wp_register_script( 'jquery-ui-timepicker', "$url/jquery-ui-timepicker-addon.min.js", array( 'jquery-ui-datepicker', 'jquery-ui-slider' ), '1.5.0', true );
        wp_enqueue_script( 'jquery-ui-timepicker', get_template_directory_uri() . '/dist/assets/js/jquery-ui-timepicker.js', array( 'jquery-ui-datepicker', 'jquery-ui-slider' ), '1.5.6', true );
        wp_enqueue_script( 'diym-google-places', get_template_directory_uri() . '/dist/assets/js/google-places.js', array( 'jquery', 'underscore' ), filemtime( get_template_directory() . '/dist/assets/js/google-places.js'), true );
    }
    
	public function sync_data() {

        // check ajax source is valid.
        check_admin_referer( "diym-options-options" );

		// query db
		$args = get_option(
            'diym_google_settings',
			array(
				'place_id'	=> '',
				'key'	=> ''
            )
        );
        
    	// build url
		$request = add_query_arg(
			$args,
			'https://maps.googleapis.com/maps/api/place/details/json'
        );
        
        // send request.
        $response = wp_remote_get( $request );

        if ( is_wp_error( $response ) ) {
            // Bail early
            wp_send_json_error( $response, 500 );
        }

        $body = wp_remote_retrieve_body( $response );
        
        // return data back to js
        wp_send_json_success( json_decode( $body ) );
        //wp_send_json_success( $response );

	}

    public function add_menu() {

        // add page to settings menu
        add_options_page(
            __( 'DIY Marketer', 'diy-marketer' ),
            __( 'DIY Marketer', 'diy-marketer' ),
            'manage_options',            
            'diym-options',
            array( &$this, 'render_page' )                 
        );
    }

    public function admin_init() {

        // Register a new setting for "wporg" page.
        register_setting( 'diym-options', 'diym_google_settings' );
        register_setting( 'diym-options', 'diym_tag_manager' );
        register_setting( 'diym-options', 'diym_business_info' );
        register_setting( 'diym-options', 'diym_hours' );

        //$theme = get_option( 'stylesheet' );
        
        //write_log( $theme );

        //update_option( "theme_mods_diy-marketer[test]", 'hello world!' );


        //$zzz = get_option( "theme_mods_$theme" );

        //write_log( $zzz );
        
        //update_option( "theme_mods_$theme", $mods );


        // First, we register a section. This is necessary since all future options must belong to one.
        add_settings_section(
            'diym_google_settings',         // ID used to identify this section and with which to register options
            __( 'Google Settings', 'diy-marketer' ),
            array( &$this, 'render_void' ),
            'diym-options'               // Title to be displayed on the administration page
        );

        // Next, we will introduce the fields for toggling the visibility of content elements.
        add_settings_field( 
            'place_id',    //id                  // ID used to identify the field throughout the theme
            __( 'Place ID', 'diy-marketer' ),  //title                          // The label to the left of the option interface element
            array( &$this, 'render_input' ), //cb
            'diym-options', //page
            'diym_google_settings', //settings section
            array(    //args
                'label_for' => 'diym_google_settings[places_id]',                          // The array of arguments to pass to the callback. In this case, just a description.
                'section' => 'diym_google_settings',
                'id' => 'place_id',                        // The array of arguments to pass to the callback. In this case, just a description.
            )
        );

        add_settings_field( 
            'key',    //id                  // ID used to identify the field throughout the theme
            __( 'API Key', 'diy-marketer' ),  //title                          // The label to the left of the option interface element
            array( &$this, 'render_input' ), //cb
            'diym-options', //page
            'diym_google_settings', //settings section
            array(    //args
                'label_for' => 'diym_google_settings[key]',                          // The array of arguments to pass to the callback. In this case, just a description.
                'section' => 'diym_google_settings',
                'id' => 'key',                        // The array of arguments to pass to the callback. In this case, just a description.
            )
        );

        add_settings_field( 
            'btn',    //id                  // ID used to identify the field throughout the theme
            __( '&nbsp;', 'diy-marketer' ),  //title                          // The label to the left of the option interface element
            array( &$this, 'render_button' ), //cb
            'diym-options', //page
            'diym_google_settings', //settings section
            array()
        );

        // First, we register a section. This is necessary since all future options must belong to one.
        add_settings_section(
            'diym_tag_manager',         // ID used to identify this section and with which to register options
            __( 'Google Tag Manager', 'diy-marketer' ),
            array( &$this, 'render_void' ),
            'diym-options'               // Title to be displayed on the administration page
        );

        add_settings_field( 
            'head_code',    //id                  // ID used to identify the field throughout the theme
            __( 'Head Code', 'diy-marketer' ),  //title                          // The label to the left of the option interface element
            array( &$this, 'render_textarea' ), //cb
            'diym-options', //page
            'diym_tag_manager', //settings section
            array(    //args
                'label_for' => 'diym_tag_manager[head_code]',                          // The array of arguments to pass to the callback. In this case, just a description.
                'section' => 'diym_tag_manager',
                'id' => 'head_code',
            )
        );

        add_settings_field( 
            'body_code',    //id                  // ID used to identify the field throughout the theme
            __( 'Body Code', 'diy-marketer' ),  //title                          // The label to the left of the option interface element
            array( &$this, 'render_textarea' ), //cb
            'diym-options', //page
            'diym_tag_manager', //settings section
            array(    //args
                'label_for' => 'diym_tag_manager[body_code]',                          // The array of arguments to pass to the callback. In this case, just a description.
                'section' => 'diym_tag_manager',
                'id' => 'body_code',
            )
        );

        // register section: business info.
        add_settings_section(
            'diym_business_info', //id
            __( 'Business Information', 'diy-marketer' ), //title
            array( &$this, 'render_void' ), //cb function
            'diym-options' //page
        );

        // register field: street address.
        add_settings_field( 
            'addressCountry', //id
            __( 'Country', 'diy-marketer' ),  //address
            array( &$this, 'render_input' ), //cb function
            'diym-options', //page
            'diym_business_info', //section
            array(    //args
                'label_for' => 'diym_business_info[addressCountry]',
                'section' => 'diym_business_info',
                'id' => 'addressCountry',
            )
        );

        // register field: street address.
        add_settings_field( 
            'streetAddress', //id
            __( 'Street Address', 'diy-marketer' ),  //address
            array( &$this, 'render_input' ), //cb function
            'diym-options', //page
            'diym_business_info', //section
            array(    //args
                'label_for' => 'diym_business_info[streetAddress]',
                'section' => 'diym_business_info',
                'id' => 'streetAddress',
            )
        );

        // register field: suburb.
        add_settings_field( 
            'subLocality', //id
            __( 'Suburb', 'diy-marketer' ),  //address
            array( &$this, 'render_input' ), //cb function
            'diym-options', //page
            'diym_business_info', //section
            array(    //args
                'label_for' => 'diym_business_info[subLocality]',
                'section' => 'diym_business_info',
                'id' => 'subLocality',
            )
        );

        // register field: suburb.
        add_settings_field( 
            'addressLocality', //id
            __( 'City', 'diy-marketer' ),  //address
            array( &$this, 'render_input' ), //cb function
            'diym-options', //page
            'diym_business_info', //section
            array(    //args
                'label_for' => 'diym_business_info[addressLocality]',
                'section' => 'diym_business_info',
                'id' => 'addressLocality',
            )
        );

        // register field: suburb.
        add_settings_field( 
            'addressRegion', //id
            __( 'Region', 'diy-marketer' ),  //address
            array( &$this, 'render_input' ), //cb function
            'diym-options', //page
            'diym_business_info', //section
            array(    //args
                'label_for' => 'diym_business_info[addressRegion]',
                'section' => 'diym_business_info',
                'id' => 'addressRegion',
            )
        );

        // register field: suburb.
        add_settings_field( 
            'postalCode', //id
            __( 'Postal code', 'diy-marketer' ),  //address
            array( &$this, 'render_input' ), //cb function
            'diym-options', //page
            'diym_business_info', //section
            array(    //args
                'label_for' => 'diym_business_info[postalCode]',
                'section' => 'diym_business_info',
                'id' => 'postalCode',
            )
        );

        // register section: business info.
        add_settings_section(
            'diym_hours', //id
            __( 'Business Hours', 'diy-marketer' ), //title
            array( &$this, 'render_void' ), //cb function
            'diym-options' //page
        );

        // register field: street address.
        add_settings_field( 
            'mondayOpen', //id
            __( 'Monday', 'diy-marketer' ),  //address
            array( &$this, 'render_time' ), //cb function
            'diym-options', //page
            'diym_hours', //section
            array(    //args
                'label_for' => 'diym_hours[mondayOpen]',
                'section' => 'diym_hours',
                'id' => 'mondayOpen',
            )
        );

    }

    // render page
    public function render_page() {

        // check user capabilities

        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <form action="options.php" method="post">
                <?php
                // output security fields for the registered setting "wporg"
                settings_fields( 'diym-options' );
                // output setting sections and their fields
                // (sections are registered for "wporg", each field is registered to a specific section)
                do_settings_sections( 'diym-options' );
                // output save settings button
                submit_button( 'Save Settings' );
                ?>
            </form>
        </div>
        <?php
    }



    // render page
    public function render_void( $args ) {

    }

    // render button
    public function render_button() {

        $google_settings = get_option( 'diym_google_settings' );

        $is_disabled = ( empty( $google_settings[ 'key' ] ) || empty( $google_settings[ 'place_id' ] ) ) ? ' disabled' : '';
        
        ?>
            <input id="sync_places" type='button' value="Synchronise Data" class="button button-secondary"<?php echo $is_disabled ?>>
        <?php
    }

    // render input
    public function render_time( $args ) {
        ?>
            <input type='time' id="<?php echo $args['section'] . '[' . $args['id'] . ']'; ?>" name="<?php echo $args['section'] . '[' . $args['id'] . ']'; ?>" value='<?php echo get_option( $args['section'] ) [ $args['id'] ] ; ?>' class=''>
        <?php
    }

    // render input
    public function render_input( $args ) {
        ?>
            <input type='text' id="<?php echo $args['section'] . '[' . $args['id'] . ']'; ?>" name="<?php echo $args['section'] . '[' . $args['id'] . ']'; ?>" value='<?php echo get_option( $args['section'] ) [ $args['id'] ] ; ?>' class='regular-text'>
        <?php
    }

    // render textarea
    public function render_textarea( $args ) {
        ?>
            <textarea id="<?php echo $args['section'] . '[' . $args['id'] . ']'; ?>" name="<?php echo $args['section'] . '[' . $args['id'] . ']'; ?>"  class="large-text code" rows="3"><?php echo get_option( $args['section'] ) [ $args['id'] ] ; ?></textarea>
        <?php
    }

}