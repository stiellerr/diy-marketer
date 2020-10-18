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
        // css
        wp_enqueue_style( 'jquery-ui', get_template_directory_uri() . "/assets/css/jqueryui/jquery-ui.min.css", array(), '1.11.4' );
        wp_enqueue_style( 'jquery-ui-timepicker', get_template_directory_uri() . "/assets/css/jqueryui/jquery-ui-timepicker-addon.min.css", array( 'jquery-ui' ), '1.6.3' );       
        //js
        wp_enqueue_script( 'jquery-ui-timepicker', get_template_directory_uri() . '/assets/js/jqueryui/jquery-ui-timepicker-addon.min.js', array( 'jquery-ui-datepicker', 'jquery-ui-slider' ), '1.6.3', true );
        //custom js
        wp_enqueue_script( 'diym-google-places', get_template_directory_uri() . '/assets/js/google-places.js', array( 'jquery', 'underscore' ), filemtime( get_template_directory() . '/assets/js/google-places.js'), true );
    }
    
	public function sync_data() {

        // check ajax source is valid.
        check_admin_referer( "diym-options-options" );

		// query db
		$args = get_theme_mod(
            'google',
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

        $theme = get_option( 'stylesheet' );
        $theme_mod = "theme_mods_{$theme}";

        register_setting(
            'diym-options',
            "theme_mods_$theme",
            array(
                'sanitize_callback' => array( &$this, 'sanitize_settings' )
            )
        );

        register_setting(
            'diym-options',
            "blogname"
        );

        add_settings_section(
            'google',
            __( 'Google Settings', 'diy-marketer' ),
            array( &$this, 'render_void' ),
            'diym-options'
        );

        add_settings_field( 
            'place_id',
            __( 'Place ID', 'diy-marketer' ),
            array( &$this, 'render_input' ),
            'diym-options',
            'google',
            array(
                'label_for' => "{$theme_mod}[google][place_id]",
                'theme_mod' => $theme_mod,
                'section' => 'google',
                'id' => 'place_id',
            )
        );

        add_settings_field( 
            'key',
            __( 'API Key', 'diy-marketer' ),
            array( &$this, 'render_input' ),
            'diym-options',
            'google',
            array(
                'label_for' => "{$theme_mod}[google][key]",
                'theme_mod' => $theme_mod,
                'section' => 'google',
                'id' => 'key'
            )
        );
        
        add_settings_field( 
            'button',
            __( '&nbsp;', 'diy-marketer' ),
            array( &$this, 'render_button' ),
            'diym-options',
            'google',
            // pass google value & set defaults if required.
            get_theme_mod( 'google',
                array(
                    'place_id' => '',
                    'key' => ''
                )
            )
        );

        add_settings_section(
            'tag_manager',
            __( 'Google Tag Manager', 'diy-marketer' ),
            array( &$this, 'render_void' ),
            'diym-options'
        );

        add_settings_field( 
            'head_code',
            __( 'Head Code', 'diy-marketer' ),
            array( &$this, 'render_textarea' ),
            'diym-options',
            'tag_manager',
            array(
                'label_for' => "{$theme_mod}[tag_manager][body_code]",
                'theme_mod' => $theme_mod,
                'section' => 'tag_manager',
                'id' => 'head_code'
            )
        );

        add_settings_field( 
            'body_code',
            __( 'Body Code', 'diy-marketer' ),
            array( &$this, 'render_textarea' ),
            'diym-options',
            'tag_manager',
            array(
                'label_for' => "{$theme_mod}[tag_manager][body_code]",
                'theme_mod' => $theme_mod,
                'section' => 'tag_manager',
                'id' => 'body_code'
            )
        );

        add_settings_section(
            'details',
            __( 'Business Details', 'diy-marketer' ),
            array( &$this, 'render_void' ),
            'diym-options'
        );

        add_settings_field( 
            'phone', //id
            __( 'Phone number', 'diy-marketer' ),
            array( &$this, 'render_details' ),
            'diym-options',
            'details',
            array(
                'label_for' => "{$theme_mod}[details][phone]",
                'theme_mod' => $theme_mod,
                'section' => 'details',
                'id' => 'phone'
            )
        );

        add_settings_section(
            'address',
            __( 'Business Address', 'diy-marketer' ),
            array( &$this, 'render_void' ),
            'diym-options'
        );

        add_settings_field( 
            'country', //id
            __( 'Country', 'diy-marketer' ),
            array( &$this, 'render_input' ),
            'diym-options',
            'address',
            array(
                'label_for' => "{$theme_mod}[address][country]",
                'theme_mod' => $theme_mod,
                'section' => 'address',
                'id' => 'country'
            )
        );

        add_settings_field( 
            'street_address',
            __( 'Street Address', 'diy-marketer' ),
            array( &$this, 'render_input' ),
            'diym-options',
            'address',
            array(
                'label_for' => "{$theme_mod}[address][street_address]",
                'theme_mod' => $theme_mod,
                'section' => 'address',
                'id' => 'street_address'
            )
        );

        add_settings_field( 
            'suburb',
            __( 'Suburb', 'diy-marketer' ),
            array( &$this, 'render_input' ),
            'diym-options',
            'address',
            array(
                'label_for' => "{$theme_mod}[address][suburb]",
                'theme_mod' => $theme_mod,
                'section' => 'address',
                'id' => 'suburb'
            )
        );

        add_settings_field( 
            'city',
            __( 'City', 'diy-marketer' ),
            array( &$this, 'render_input' ),
            'diym-options',
            'address',
            array(
                'label_for' => "{$theme_mod}[address][city]",
                'theme_mod' => $theme_mod,
                'section' => 'address',
                'id' => 'city'
            )
        );

        add_settings_field( 
            'region',
            __( 'Region', 'diy-marketer' ),
            array( &$this, 'render_input' ),
            'diym-options',
            'address',
            array(
                'label_for' => "{$theme_mod}[address][region]",
                'theme_mod' => $theme_mod,
                'section' => 'address',
                'id' => 'region'
            )
        );

        add_settings_field( 
            'post_code',
            __( 'Postal code', 'diy-marketer' ),
            array( &$this, 'render_input' ),
            'diym-options',
            'address',
            array(
                'label_for' => "{$theme_mod}[address][post_code]",
                'theme_mod' => $theme_mod,
                'section' => 'address',
                'id' => 'post_code'
            )
        );

        add_settings_section(
            'hours',
            __( 'Business hours', 'diy-marketer' ),
            array( &$this, 'render_void' ),
            'diym-options'
        );

        add_settings_field( 
            'monday',
            __( 'Monday', 'diy-marketer' ),
            array( &$this, 'render_hours' ),
            'diym-options',
            'hours',
            array(
                'theme_mod' => $theme_mod,
                'section' => "hours",
                'id' => 'monday'
            )
        );

        add_settings_field( 
            'tuesday',
            __( 'Tuesday', 'diy-marketer' ),
            array( &$this, 'render_hours' ),
            'diym-options',
            'hours',
            array(
                'theme_mod' => $theme_mod,
                'section' => "hours",
                'id' => 'tuesday'
            )
        );

        add_settings_field( 
            'wednesday',
            __( 'Wednesday', 'diy-marketer' ),
            array( &$this, 'render_hours' ),
            'diym-options',
            'hours',
            array(
                'theme_mod' => $theme_mod,
                'section' => "hours",
                'id' => 'wednesday'
            )
        );

        add_settings_field( 
            'thursday',
            __( 'Thursday', 'diy-marketer' ),
            array( &$this, 'render_hours' ),
            'diym-options',
            'hours',
            array(
                'theme_mod' => $theme_mod,
                'section' => "hours",
                'id' => 'thursday'
            )
        );

        add_settings_field( 
            'friday',
            __( 'Friday', 'diy-marketer' ),
            array( &$this, 'render_hours' ),
            'diym-options',
            'hours',
            array(
                'theme_mod' => $theme_mod,
                'section' => "hours",
                'id' => 'friday'
            )
        );

        add_settings_field( 
            'saturday',
            __( 'Saturday', 'diy-marketer' ),
            array( &$this, 'render_hours' ),
            'diym-options',
            'hours',
            array(
                'theme_mod' => $theme_mod,
                'section' => "hours",
                'id' => 'saturday'
            )
        );

        add_settings_field( 
            'sunday',
            __( 'Sunday', 'diy-marketer' ),
            array( &$this, 'render_hours' ),
            'diym-options',
            'hours',
            array(
                'theme_mod' => $theme_mod,
                'section' => "hours",
                'id' => 'sunday'
            )
        );

        // map section
        add_settings_section(
            'map',
            __( 'Google Map settings', 'diy-marketer' ),
            array( &$this, 'render_void' ),
            'diym-options'
        );

        add_settings_field( 
            'lat',
            __( 'Latitude', 'diy-marketer' ),
            array( &$this, 'render_input' ),
            'diym-options',
            'map',
            array(
                'label_for' => "{$theme_mod}[map][lat]",
                'theme_mod' => $theme_mod,
                'section' => 'map',
                'id' => 'lat',
            )
        );

        add_settings_field( 
            'lng',
            __( 'Longitude', 'diy-marketer' ),
            array( &$this, 'render_input' ),
            'diym-options',
            'map',
            array(
                'label_for' => "{$theme_mod}[map][lng]",
                'theme_mod' => $theme_mod,
                'section' => 'map',
                'id' => 'lng'
            )
        );

        add_settings_field( 
            'url',
            __( 'Map url', 'diy-marketer' ),
            array( &$this, 'render_input' ),
            'diym-options',
            'map',
            array(
                'label_for' => "{$theme_mod}[map][url]",
                'theme_mod' => $theme_mod,
                'section' => 'map',
                'id' => 'url'
            )
        );

        add_settings_section(
            'socials',
            __( 'Social media', 'diy-marketer' ),
            array( &$this, 'render_void' ),
            'diym-options'
        );

        add_settings_field( 
            'facebook',
            __( 'Facebook', 'diy-marketer' ),
            array( &$this, 'render_input' ),
            'diym-options',
            'socials',
            array(
                'label_for' => "{$theme_mod}[socials][facebook]",
                'theme_mod' => $theme_mod,
                'section' => 'socials',
                'id' => 'facebook'
            )
        );

        add_settings_field( 
            'instagram',
            __( 'Instagram', 'diy-marketer' ),
            array( &$this, 'render_input' ),
            'diym-options',
            'socials',
            array(
                'label_for' => "{$theme_mod}[socials][instagram]",
                'theme_mod' => $theme_mod,
                'section' => 'socials',
                'id' => 'instagram'
            )
        );

        add_settings_field( 
            'youtube',
            __( 'Youtube', 'diy-marketer' ),
            array( &$this, 'render_input' ),
            'diym-options',
            'socials',
            array(
                'label_for' => "{$theme_mod}[socials][youtube]",
                'theme_mod' => $theme_mod,
                'section' => 'socials',
                'id' => 'youtube'
            )
        );

        add_settings_field( 
            'twitter',
            __( 'Twitter', 'diy-marketer' ),
            array( &$this, 'render_input' ),
            'diym-options',
            'socials',
            array(
                'label_for' => "{$theme_mod}[socials][twitter]",
                'theme_mod' => $theme_mod,
                'section' => 'socials',
                'id' => 'twitter'
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

    // render input
    public function render_details( $args ) {

        // extract tags from array
        extract( $args );

        // build tag
        $tag = "{$theme_mod}[{$section}][{$id}]";
        

        ?>
            <input type="text" id="<?php echo $tag; ?>" name="<?php echo $tag; ?>" value="<?php echo get_theme_mod($section)[$id]; ?>" class="regular-text">
            <input type="hidden" name="blogname" value="<?php echo get_option('blogname'); ?>">
        <?php
    }


    // render input
    public function render_hours( $args ) {
        // extract tags from array
        extract( $args );

        // build prefix
        $prefix = "{$theme_mod}[{$section}][{$id}";

        ?>
           <fieldset>
                <label for="<? echo "{$prefix}_open]"; ?>">Open</label>
                <input type="text" id="<?php echo "{$prefix}_open]"; ?>" name="<?php echo "{$prefix}_open]"; ?>" value="<?php echo get_theme_mod($section)["{$id}_open"]; ?>" class="timepicker small-text">
                <br>
                <label for="<? echo "{$prefix}_close]"; ?>">Close</label>
                <input type="text" id="<?php echo "{$prefix}_close]"; ?>" name="<?php echo "{$prefix}_close]"; ?>" value="<?php echo get_theme_mod($section)["{$id}_close"]; ?>" class="timepicker small-text">
            </fieldset>
        <?php
    }

    // render input
    public function render_void( $args ) {

    }

    // render button
    public function render_button( $args ) {

        // extract tags from array
        extract( $args );
        
        ?>
            <input id="sync_places" type='button' value="Synchronise Data" class="button button-secondary"<?php echo empty( $place_id ) || empty( $key ) ? ' disabled' : '' ?>>
        <?php
    }

    // render input
    public function render_input( $args ) {

        // extract tags from array
        extract( $args );

        // build tag
        $tag = "{$theme_mod}[{$section}][{$id}]";

        ?>
            <input type="text" id="<?php echo $tag; ?>" name="<?php echo $tag; ?>" value="<?php echo get_theme_mod($section)[$id]; ?>" class="regular-text">
        <?php
    }

    // render textarea
    public function render_textarea( $args ) {

        // extract tags from array
        extract( $args );

        // build tag
        $tag = "{$theme_mod}[{$section}][{$id}]";

        ?>
            <textarea id="<?php echo $tag; ?>" name="<?php echo $tag; ?>"  class="large-text code" rows="3"><?php echo get_theme_mod( $section ) [ $id ]; ?></textarea>
        <?php
    }

    public function sanitize_settings( $data ) {

        // sanitize time...
        foreach ( $data['hours'] as $key => $value) {
            $data[ 'hours' ][ $key ] = sanitize_event_time( $value );
        }

        // sanitize socials...
        foreach ( $data['socials'] as $key => $value) {
            $data[ 'socials' ][ $key ] = esc_url_raw( $value );

            //esc_url_raw( 
            //write_log( $key );
            //write_log( $value );
            //$data[ 'socials' ][ $key ] = sanitize_event_time( $value );
        }

        return $data;
    }

    /**
     * Sanitizes date time input
     * https://www.lehelmatyus.com/1416/sanitize-date-time-value-in-wordpress
     * 
     * @return String
     */
    function sanitize_event_time($event_time) {

        // General sanitization, to get rid of malicious scripts or characters
        $event_time = sanitize_text_field($event_time);
        $event_time = filter_var($event_time, FILTER_SANITIZE_STRING);
    
        // Validation to see if it is the right format
        if (_my_validate_date($event_time)){
            return $event_time;
        }
    
        // default value, to return if checks have failed
        return "00:00";
    }
    
    /**
     * Validates that a date string is in the right format
     * default format is 'H:i' to test for time only in this format '24:00'
     * but you can pass a new format to test against other formats
     * other formats here https://www.lehelmatyus.com/1003/android-change-date-format-from-utc-to-local-time
     * 
     * @return bool
     */
    
    function _my_validate_date($date, $format = 'H:i') {
        // Create the format date
        $d = DateTime::createFromFormat($format, $date);
    
        // Return the comparison    
        return $d && $d->format($format) === $date;
    }

}