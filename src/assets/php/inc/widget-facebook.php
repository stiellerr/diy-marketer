<?php
/**
 * DIY Marketer facebook embed custom widget
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

        if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
            //add_action( 'wp_head', array( &$this, 'inject_head' ), 0 );
            //add_action( 'wp_body_open', array( &$this, 'inject_body' ) );
        }
    }

    function inject_head() {
        ?>
            <script defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v8.0" nonce="bV5BLVHU"></script>
        <?php
    }
        
    function inject_body() {
        ?>
            <div id="fb-root"></div>
        <?php
    }

    public function widget($args, $instance) {

        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__('Facebook', 'diy-marketer');

        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        echo $args['before_widget'];

        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        $socials = get_option( 'diym_socials', null );

        /* fb pages js
        <div class="fb-page" data-href="https://www.facebook.com/michaelsurealestate/" data-tabs="" data-width="210" data-height="154" data-small-header="true" data-adapt-container-width="false" data-hide-cover="false" data-show-facepile="true" data-hide-cta="false" data-lazy="true"><blockquote cite="https://www.facebook.com/michaelsurealestate/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/michaelsurealestate/">Michael Su - Real Estate Salesperson</a></blockquote></div>        

        fb pages iframe
        <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fmichaelsurealestate%2F&tabs&width=210&height=154&small_header=true&adapt_container_width=false&hide_cover=false&show_facepile=true&hide_cta=false&lazy=true&appId" width="210" height="154" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
        */
        
        if ( $socials ) {
            if ( $socials[ 'facebook' ] ) {
                $url = urlencode( trailingslashit( $socials[ 'facebook' ] ) );

                write_log( $url );

                echo "<iframe src='https://www.facebook.com/plugins/page.php?href={$url}&tabs&width=210&height=154&small_header=true&adapt_container_width=false&hide_cover=false&show_facepile=true&hide_cta=false&lazy=true&appId' width='210' height='154' style='border:none;overflow:hidden' scrolling='no' frameborder='0' allowTransparency='true' allow='encrypted-media'></iframe>";
            }
        }

        echo $args['after_widget'];
    }

    public function form( $instance ) {

        $title = isset( $instance['title'] ) ? $instance['title'] : esc_html__('Facebook', 'diy-marketer');

        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title') ?>"><?php esc_html_e('Title:', 'diy-marketer'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
			<?php
                $url = admin_url( 'options-general.php?page=diym-options' );

                /* translators: %s: URL to create a new menu. */
                printf( __( 'Edit your business hours. <a href="%s">here</a>.' ), esc_attr( $url ) );
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