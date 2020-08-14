<?php
/**
 * Template part for displaying social link nav in banner
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DIY_Marketer
 */

$diym_name          = get_bloginfo( 'name' );
        
// get theme mods.
$diym_street_address= get_theme_mod( 'diym_streetAddress' );
$diym_suburb        = get_theme_mod( 'diym_suburb' );
$diym_city          = get_theme_mod( 'diym_city' );
$diym_postal_code   = get_theme_mod( 'diym_postal_code' );

//
$diym_phone_number  = get_theme_mod( 'diym_phoneNumber' );
$diym_email         = get_bloginfo( 'admin_email' );
$diym_url           = get_bloginfo( 'url' );

// build address string...
$temp  = $diym_street_address;

$temp .= $temp && $diym_suburb ? '<br>' : '';
$temp .= $diym_suburb;

$temp .= $temp && ( $diym_city || $diym_postal_code ) ? '<br>' : '';
$temp .= $diym_city ? $diym_postal_code ? $diym_city . ', ' . $diym_postal_code : $diym_city : $diym_postal_code;

?>
<table class="contact-details">
    <?php if ( $diym_name ) { ?>
        <tr>
            <td>
                <span class="dashicons dashicons-admin-users"></span>
            </td>
            <td><?php echo $diym_name; ?></td>
        </tr>
    <?php } ?>
    <?php if ( $temp ) { ?>
        <tr>
            <td>
                <span class="dashicons dashicons-location"></span>
            </td>
            <td><?php echo $temp; ?></td>
        </tr>
    <?php } ?>
    <?php if ( $diym_phone_number ) { ?>
        <tr>
            <td>
                <span class="dashicons dashicons-phone"></span>
            </td>
            <td>
                <a href="tel:<?php echo $diym_phone_number; ?>" target="_blank"><?php echo $diym_phone_number; ?></a>
            </td>
        </tr>
    <?php } ?>
    <?php if ( $diym_email ) { ?>
        <tr>
            <td>
                <span class="dashicons dashicons-email"></span>
            </td>
            <td>
                <a href="mailto:<?php echo $diym_email; ?>" target="_blank"><?php echo $diym_email; ?></a>
            </td>
        </tr>
    <?php } ?>
    <?php if ( $diym_url ) { ?>
        <tr>
            <td>
                <span class="dashicons dashicons-admin-site-alt3"></span>
            </td>
            <td>
                <a href="<?php echo $diym_url; ?>"><?php echo $diym_url; ?></a>
            </td>
        </tr>
    <?php } ?>
</table>