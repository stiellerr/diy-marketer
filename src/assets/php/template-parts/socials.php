<?php
/**
 * Template part for displaying social link nav in banner
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DIY_Marketer
 */

$diym_facebook      = get_theme_mod( 'diym_facebook', 'facebook.com/facebook' );
$diym_instagram     = get_theme_mod( 'diym_instagram', 'instagram.com/instagram' );
$diym_twitter       = get_theme_mod( 'diym_twitter', 'twitter.com/twitter' );

?>

<ul id="socials" class="nav d-inline-flex text-nowrap">
    <?php if ( $diym_facebook ) { ?>
        <li class="nav-item">
            <a class="px-n0_5" href="<?php echo $diym_facebook; ?>" target="_blank">
                <span style="line-height: 24px;" class="dashicons dashicons-facebook-alt"></span>
            </a>
        </li>
    <?php } ?>
    <?php if ( $diym_instagram ) { ?>
        <li class="nav-item">
            <a class="px-0_5" href="<?php echo $diym_instagram; ?>" target="_blank">
                <span style="line-height: 24px;" class="dashicons dashicons-instagram"></span>
            </a>
        </li>
    <?php } ?>
    <?php if ( $diym_twitter ) { ?>
        <li class="nav-item">
            <a class="px-0_5" href="<?php echo $diym_twitter; ?>" target="_blank">
                <span style="line-height: 24px;" class="dashicons dashicons-twitter"></span>
            </a>
        </li>
    <?php } ?>
</ul>