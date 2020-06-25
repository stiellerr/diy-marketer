<?php
/**
 * Template part for displaying social link nav in banner
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DIY_Marketer
 */

$diym_phone_number  = get_theme_mod( 'diym_phone_number' );
$diym_facebook      = get_theme_mod( 'diym_facebook' );
$diym_instagram     = get_theme_mod( 'diym_instagram' );
$diym_twitter       = get_theme_mod( 'diym_twitter' );
?>

<ul id="socials" class="nav justify-content-center justify-content-md-end">
    <?php if ( $diym_phone_number ) { ?>
        <li class="nav-item">Call Now
            <a class="px-0_5 font-weight-bold phone-number" href="tel:<?php echo $diym_phone_number; ?>"><?php echo $diym_phone_number; ?></a>
        </li>
    <?php } ?>
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