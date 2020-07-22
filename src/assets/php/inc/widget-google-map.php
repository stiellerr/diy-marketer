<?php
/**
 * DIY Marketer google map embed custom widget
 *
 * @link https://developer.wordpress.org/themes/functionality/widgets/
 *
 * @package DIY_Marketer
 */

class DIYM_Google_Map_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'diym_google_map',
            esc_html__('Google Map', 'diy-marketer'),
            array(
                'description' => esc_html__("Embeds a google map to your website", 'diy-marketer'),
                'customize_selective_refresh' => true
            )
        );
    }

    public function widget($args, $instance) {

        //$diym_facebook = get_theme_mod( 'diym_facebook', 'facebook.com/facebook' );

        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__('Google Map', 'diy-marketer');

        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        echo $args['before_widget'];

        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        ?>

        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d90575.20516202337!2d168.31390696654196!3d-44.81188366296523!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xa9d5a41f73b0997f%3A0x500ef8684797100!2sGlenorchy%209372!5e0!3m2!1sen!2snz!4v1595406096718!5m2!1sen!2snz" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        <!--
        <div class="fb-page" data-href="<?php /*echo $diym_facebook;*/ ?>" data-small-header="true"></div>
        -->
        <?php

        echo $args['after_widget'];
    }

    public function form( $instance ) {

        //global $wp_customize;

        $title = isset( $instance['title'] ) ? $instance['title'] : esc_html__('Google Map', 'diy-marketer');

        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title') ?>"><?php esc_html_e('Title:', 'diy-marketer'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
			<?php
                /*
                if ( $wp_customize instanceof WP_Customize_Manager ) {
                    $url = 'javascript: wp.customize.section( "diym_social" ).focus();' ;
                } else {
                    $url = admin_url( 'customize.php' );
                }
                

                if ( is_customize_preview() ) {
                    $url = 'javascript: wp.customize.section( "diym_social" ).focus();' ;
                } else {
                    $url = admin_url( 'customize.php' );
                }
                */

			/* translators: %s: URL to create a new menu. */
            //printf( __( 'Edit your facebook page details. <a href="%s">here</a>.' ), esc_attr( $url ) );
			?>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] =  sanitize_text_field($new_instance['title']);
        return $instance;
    }
}

function diym_register_google_map_widget() {
    register_widget('DIYM_Google_Map_Widget');
}

add_action('widgets_init', 'diym_register_google_map_widget');