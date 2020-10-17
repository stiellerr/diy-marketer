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
        ?>
            <div class="site-socials">
                <?php if ( $facebook ) { ?>
                    <a class="facebook" href="<?php echo $facebook; ?>" target="_blank">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                <?php } ?>
                <?php if ( $instagram ) { ?>
                    <a class="instagram" href="<?php echo $instagram; ?>" target="_blank">
                        <i class="fab fa-instagram"></i>
                    </a>
                <?php } ?>
                <?php if ( $twitter ) { ?>
                    <a class="twitter" href="<?php echo $twitter; ?>" target="_blank">
                        <i class="fab fa-twitter"></i>
                    </a>
                <?php } ?>
                <?php if ( $youtube ) { ?>
                    <a class="youtube" href="<?php echo $youtube; ?>" target="_blank">
                        <i class="fab fa-youtube"></i>
                    </a>               
                <?php } ?>
            </div>
        <?php
    }
}
?>