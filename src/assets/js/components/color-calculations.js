/* global Color */
/**
 * Color Calculations.
 *
 * @since Twenty Twenty 1.0
 *
 * @param {string} backgroundColor - The background color.
 * @param {number} accentHue - The hue for our accent color.
 *
 * @return {Object} - this
 */
class _diymColor {
    constructor(backgroundColor, accentHue) {
        // Set the object properties.
        this.backgroundColor = backgroundColor;
        this.accentHue = accentHue;
        this.bgColorObj = new Color(backgroundColor);
        this.textColorObj = this.bgColorObj.getMaxContrastColor();
        this.textColor = this.textColorObj.toCSS();
        this.isDark = 0.5 > this.bgColorObj.toLuminosity();
        this.isLight = !this.isDark;
    }

    /**
     * Builds an array of Color objects based on the accent hue.
     * For improved performance we only build half the array
     * depending on dark/light background-color.
     *
     * @since Twenty Twenty 1.0
     *
     * @return {Object} - this
     */
    setAccentColorsArray() {
        let minSaturation = 65,
            maxSaturation = 100,
            minLightness = 30,
            maxLightness = 80,
            stepSaturation = 2,
            stepLightness = 2,
            pushColor = () => {
                let colorObj = new Color({
                        h: this.accentHue,
                        s: s,
                        l: l
                    }),
                    item,
                    /**
                     * Get a score for this color in contrast to its background color and surrounding text.
                     *
                     * @since Twenty Twenty 1.0
                     *
                     * @param {number} contrastBackground - WCAG contrast with the background color.
                     * @param {number} contrastSurroundingText - WCAG contrast with surrounding text.
                     * @return {number} - 0 is best, higher numbers have bigger difference with the desired scores.
                     */
                    getScore = (contrastBackground, contrastSurroundingText) => {
                        let diffBackground = 7 >= contrastBackground ? 0 : 7 - contrastBackground,
                            diffSurroundingText =
                                3 >= contrastSurroundingText ? 0 : 3 - contrastSurroundingText;

                        return diffBackground + diffSurroundingText;
                    };

                item = {
                    color: colorObj,
                    contrastBackground: colorObj.getDistanceLuminosityFrom(this.bgColorObj),
                    contrastText: colorObj.getDistanceLuminosityFrom(this.textColorObj)
                };

                // Check a minimum of 4.5:1 contrast with the background and 3:1 with surrounding text.
                if (4.5 > item.contrastBackground || 3 > item.contrastText) {
                    return;
                }

                // Get a score for this color by multiplying the 2 contrasts.
                // We'll use that to sort the array.
                item.score = getScore(item.contrastBackground, item.contrastText);

                this.accentColorsArray.push(item);
            },
            s,
            l,
            aaa;

        this.accentColorsArray = [];

        // We're using `for` loops here because they perform marginally better than other loops.
        for (s = minSaturation; s <= maxSaturation; s += stepSaturation) {
            for (l = minLightness; l <= maxLightness; l += stepLightness) {
                pushColor(s, l);
            }
        }
        // Check if we have colors that are AAA compliant.
        aaa = this.accentColorsArray.filter(color => {
            return 7 <= color.contrastBackground;
        });

        // If we have AAA-compliant colors, always prefer them.
        if (aaa.length) {
            this.accentColorsArray = aaa;
        }

        // Sort colors by contrast.
        this.accentColorsArray.sort((a, b) => {
            return a.score - b.score;
        });
        return this;
    }

    /**
     * Get accessible text-color.
     *
     * @since Twenty Twenty 1.0
     *
     * @return {Color} - Returns a Color object.
     */
    getTextColor() {
        return this.textColor;
    }

    /**
     * Get accessible color for the defined accent-hue and background-color.
     *
     * @since Twenty Twenty 1.0
     *
     * @return {Color} - Returns a Color object.
     */
    getAccentColor() {
        let fallback;

        // If we have colors returns the 1st one - it has the highest score.
        if (this.accentColorsArray[0]) {
            return this.accentColorsArray[0].color;
        }

        // Fallback.
        fallback = new Color("hsl(" + this.accentHue + ",75%,50%)");
        return fallback.getReadableContrastingColor(this.bgColorObj, 4.5);
    }
}

/**
 * Return a new instance of the _twentyTwentyColor object.
 *
 * @since Twenty Twenty 1.0
 *
 * @param {string} backgroundColor - The background color.
 * @param {number} accentHue - The hue for our accent color.
 * @return {Object} - this
 */
export const diymColor = (backgroundColor, accentHue) => {
    let color = new _diymColor(backgroundColor, accentHue);
    color.setAccentColorsArray();
    return color;
};
