<?php
/**
 * DIY Marketer customizer custom controls
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package DIY_Marketer
 */

if ( class_exists( 'WP_Customize_Control' ) ) {

	if ( ! class_exists( 'DIYM_Image_Radio_Control' ) ) {

		/**
		 * Image Radio Button Custom Control
		 *
		 * @author Anthony Hortin <http://maddisondesigns.com>
		 * @license http://www.gnu.org/licenses/gpl-2.0.html
		 * @link https://github.com/maddisondesigns
		 */
		class DIYM_Image_Radio_Control extends WP_Customize_Control {
			/**
			 * The type of control being rendered
			 */
			public $type = 'image_radio';
			/**
			 * Enqueue our scripts and styles
			 */
			public function enqueue() {
				wp_enqueue_style( 'diym-custom-controls', get_template_directory_uri() . '/dist/assets/css/custom-controls.css', array(), wp_get_theme()->get( 'Version' ), 'all' );
			}

			/**
			 * Don't render the control content from PHP, as it's rendered via JS on load.
			 *
			 * @since 4.9.0
			 */
			public function render_content() {
				?>
				<?php if ( ! empty( $this->label ) ) : ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php endif; ?>
				<?php if( !empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>

				<?php foreach ( $this->choices as $key => $value ) { ?>
					<!--<label class="radio-button-label">-->
					<label>
						<input type="radio" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php $this->link(); ?> <?php checked( esc_attr( $key ), $this->value() ); ?>/>
						<img src="<?php echo esc_attr( $value['image'] ); ?>" alt="<?php echo esc_attr( $value['name'] ); ?>" title="<?php echo esc_attr( $value['name'] ); ?>" />
				</label>
						<!--</label>-->
				<?php	} ?>

				<?php
			}
		}
	}
}
	/**
	 * Radio Button and Select sanitization
	 *
	 * @param  string		Radio Button value
	 * @return integer	Sanitized value
	 */
	/*
	if ( ! function_exists( 'skyrocket_radio_sanitization' ) ) {
		function skyrocket_radio_sanitization( $input, $setting ) {
			//get the list of possible radio box or select options
		 $choices = $setting->manager->get_control( $setting->id )->choices;

			if ( array_key_exists( $input, $choices ) ) {
				return $input;
			} else {
				return $setting->default;
			}
		}
	}
	*/
    

?>