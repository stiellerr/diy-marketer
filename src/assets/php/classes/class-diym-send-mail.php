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
               
            wp_enqueue_script( 'diym-mail', get_template_directory_uri() . '/dist/assets/js/mail.js', array( 'jquery' ), DIYM_VER, true );
            wp_localize_script('diym-mail', 'diymMailVars', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
        }

        /**
		 * Enqueue our scripts and styles
		 */
		public function send_form() {
            //error_log( 'send_form' );
        }
    }
}

?>