/* global diy_marketer */
/**
 * File customizer-preview.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

import $ from "jquery";
import strip_tags from "locutus/php/strings/strip_tags";

const diym_build_css = () => {
    let inline_css = "";
    let inline_css_obj = diy_marketer[0];
    for (let selector in inline_css_obj) {
        inline_css += `${selector}{`;
        for (let prop in inline_css_obj[selector]) {
            let prop_str = inline_css_obj[selector][prop];
            let prop_arr = prop_str.split(",");
            let arg = prop_arr[1] ? prop_arr[1] : "";
            inline_css += `${prop}: ${wp.customize(prop_arr[0]).get()}${arg};`;
        }
        inline_css += `}`;
    }
    $("#diym-stylesheet-inline-css").html(inline_css);
};

wp.customize("blogname", value => {
    value.bind(to => {
        $(".site-name").text(to);
    });
});

wp.customize("blogdescription", value => {
    value.bind(to => {
        $(".site-tagline").text(to);
    });
});

wp.customize("diym_phone_number", value => {
    value.bind(to => {
        $(".phone-number").text(to);
    });
});

wp.customize("diym_google_map", value => {
    value.bind(to => {
        $(".widget_diym_google_map")
            .contents()
            .filter(function () {
                return this.nodeType == 3; //Node.TEXT_NODE
            })
            .remove();
        $(".widget_diym_google_map > iframe").remove();
        $(".widget_diym_google_map").append(strip_tags(to, "<iframe>"));
    });
});

/*
wp.customize("diym_font_select", value => {
    value.bind(to => {
        if (to !== "default") {
            if (!diy_marketer[0]["body"]) {
                diy_marketer[0]["body"] = { "font-family": "diym_font_select" };
            }
        }
        diym_build_css();
    });
});
*/

wp.customize("diym_primary_color", value => {
    value.bind(() => {
        diym_build_css();
    });
});

wp.customize("diym_banner_footer_bg", value => {
    value.bind(() => {
        diym_build_css();
    });
});

wp.customize("diym_banner_footer_text", value => {
    value.bind(() => {
        diym_build_css();
    });
});

/*
const diym_build_address = () => {
    //
    let temp = wp.customize("diym_street_address").get();
    let suburb = wp.customize("diym_suburb").get();
    let city = wp.customize("diym_city").get();
    let postal_code = wp.customize("diym_postal_code").get();

    temp += temp && suburb ? "<br>" : "";
    temp += suburb;

    temp += temp && (city || postal_code) ? "<br>" : "";
    temp += city ? (postal_code ? city + ", " + postal_code : city) : postal_code;

    $(".site-address").html(temp);
};

wp.customize("diym_street_address", value => {
    value.bind(() => {
        diym_build_address();
    });
});

wp.customize("diym_suburb", value => {
    value.bind(() => {
        diym_build_address();
    });
});

wp.customize("diym_city", value => {
    value.bind(() => {
        diym_build_address();
    });
});

wp.customize("diym_postal_code", value => {
    value.bind(() => {
        diym_build_address();
    });
});
*/
