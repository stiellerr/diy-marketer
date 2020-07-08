<?php
/**
 * DIY Marketer business hours custom widget
 *
 * @link https://developer.wordpress.org/themes/functionality/widgets/
 *
 * @package DIY_Marketer
 */

/**
 * Sanitizes date time input
 * https://www.lehelmatyus.com/1416/sanitize-date-time-value-in-wordpress
 * 
 * @return String
 */

function sanitize_event_time($event_time) {

    // General sanitization, to get rid of malicious scripts or characters
    $event_time = sanitize_text_field($event_time);
    $event_time = filter_var($event_time, FILTER_SANITIZE_STRING);

    // Validation to see if it is the right format
    if (_my_validate_date($event_time)){
        return $event_time;
    }

    // default value, to return if checks have failed
    return "00:00";
}

/**
 * Validates that a date string is in the right format
 * default format is 'g:i a' to test for time only in this format '5:00 am'
 * but you can pass a new format to test against other formats
 * other formats here https://www.lehelmatyus.com/1003/android-change-date-format-from-utc-to-local-time
 * 
 * @return bool
 */

function _my_validate_date($date, $format = 'H:i') {
    // Create the format date
    $d = DateTime::createFromFormat($format, $date);

    // Return the comparison    
    return $d && $d->format($format) === $date;
}

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

        if(isset($instance['wednesday_open'])) {
            $wednesday_open = $instance['wednesday_open'];
        } else {
            $wednesday_open = '00:00';
        }

        if(isset($instance['wednesday_close'])) {
            $wednesday_close = $instance['wednesday_close'];
        } else {
            $wednesday_close = '00:00';
        }

        if(isset($instance['thursday_open'])) {
            $thursday_open = $instance['thursday_open'];
        } else {
            $thursday_open = '00:00';
        }

        if(isset($instance['thursday_close'])) {
            $thursday_close = $instance['thursday_close'];
        } else {
            $thursday_close = '00:00';
        }

        if(isset($instance['friday_open'])) {
            $friday_open = $instance['friday_open'];
        } else {
            $friday_open = '00:00';
        }

        if(isset($instance['friday_close'])) {
            $friday_close = $instance['friday_close'];
        } else {
            $friday_close = '00:00';
        }

        if(isset($instance['saturday_open'])) {
            $saturday_open = $instance['saturday_open'];
        } else {
            $saturday_open = '00:00';
        }

        if(isset($instance['saturday_close'])) {
            $saturday_close = $instance['saturday_close'];
        } else {
            $saturday_close = '00:00';
        }

        if(isset($instance['sunday_open'])) {
            $sunday_open = $instance['sunday_open'];
        } else {
            $sunday_open = '00:00';
        }

        if(isset($instance['sunday_close'])) {
            $sunday_close = $instance['sunday_close'];
        } else {
            $sunday_close = '00:00';
        }

        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title') ?>"><?php esc_html_e('Title:', 'diy-marketer'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <table>
                <tr>
                    <th>Day</th>
                    <th>Open</th>
                    <th>Close</th>
                </tr>
                <tr>
                    <td>Monday:</td>
                    <td>
                        <input id="<?php echo $this->get_field_id('monday_open') ?>" name="<?php echo $this->get_field_name('monday_open') ?>" type="time" value="<?php echo esc_attr($monday_open); ?>" />
                    </td>
                    <td>
                        <input id="<?php echo $this->get_field_id('monday_close') ?>" name="<?php echo $this->get_field_name('monday_close') ?>" type="time" value="<?php echo esc_attr($monday_close); ?>" />
                    </td>
                </tr>
                <tr>
                    <td>Tuesday:</td>
                    <td>
                        <input id="<?php echo $this->get_field_id('tuesday_open') ?>" name="<?php echo $this->get_field_name('tuesday_open') ?>" type="time" value="<?php echo esc_attr($tuesday_open); ?>" />
                    </td>
                    <td>
                        <input id="<?php echo $this->get_field_id('tuesday_close') ?>" name="<?php echo $this->get_field_name('tuesday_close') ?>" type="time" value="<?php echo esc_attr($tuesday_close); ?>" />
                    </td>
                </tr>
                <tr>
                    <td>Wednesday:</td>
                    <td>
                        <input id="<?php echo $this->get_field_id('wednesday_open') ?>" name="<?php echo $this->get_field_name('wednesday_open') ?>" type="time" value="<?php echo esc_attr($wednesday_open); ?>" />
                    </td>
                    <td>
                        <input id="<?php echo $this->get_field_id('wednesday_close') ?>" name="<?php echo $this->get_field_name('wednesday_close') ?>" type="time" value="<?php echo esc_attr($wednesday_close); ?>" />
                    </td>
                </tr>
                <tr>
                    <td>Thursday:</td>
                    <td>
                        <input id="<?php echo $this->get_field_id('thursday_open') ?>" name="<?php echo $this->get_field_name('thursday_open') ?>" type="time" value="<?php echo esc_attr($thursday_open); ?>" />
                    </td>
                    <td>
                        <input id="<?php echo $this->get_field_id('thursday_close') ?>" name="<?php echo $this->get_field_name('thursday_close') ?>" type="time" value="<?php echo esc_attr($thursday_close); ?>" />
                    </td>
                </tr>
                <tr>
                    <td>Friday:</td>
                    <td>
                        <input id="<?php echo $this->get_field_id('friday_open') ?>" name="<?php echo $this->get_field_name('friday_open') ?>" type="time" value="<?php echo esc_attr($friday_open); ?>" />
                    </td>
                    <td>
                        <input id="<?php echo $this->get_field_id('friday_close') ?>" name="<?php echo $this->get_field_name('friday_close') ?>" type="time" value="<?php echo esc_attr($friday_close); ?>" />
                    </td>
                </tr>
                <tr>
                    <td>Saturday:</td>
                    <td>
                        <input id="<?php echo $this->get_field_id('saturday_open') ?>" name="<?php echo $this->get_field_name('saturday_open') ?>" type="time" value="<?php echo esc_attr($saturday_open); ?>" />
                    </td>
                    <td>
                        <input id="<?php echo $this->get_field_id('saturday_close') ?>" name="<?php echo $this->get_field_name('saturday_close') ?>" type="time" value="<?php echo esc_attr($saturday_close); ?>" />
                    </td>
                </tr>
                <tr>
                    <td>Sunday:</td>
                    <td>
                        <input id="<?php echo $this->get_field_id('sunday_open') ?>" name="<?php echo $this->get_field_name('sunday_open') ?>" type="time" value="<?php echo esc_attr($sunday_open); ?>" />
                    </td>
                    <td>
                        <input id="<?php echo $this->get_field_id('sunday_close') ?>" name="<?php echo $this->get_field_name('sunday_close') ?>" type="time" value="<?php echo esc_attr($sunday_close); ?>" />
                    </td>
                </tr>
             </table>
        </p>

        <?php
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];

            if(isset($instance['title']) && !empty($instance['title'])) {
                $title = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);
                echo $args['before_title'] . esc_html($title) . $args['after_title'];
            }

            echo '<table class="w-100">';

            if(isset($instance['monday_open']) && !empty($instance['monday_open']) && isset($instance['monday_close']) && !empty($instance['monday_close'])) {
                echo '<td>Monday</td>';
                $monday_open = $instance['monday_open'];
                $monday_close = $instance['monday_close'];
                echo '<td>';
                if ( $monday_open == $monday_close ) {
                    echo 'Closed';
                } else {
                    echo $monday_open . ' - ' . $monday_close;
                }
                echo '</td>';
            }

            echo '</table>';

        echo $args['after_widget'];
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] =  sanitize_text_field($new_instance['title']);

        $instance['monday_open'] = sanitize_event_time($new_instance['monday_open']);
        $instance['monday_close'] = sanitize_event_time($new_instance['monday_close']);

        $instance['tuesday_open'] = sanitize_event_time($new_instance['tuesday_open']);
        $instance['tuesday_close'] = sanitize_event_time($new_instance['tuesday_close']);

        $instance['wednesday_open'] = sanitize_event_time($new_instance['wednesday_open']);
        $instance['wednesday_close'] = sanitize_event_time($new_instance['wednesday_close']);

        $instance['thursday_open'] = sanitize_event_time($new_instance['thursday_open']);
        $instance['thursday_close'] = sanitize_event_time($new_instance['thursday_close']);

        $instance['friday_open'] = sanitize_event_time($new_instance['friday_open']);
        $instance['friday_close'] = sanitize_event_time($new_instance['friday_close']);

        $instance['saturday_open'] = sanitize_event_time($new_instance['saturday_open']);
        $instance['saturday_close'] = sanitize_event_time($new_instance['saturday_close']);

        $instance['sunday_open'] = sanitize_event_time($new_instance['sunday_open']);
        $instance['sunday_close'] = sanitize_event_time($new_instance['sunday_close']);

        return $instance;
    }
}

function diym_register_business_hours_widget() {
    register_widget('DIYM_Business_Hours_Widget');
}

add_action('widgets_init', 'diym_register_business_hours_widget');