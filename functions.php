<?php if (!defined('DIYM_VER')) {
    define('DIYM_VER', '1.0.0');
}
define('DIYM_URL', trailingslashit(get_template_directory_uri()));
define('DIYM_JS_URL', trailingslashit(DIYM_URL . 'dist/assets/js'));
define('DIYM_CSS_URL', trailingslashit(DIYM_URL . 'dist/assets/css'));
if (!function_exists('diym_setup')):
    function diym_setup() {
        register_nav_menus([
            'menu-1' => esc_html__('Primary', 'diy-marketer'),
            'menu-2' => esc_html__('Footer', 'diy-marketer'),
        ]);
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
function diym_assets() {
    wp_enqueue_style('diym-stylesheet', DIYM_CSS_URL . 'bundle.css', [], DIYM_VER, 'all');
    wp_enqueue_script('diym-scripts', DIYM_JS_URL . 'bundle.js', ['jquery'], DIYM_VER, true);
}
add_action('wp_enqueue_scripts', 'diym_assets');
function diym_admin_assets() {
    wp_enqueue_style('diym-admin-stylesheet', DIYM_CSS_URL . 'admin.css', [], DIYM_VER, 'all');
    wp_enqueue_script('diym-admin-scripts', DIYM_JS_URL . 'admin.js', [], DIYM_VER, true);
}
add_action('admin_enqueue_scripts', 'diym_admin_assets');
function diym_nav_menu_css_class($classes, $item, $args, $depth) {
    $classes[] = 'nav-item';
    if (in_array('menu-item-has-children', $classes)) {
        $classes[] = 'dropdown';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'diym_nav_menu_css_class', 10, 4);
function diym_nav_menu_link_attributes($atts, $item, $args, $depth) {
    if (in_array('menu-item-has-children', $item->classes)) {
        $atts['href'] = '#';
        $atts['data-toggle'] = 'dropdown';
        $atts['aria-haspopup'] = 'true';
        $atts['aria-expanded'] = 'false';
        $atts['class'] = 'nav-link dropdown-toggle';
    } else {
        if ($depth > 0) {
            $atts['class'] = 'dropdown-item';
        } else {
            $atts['class'] = 'nav-link';
        }
    }
    if ($item->current) {
        $atts['class'] .= ' active';
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'diym_nav_menu_link_attributes', 10, 4);
function diym_nav_menu_submenu_css_class($classes, $args, $depth) {
    $classes[] = 'dropdown-menu';
    return $classes;
}
add_filter('nav_menu_submenu_css_class', 'diym_nav_menu_submenu_css_class', 10, 4); ?>
