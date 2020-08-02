/* global diymBgColors, _ */
/* eslint no-console: off, no-unused-vars: off */
/**
 * Customizer enhancements for a better user experience.
 *
 * Contains extra logic for our Customizer controls & settings.
 *
 * @since Twenty Twenty 1.0
 */

import { diymColor } from "./components/color-calculations";

wp.customize.bind("ready", () => {
    // Wait until the customizer has finished loading.

    wp.customize("test_color", value => {
        // Add a listener for accent-color changes.
        value.bind(to => {
            //console.log(to);

            // create a new color and set it to white...
            let color_black = new Color("#000000"),
                color_white = new Color("#ffffff");

            // workout the contrast ratio between black and white
            let x = color_black.getDistanceLuminosityFrom(color_white);
            //console.log(x);

            // workout the contrast ratio between black and white
            let y = new Color("#0000ff");
            console.log("Before: " + y.toCSS());
            console.log(y.getDistanceLuminosityFrom(color_black));

            y.getReadableContrastingColor(color_black, 4.5);
            console.log("After: " + y.toCSS());

            console.log("new ratio:" + y.getDistanceLuminosityFrom(color_black));
        });
    });

    wp.customize("accent_hue", value => {
        // Add a listener for accent-color changes.
        value.bind(to => {
            // Update the value for our accessible colors for all areas.
            for (let context of Object.keys(diymBgColors)) {
                let backgroundColorValue;
                if (diymBgColors[context].color) {
                    backgroundColorValue = diymBgColors[context].color;
                } else {
                    backgroundColorValue = wp.customize(diymBgColors[context].setting).get();
                }
                diymSetAccessibleColorsValue(context, backgroundColorValue, to);
            }
        });
    });

    // Add a listener for background-color changes.
    for (let context of Object.keys(diymBgColors)) {
        wp.customize(diymBgColors[context].setting, value => {
            value.bind(to => {
                // Update the value for our accessible colors for this area.
                //diymSetAccessibleColorsValue(context, to, wp.customize("accent_hue").get(), to);
                diymSetAccessibleColorsValue(context, to, wp.customize.get().accent_hue, to);
            });
        });
    }
});

/**
 * Updates the value of the "accent_accessible_colors" setting.S
 * @since Twenty Twenty 1.0
 *
 * @param {string} context The area for which we want to get colors. Can be for example "content", "header" etc.
 * @param {string} backgroundColor The background color (HEX value).
 * @param {number} accentHue Numeric representation of the selected hue (0 - 359).
 *
 * @return {void}
 */
const diymSetAccessibleColorsValue = (context, backgroundColor, accentHue) => {
    let value, colors;

    // Get the current value for our accessible colors, and make sure it's an object.
    value = wp.customize("accent_accessible_colors").get();
    value = _.isObject(value) && !_.isArray(value) ? value : {};

    // Get accessible colors for the defined background-color and hue.
    colors = diymColor(backgroundColor, accentHue);

    // Sanity check.
    if (colors.getAccentColor() && "function" === typeof colors.getAccentColor().toCSS) {
        // Update the value for this context.
        value[context] = {
            text: colors.getTextColor(),
            accent: colors.getAccentColor().toCSS(),
            background: backgroundColor
        };
        // Get borders color.
        value[context].borders = colors.bgColorObj
            .clone()
            .getReadableContrastingColor(colors.bgColorObj, 1.36)
            .toCSS();

        // Get secondary color.
        value[context].secondary = colors.bgColorObj
            .clone()
            .getReadableContrastingColor(colors.bgColorObj)
            .s(colors.bgColorObj.s() / 2)
            .toCSS();

        // Change the value.
        wp.customize("accent_accessible_colors").set(value);

        // Small hack to save the option.
        wp.customize("accent_accessible_colors")._dirty = true;
    }
};
