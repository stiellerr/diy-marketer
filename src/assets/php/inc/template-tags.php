<?php
/**
 * Custom template tags for this theme.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

/**
 * Menus
 */

/**
 * Add boostrap classes to menu elements.
 */
function diym_nav_menu_css_class( $classes, $item, $args, $depth ) {

	if ( $args->theme_location == 'primary' ) {
		$classes[] = 'nav-item';
		if ( in_array( 'menu-item-has-children', $classes ) ) {
			$classes[] = 'dropdown';
		}
	}
	return $classes;
}

add_filter( 'nav_menu_css_class', 'diym_nav_menu_css_class', 10, 4 );

function diym_nav_menu_link_attributes($atts, $item, $args, $depth) {

	if ( $args->theme_location == 'primary' ) {
		if ( in_array( 'menu-item-has-children', $item->classes ) && 0 === $depth && $args->depth > 1 ) {
			$atts['href']          = '#';
			$atts['data-toggle']   = 'dropdown';
			$atts['aria-haspopup'] = 'true';
			$atts['aria-expanded'] = 'false';
			$atts['class']         = 'nav-link dropdown-toggle';
			//$atts['id']            = 'menu-item-dropdown-' . $item->ID;
		} else {
			if ( $depth > 0 ) {
				$atts['class'] = 'dropdown-item';
			} else {
				$atts['class'] = 'nav-link';
			}
		}
		if ( $item->current ) {
			$atts['class'] .= ' active';
		}
	}
    return $atts;
}

add_filter( 'nav_menu_link_attributes', 'diym_nav_menu_link_attributes', 10, 4 );

function diym_nav_menu_submenu_css_class( $classes, $args, $depth ) {
	if ( $args->theme_location == 'primary' ) {
		$classes[] = 'dropdown-menu';
	}
	return $classes;
}

add_filter( 'nav_menu_submenu_css_class', 'diym_nav_menu_submenu_css_class', 10, 3 );

if ( ! function_exists( 'underscores_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function underscores_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

			<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
				<?php
					the_post_thumbnail(
						'post-thumbnail',
						array(
							'alt' => the_title_attribute(
								array(
									'echo' => false,
								)
							),
						)
					);
				?>
			</a>

			<?php
		endif; // End is_singular().
	}
endif;

?>