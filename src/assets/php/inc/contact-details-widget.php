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
            'diym_contact_details_widget',
            esc_html__('Contact Details', 'diy-marketer'),
            array(
                'description' => esc_html__("Displays the business' contact details", 'diy-marketer'),
                //'customize_selective_refresh' => true
            )
        );
    }

    public function form( $instance ) {

        $title = isset( $instance['title'] ) ? $instance['title'] : esc_html__('Contact Details', 'diy-marketer');

        $business_name = isset( $instance['business_name'] ) ? $instance['business_name'] : get_bloginfo( 'name' );

        $business_email = isset( $instance['business_email'] ) ? $instance['business_email'] : get_bloginfo( 'admin_email' );

        $business_site = isset( $instance['business_site'] ) ? $instance['business_site'] : get_bloginfo( 'url' );

        /*
        if(isset($instance['post_count'])) {
            $post_count = $instance['post_count'];
        } else {
            $post_count = 3;
        }

        if(isset($instance['include_date'])) {
            $include_date = $instance['include_date'];
        } else {
            $include_date = false;
        }

        if(isset($instance['sort_by'])) {
            $sort_by = $instance['sort_by'];
        } else {
            $sort_by = 'date';
        }
        */

        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title') ?>"><?php esc_html_e('Title:', 'diy-marketer'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('business_name') ?>"><?php esc_html_e('Business Name:', 'diy-marketer'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('business_name') ?>" name="<?php echo $this->get_field_name('business_name') ?>" type="text" value="<?php echo esc_attr($business_name); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('business_email') ?>"><?php esc_html_e('Business Email:', 'diy-marketer'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('business_email') ?>" name="<?php echo $this->get_field_name('business_email') ?>" type="text" value="<?php echo esc_attr($business_email); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('business_site') ?>"><?php esc_html_e('Business Site:', 'diy-marketer'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('business_site') ?>" name="<?php echo $this->get_field_name('business_site') ?>" type="text" value="<?php echo esc_attr($business_site); ?>" />
        </p>
        <!--
        <p>
            <input <?php checked($include_date); ?> type="checkbox" id="<?php echo $this->get_field_id('include_date') ?>" name="<?php echo $this->get_field_name('include_date') ?>" />
            <label for="<?php echo $this->get_field_id('include_date') ?>"><?php esc_html_e('Include Date?', '_themename'); ?></label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('sort_by') ?>"><?php esc_html_e('Sort By:', '_themename'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('sort_by') ?>" name="<?php echo $this->get_field_name('sort_by') ?>">
                <option <?php selected($sort_by, 'date'); ?> value="date"><?php esc_html_e('Most Recent', "_themename") ?></option>
                <option <?php selected($sort_by, 'rand'); ?> value="rand"><?php esc_html_e('Random', "_themename") ?></option>
                <option <?php selected($sort_by, 'comment_count'); ?> value="comment_count"><?php esc_html_e('Number Of Comments', "_themename") ?></option>
            </select>
        </p>
        -->
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

        $diym_phone_number  = get_theme_mod( 'diym_phone_number' );

        ?>
        <table>
            <tr>
                <td>
                    <span class="dashicons dashicons-admin-users"></span>
                </td>
                <td class="site-name"><?php bloginfo( 'name' ); ?></td>
            </tr>
            <tr>
                <td>
                    <span class="dashicons dashicons-location"></span>
                </td>
                <td>
                    <div>4 Fuchsia Avenue</div>
                    <div>Pukete</div>
                    <div>Hamilton, 3200</div>  
                </td>
            </tr>
            <tr>
                <td>
                    <span class="dashicons dashicons-phone"></span>
                </td>
                <td>
                    <a class="phone-number" href="tel:<?php echo $diym_phone_number; ?>" target="_blank"><?php echo $diym_phone_number; ?></a>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="dashicons dashicons-email"></span>
                </td>
                <td>
                    <a href="mailto:<?php bloginfo( 'admin_email' ); ?>" target="_blank"><?php bloginfo( 'admin_email' ); ?></a>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="dashicons dashicons-admin-site-alt3"></span>
                </td>
                <td>
                    <a href="<?php bloginfo( 'url' ); ?>"><?php bloginfo( 'url' ); ?></a>
                </td>
            </tr>
        </table>
        <?php

        echo $args['after_widget'];
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] =  sanitize_text_field($new_instance['title']);
        /*
        $instance['post_count'] = intval($new_instance['post_count']);
        $instance['include_date'] = boolval($new_instance['include_date']);
        $instance['sort_by'] = _themename_sanitize_sort_by($new_instance['sort_by']);
        */
        return $instance;
    }
}

function diym_register_contact_details_widget() {
    register_widget('DIYM_Contact_Details_Widget');
}

add_action('widgets_init', 'diym_register_contact_details_widget');