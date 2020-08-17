/* global diymBgColors, _ */
/**
 * Customizer enhancements for a better user experience.
 *
 * Contains extra logic for our Customizer controls & settings.
 *
 * @since Twenty Twenty 1.0
 */

import DIYM_Color from "./components/class-diym-color";

// Wait until the customizer has finished loading.
wp.customize.bind("ready", () => {
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
                diymCustomColors(context, backgroundColor, to);
            }
        });
    });

    // Add a listener for background-color changes.
    for (let context of Object.keys(diymBgColors)) {
        if (_.isUndefined(diymBgColors[context].setting)) {
            continue;
        }
        wp.customize(diymBgColors[context].setting, value => {
            value.bind(to => {
                // Update the value for our accessible colors for this area.
                diymCustomColors(context, to, wp.customize.get().accent_color);
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
const diymCustomColors = (context, background, accent) => {
    let settings, colors;

    settings = wp.customize.get().custom_colors;
    settings = _.isObject(settings) && !_.isArray(settings) ? settings : {};

    colors = new DIYM_Color(background, accent);

    // Sanity check.
    //35: colors.getAccentDarken(15),
    //99: colors.getLinkHover(15)
    if (_.isFunction(colors.getAccentColor) && colors.getAccentColor) {
        // Update the values for this context.
        settings[context] = {
            text: colors.getTextColor(),
            accent: {
                0: colors.getAccentColor(4.5),
                40: colors.getAccentDarken(10),
                43: colors.getAccentDarken(7.5),
                57: colors.getAccentLighten(7.5),
                75: colors.getAccentLighten(25),
                link_hover: colors.getLinkHover(15)
            },
            background: colors.getBackgroundColor()
        };
    }

    //
    //console.log(colors.getAccentLighten(15));

    // Change the value.
    wp.customize("custom_colors").set(settings);

    // Small hack to save the option.
    wp.customize("custom_colors")._dirty = true;
};
