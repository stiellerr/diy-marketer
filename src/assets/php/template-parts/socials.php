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
$diym_youtube       = get_theme_mod( 'diym_youtube', 'youtube.com/youtube' );

if ( $diym_facebook || $diym_instagram || $diym_twitter || $diym_youtube ) { ?>
    <div class="site-socials">
        <?php if ( $diym_facebook ) { ?>
            <a class="facebook" href="<?php echo $diym_facebook; ?>" target="_blank">
                <i class="fab fa-facebook-f"></i>
            </a>
        <?php } ?>
        <?php if ( $diym_instagram ) { ?>
            <a class="instagram" href="<?php echo $diym_instagram; ?>" target="_blank">
                <i class="fab fa-instagram"></i>
            </a>
        <?php } ?>
        <?php if ( $diym_twitter ) { ?>
            <a class="twitter" href="<?php echo $diym_twitter; ?>" target="_blank">
                <i class="fab fa-twitter"></i>
            </a>
        <?php } ?>
        <?php if ( $diym_youtube ) { ?>
            <a class="youtube" href="<?php echo $diym_youtube; ?>" target="_blank">
                <i class="fab fa-youtube"></i>
            </a>               
        <?php } ?>
        </div>
    <?php
}
?>