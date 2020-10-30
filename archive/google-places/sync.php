<?php
class DIYM_Google_Places {
	
	//private $diym_api_endpoint = 'https://stieller.com/api/diy-license-manager/v1/info';

	public function __construct() {
		
		if ( is_admin() ) {
			// Add the menu screen for inserting license information
			add_action( 'admin_menu', array( $this, 'diym_add_google_places_page' ) );

			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
			//add_action( 'admin_init', array( $this, 'diym_add_license_settings_fields' ) );
			
			// Add a nag text for reminding the user to save the license information
			//add_action( 'admin_notices', array( $this, 'diym_show_admin_notices' ) );
			
			// Check for updates (for themes)
			//add_filter( 'pre_set_site_transient_update_themes', array( $this, 'diym_check_updates' ) );
            add_action('wp_ajax_sync_data', array( $this, 'sync_data' ) ); // This is for authenticated users
            add_action('wp_ajax_nopriv_sync_data', array( $this, 'sync_data') ); // This is for unauthenticated users.
		}

	}

	public function enqueue() {
		wp_enqueue_script( 'diym-google-places', get_template_directory_uri() . '/dist/assets/js/google-places.js', array( 'jquery' ), filemtime( get_template_directory() . '/dist/assets/js/google-places.js'), true );
	}

	/**
	 * Enqueue our scripts and styles
	 */
	public function sync_data() {

		// get the value from the theme-mod.
		$data = get_theme_mod(
			'_places',
			array(
				'place_id'	=> 'ChIJZY4oZ0efFW0RczJOuFArzR4',
				/*
				'fields' => implode(
					",",
					array(
						//'name', 'rating', 'formatted_phone_number'
						'permanently_closed', 'photo', 'place_id', 'plus_code', 'type', 'url', 'utc_offset', 'vicinity', 'address_component', 'adr_address', 'business_status', 'formatted_address', 'geometry', 'icon', 'name', 'formatted_phone_number', 'international_phone_number', 'opening_hours', 'website', 'price_level', 'rating', 'review', 'user_ratings_total'
					)
				),
				*/
				'key'	=> 'AIzaSyCKPAa7QAk7mOdAzqD64OHmrBMW3hT8998'
			)
		);

		// grab updated values...
		$keys = array_keys( $data );

		foreach ( $keys as $key ) {
			if ( array_key_exists( $key, $_POST ) ) {
				$data[ $key ] = $_POST[ $key ];
			}
		}

		// update value in db
		set_theme_mod( '_places', $data );

		//
		$url = add_query_arg(
			$data,
			'https://maps.googleapis.com/maps/api/place/details/json'
		);

		$request = wp_remote_get( $url );

		

		$body = wp_remote_retrieve_body( $request );

		$response = json_decode( $body );

		write_log( $url );

		//json


		write_log( $response );

		// retrieve address data.
		/*
		foreach ( $response->result->address_components as $element ) {
			//extract data
			if ( in_array( "subpremise", $element->types ) ) {
				$address['streetAddress'] = $element->long_name;
			}
			if ( in_array( "street_number", $element->types ) ) {
				if ( isset( $address['streetAddress'] ) ) {
					$address['streetAddress'] = $address['streetAddress'] . '/' . $element->long_name;
				} else {
					$address['streetAddress'] = $element->long_name;
				}
			}
			if ( in_array( "route", $element->types ) ) {
				if ( isset( $address['streetAddress'] ) ) {
					$address['streetAddress'] = $address['streetAddress'] . ' ' . $element->long_name;
				} else {
					$address['streetAddress'] = $element->long_name;
				}
			}
			if ( in_array( "sublocality", $element->types ) ) {
				$address['sublocality'] = $element->long_name;
			}
			if ( in_array( "locality", $element->types ) ) {
				$address['addressLocality'] = $element->long_name;
			}
			if ( in_array( "administrative_area_level_1", $element->types ) ) {
				$address['addressRegion'] = $element->long_name;
			}
			if ( in_array( "country", $element->types ) ) {
				$address['addressCountry'] = $element->long_name;
			}
			if ( in_array( "postal_code", $element->types ) ) {
				$address['postalCode'] = $element->long_name;
			}	
		}

		write_log( $address );
		*/

		//$response = json_decode( $body );


		//write_log( $response->result );
		//status_header( 200 );
		
		//echo $body;

		//die;

		//return $body; // ? json_decode( $diym_response, true ) : false;
		//wp_send_json_success( json_decode( $response ) );


		//write_log( json_decode(  $response ) );



		//write_log( $body );



		//$keys = array_keys( $data );

		
		//if in_array(   $_POST ) {

		//}
		
		//for

		/*
		
		$allowed  = [ 'apiKey', 'placeID' ];
		
		
		
		
		
		
		
		$data = array_filter(
			$_POST,
			function ($key) use ($allowed) {
				return in_array($key, $allowed);
			},
			ARRAY_FILTER_USE_KEY
		);

		

		*/
		
		
		// check form submit has been done from a valid source.
		check_admin_referer( '_diym_google_places_nonce' );

		//write_log( $_POST );

		//wp_send_json_success( __( 'Thanks, we will be in touch shortly!', 'diy-marketer' ) );
	}
	
