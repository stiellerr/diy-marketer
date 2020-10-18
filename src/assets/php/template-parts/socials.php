<?php
/**
 * Template part for displaying social link nav in banner
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DIY_Marketer
 */

$socials = get_theme_mod( 'socials', null );

if ( !empty( $socials ) ) {
    extract( $socials );

    if ( $facebook || $instagram || $youtube || $twitter ) {
        $html  = "<div class='site-socials'>";
            if ( $facebook ) {
                $html .="<a class='facebook' href='{$facebook}' target='_blank'>";
                    $html .= "<i class='fab fa-facebook-f'></i>";
                $html .="</a>";
            }
            if ( $instagram ) {
                $html .="<a class='instagram' href='{$instagram}' target='_blank'>";
                    $html .= "<i class='fab fa-instagram'></i>";
                $html .="</a>";
            }
            if ( $youtube ) {
                $html .="<a class='youtube' href='{$youtube}' target='_blank'>";
                    $html .= "<i class='fab fa-youtube'></i>";
                $html .="</a>";
            }
            if ( $twitter ) {
                $html .="<a class='twitter' href='{$twitter}' target='_blank'>";
                    $html .= "<i class='fab fa-twitter'></i>";
                $html .="</a>";
            }
        $html .= "</div>";
        echo $html;
    }
}