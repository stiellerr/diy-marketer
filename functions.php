<?php
/**
 * DIY Marketer functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package DIY_Marketer
 */

if (!defined('DIYM_VER')) {
    // Replace the version number of the theme on each release.
    define('DIYM_VER', '1.0.0');
}

define('DIYM_URL', trailingslashit(get_template_directory_uri()));
define('DIYM_JS_URL', trailingslashit(DIYM_URL . 'dist/assets/js'));
define('DIYM_CSS_URL', trailingslashit(DIYM_URL . 'dist/assets/css'));

if (!function_exists('diym_setup')):
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function diym_setup()
    {
        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support('custom-logo', [
            'height' => 80,
            'width' => 80,
            'flex-width' => true,
            'flex-height' => false,
            'header-text' => ['site-banner'],
        ]);
    }
endif;
add_action('after_setup_theme', 'diym_setup');

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
