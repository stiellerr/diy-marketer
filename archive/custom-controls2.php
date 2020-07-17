<?php
/**
 * DIY Marketer Customizer Custom Controls
 *
 * @package DIY_Marketer
 */

 if ( class_exists( 'WP_Customize_Control' ) ) {
    
    Class DIYM_Admin_Field extends WP_Customize_Control {
        /**
        * The type of control being rendered
        */
        public $type = 'admin_field';
        /**
         * Render the control in the customizer
         */
        public function render_content() {
        ?>
        <div class="admin-field-custom-control">
            <?php if( !empty( $this->label ) ) { ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php } ?>
            <?php if( !empty( $this->description ) ) { ?>
                <span class="customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
            <?php } ?>
        </div>
        <?php
        }
    }
 }