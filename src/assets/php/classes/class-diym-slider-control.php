<?php
/**
 * DIY Marketer customizer custom controls
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package DIY_Marketer
 */

if ( class_exists( 'WP_Customize_Control' ) ) {

	if ( ! class_exists( 'DIYM_Slider_Control' ) ) {

		/**
		 * Image Radio Button Custom Control
		 *
		 * @author Anthony Hortin <http://maddisondesigns.com>
		 * @license http://www.gnu.org/licenses/gpl-2.0.html
		 * @link https://github.com/maddisondesigns
		 */
		class DIYM_Slider_Control extends WP_Customize_Control {
			/**
			 * The type of control being rendered
			 */
			public $type = 'slider_control';
			/**
			 * Enqueue our scripts and styles
			 */
			public function enqueue() {
				//wp_enqueue_script( 'skyrocket-custom-controls-js', $this->get_skyrocket_resource_url() . 'js/customizer.js', array( 'jquery', 'jquery-ui-core' ), '1.0', true );
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
				<input type="number" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" class="customize-control-slider-value" <?php $this->link(); ?> />



				<?php if( !empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>

				<?php foreach ( $this->choices as $key => $value ) { ?>
					<label>
						<input type="radio" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php $this->link(); ?> <?php checked( esc_attr( $key ), $this->value() ); ?>/>
						<img src="<?php echo esc_attr( $value['image'] ); ?>" alt="<?php echo esc_attr( $value['name'] ); ?>" title="<?php echo esc_attr( $value['name'] ); ?>" />
					</label>
				<?php	} ?>


				<div class="slider-custom-control">
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
					
					
					<div class="slider" slider-min-value="<?php echo esc_attr( $this->input_attrs['min'] ); ?>" slider-max-value="<?php echo esc_attr( $this->input_attrs['max'] ); ?>" slider-step-value="<?php echo esc_attr( $this->input_attrs['step'] ); ?>"></div><span class="slider-reset dashicons dashicons-image-rotate" slider-reset-value="<?php echo esc_attr( $this->value() ); ?>"></span>
				</div>

				<?php


			}
		}
	}
}

?>