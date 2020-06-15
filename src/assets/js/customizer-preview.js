// global wp, jQuery
/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

import $ from "jquery";

wp.customize("diym_phone_number", value => {
    value.bind(to => {
        $(".phone-number").text(to);
    });
});

window.wp.customize("diym_font_select", value => {
    value.bind(() => {
        let inline_css = "";
        let inline_css_obj = diy_marketer[0];
        for (let selector in inline_css_obj) {
            inline_css += `${selector}{`;
            for (let prop in inline_css_obj[selector]) {
                let val = inline_css_obj[selector][prop];
                let zzz = val.split(",")[0];
                inline_css += `${prop}: ${wp.customize(zzz).get()}`;
            }
            inline_css += `}`;
        }
        $("#diym-stylesheet-inline-css").html(inline_css);
    });
});