	public function diym_add_google_places_page() {
		
		add_options_page(
			__( 'Google Places', 'diy-marketer' ),
			__( 'Google Places', 'diy-marketer' ),
			'read',
			'diym-google-places',
			array( $this, 'diym_render_google_places' )
		);
	}

	public function diym_add_license_settings_fields() {
		
		register_setting( 'diym_license_settings_group', 'diym_license_settings_field' );

		add_settings_section(
			'diym_license_settings_section',
			__( 'License Settings', 'diy-marketer' ),
			array( $this, 'diym_render_license_settings_section' ),
			'diym_license_settings_group'
		);

		add_settings_field(
			'diym-registered-email',
			__( 'Registered Email', 'diy-marketer' ),
			array( $this, 'diym_render_email_settings_field' ),
			'diym_license_settings_group',
			'diym_license_settings_section'
		);
		
		add_settings_field(
			'diym-license-key',
			__( 'License Key', 'diy-marketer' ),
			array( $this, 'diym_render_license_key_settings_field' ),
			'diym_license_settings_group',
			'diym_license_settings_section'
		);
	}

	public function diym_render_google_places() {
		
		//$title = sprintf( __( '%s License Settings', 'diy-marketer' ), 'DIY Marketer' );



		
		// Get the value from the theme-mod.
		$data = get_theme_mod(
			'_places',
			array(
				'place_id'	=> '',
				'key'		=> ''
			)
		);
		
		?>
		<div class="wrap">
			<h1>DIY Marketer Settings</h1>
			<form id="google-places" novalidate>
				<?php wp_nonce_field( '_diym_google_places_nonce' ); ?>
				<table class="form-table">
					<h2 class="title">Google Places</h2>
					<tbody>
						<tr>
							<th scope="row">
								<label for="apiKey">API Key</label>
							</th>
							<td>
								<input name="key" type="text" id="Key" value="<?php echo $data[ 'key' ]; ?>" class="regular-text" required>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="placeID">Place ID</label>
							</th>
							<td>
								<input name="place_id" type="text" id="place_id" value="<?php echo $data[ 'place_id' ]; ?>" class="regular-text" required>
							</td>
						</tr>
					</tbody>
				</table>
				<h2 class="title">Google Tag Manager</h2>
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row">Head</th>
							<td>
								<textarea class="large-text code" rows="3">
								</textarea>
								<!--<input name="key" type="text" id="Key" value="<?php echo $data[ 'key' ]; ?>" class="regular-text" required>-->
							</td>
						</tr>
						<tr>
							<th scope="row">Body</th>
							<td>
								<textarea class="large-text code" rows="3">
								</textarea>
								<!--<input name="key" type="text" id="Key" value="<?php echo $data[ 'key' ]; ?>" class="regular-text" required>-->
							</td>
						</tr>
					</tbody>
				</table>
				<h2 class="title">Contact Details</h2>
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row">
								<label for="apiKey">Street Address</label>
							</th>
							<td>
								<input name="keyzzz" type="text" id="Key" value="" class="regular-text" required>
							</td>
						</tr>
						<tr>
							<th scope="row">
								<label for="apiKey">City</label>
							</th>
							<td>
								<input name="key444" type="text" id="Key" value="" class="regular-text" required>
							</td>
						</tr>
						<tr>
							<th scope="row">Postal Code</th>
							<td>
								<input name="key888" type="number" id="Key" value="" class="small-text" required>
							</td>
						</tr>
					</tbody>
				</table>


				<p class="submit">
					<input class="button button-primary" type="submit" value="Sync Data"></button>
				</p>
			</form>
		</div>
		<?php
	}
	
