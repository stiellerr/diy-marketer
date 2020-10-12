<?php
class DIYM_Google_Places {
	
	//private $diym_api_endpoint = 'https://stieller.com/api/diy-license-manager/v1/info';

	public function __construct() {
		
		if ( is_admin() ) {
			// Add the menu screen for inserting license information
			add_action( 'admin_menu', array( $this, 'diym_add_google_places_page' ) );
			//add_action( 'admin_init', array( $this, 'diym_add_license_settings_fields' ) );
			
			// Add a nag text for reminding the user to save the license information
			//add_action( 'admin_notices', array( $this, 'diym_show_admin_notices' ) );
			
			// Check for updates (for themes)
			//add_filter( 'pre_set_site_transient_update_themes', array( $this, 'diym_check_updates' ) );
		}

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
		
		?>
			<div class="wrap">
				<div id="icon-edit" class="icon32 icon32-posts-post"></div>
			 
				<h1><?php echo __( 'DIY Marketer', 'diy-marketer' ); ?></h1>
			 
				<form action='options.php' method='post'>
					<?php
					//settings_fields( 'diym_license_settings_group' );
					//do_settings_sections( 'diym_license_settings_group' );
					submit_button();
					?>
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
	
	public function diym_send_request() {
		
		$diym_options = get_option( 'diym_license_settings_field' );
		
		if ( ! isset( $diym_options['diym-registered-email'] ) || ! isset( $diym_options['diym-license-key'] ) ) {
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