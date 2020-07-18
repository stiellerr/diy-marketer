<?php
/**
 * DIY Marketer social media custom widget
 *
 * @link https://developer.wordpress.org/themes/functionality/widgets/
 *
 * @package DIY_Marketer
 */

class DIYM_Social_Media_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'diym_social_media_widget',
            esc_html__('Social Media', 'diy-marketer'),
            array(
                'description' => esc_html__("Displays your business' social media links", 'diy-marketer'),
                //'customize_selective_refresh' => true
            )
        );
    }

    public function widget($args, $instance) {

        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__('Social Media', 'diy-marketer');
        
        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        echo $args['before_widget'];

        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        // get theme mods.
        $diym_facebook  = get_theme_mod( 'diym_facebook' );
        $diym_instagram = get_theme_mod( 'diym_instagram' );
        $diym_twitter   = get_theme_mod( 'diym_twitter' );

        ?>
        <table>
            <?php if ( $diym_facebook ) { ?>
                <tr>
                    <td>
                        <a href="<? echo $diym_facebook; ?>"><span class="dashicons dashicons-facebook-alt"></span></a>
                    </td>
                    <td>Like us on facebook.</td>
                </tr>
            <?php } ?>
            <?php if ( $diym_instagram ) { ?>
                <tr>
                    <td>
                        <a href="<? echo $diym_instagram; ?>"><span class="dashicons dashicons-instagram"></span></a>
                    </td>
                    <td>Follow us on instagram.</td>
                </tr>
            <?php } ?>
            <?php if ( $diym_twitter ) { ?>
                <tr>
                    <td>
                        <a href="<? echo $diym_twitter; ?>"><span class="dashicons dashicons-twitter"></span></a>
                    </td>
                    <td>Follow us on twitter.</td>
                </tr>
            <?php } ?>
        </table>
        <?php

        echo $args['after_widget'];
    }

    public function form( $instance ) {

        global $wp_customize;

        $title = isset( $instance['title'] ) ? $instance['title'] : esc_html__('Social Media', 'diy-marketer');

        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title') ?>"><?php esc_html_e('Title:', 'diy-marketer'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
			<?php
                if ( $wp_customize instanceof WP_Customize_Manager ) {
                    $url = 'javascript: wp.customize.section( "diym_social" ).focus();' ;
                } else {
                    $url = admin_url( 'customize.php' );
                }

			/* translators: %s: URL to create a new menu. */
            printf( __( 'Edit your social media. <a href="%s">here</a>.' ), esc_attr( $url ) );
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

function diym_register_social_media_widget() {
    register_widget('DIYM_Social_Media_Widget');
}

add_action('widgets_init', 'diym_register_social_media_widget');