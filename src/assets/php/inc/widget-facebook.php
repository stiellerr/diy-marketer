<?php
/**
 * DIY Marketer business hours custom widget
 *
 * @link https://developer.wordpress.org/themes/functionality/widgets/
 *
 * @package DIY_Marketer
 */

class DIYM_Facebook_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'diym_facebook',
            esc_html__('Facebook', 'diy-marketer'),
            array(
                'description' => esc_html__("Displays an excert of the business facebook page", 'diy-marketer'),
                //'customize_selective_refresh' => true
            )
        );
    }

    public function widget($args, $instance) {

        $diym_facebook = get_theme_mod( 'diym_facebook', 'facebook.com/facebook' );

        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__('Facebook', 'diy-marketer');

        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        echo $args['before_widget'];

        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        ?>

        <div class="fb-page" data-href="<?php echo $diym_facebook; ?>" data-small-header="true"></div>

        <?php

        echo $args['after_widget'];
    }

    public function form( $instance ) {

        //global $wp_customize;

        $title = isset( $instance['title'] ) ? $instance['title'] : esc_html__('Facebook', 'diy-marketer');

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
                */

                if ( is_customize_preview() ) {
                    $url = 'javascript: wp.customize.section( "diym_social" ).focus();' ;
                } else {
                    $url = admin_url( 'customize.php' );
                }

			/* translators: %s: URL to create a new menu. */
            printf( __( 'Edit your facebook page details. <a href="%s">here</a>.' ), esc_attr( $url ) );
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

function diym_register_facebook_widget() {
    register_widget('DIYM_Facebook_Widget');
}

add_action('widgets_init', 'diym_register_facebook_widget');