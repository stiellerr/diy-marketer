<?php
/**
 * DIY Marketer send mail
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package DIY_Marketer
 */

if ( ! class_exists( 'DIYM_Send_Mail' ) ) {

    /**
     * Image Radio Button Custom Control
     *
     * @author Anthony Hortin <http://maddisondesigns.com>
     * @license http://www.gnu.org/licenses/gpl-2.0.html
     * @link https://github.com/maddisondesigns
     */
    class DIYM_Send_Mail {

        function __construct() {

            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );

            add_action('wp_ajax_send_form', array( $this, 'send_form' ) ); // This is for authenticated users
            add_action('wp_ajax_nopriv_send_form', array( $this, 'send_form') ); // This is for unauthenticated users.
        }

        /**
		 * Enqueue our scripts and styles
		 */
		public function enqueue() {         

            //wp_enqueue_script( 'diym-mail', get_template_directory_uri() . '/dist/assets/js/mail.js', array( 'jquery' ), DIYM_VER, true );
            wp_enqueue_script( 'diym-mail', get_template_directory_uri() . '/assets/js/mail.js', array( 'jquery' ), filemtime( get_template_directory() . '/assets/js/mail.js'), true );
            wp_localize_script( 'diym-mail', 'diymMailVars',
                array( 
                    'ajax_url' => admin_url( 'admin-ajax.php' ),
                    'ajax_nonce' => wp_create_nonce( 'secure_nonce_name' )
                )
            );
        }

        /**
		 * Enqueue our scripts and styles
		 */
		public function send_form() {

            // check form submit has been done from a valid source.
            check_ajax_referer( 'secure_nonce_name', 'security' );

            $allowed = array( 'name', 'email', 'phone', 'message' );
            $body = '';

            // retrieve form post vars
            foreach ( $_POST as $key => $value ) {
                if ( in_array( $key, $allowed ) ) {
                    if ( $value ) {
                        $body .= ucfirst($key) . ': ' . $value . "\n";
                    }
                }
            }

            $to = get_bloginfo( 'admin_email' );

            if ( ! $body || ! is_email( $to ) ) {
                error_log('zzz');
                wp_send_json_error( null, 400 );
            }
            
            $subject = __( 'New Website Enquiry.', 'diy-marketer' );
            
            // get domain name...
            $domain = parse_url( home_url(), PHP_URL_HOST );
            $name = get_bloginfo( 'name' );

            if ( $name && $domain ) {
                $headers[] = 'From: ' . $name . ' <no-reply@' . $domain . '>';
            }
                        
            // send the email.
            $result = wp_mail( $to, $subject, $body, $headers );

            if ( $result ) {
                wp_send_json_success( __( 'Thanks, we will be in touch shortly!', 'diy-marketer' ) );
            }

            // if we get to this point, something is wrong...
            wp_send_json_error( null, 500 );
        }
    }
}

?>