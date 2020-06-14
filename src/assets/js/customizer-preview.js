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

wp.customize("diym_phone_number", value => {
    value.bind(to => {
        $(".phone-number").text(to);
    });
});

wp.customize("diym_font_select", value => {
    value.bind(to => {
        $("#diym-stylesheet-inline-css").html(`body{font-family:${to};}`);
    });
});
