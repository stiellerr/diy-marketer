<?php
/**
 * DIY Marketer page excerpt custom widget
 *
 * @link https://developer.wordpress.org/themes/functionality/widgets/
 *
 * @package DIY_Marketer
 */

class DIYM_Page_Excerpt_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'diym_page_excerpt',
            esc_html__('Page Excerpt', 'diy-marketer'),
            array(
                'description' => esc_html__("Displays an excert from the selected page", 'diy-marketer'),
                'customize_selective_refresh' => true
            )
        );
    }

    public function widget($args, $instance) {

        $title = !empty( $instance['title'] ) ? $instance['title'] : esc_html__('Page Excerpt', 'diy-marketer');

        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        $excerpt = !empty( $instance['page_id'] ) ? get_the_excerpt( intval($instance['page_id']) ) : esc_html__('Welcome to DIY Marketer. This the excerpt widget. Select a page to retrieve its excerpt. If no excerpt is found, we will attempt to create one for you automatically.', 'diy-marketer');

        echo $args['before_widget'];

        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        if ( $excerpt ) {
            echo '<p class="text-justify">' . $excerpt . '</p>';
        }

        echo $args['after_widget'];
    }

    public function form( $instance ) {

		$instance = wp_parse_args(
			(array) $instance,
			array(
                'title'     => esc_html__('Page Excerpt', 'diy-marketer'),
                'page_id'   => 0,
			)
		);

        $pages = get_pages();
        
        ?>

        <p>
            <label for="<?php echo $this->get_field_id('title') ?>"><?php esc_html_e('Title:', 'diy-marketer'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'page_id' ); ?>"><?php _e( 'Select Page:' ); ?></label>
            <select id="<?php echo $this->get_field_id( 'page_id' ); ?>" name="<?php echo $this->get_field_name( 'page_id' ); ?>" class="widefat">
                <option value="0"><?php _e( '&mdash; Select &mdash;' ); ?></option>
                <?php foreach ( $pages as $page ) : ?>
                    <option value="<?php echo esc_attr( $page->ID ); ?>" <?php selected( $instance['page_id'], $page->ID ); ?>>
                        <?php echo esc_html( $page->post_title ); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>

        <?php
    }

    public function update($new_instance, $old_instance) {

        $instance = array();

        if ( empty( $old_instance ) ) {
        
            if ( empty( $new_instance['page_id'] ) ) {
                $instance['title'] = sanitize_text_field( $new_instance['title'] );
            } else {
                $instance['title'] = get_the_title( $new_instance['page_id'] );
            }

        } else {

            if ( $new_instance['page_id'] != $old_instance['page_id'] ) {
                if ( $new_instance['page_id'] > 1 ) {
                    $instance['title'] = get_the_title( $new_instance['page_id'] );
                } else {
                    $instance['title'] = esc_html__('Page Excerpt', 'diy-marketer');
                }
            } else {
                $instance['title'] = sanitize_text_field( $new_instance['title'] );
            }    
        }

        $instance['page_id'] = intval( $new_instance['page_id'] );

        return $instance;
    }
}

function diym_register_page_excerpt_widget() {
    register_widget('DIYM_Page_Excerpt_Widget');
}

add_action('widgets_init', 'diym_register_page_excerpt_widget');