/* global diymBgColors, diymPreviewEls */
/* eslint no-unused-vars: off */
/**
 * File customize-preview.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

import $ from "jquery";

// Add listener for the "header_footer_background_color" control.
wp.customize("header_footer_background_color", value => {
    value.bind(function (to) {
        // Add background color to header and footer wrappers.
        $(".site-banner, #site-footer").css("background-color", to);

        //console.log(diymPreviewEls);

        /*
        // Change body classes if this is the same background-color as the content background.
        if (to.toLowerCase() === api("background_color").get().toLowerCase()) {
            $("body").addClass("reduced-spacing");
        } else {
            $("body").removeClass("reduced-spacing");
        }
        */
    });
});
