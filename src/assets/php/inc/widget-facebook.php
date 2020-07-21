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

        $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__('Facebook', 'diy-marketer');

        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        echo $args['before_widget'];

        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }



        /*
        $monday_open = !empty( $instance['monday_open'] ) ? $instance['monday_open'] : '00:00';
        $monday_close = !empty( $instance['monday_close'] ) ? $instance['monday_close'] : '00:00';

        $tuesday_open = !empty( $instance['tuesday_open'] ) ? $instance['tuesday_open'] : '00:00';
        $tuesday_close = !empty( $instance['tuesday_close'] ) ? $instance['tuesday_close'] : '00:00';

        $wednesday_open = !empty( $instance['wednesday_open'] ) ? $instance['wednesday_open'] : '00:00';
        $wednesday_close = !empty( $instance['wednesday_close'] ) ? $instance['wednesday_close'] : '00:00';

        $thursday_open = !empty( $instance['thursday_open'] ) ? $instance['thursday_open'] : '00:00';
        $thursday_close = !empty( $instance['thursday_close'] ) ? $instance['thursday_close'] : '00:00';

        $friday_open = !empty( $instance['friday_open'] ) ? $instance['friday_open'] : '00:00';
        $friday_close = !empty( $instance['friday_close'] ) ? $instance['friday_close'] : '00:00';

        $saturday_open = !empty( $instance['saturday_open'] ) ? $instance['saturday_open'] : '00:00';
        $saturday_close = !empty( $instance['saturday_close'] ) ? $instance['saturday_close'] : '00:00';

        $sunday_open = !empty( $instance['sunday_open'] ) ? $instance['sunday_open'] : '00:00';
        $sunday_close = !empty( $instance['sunday_close'] ) ? $instance['sunday_close'] : '00:00'; 

        ?>
        <table style="width:100%">
            <tr>
                <td>Monday</td>
                <td><?php echo ( $monday_open == $monday_close ) ? 'Closed' : $monday_open . ' - ' . $monday_close; ?></td>    
            </tr>
            <tr>
                <td>Tuesday</td>
                <td><?php echo ( $tuesday_open == $tuesday_close ) ? 'Closed' : $tuesday_open . ' - ' . $tuesday_close; ?></td>    
            </tr>
            <tr>
                <td>Wednesday</td>
                <td><?php echo ( $wednesday_open == $wednesday_close ) ? 'Closed' : $wednesday_open . ' - ' . $wednesday_close; ?></td>    
            </tr>
            <tr>
                <td>Thursday</td>
                <td><?php echo ( $thursday_open == $thursday_close ) ? 'Closed' : $thursday_open . ' - ' . $thursday_close; ?></td>    
            </tr>
            <tr>
                <td>Friday</td>
                <td><?php echo ( $friday_open == $friday_close ) ? 'Closed' : $friday_open . ' - ' . $friday_close; ?></td>    
            </tr>
            <tr>
                <td>Saturday</td>
                <td><?php echo ( $saturday_open == $saturday_close ) ? 'Closed' : $saturday_open . ' - ' . $saturday_close; ?></td>
            </tr>
            <tr>
                <td>Sunday</td>
                <td><?php echo ( $sunday_open == $sunday_close ) ? 'Closed' : $sunday_open . ' - ' . $sunday_close; ?></td>    
            </tr>
        </table>
        <?php
        */

        echo $args['after_widget'];
    }

    public function form( $instance ) {

        $title = isset( $instance['title'] ) ? $instance['title'] : esc_html__('Facebook', 'diy-marketer');

        /*
        $monday_open = isset( $instance['monday_open'] ) ? $instance['monday_open'] : '00:00';
        $monday_close = isset( $instance['monday_close'] ) ? $instance['monday_close'] : '00:00';

        $tuesday_open = isset( $instance['tuesday_open'] ) ? $instance['tuesday_open'] : '00:00';
        $tuesday_close = isset( $instance['tuesday_close'] ) ? $instance['tuesday_close'] : '00:00';        

        $wednesday_open = isset( $instance['wednesday_open'] ) ? $instance['wednesday_open'] : '00:00';
        $wednesday_close = isset( $instance['wednesday_close'] ) ? $instance['wednesday_close'] : '00:00';

        $thursday_open = isset( $instance['thursday_open'] ) ? $instance['thursday_open'] : '00:00';
        $thursday_close = isset( $instance['thursday_close'] ) ? $instance['thursday_close'] : '00:00'; 

        $friday_open = isset( $instance['friday_open'] ) ? $instance['friday_open'] : '00:00';
        $friday_close = isset( $instance['friday_close'] ) ? $instance['friday_close'] : '00:00';        

        $saturday_open = isset( $instance['saturday_open'] ) ? $instance['saturday_open'] : '00:00';
        $saturday_close = isset( $instance['saturday_close'] ) ? $instance['saturday_close'] : '00:00';

        $sunday_open = isset( $instance['sunday_open'] ) ? $instance['sunday_open'] : '00:00';
        $sunday_close = isset( $instance['sunday_close'] ) ? $instance['sunday_close'] : '00:00'; 
        */
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title') ?>"><?php esc_html_e('Title:', 'diy-marketer'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <!--
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
        </p>-->
        

        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] =  sanitize_text_field($new_instance['title']);
/*
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
*/
        return $instance;
    }
}

function diym_register_facebook_widget() {
    register_widget('DIYM_Facebook_Widget');
}

add_action('widgets_init', 'diym_register_facebook_widget');