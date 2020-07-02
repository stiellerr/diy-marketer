<?php
/**
 * DIY Marketer Theme Inline CSS
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package DIY_Marketer
 */

$diym_inline_selectors = [];
$diym_inline_styles = '';

// Get Theme Options.
$diym_font_select         = get_theme_mod( 'diym_font_select', 'default' );
$diym_primary_color       = sanitize_hex_color( get_theme_mod( 'diym_primary_color', '#007bff' ) );
$diym_banner_footer_bg    = sanitize_hex_color( get_theme_mod( 'diym_banner_footer_bg', '#343a40' ) );
$diym_banner_footer_text  = sanitize_hex_color( get_theme_mod( 'diym_banner_footer_text', '#ffffff' ) );

// build array
if ( $diym_font_select != 'default' ) {
  $diym_inline_selectors['body'] = ['font-family' => 'diym_font_select'];
}

$diym_inline_selectors['.border-primary'] = ['border-color' => 'diym_primary_color' . ',!important'];
// same as above without: '!important'
$diym_inline_selectors['#main-nav .nav-item .nav-link:hover'] = ['border-color' => 'diym_primary_color'];

$diym_inline_selectors['.nav-pills .nav-link.active,.nav-pills .show > .nav-link'] = ['background-color' => 'diym_primary_color'];

$diym_inline_selectors['a,.nav-link:hover'] = ['color' => 'diym_primary_color'];

$diym_inline_selectors['.site-banner,#site-footer'] = ['background-color' => 'diym_banner_footer_bg', 'color' => 'diym_banner_footer_text'];

$diym_inline_selectors['.site-banner a,#site-footer a'] = ['color' => 'diym_banner_footer_text'];

$diym_inline_selectors['#footer-nav .nav-item .nav-link:hover'] = ['border-right-color' => 'diym_banner_footer_text'];

$diym_inline_selectors['.site-banner a:hover,#site-footer a:hover'] = ['color' => 'diym_primary_color'];

// build inline css string
foreach ($diym_inline_selectors as $selector => $props) {
  $diym_inline_styles .= "{$selector}{";
  foreach ($props as $prop => $prop_str){
    $prop_arr = explode(",", $prop_str);
    $val = $prop_arr[0];
    $arg = ( isset($prop_arr[1] )) ? $prop_arr[1] : '';
    $diym_inline_styles .= "{$prop}:{$$val}{$arg};";
  }
  $diym_inline_styles .= "}";
}

 /**
 * End of file.
 */
?>