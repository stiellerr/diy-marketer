<?php
/**
 * Template part for displaying social link nav in banner
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DIY_Marketer
 */

$name          = get_bloginfo( 'name' );
$email         = get_bloginfo( 'admin_email' );
$url           = get_bloginfo( 'url' );

// object...
$details       = get_option( 'diym_details', null );

$temp           = null;
$phone          = null;

if ( $details ) {
    extract( $details );

    // build address html string...
    $temp = $street_address;

    $temp .= $temp && $suburb ? '<br>' : '';
    $temp .= $suburb;

    $temp .= $temp && ( $city || $postal_code ) ? '<br>' : '';
    $temp .= $city ? $post_code ? $city . ', ' . $post_code : $city : $post_code;
}

if ( $name || $temp || $phone || $email || $url ) {
    // build html string
    $html = "<table class='contact-details'>";
        if ( $name ) {
            $html .= "<tr>";
                $html .= "<td>";
                    $html .= "<i class='fas fa-user' data-content='f007'></i>";
                $html .= "</td>";
                $html .= "<td>{$name}</td>";
            $html .= "</tr>";
        }
        if ( $temp ) {
            $html .= "<tr>";
                $html .= "<td>";
                    $html .= "<i class='fas fa-map-marker-alt' data-content='f3c5'></i>";
                $html .= "</td>";
                $html .= "<td>{$temp}</td>";
            $html .= "</tr>";
        }
        if ( $phone ) {
            $html .= "<tr>";
                $html .= "<td>";
                    $html .= "<i class='fas fa-phone' data-content='f095'></i>";
                $html .= "</td>";
                $html .= "<td><a href='tel:{$phone}'>{$phone}</a></td>";
            $html .= "</tr>";
        }
        if ( $email ) {
            $html .= "<tr>";
                $html .= "<td>";
                    $html .= "<i class='fas fa-envelope' data-content='f0e0'></i>";
                $html .= "</td>";
                $html .= "<td><a href='mailto:{$email}'>{$email}</a></td>";
            $html .= "</tr>";
        }
        if ( $url ) {
            $html .= "<tr>";
                $html .= "<td>";
                    $html .= "<i class='fas fa-globe' data-content='f0ac'></i>";
                $html .= "</td>";
                $html .= "<td><a href='{$url}' target='_blank'>{$url}</a></td>";
            $html .= "</tr>";
        }
    $html .= "</table>";
    echo $html;
}
?>