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
 * default format is 'H:i' to test for time only in this format '24:00'
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
            'diym_business_hours',
            esc_html__('Business Hours', 'diy-marketer'),
            array(
                'description' => esc_html__("Displays your business' hours", 'diy-marketer'),
                'customize_selective_refresh' => true
            )
        );
    }

    function render_row( $open, $close ) {
        if ( $open == $close ) {
            return "Closed";
        }
        if ( $open == '00:00' && $close == '23:59' ) {
            return "24 Hours";
        }

        return "<time>{$open}</time> - <time>{$close}</time>";
    }

    public function widget($args, $instance) {

        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__('Business Hours', 'diy-marketer');

        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        echo $args['before_widget'];

        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        $hours = get_theme_mod( 'hours', null );

        if ( !empty( $hours ) ) {
            extract( $hours );
        
            ?>

            <table style="width:100%">
                <tr>
                    <td>Monday</td>
                    <td><?php echo $this->render_row( $monday_open, $monday_close ); ?></td>
                </tr>
                <tr>
                    <td>Tuesday</td>
                    <td><?php echo $this->render_row( $tuesday_open, $tuesday_close ); ?></td>
                </tr>
                <tr>
                    <td>Wednesday</td>
                    <td><?php echo $this->render_row( $wednesday_open, $wednesday_close ); ?></td>
                </tr>
                <tr>
                    <td>Thursday</td>
                    <td><?php echo $this->render_row( $thursday_open, $thursday_close ); ?></td>
                </tr>
                <tr>
                    <td>Friday</td>
                    <td><?php echo $this->render_row( $friday_open, $friday_close ); ?></td>
                </tr>
                <tr>
                    <td>Saturday</td>
                    <td><?php echo $this->render_row( $saturday_open, $saturday_close ); ?></td>
                </tr>
                <tr>
                    <td>Sunday</td>
                    <td><?php echo $this->render_row( $sunday_open, $sunday_close ); ?></td>
                </tr>
            </table>
            
            <?php
        }

        echo $args['after_widget'];
    }

    public function form( $instance ) {

        $title = isset( $instance['title'] ) ? $instance['title'] : esc_html__('Business Hours', 'diy-marketer');

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

function diym_register_business_hours_widget() {
    register_widget('DIYM_Business_Hours_Widget');
}

add_action('widgets_init', 'diym_register_business_hours_widget');