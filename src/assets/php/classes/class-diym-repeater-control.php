<?php
/**
 * DIY Marketer customizer repeater control
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package DIY_Marketer
 */

if ( class_exists( 'WP_Customize_Control' ) ) {

	if ( ! class_exists( 'DIYM_Reapater_Control' ) ) {

		/**
		 * Image Radio Button Custom Control
		 *
		 * @author Anthony Hortin <http://maddisondesigns.com>
		 * @license http://www.gnu.org/licenses/gpl-2.0.html
		 * @link https://github.com/maddisondesigns
		 */
		class DIYM_Repeater_Control extends WP_Customize_Control {
			/**
			 * The type of control being rendered
			 */
			public $type = 'diym_repeater';
			/**
			 * Enqueue our scripts and styles
			 */
			public function enqueue() {
				wp_enqueue_media();
				//wp_enqueue_style( 'diym-custom-controls', get_template_directory_uri() . '/dist/assets/css/custom-controls.css', array(), wp_get_theme()->get( 'Version' ), 'all' );

				wp_enqueue_style( 'diym-customize-repeater-styles', get_template_directory_uri().'/dist/assets/css/customize-repeater.css', array('dashicons'), filemtime( get_template_directory() . '/dist/assets/js/customize-repeater.css'), 'all' );

				wp_enqueue_script( 'diym-customize-repeater-js', get_template_directory_uri() . '/dist/assets/js/customize-repeater.js', array( 'underscore', 'jquery' ), filemtime( get_template_directory() . '/dist/assets/js/customize-repeater.js'), true );
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

				<div class="diym-repeater-sortable">

					<!-- hidden value to hold all field values... -->					   
					<input type="hidden" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_textarea( $this->value() ); ?>" <?php esc_attr( $this->link() ); ?>/>
					
					<!-- this is the element that gets cloned. -->
					<div class="diym-repeater-container">
						<div class="diym-repeater-title"><?php echo esc_html( $this->label ); ?></div>
						<div class="diym-repeater-box">
							<button type="button" class="diym-add-image">Add Image</button>
							<label>url:
								<input class="diym-repeater-url" type="text" readonly />
							</label>
							<label>Heading:
								<input class="diym-repeater-heading" type="text" />
							</label>
						</div>
					</div>

				</div>
				<button type="button" class="button diym-repeater-new-field">
					<?php echo esc_html( 'Add new field' ); ?>
        		</button>

				<?php
			}
		}
	}
}

?>
