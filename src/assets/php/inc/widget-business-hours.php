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

        $hours = get_option( 'diym_hours', null );

        if ( !empty( $hours ) ) {
            extract( $hours );

            $html = '<table style="width:100%">';
                $html .= '<tr>';
                    $html .= '<td>Monday</td>';
                    $html .= "<td>" . $this->render_row( $monday_open, $monday_close ) . "</td>";
                $html .= '</tr>';
                $html .= '<tr>';
                    $html .= '<td>Tuesday</td>';
                    $html .= "<td>" . $this->render_row( $tuesday_open, $tuesday_close ) . "</td>";
                $html .= '</tr>';
                $html .= '<tr>';
                    $html .= '<td>Wednesday</td>';
                    $html .= "<td>" . $this->render_row( $wednesday_open, $wednesday_close ) . "</td>";
                $html .= '</tr>';
                $html .= '<tr>';
                    $html .= '<td>Thursday</td>';
                    $html .= "<td>" . $this->render_row( $thursday_open, $thursday_close ) . "</td>";
                $html .= '</tr>';
                $html .= '<tr>';
                    $html .= '<td>Friday</td>';
                    $html .= "<td>" . $this->render_row( $friday_open, $friday_close ) . "</td>";
                $html .= '</tr>';
                $html .= '<tr>';
                    $html .= '<td>Saturday</td>';
                    $html .= "<td>" . $this->render_row( $saturday_open, $saturday_close ) . "</td>";
                $html .= '</tr>';
                $html .= '<tr>';
                    $html .= '<td>Sunday</td>';
                    $html .= "<td>" . $this->render_row( $sunday_open, $sunday_close ) . "</td>";
                $html .= '</tr>';
            $html .= '</table>';

            echo $html;
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