/* global diymBgColors, _, Color */
/* eslint no-console: off, no-unused-vars: off */
/**
 * Customizer enhancements for a better user experience.
 *
 * Contains extra logic for our Customizer controls & settings.
 *
 * @since Twenty Twenty 1.0
 */

import { diymColor } from "./components/color-calculations";
import DIYM_Color from "./components/color-calculations2";
//import $ from "jquery";

wp.customize.bind("ready", () => {
    // Wait until the customizer has finished loading.
    // background, accent
    //let zzzTest = new DIYM_Color("#000000", "#000000");

    //console.log("bg" + zzzTest.background.toCSS());
    //console.log("tx" + zzzTest.getTextColor());
    //console.log("ac" + zzzTest.getAccentColor(4.5));
    //console.log("ac" + zzzTest.accent.toCSS());

    //let x = new Color("#ffffff");
    //let y = new Color("#000000");

    //let COLOR_BLACK = new Color("#000000"),
    //COLOR_WHITE = new Color("#ffffff");

    //COLOR_BLACK.getReadableContrastingColor(COLOR_WHITE, 4.5);

    // console.log(COLOR_BLACK.toCSS());
    //fallback = new Color("hsl(" + this.accentHue + ",75%,50%)");
    //console.log(x.getReadableContrastingColor(y, 4.5).toCSS());

    wp.customize("accent_color", value => {
        // Add a listener for accent-color changes.
        value.bind(to => {
            for (let context of Object.keys(diymBgColors)) {
                let backgroundColor;
                if (diymBgColors[context].color) {
                    backgroundColor = diymBgColors[context].color;
                } else {
                    backgroundColor = wp.customize(diymBgColors[context].setting).get();
                }
                //console.log(backgroundColorValue);
                diymCustomColors(context, backgroundColor, to);
            }

            /*

            let customColors = wp.customize.get().custom_colors,
                bannerFooterBackgroundColor = new Color(
                    wp.customize.get().banner_footer_background_color
                ),
                accentColor = new Color(to);

            customColors = _.isObject(customColors) && !_.isArray(customColors) ? customColors : {};

            console.log(bannerFooterBackgroundColor.toCSS());
            console.log(accentColor.toCSS());

            accentColor.getReadableContrastingColor(bannerFooterBackgroundColor, 4.5);

            //customColors["banner-footer"]["accent"] = accentColor.toCSS();
            console.log(accentColor.toCSS());

            customColors["banner-footer"].accent = accentColor.toCSS();
*/
            //console.log(wp.customize("custom_colors").get());
            //customColors["banner-footer"].accent = "#00FFFF";
            //console.log(customColors);
            //wp.customize("custom_colors").set(customColors);
            //console.log(wp.customize("custom_colors").get());
            //wp.customize("custom_colors")._dirty = true;
            //console.log(customColors);
            //console.log(to);
            // create a new color and set it to white...
            /*
            const COLOR_BLACK = new Color("#000000"),
                COLOR_WHITE = new Color("#ffffff");

            let accentColor = new Color(to);

            accentColor.getReadableContrastingColor(COLOR_WHITE, 4.5);

            let customColors = wp.customize.get().custom_colors;

            console.log(customColors);

            $(".customize-action").css("color", accentColor.toCSS());
            */
            //console.log(accentColor.toCSS());
            // workout the contrast ratio between black and white
            //let x = accentColor.getDistanceLuminosityFrom(color_white);
            // workout the contrast ratio between black and white
            //let x = color_black.getDistanceLuminosityFrom(color_white);
            //console.log(x);
            // workout the contrast ratio between black and white
            //let y = new Color("#0000ff");
            //console.log("Before: " + y.toCSS());
            //console.log(y.getDistanceLuminosityFrom(color_black));
            //y.getReadableContrastingColor(color_black, 4.5);
            //console.log("After: " + y.toCSS());
            //console.log("new ratio:" + y.getDistanceLuminosityFrom(color_black));
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
    /*
    for (let context of Object.keys(diymBgColors)) {
        wp.customize(diymBgColors[context].setting, value => {
            value.bind(to => {
                // Update the value for our accessible colors for this area.
                //diymSetAccessibleColorsValue(context, to, wp.customize("accent_hue").get(), to);
                //diymSetAccessibleColorsValue(context, to, wp.customize.get().accent_hue, to);
                diymCustomColors(context, to, wp.customize.get().accent_color);
            });
        });
    }
    */
    // Add a listener for background-color changes.
    wp.customize("banner_footer_background_color", value => {
        value.bind(to => {
            // Update the value for our accessible colors for this area.
            diymCustomColors("banner-footer", to, wp.customize.get().accent_color);
        });
    });
});

const diymCustomColors = (context, background, accent) => {
    let settings, colors;

    settings = wp.customize.get().custom_colors;
    settings = _.isObject(settings) && !_.isArray(settings) ? settings : {};

    colors = new DIYM_Color(background, accent);

    // Sanity check.
    if (_.isFunction(colors.getAccentColor) && colors.getAccentColor()) {
        // Update the value for this context.
        settings[context] = {
            text: colors.getTextColor(),
            accent: colors.getAccentColor(),
            background: colors.getBackgroundColor()
        };
    }

    // Change the value.
    wp.customize("custom_colors").set(settings);

    // Small hack to save the option.
    wp.customize("custom_colors")._dirty = true;
};

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

        console.log(value);

        // Change the value.
        wp.customize("accent_accessible_colors").set(value);

        // Small hack to save the option.
        wp.customize("accent_accessible_colors")._dirty = true;
    }
};