	public function diym_render_license_settings_section() {
		_e( 'Enter your DIY Marketer subscription details below.', 'diy-marketer' );
	}
	
	public function diym_render_email_settings_field() {		
		?>
			<input type='text' name='diym_license_settings_field[diym-registered-email]' value='<?php echo get_option( 'diym_license_settings_field' )['diym-registered-email']; ?>' class='regular-text'>
		<?php
	}
	
	public function diym_render_license_key_settings_field() {
		?>
			<input type='text' name='diym_license_settings_field[diym-license-key]' value='<?php echo  get_option( 'diym_license_settings_field' )['diym-license-key']; ?>' class='regular-text'>
		<?php
	}
	
	public function diym_show_admin_notices() {
		$diym_options = get_option( 'diym_license_settings_field' );
	 
		if ( ! $diym_options || ! isset( $diym_options['diym-registered-email'] ) || ! isset( $diym_options['diym-license-key'] ) ||
			$diym_options['diym-registered-email'] == '' || $diym_options['diym-license-key'] == '' ) {
	 
			$diym_message = __( 'Please enter your email and license key to enable updates to %s.', 'diy-marketer' );
			$diym_message = sprintf( $diym_message, 'DIY Marketer' );
			?>
				<div class="update-nag">
					<p>
						<?php echo $diym_message; ?>
					</p>
	 
					<p>
						<a href="<?php echo admin_url( 'options-general.php?page=diym-license-settings' ); ?>">
							<?php _e( 'Complete the setup now.', 'diy-marketer' ); ?>
						</a>
					</p>
				</div>
			<?php
		}
	}
	
	public function diym_check_updates( $diym_theme_update_data ) {
		
		if ( empty( $diym_theme_update_data->checked ) ) {
			return $diym_theme_update_data;
		}

		static $diym_response = null;
		
		// Make sure to send remote request once.
		if ( null === $diym_response ) {
			$diym_response = $this->diym_send_request();
		}
		
		if ( isset( $diym_response['error'] ) ) {
			// TODO publish notice...
			return $diym_theme_update_data;
		}
		
		$diym_theme = $this->diym_has_update( $diym_response );
		
		if ( false === $diym_theme ) {
			return $diym_theme_update_data;
		}
		
		if ( ! isset( $diym_theme_update_data->response ) ) {
			$diym_theme_update_data->response = array();
		}

		$diym_theme_update_data->response[ $diym_theme['theme'] ] = $diym_theme;
		
		return( $diym_theme_update_data );
		
	}
	
	public function send_request() {

		// Get the value from the theme-mod.
		$data = get_theme_mod( '_places' );

		if ( empty( $data[ 'key' ] ) || empty( $data[ 'place_id' ] ) ) {
			// User hasn't saved the license to settings yet. No use making the call.
			return false;
		}

		/*
		$response = wp_remote_get(
			//$this->diym_api_endpoint,
			'https://maps.googleapis.com/maps/api/place/details/json?'
			array(
				'body' => $diym_args
			)
		);
		*/
		
		//place_id=ChIJN1t_tDeuEmsRUsoyG83frY4&fields=name,rating,formatted_phone_number&key=YOUR_API_KEY
		
		
		/*
		$diym_options = get_option( 'diym_license_settings_field' );
		
		if ( ! isset( $data['diym-registered-email'] ) || ! isset( $diym_options['diym-license-key'] ) ) {
			// User hasn't saved the license to settings yet. No use making the call.
			return false;
		}
		
		$diym_this_theme = wp_get_theme();	
		
		$diym_args = array(
			'k'	=> $diym_options['diym-license-key'],
			'e'	=> $diym_options['diym-registered-email'],
			't'	=> $diym_this_theme->Name,
			'd'	=> $_SERVER['SERVER_NAME']
		);
		*/
		
		$diym_request = wp_remote_post(
			$this->diym_api_endpoint,
			array(
				'body' => $diym_args
			)
		);
		
		$diym_response = wp_remote_retrieve_body( $diym_request );
			
		return $diym_response ? json_decode( $diym_response, true ) : false;
		
	}
	
	// has update ?
	private function diym_has_update( $diym_theme_data ) {
		
		$diym_this_theme = wp_get_theme();

		return version_compare( $diym_this_theme->Version, $diym_theme_data['new_version'], '<' ) ? $diym_theme_data : false;
		
	}
	
}