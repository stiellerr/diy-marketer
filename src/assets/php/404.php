<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package DIY_Marketer
 */

get_header(); ?>
    <div class="row flex-grow-1 py-3 border-top">
        <div class="text-center align-self-center">
            <i class="fas fa-exclamation-triangle fa-3x" data-content="f071"></i>
            <h1>Error 404</h1>
            <h2>Opps! that page could not be found.</h2>
        </div>
    </div>
<?php get_footer(); ?>
