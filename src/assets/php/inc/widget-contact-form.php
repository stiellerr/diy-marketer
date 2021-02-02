<?php
/**
 * DIY Marketer contact form custom widget
 *
 * @link https://developer.wordpress.org/themes/functionality/widgets/
 *
 * @package DIY_Marketer
 */

if ( ! class_exists( 'DIYM_Contact_Form_Widget' ) ) {

class DIYM_Contact_Form_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'diym_contact_form',
            esc_html__('Contact Form', 'diy-marketer'),
            array(
                'description' => esc_html__("Displays a contact form", 'diy-marketer'),
                // append sticky top class name...
                'classname' => 'widget_diym_contact_form sticky-md-top bg-white',
                'customize_selective_refresh' => true
            )
        );
        //write_log( is_admin() );
        /*
        if ( is_active_widget( false, false, $this->id_base ) ) {     
            global $diym_fa;
            //
            $diym_fa[ 'icons' ][ 'fa-lock' ] = "f023";
            if ( !in_array( 'fas' , $diym_fa[ 'fonts' ] ) ) {
                $diym_fa[ 'fonts' ][] = 'fas';
            }

            //write_log( wp_debug_backtrace_summary() ); 
            //write_log( 'widget contact form' );
        }
        */

    }

    public function widget($args, $instance) {
        
        //$title = !empty( $instance['title'] ) ? $instance['title'] : esc_html__('Contact Form', 'diy-marketer');
        $title = isset($instance['title']) ? $instance['title'] : esc_html__('Contact Form', 'diy-marketer');
        
        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        $message = isset( $instance['message'] ) ? boolval($instance['message']) : true;
        $name = isset( $instance['name'] ) ? boolval($instance['name']) : true;
        $phone = isset( $instance['phone'] ) ? boolval($instance['phone']) : false;
        $email = isset( $instance['email'] ) ? boolval($instance['email']) : true;

        echo $args['before_widget'];

        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        ?>

        <form class="contact-form needs-validation" novalidate>
            <?php /* echo $title ? $args['before_title'] . $title . $args['after_title'] : ''; */ ?>
            <!--<input type="hidden" name="action" value="send_form" />-->
            <?php if ( $message ) { ?>            
                <div class="mb-2"><!-- message -->
                    <textarea class="form-control form-control-sm" name="message" id="message" placeholder="How can we help?" required></textarea>
                    <div class="invalid-feedback"><?php esc_html_e("message required", 'diy-marketer'); ?></div>
                </div>
            <?php } ?>
            <?php if ( $name ) { ?>
                <div class="mb-2"><!-- name -->
                    <input type="text" class="form-control form-control-sm" name="name" id="name" placeholder="Your name." required />
                    <div class="invalid-feedback"><?php esc_html_e("name required", 'diy-marketer'); ?></div>
                </div>
            <?php } ?>
            <?php if ( $phone ) { ?>   
                <div class="mb-2"><!-- Phone -->
                    <input type="text" class="form-control form-control-sm" name="phone" id="phone" placeholder="Phone number." required />
                    <div class="invalid-feedback"><?php esc_html_e("phone number required", 'diy-marketer'); ?></div>
                </div>
            <?php } ?>
            <?php if ( $email ) { ?>
                <div class="mb-2"><!-- Email -->
                    <input type="email" class="form-control form-control-sm" name="email" id="email" placeholder="Email." required />
                    <div class="invalid-feedback"><?php esc_html_e("valid email required", 'diy-marketer'); ?></div>
                </div>
            <?php } ?>
            <div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary"><?php esc_html_e("Submit.", 'diy-marketer'); ?></button>
                </div>
            </div>
            <small>
                <i class="fas fa-lock" data-content="f023"></i>&nbsp;<?php esc_html_e("we'll never share your information with anyone.", 'diy-marketer'); ?>
            </small>

        </form>

        <?php

        echo $args['after_widget'];
    }

    public function form( $instance ) {
        
		$instance = wp_parse_args(
			(array) $instance,
			array(
                'title'     => esc_html__('Contact Form', 'diy-marketer'),
                'message'   => true,
                'name'      => true,
				'phone'     => false,
				'email'     => true
			)
		);
        
        /*
        $title = isset( $instance['title'] ) ? $instance['title'] : esc_html__('Contact Form', 'diy-marketer');

        $message = isset( $instance['message'] ) ? $instance['message'] : true;
        $name = isset( $instance['name'] ) ? $instance['name'] : true;
        $phone = isset( $instance['phone'] ) ? $instance['phone'] : false;
        $email = isset( $instance['email'] ) ? $instance['email'] : true;
        */
        //$message = isset( $instance['message'] ) ? 1 : 1;
        //$name = isset( $instance['name'] ) ? $instance['name'] : true;
        //$phone = isset( $instance['phone'] ) ? $instance['phone'] : false;
        //$email = isset( $instance['email'] ) ? $instance['email'] : true;

        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title') ?>"><?php esc_html_e('Title:', 'diy-marketer'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
        </p>
        <p><?php esc_html_e('Fields to display:', 'diy-marketer'); ?><br>
            <input class="checkbox" id="<?php echo $this->get_field_id('message') ?>" name="<?php echo $this->get_field_name('message') ?>" type="checkbox" <?php checked( $instance['message'] ); ?> />
            <label for="<?php echo $this->get_field_id('message') ?>"><?php esc_html_e('message', 'diy-marketer'); ?></label>
            <br>  
            <input class="checkbox" id="<?php echo $this->get_field_id('name') ?>" name="<?php echo $this->get_field_name('name') ?>" type="checkbox" <?php checked( $instance['name'] ); ?> />
            <label for="<?php echo $this->get_field_id('name') ?>"><?php esc_html_e('name', 'diy-marketer'); ?></label>
            <br>
            <input class="checkbox" id="<?php echo $this->get_field_id('phone') ?>" name="<?php echo $this->get_field_name('phone') ?>" type="checkbox" <?php checked( $instance['phone'] ); ?> />
            <label for="<?php echo $this->get_field_id('phone') ?>"><?php esc_html_e('phone number', 'diy-marketer'); ?></label>
            <br>
            <input class="checkbox" id="<?php echo $this->get_field_id('email') ?>" name="<?php echo $this->get_field_name('email') ?>" type="checkbox" <?php checked( $instance['email'] ); ?> />
            <label for="<?php echo $this->get_field_id('email') ?>"><?php esc_html_e('email', 'diy-marketer'); ?></label>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {

        $instance = $old_instance;

		$new_instance   = wp_parse_args(
			(array) $new_instance,
			array(
				'title'     => '',
				'message'   => false,
                'name'      => false,
                'phone'     => false,
                'email'     => false
			)
		);

        $instance['title']  = sanitize_text_field($new_instance['title']);
        $instance['message']= boolval($new_instance['message']);
        $instance['name']   = boolval($new_instance['name']);
        $instance['phone']  = boolval($new_instance['phone']);
        $instance['email']  = boolval($new_instance['email']);

        return $instance;
    }
}
}

function diym_register_contact_form_widget() {
    //write_log('ddddd');
    register_widget('DIYM_Contact_Form_Widget');
}

add_action('widgets_init', 'diym_register_contact_form_widget');