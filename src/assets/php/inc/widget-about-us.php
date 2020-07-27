<?php
/**
 * DIY Marketer about us custom widget
 *
 * @link https://developer.wordpress.org/themes/functionality/widgets/
 *
 * @package DIY_Marketer
 */

class DIYM_About_Us_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'diym_about_us',
            esc_html__('About Us', 'diy-marketer'),
            array(
                'description' => esc_html__("Displays an excert from your business' about page", 'diy-marketer'),
                'customize_selective_refresh' => true
            )
        );
    }

    public function widget($args, $instance) {

        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__('About Us', 'diy-marketer');

        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        echo $args['before_widget'];

        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        echo $args['after_widget'];
    }

    public function form( $instance ) {

        $title = isset( $instance['title'] ) ? $instance['title'] : esc_html__('About Us', 'diy-marketer');

        $pages = get_pages();
        
        write_log( $pages );

        $widget_pages = isset( $instance['widget_pages'] ) ? $instance['widget_pages'] : '';

        ?>

        <p>
            <label for="<?php echo $this->get_field_id('title') ?>"><?php esc_html_e('Title:', 'diy-marketer'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'widget_pages' ); ?>"><?php _e( 'Select Page:' ); ?></label>
            <select id="<?php echo $this->get_field_id( 'widget_pages' ); ?>" name="<?php echo $this->get_field_name( 'widget_pages' ); ?>" class="widefat">
                <option value="0"><?php _e( '&mdash; Select &mdash;' ); ?></option>
                <?php foreach ( $pages as $page ) : ?>
                    <option value="<?php echo esc_attr( $page->ID ); ?>" <?php selected( $widget_pages, $page->ID ); ?>>
                        <?php echo esc_html( $page->post_title ); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>




        <?php


        
		//$out = wp_list_pages(
			/**
			 * Filters the arguments for the Pages widget.
			 *
			 * @since 2.8.0
			 * @since 4.9.0 Added the `$instance` parameter.
			 *
			 * @see wp_list_pages()
			 *
			 * @param array $args     An array of arguments to retrieve the pages list.
			 * @param array $instance Array of settings for the current widget.
			 *//*
			apply_filters(
				'widget_pages_args',
				array(
					'title_li'    => '',
					'echo'        => 0,
					'sort_column' => $sortby,
					'exclude'     => $exclude,
				),
				$instance
			)
		);*/


        ?>


        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] =  sanitize_text_field($new_instance['title']);

        return $instance;
    }
}

function diym_register_about_us_widget() {
    register_widget('DIYM_About_Us_Widget');
}

add_action('widgets_init', 'diym_register_about_us_widget');