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

export default class DIYM_Color {
    constructor(background, accent) {
        //
        this.background = new Color(background);
        this.accent = new Color(accent);
        //this.accent = new Color(accent);
        this.text = this.background.getMaxContrastColor();
    }
    getBackgroundColor() {
        return this.background.toCSS();
    }
    getTextColor() {
        return this.text.toCSS();
    }
    getAccentColor(minContrast) {
        /*
        return this.accent
            .clone()
            .getReadableContrastingColor(this.background, minContrast)
            .toCSS();
        */
        return this.accent.getReadableContrastingColor(this.background, minContrast).toCSS();
    }
    getAccentLighten(amount) {
        return this.accent.clone().lighten(amount).toCSS();
        /*
            .clone()
            .getReadableContrastingColor(this.background, minContrast)
            .toCSS();
            */
    }
    getAccentDarken(amount) {
        return this.accent.clone().darken(amount).toCSS();
        /*
            .clone()
            .getReadableContrastingColor(this.background, minContrast)
            .toCSS();
            */
    }
    getAccentRgb() {
        //
        return this.accent.r() + ", " + this.accent.g() + ", " + this.accent.b();
    }
}
