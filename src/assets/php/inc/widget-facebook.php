<?php
/**
 * DIY Marketer facebook embed custom widget
 *
 * @link https://developer.wordpress.org/themes/functionality/widgets/
 *
 * @package DIY_Marketer
 */

function diym_wp_body_open() {
    ?>
        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v8.0" nonce="EnWB7388"></script>
   <?php
}

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

        if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
            //add_action( 'wp_body_open', 'diym_wp_body_open' );
            //add_action( 'wp_head', 'diym_wp_head' );
        }
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

        <!--<div class="fb-page" data-href="<?php echo $diym_facebook; ?>" data-small-header="true"></div>

        <div class="fb-page" data-href="https://www.facebook.com/michaelsurealestate/" data-tabs="" data-width="" data-height="" data-small-header="true" data-adapt-container-width="false" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/michaelsurealestate/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/michaelsurealestate/">Michael Su - Real Estate Salesperson</a></blockquote></div>
        https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fmichaelsurealestate%2F&tabs&width&height&small_header=true&adapt_container_width&hide_cover=false&show_facepile=true&appId

        <iframe id="diym-fb" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
-->
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
                    $url = 'javascript: wp.customize.section( "social_media" ).focus();' ;
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