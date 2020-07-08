<?php
/**
 * DIY Marketer business hours custom widget
 *
 * @link https://developer.wordpress.org/themes/functionality/widgets/
 *
 * @package DIY_Marketer
 */

class DIYM_Business_Hours_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'diym_business_hours_widget',
            esc_html__('Business Hours', 'diy-marketer'),
            array(
                'description' => esc_html__("Displays your business' hours", 'diy-marketer'),
                'customize_selective_refresh' => true
            )
        );
    }

    public function form( $instance ) {
        if(isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = "Business Hours";
        }

        if(isset($instance['monday_open'])) {
            $monday_open = $instance['monday_open'];
        } else {
            $monday_open = '00:00';
        }

        if(isset($instance['monday_close'])) {
            $monday_close = $instance['monday_close'];
        } else {
            $monday_close = '00:00';
        }

        if(isset($instance['tuesday_open'])) {
            $tuesday_open = $instance['tuesday_open'];
        } else {
            $tuesday_open = '00:00';
        }

        if(isset($instance['tuesday_close'])) {
            $tuesday_close = $instance['tuesday_close'];
        } else {
            $tuesday_close = '00:00';
        }


        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title') ?>"><?php esc_html_e('Title:', 'diy-marketer'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <table>
                <tr style="text-align: center;">
                    <th>Day</th>
                    <th>Open</th>
                    <th>Close</th>
                </tr>
                <tr>
                    <td>Monday</td>
                    <td>
                        <input class="" id="<?php echo $this->get_field_id('monday_open') ?>" name="<?php echo $this->get_field_name('monday_open') ?>" type="time" value="<?php echo esc_attr($monday_open); ?>" />
                    </td>
                    <td>
                        <input class="" id="<?php echo $this->get_field_id('monday_close') ?>" name="<?php echo $this->get_field_name('monday_close') ?>" type="time" value="<?php echo esc_attr($monday_close); ?>" />
                    </td>
                </tr>
                <tr>
                    <td>Tuesday</td>
                    <td>
                        <input class="" id="<?php echo $this->get_field_id('tuesday_open') ?>" name="<?php echo $this->get_field_name('tuesday_open') ?>" type="time" value="<?php echo esc_attr($tuesday_open); ?>" />
                    </td>
                    <td>
                        <input class="" id="<?php echo $this->get_field_id('tuesday_close') ?>" name="<?php echo $this->get_field_name('tuesday_close') ?>" type="time" value="<?php echo esc_attr($tuesday_close); ?>" />
                    </td>
                </tr>
             </table>
        </p>

        <?php
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];

            if(isset($instance['title']) && !empty($instance['title'])) {

                //var_dump($this);
                $title = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);
                echo $args['before_title'] . esc_html($title) . $args['after_title'];
            }

            if(isset($instance['monday_open']) && !empty($instance['monday_open'])) {
                $monday_open = $instance['monday_open'];
                echo '<div>' . $monday_open . '</div>';
            }

        echo $args['after_widget'];
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] =  sanitize_text_field($new_instance['title']);


        $instance['monday_open'] = sanitize_text_field($new_instance['monday_open']);
        $instance['monday_close'] = sanitize_text_field($new_instance['monday_close']);

        $instance['tuesday_open'] = sanitize_text_field($new_instance['tuesday_open']);
        $instance['tuesday_close'] = sanitize_text_field($new_instance['tuesday_close']);

        //$instance['monday_open'] = sanitize_text_field($new_instance['monday_open']);

        /*
        $instance['post_count'] = intval($new_instance['post_count']);
        $instance['include_date'] = boolval($new_instance['include_date']);
        $instance['sort_by'] = _themename_sanitize_sort_by($new_instance['sort_by']);
        */
        return $instance;
    }
}

function diym_register_business_hours_widget() {
    register_widget('DIYM_Business_Hours_Widget');
}

add_action('widgets_init', 'diym_register_business_hours_widget');