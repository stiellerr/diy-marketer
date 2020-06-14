<?php
/**
 * DIY Marketer Theme Inline CSS
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package DIY_Marketer
 */

// Get Theme Mods.
$diym_font_select = get_theme_mod( 'diym_font_select', 'default' );
$diym_primary_color = sanitize_hex_color( get_theme_mod( 'diym_primary_color', '#007bff' ) );

// font
$diym_inline_css .= ( $diym_font_select != 'default' ) ? "body{font-family:{$diym_font_select};}" : '';

// colors
$diym_inline_css .= ".border-primary{border-color:{$diym_primary_color}!important;}";

// nav
$diym_inline_css .= ".nav-pills .nav-link.active,.nav-pills .show > .nav-link{background-color:{$diym_primary_color};}";

//
$diym_inline_css .= "a{color:{$diym_primary_color};}";


// zzz Reece.
/*
$diym_inline_selectors = array(
  'body' => array(
    'font-family' => ''
  )
)
*/


/*
.nav-pills .nav-link.active,.nav-pills .show > .nav-link {
    color: #fff;
    background-color: #007bff;
  }
*/

 /**
 * End of file.
 */
?>