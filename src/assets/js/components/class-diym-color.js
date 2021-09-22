/* global Color */
/**
 * Color Calculations.
 *
 * @param {string} backgroundColor - The background color.
 * @param {number} accentHue - The hue for our accent color.
 *
 * @return {Object} - this
 */

export default class DIYM_Color {
    constructor(background, accent) {
        //
        this.background = new Color(background);
        this.accent = new Color(accent);
        this.content = this.background.getMaxContrastColor();
    }
    getBackgroundColor() {
        return this.background.toCSS();
    }
    getContentColor() {
        return this.content.toCSS();
    }
    getAccentColor(minContrast) {
        return this.accent.getReadableContrastingColor(this.background, minContrast).toCSS();
    }
    getAccentLighten(amount) {
        return this.accent.clone().lighten(amount).toCSS();
    }
    getAccentDarken(amount) {
        return this.accent.clone().darken(amount).toCSS();
    }
    //
    getLinkHover(amount) {
        let lum = this.accent.toLuminosity();
        let hex = lum >= 0.5 ? this.getAccentDarken(amount) : this.getAccentLighten(amount);

        return hex;
    }
}
