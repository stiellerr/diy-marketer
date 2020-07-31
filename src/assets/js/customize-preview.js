/* global diymBgColors, diymPreviewEls, _ */
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
    value.bind(to => {
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

wp.customize("diym_font_select", value => {
    value.bind(to => {
        if ("default" !== to) {
            $("body").css("font-family", to);
        }
    });
});

// Add listener for the accent color.
wp.customize("accent_hue", value => {
    value.bind(() => {
        // Generate the styles.
        // Add a small delay to be sure the accessible colors were generated.
        setTimeout(() => {
            for (let context of Object.keys(diymBgColors)) {
                diymGenerateColorA11yPreviewStyles(context);
            }
        }, 50);
    });
});

// Add listeners for background-color settings.
for (let context of Object.keys(diymBgColors)) {
    wp.customize(diymBgColors[context].setting, value => {
        value.bind(() => {
            // Generate the styles.
            // Add a small delay to be sure the accessible colors were generated.
            setTimeout(() => {
                diymGenerateColorA11yPreviewStyles(context);
            }, 50);
        });
    });
}

/**
 * Add styles to elements in the preview pane.
 *
 * @since Twenty Twenty 1.0
 *
 * @param {string} context The area for which we want to generate styles. Can be for example "content", "header" etc.
 *
 * @return {void}
 */
function diymGenerateColorA11yPreviewStyles(context) {
    // Get the accessible colors option.
    //let a11yColors = window.parent.wp.customize("accent_accessible_colors").get(),
    let a11yColors = window.parent.wp.customize.get().accent_accessible_colors,
        stylesheedID = "diym-customizer-styles-" + context,
        stylesheet = $("#" + stylesheedID),
        styles = "";

    // If the stylesheet doesn't exist, create it and append it to <head>.
    if (!stylesheet.length) {
        //$("#diym-style-inline-css").after('<style id="' + stylesheedID + '"></style>');
        $("#diym-stylesheet-inline-css").after('<style id="' + stylesheedID + '"></style>');
        stylesheet = $("#" + stylesheedID);
    }
    if (!_.isUndefined(a11yColors[context])) {
        // Check if we have elements defined.
        if (diymPreviewEls[context]) {
            _.each(diymPreviewEls[context], (items, setting) => {
                _.each(items, (elements, property) => {
                    if (!_.isUndefined(a11yColors[context][setting])) {
                        styles +=
                            elements.join(",") +
                            "{" +
                            property +
                            ":" +
                            a11yColors[context][setting] +
                            ";}";
                    }
                });
            });
        }
    }
    // Add styles.
    console.log(styles);
    stylesheet.html(styles);
}
