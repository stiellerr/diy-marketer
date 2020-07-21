<?php
/**
 * DIY Marketer contact details custom widget
 *
 * @link https://developer.wordpress.org/themes/functionality/widgets/
 *
 * @package DIY_Marketer
 */

class DIYM_Contact_Details_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'diym_contact_details',
            esc_html__('Contact Details', 'diy-marketer'),
            array(
                'description' => esc_html__("Displays the business' contact details", 'diy-marketer'),
                'customize_selective_refresh' => true
            )
        );
    }

    public function form( $instance ) {

        global $wp_customize;

        $title = isset( $instance['title'] ) ? $instance['title'] : esc_html__('Contact Details', 'diy-marketer');

        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title') ?>"><?php esc_html_e('Title:', 'diy-marketer'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
			<?php
                if ( $wp_customize instanceof WP_Customize_Manager ) {
                    $url = 'javascript: wp.customize.section( "diym_contact_details" ).focus();' ;
                } else {
                    $url = admin_url( 'customize.php' );
                }

			/* translators: %s: URL to create a new menu. */
            printf( __( 'Edit your contact details. <a href="%s">here</a>.' ), esc_attr( $url ) );
			?>
        </p>
        <?php
    }

    public function widget($args, $instance) {

        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__('Contact Details', 'diy-marketer');
        
        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        echo $args['before_widget'];

        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        get_template_part( 'template-parts/contact-details' );

        echo $args['after_widget'];
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] =  sanitize_text_field($new_instance['title']);
        return $instance;
    }
}

function diym_register_contact_details_widget() {
    register_widget('DIYM_Contact_Details_Widget');
}

add_action('widgets_init', 'diym_register_contact_details_widget');