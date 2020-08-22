<?php
/**
 * Template part for displaying footer sidebars
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DIY_Marketer
 */

$sidebars = [];

$classes = array(
	1 => "col-12",
	2 => "col-12 col-md-6",
	3 => "col-12 col-md-4",
	4 => "col-12 col-md-6 col-lg-3"
);

// build an array of active sidebars...
for ( $i = 1; $i < 5; $i ++ ) {
    if ( is_active_sidebar( 'footer-' . $i ) ) {
        array_push( $sidebars, "footer-" . $i );
    }
}

$num_items = count( $sidebars );

// print the footer sidebars
foreach( $sidebars as $sidebar ) {
	echo '<div class="' . $classes[ $num_items ] . ' pt-4">';
		dynamic_sidebar( $sidebar );
	echo '</div>';
}

?>