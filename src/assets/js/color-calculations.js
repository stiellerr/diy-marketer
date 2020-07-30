/* global Color */
/* eslint no-unused-vars: off */
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
//function diymColor(backgroundColor, accentHue) {
// jshint ignore:line
//var color = new _twentyTwentyColor( backgroundColor, accentHue );
//color.setAccentColorsArray();
//var color = 1;
//return color;
//}

//window.diymColor = diymColor;
// ES6
const diymColor = (backgroundColor, accentHue) => {
    //let color = 1;
    let color = new _diymColor(backgroundColor, accentHue);
    //color.setAccentColorsArray();
    return color;
};

window.diymColor = diymColor;
