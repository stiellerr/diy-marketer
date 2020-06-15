// global wp, jQuery
/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

import $ from "jquery";

/*
wp.customize('blogdescription', (value) => {
    value.bind((to) =>{
        $('.tag-line').html(to);
        //console.log(to);
    })
});
*/

//console.log(diy_marketer);
//console.log("hello");
/*
const diym_build_css = zzzz => {
    let inline_css = "";
    let inline_css_obj = diy_marketer[0];
    for (let selector in inline_css_obj) {
        inline_css += `${selector} {`;
        for (let prop in inline_css_obj[selector]) {
            let val = inline_css_obj[selector][prop];

            let zzz = val.split(",")[0];

            console.log(zzz);

            console.log(zzzz("diym_font_select").get());

            //inline_css += `${prop}: ${wp.customize(zzz).get()}`;
        }
        inline_css += `}`;
    }
    //$("#diym-stylesheet-inline-css").html(inline_css);

    //console.log(inline_css);
    return inline_css;
};

//let inline_css_obj = diy_marketer[0];

console.log(diym_build_css(wp.customize));
*/
wp.customize("diym_phone_number", value => {
    value.bind(to => {
        $(".phone-number").text(to);
    });
});

/*
wp.customize("diym_font_select", value => {
    value.bind(to => {
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
        console.log(to);
        console.log(inline_css);
        $("#diym-stylesheet-inline-css").html(inline_css);
    });
});
*/

wp.customize("diym_font_select", value => {
    value.bind(to => {
        $("#diym-stylesheet-inline-css").html(`body{font-family:${to};}`);
        console.log(to);
    });
});
