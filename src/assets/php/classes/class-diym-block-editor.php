<?php
/**
 * DIY Marketer block editor
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package DIY_Marketer
 */

if ( ! class_exists( 'DIYM_Block_Editor' ) ) {

    /**
     * Image Radio Button Custom Control
     *
     * @author Anthony Hortin <http://maddisondesigns.com>
     * @license http://www.gnu.org/licenses/gpl-2.0.html
     * @link https://github.com/maddisondesigns
     */
    class DIYM_Block_Editor {

        function __construct() {

            //add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );

            // 
            //add_action( 'enqueue_block_assets', array( $this, 'enqueue_block_assets' ) );


            add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_editor_assets' ), 9 );

            add_filter( 'block_categories', array( $this, 'diym_block_categories' ), 10, 2 );

            add_filter( 'init', array( &$this, 'register_meta' ) );
            //add_filter( 'init', array( &$this, 'register_page_template' ) );

            //add_action('wp_ajax_send_form', array( $this, 'send_form' ) ); // This is for authenticated users
            //add_action('wp_ajax_nopriv_send_form', array( $this, 'send_form') ); // This is for unauthenticated users.
        }

        function register_meta() {
            // metabox
            /*
            register_meta('post', '_diym_seo_page_title', array(
                    'show_in_rest' => true,
                    'type' => 'string',
                    'single' => true,
                    'sanitize_callback' => 'sanitize_text_field',
                    // needed if meta field starts with _ note: starting with _ hides the field from custom fields in classic editor. (which is why we do it)
                    'auth_callback' => function() {
                        return current_user_can( 'edit_posts' );
                    }
                )
            );
    properties: {
        my_prop1: {
            type: 'string',
            enum: [ 'Hello', 'Bye' ]
        },
        my_prop2: {
            type: 'integer'
        }
    }
            */
            register_meta('post',
                '_diym_post_meta',
                array(
                    'show_in_rest' => array(
                        'schema' => array(
                            'type'       => 'object',
                            'properties' => array(
                                'title' => array(
                                    'type' => 'string',
                                ),
                                'description'  => array(
                                    'type' => 'string',
                                ),
                            ),
                        )
                    ),
                    //),
                    'type' => 'object',
                    'single' => true,
                    'default' => array(
                        'title' => '',
                        'description' => '',
                    ),
                    'sanitize_callback' => 'diym_sanitize_text',
                    // needed if meta field starts with _ note: starting with _ hides the field from custom fields in classic editor. (which is why we do it)
                    'auth_callback' => function() {
                        return current_user_can( 'edit_posts' );
                    }
                )
            );
        }

        /*
        function register_page_template() {

            $post_type_object = get_post_type_object( 'page' );
            $post_type_object->template = array(
                array( 'diym/meta' )
            );
            //$post_type_object->template_lock = 'all';
        }
        */

        function diym_block_categories( $categories, $post ) {
            //
            //write_log( $categories );
            // merge custom block category.
            return array_merge(
                $categories,
                array(
                    array(
                        'slug'  => 'diy-marketer',
                        'title' => __( 'DIY Marketer', 'diy-marketer' ),
                        //'icon'  => 'wordpress'
                    )
                )
            );
        }

        /*
        function diym_editor_assets() {



            //wp_register_script( 'diy-marketer-blocks-script', get_template_directory_uri() . '/dist/assets/blocks/script.js', array( 'jquery' ), filemtime( get_template_directory() . '/dist/assets/blocks/script.js'), true );
        
            // Scripts.
            wp_enqueue_script(
                'diym-editor-assets',
                get_template_directory_uri() . '/dist/assets/blocks/assets.js',
                //array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-plugins', 'wp-components', 'wp-edit-post', 'wp-api', 'wp-editor', 'wp-hooks', 'lodash' ),
                array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-plugins', 'wp-components', 'wp-edit-post', 'wp-api', 'wp-editor', 'wp-hooks', 'lodash' ),
                time(),
                false
            );
        
        }
        */

        /**
		 * Enqueue our scripts and styles
		 */
        public function enqueue_block_editor_assets() {

            //$debug   = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG;
            $version = gmdate( 'Ymd' );
    
            wp_enqueue_script(
                'diym-block-editor-script',
                //'diym-block-editor-script',
                get_template_directory_uri() . '/assets/blocks/editor.js',
                /*
                $debug
                    ? '//widgets.wp.com/wpcom-block-editor/default.editor.js?minify=false'
                    : '//widgets.wp.com/wpcom-block-editor/default.editor.min.js',
                */
                array(
                    //'wp-hooks',
                    'wp-element',
                    'wp-data',
                    'wp-block-editor',
                    'wp-rich-text',
                    'wp-blocks',
                    'wp-i18n',
                    'wp-block-editor',
                    'wp-components',
                    'lodash',
                    'wp-plugins',
                    'wp-edit-post',
                    'wp-compose'

                    /*
                    'jquery',
                    'wp-compose',
                    'wp-data',
                    'wp-editor',
                    'wp-element',
                    'wp-rich-text',
                    */
                ),
                $version,
                true
            );

            // load font awesome data to browser...
            wp_localize_script(
                'diym-block-editor-script',
                'js_data',
                array(
                    'icons_json' => get_template_directory_uri() . '/assets/data/icons.json'
                )
            );



            wp_enqueue_style(
                'diym-block-editor-style',
                get_template_directory_uri() . '/assets/blocks/editor.css',
                /*
                $debug
                    ? '//widgets.wp.com/wpcom-block-editor/default.editor.js?minify=false'
                    : '//widgets.wp.com/wpcom-block-editor/default.editor.min.js',
                */
                array(
                    'wp-edit-blocks'
                ),
                $version,
                'all'
            );

            wp_add_inline_style( 'diym-block-editor-style', diym_get_customizer_css( 'block-editor' ) );

        }
    }
}

?>