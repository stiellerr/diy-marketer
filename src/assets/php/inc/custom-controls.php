<?php
/**
 * DIY Marketer Customizer Custom Controls
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package DIY_Marketer
 */

if ( class_exists( 'WP_Customize_Control' ) ) {

	/**
	 * Custom Control Base Class
	 *
	 * @author Anthony Hortin <http://maddisondesigns.com>
	 * @license http://www.gnu.org/licenses/gpl-2.0.html
	 * @link https://github.com/maddisondesigns
	 */
	class DIYM_Google_Font_Select2 extends WP_Customize_Control {
		/**
		 * Constructor
		 */
		public function __construct( $manager, $id, $args = array(), $options = array() ) {
			parent::__construct( $manager, $id, $args );
		}
		/**
		 * Enqueue our scripts and styles
		 */
		public function enqueue() {
			//wp_enqueue_script( 'diym-select2-js', DIYM_JS_URL . 'select2.js', ['jquery'], '4.0.13', true );
			//wp_enqueue_script( 'diym-custom-controls-js', DIYM_JS_URL . 'customizer.js', ['diym-select2-js'], DIYM_VER, true );
			//wp_enqueue_style( 'diym-custom-controls-css', DIYM_CSS_URL . 'customizer.css', [], DIYM_VER, 'all' );
			//wp_enqueue_style( 'diym-select2-css', DIYM_CSS_URL . 'select2.css', [], '4.0.13', 'all' );

		}
		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
			
			
		?>
			<div class="google_font_select2_control">
				<?php if( !empty( $this->label ) ) { ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php } ?>
				<?php if( !empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>

				<input type="hidden" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" class="customize-control-google-font-selection" <?php $this->link(); ?> />
				<div class="google-fonts">
					<select class="google-fonts-list" control-name="<?php echo esc_attr( $this->id ); ?>">
						
						<option>hello world</option>
						<?php
							/*
							foreach( $this->fontList as $key => $value ) {
								$fontCounter++;
								$fontListStr .= '<option value="' . $value->family . '" ' . selected( $this->fontValues->font, $value->family, false ) . '>' . $value->family . '</option>';
								if ( $this->fontValues->font === $value->family ) {
									$isFontInList = true;
								}
								if ( is_int( $this->fontCount ) && $fontCounter === $this->fontCount ) {
									break;
								}
							}
							if ( !$isFontInList && $this->fontListIndex ) {
								// If the default or saved font value isn't in the list of displayed fonts, add it to the top of the list as the default font
								$fontListStr = '<option value="' . $this->fontList[$this->fontListIndex]->family . '" ' . selected( $this->fontValues->font, $this->fontList[$this->fontListIndex]->family, false ) . '>' . $this->fontList[$this->fontListIndex]->family . ' (default)</option>' . $fontListStr;
							}
							// Display our list of font options
							echo $fontListStr;
							*/
						?>
					</select>
				</div>
			</div>
		<?php
		}
	}
}




/**
 * End of file.
 */
?>