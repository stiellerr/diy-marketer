<?php


function diy_marketer_blocks_register_block_type( $block, $options = array() ) {
    register_block_type( 
        'diy-marketer/' . $block,
        array_merge(
            array(
                'editor_script' => 'diy-marketer-blocks-editor-script',
                'editor_style' => 'diy-marketer-blocks-editor-style',
                'script' => 'diy-marketer-blocks-script',
                'style' => 'diy-marketer-blocks-style'
            ),
            $options
        )
    );
}

function diy_marketer_blocks_register() {

    wp_register_script( 'diy-marketer-blocks-editor-script', get_template_directory_uri() . '/dist/assets/blocks/editor.js', array( 'wp-blocks', 'wp-i18n', 'wp-element' ), filemtime( get_template_directory() . '/dist/assets/blocks/editor.js'), true );

    wp_register_script( 'diy-marketer-blocks-script', get_template_directory_uri() . '/dist/assets/blocks/script.js', array( 'jquery' ), filemtime( get_template_directory() . '/dist/assets/blocks/script.js'), true );

    wp_register_style( 'diy-marketer-blocks-editor-style', get_template_directory_uri() . '/dist/assets/blocks/editor.css', array( 'wp-edit-blocks' ), filemtime( get_template_directory() . '/dist/assets/blocks/editor.css'), 'all' );

    wp_register_style( 'diy-marketer-blocks-style', get_template_directory_uri() . '/dist/assets/blocks/style.css', array(), filemtime( get_template_directory() . '/dist/assets/blocks/style.css'), 'all' );
    
    //wp_enqueue_script( 'diym-admin-js', get_template_directory_uri() . '/dist/assets/js/admin.js', array(), DIYM_VER, true );

    diy_marketer_blocks_register_block_type( 'heading1' );
    diy_marketer_blocks_register_block_type( 'paragraph' );

}

add_action('init', 'diy_marketer_blocks_register');

?>