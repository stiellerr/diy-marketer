/* global diymBgColors, diymColor */
/* eslint no-unused-vars: off */
/**
 * Customizer enhancements for a better user experience.
 *
 * Contains extra logic for our Customizer controls & settings.
 *
 * @since Twenty Twenty 1.0
 */

wp.customize.bind("ready", () => {
    // Wait until the customizer has finished loading.
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
                console.log(to);
                // Update the value for our accessible colors for this area.
                /*
				diymSetAccessibleColorsValue(
					context,
					to,
					wp.customize("accent_hue").get(),
					to
				);
				*/
            });
        });
    }
});

/**
 * Updates the value of the "accent_accessible_colors" setting.
 *
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
    console.log(colors);
};
