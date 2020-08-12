/* global diymBgColors, diymPreviewEls, _ */
/**
 * File customize-preview.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

import $ from "jquery";

// Generate styles on load. Handles page-changes on the preview pane.
$(document).ready(() => {
    diymGenerateColorPreviewStyles("content");
    diymGenerateColorPreviewStyles("banner-footer");
});

//
wp.customize("blogname", value => {
    value.bind(to => {
        $(".site-name").text(to);
    });
});

//
wp.customize("blogdescription", value => {
    value.bind(to => {
        $(".site-tagline").text(to);
    });
});

// Add listener for the accent color.
wp.customize("accent_color", value => {
    value.bind(() => {
        // Generate the styles.
        // Add a small delay to be sure the accessible colors were generated.
        setTimeout(() => {
            for (let context of Object.keys(diymBgColors)) {
                diymGenerateColorPreviewStyles(context);
            }
        }, 50);
    });
});

// Add listener to the font select.
wp.customize("font_family", value => {
    value.bind(to => {
        if ("default" !== to) {
            $("body").css("font-family", to);
            //$(":root").css("font-family", to);
        }
    });
});

wp.customize("background_pattern", value => {
    value.bind(to => {
        $("body").css(
            "background-image",
            "url('/wp-content/themes/diy-marketer/dist/assets/images/bg/" + to + ".png')"
        );
    });
});

// Add listeners for background-color settings.
for (let context of Object.keys(diymBgColors)) {
    // check if setting is defined.
    if (_.isUndefined(diymBgColors[context].setting)) {
        continue;
    }
    wp.customize(diymBgColors[context].setting, value => {
        value.bind(() => {
            // Generate the styles.
            // Add a small delay to be sure the accessible colors were generated.
            setTimeout(() => {
                diymGenerateColorPreviewStyles(context);
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
function diymGenerateColorPreviewStyles(context) {
    // Get the accessible colors option.
    let a11yColors = window.parent.wp.customize.get().custom_colors,
        stylesheedID = "diym-customizer-styles-" + context,
        stylesheet = $("#" + stylesheedID),
        styles = "";

    // If the stylesheet doesn't exist, create it and append it to <head>.
    if (!stylesheet.length) {
        $("#diym-style-inline-css").after('<style id="' + stylesheedID + '"></style>');
        stylesheet = $("#" + stylesheedID);
    }

    if (!_.isUndefined(a11yColors[context])) {
        // Check if we have elements defined.
        if (diymPreviewEls[context]) {
            _.each(diymPreviewEls[context], (definitions, setting) => {
                _.each(definitions, index => {
                    _.each(index, (options, property) => {
                        let selectors = _.isUndefined(options.selector) ? false : options.selector;
                        if (
                            !_.isArray(selectors) ||
                            _.isEmpty(selectors) ||
                            _.isUndefined(a11yColors[context][setting])
                        ) {
                            return;
                        }

                        let val = a11yColors[context][setting],
                            shade = _.isUndefined(options.shade) ? 0 : options.shade;

                        if (_.isObject(a11yColors[context][setting])) {
                            if (_.isUndefined(a11yColors[context][setting][shade])) {
                                return;
                            }
                            val = a11yColors[context][setting][shade];
                        } else if (shade) {
                            return;
                        }

                        let suffix = _.isUndefined(options.suffix) ? "" : options.suffix,
                            prefix = _.isUndefined(options.prefix) ? "" : options.prefix,
                            rgb = _.isUndefined(options.rgb) ? false : options.rgb;

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
                    });
                });
            });
        }
    }
    // Add styles.
    stylesheet.html(styles);
}
