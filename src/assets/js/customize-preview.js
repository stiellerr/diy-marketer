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
import { array_search } from "locutus/php/array";

// Generate styles on load. Handles page-changes on the preview pane.
$(document).ready(() => {
    diymGenerateColorPreviewStyles("content");
    diymGenerateColorPreviewStyles("banner-footer");
});

wp.customize("accent_color", value => {
    value.bind(to => {
        // Generate the styles.
        // Add a small delay to be sure the accessible colors were generated.
        setTimeout(() => {
            for (let context of Object.keys(diymBgColors)) {
                diymGenerateColorPreviewStyles(context);
            }
        }, 50);
    });
});

// Add listener for the "header_footer_background_color" control.
/*
wp.customize("banner_footer_background_color", value => {
    value.bind(to => {
        // Add background color to header and footer wrappers.
        $(".site-banner").css("background-color", to);
    });
});
*/

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

wp.customize("font_family", value => {
    value.bind(to => {
        if ("default" !== to) {
            $("body").css("font-family", to);
            //$(":root").css("font-family", to);
        }
    });
});

wp.customize("zzz_test2", value => {
    value.bind(to => {
        $("body").css(
            "background-image",
            "url('/wp-content/themes/diy-marketer/dist/assets/images/bg/" + to + ".png')"
        );
        ///dist/assets/images/bg/pattern1.png
        //console.log(to);
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
/*
for (let context of Object.keys(diymBgColors)) {
    //console.log(diymBgColors[context].setting);
    wp.customize(diymBgColors[context].setting, value => {
        value.bind(() => {
            // Generate the styles.
            // Add a small delay to be sure the accessible colors were generated.
            setTimeout(() => {
                //let a11yColors = window.parent.wp.customize.get().custom_colors;
                //console.log(a11yColors);
                //diymGenerateColorA11yPreviewStyles(context);
                diymGenerateColorPreviewStyles(context);
                //console.log(context);
            }, 50);
        });
    });
}
*/

wp.customize("banner_footer_background_color", value => {
    value.bind(() => {
        // Generate the styles.
        // Add a small delay to be sure the accessible colors were generated.
        setTimeout(() => {
            diymGenerateColorPreviewStyles("banner-footer");
        }, 50);
    });
});

/**
 * Add styles to elements in the preview pane.
 *
 * @since Twenty Twenty 1.0
 *
 * @param {string} context The area for which we want to generate styles. Can be for example "content", "header" etc.
 *
 * @return {void}
 */
function diymGenerateColorPreviewStyles(context) {
    // Get the accessible colors option.

    let a11yColors = window.parent.wp.customize.get().custom_colors,
        stylesheedID = "diym-customizer-styles-" + context,
        stylesheet = $("#" + stylesheedID),
        styles = "";

    //var x = new window.parent.Color("#ffffff");

    //console.log(context);

    // If the stylesheet doesn't exist, create it and append it to <head>.
    if (!stylesheet.length) {
        console.log("true");
        $("#diym-style-inline-css").after('<style id="' + stylesheedID + '"></style>');
        stylesheet = $("#" + stylesheedID);
    } else {
        console.log("false");
    }

    console.log(stylesheet);

    /*
    if (!_.isUndefined(a11yColors[context])) {
        // Check if we have elements defined.
        if (diymPreviewEls[context]) {
            _.each(diymPreviewEls[context], (definitions, setting) => {
                _.each(definitions, index => {
                    _.each(index, (options, property) => {
                        let selectors = !_.isUndefined(options.selector) ? options.selector : false;
                        if (
                            !_.isArray(selectors) ||
                            _.isEmpty(selectors) ||
                            _.isUndefined(a11yColors[context][setting])
                        ) {
                            return;
                        }
                        // set prefix and suffix

                        //console.log(property);

                        let suffix = !_.isUndefined(options.suffix) ? options.suffix : "",
                            prefix = !_.isUndefined(options.prefix) ? options.prefix : "",
                            shade = !_.isUndefined(options.shade) ? options.shade : 0,
                            rgb = !_.isUndefined(options.rgb) ? options.rgb : false,
                            val = !_.isObject(a11yColors[context][setting])
                                ? a11yColors[context][setting]
                                : a11yColors[context][setting][shade];
                        //console.log("val = " + val);

                        if (rgb) {
                            let hex = new window.parent.Color(val);
                            val = hex.r() + ", " + hex.g() + ", " + hex.b();
                        }

                        styles +=
                            selectors.join(",") +
                            "{" +
                            property +
                            ":" +
                            prefix +
                            val +
                            suffix +
                            ";}";

                        //console.log(styles);
                    });
                });
            });
        }
    }
    */
    // Add styles.
    //console.log(styles);body{background-color:blue;}
    //stylesheet.html(styles);
    stylesheet.html("body{background-color:blue;}");
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
        $("#diym-style-inline-css").after('<style id="' + stylesheedID + '"></style>');
        stylesheet = $("#" + stylesheedID);
    }
    if (!_.isUndefined(a11yColors[context])) {
        // Check if we have elements defined.
        if (diymPreviewEls[context]) {
            _.each(diymPreviewEls[context], (definitions, setting) => {
                _.each(definitions, $index => {
                    _.each($index, (options, property) => {
                        let selectors = !_.isUndefined(options["selector"])
                            ? options["selector"]
                            : false;
                        if (
                            !_.isArray(selectors) ||
                            _.isEmpty(selectors) ||
                            _.isUndefined(a11yColors[context][setting])
                        ) {
                            return;
                        }
                        // set prefix and suffix
                        let suffix = !_.isUndefined(options["suffix"]) ? options["suffix"] : "",
                            prefix = !_.isUndefined(options["prefix"]) ? options["prefix"] : "";
                        styles +=
                            selectors.join(",") +
                            "{" +
                            property +
                            ":" +
                            prefix +
                            a11yColors[context][setting] +
                            suffix +
                            ";}";
                    });
                });
            });
        }
    }
    // Add styles.
    stylesheet.html(styles);
}
