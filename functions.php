<?php

define('DIYM_VER', 1.0);

define('DIYM_URL', trailingslashit(get_template_directory_uri()));
define('DIYM_JS_URL', trailingslashit(DIYM_URL . 'dist/assets/js'));
define('DIYM_CSS_URL', trailingslashit(DIYM_URL . 'dist/assets/css'));

function diym_assets()
{
    wp_enqueue_style('diym-stylesheet', DIYM_CSS_URL . 'bundle.css', [], DIYM_VER, 'all');

    wp_enqueue_script('diym-scripts', DIYM_JS_URL . 'bundle.js', ['jquery'], DIYM_VER, true);
}

add_action('wp_enqueue_scripts', 'diym_assets');

function diym_admin_assets()
{
    wp_enqueue_style('diym-admin-stylesheet', DIYM_CSS_URL . 'admin.css', [], DIYM_VER, 'all');

    wp_enqueue_script('diym-admin-scripts', DIYM_JS_URL . 'admin.js', [], DIYM_VER, true);
}

add_action('admin_enqueue_scripts', 'diym_admin_assets');
