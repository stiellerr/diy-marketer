/* global diymBgColors, _ */
/**
 * Customizer enhancements for a better user experience.
 *
 * Contains extra logic for our Customizer controls & settings.
 *
 * @since Twenty Twenty 1.0
 */

import DIYM_Color from "./components/class-diym-color";

// trigger refresh of media view on open...
wp.media.view.Modal.prototype.bind("open", () => {
    if (wp.media.frame.content.get() !== null) {
        wp.media.frame.content.get().collection._requery(true);
        wp.media.frame.content.get().options.selection.reset();
    }
});

/*
if (wp.media) {
    wp.media.view.Modal.prototype.on("open", function (data) {
        //console.log(wp.media.frame.modal.clickedOpenerEl);
        wp.media.frame.content.get().collection._requery(true);
    });
}
*/
/*
wp.media.frame.on(
    "open",
    function () {
        //if (wp.media.frame.content.get() !== null) {
        // this forces a refresh of the content
        //parent.wp.media.frame.content.get().collection._requery(true);
        //console.log(wp.media.frame.content.get().collection);
        // optional: reset selection
        //wp.media.frame.content.get().options.selection.reset();
        //}
        console.log("hello555");
    },
    this
);
*/
/*
wp.media.frame.bind("open", () => {
    console.log("ttt");
});
*/

// Wait until the customizer has finished loading.
wp.customize.bind("ready", () => {
    // hide blog name.
    wp.customize.control("blogname").toggle();

    //wp.customize.control("custom_logo").toggle();

    //wp.customize("custom_logo", value => {
    // Add a listener for accent-color changes.
    //value.bind(to => {
    //wp.media.frame.on('open', function() {
    //if (wp.media.frame.content.get() !== null) {
    // this forces a refresh of the content
    //parent.wp.media.frame.content.get().collection._requery(true);
    //console.log(wp.media.frame.content.get().collection);
    // optional: reset selection
    //wp.media.frame.content.get().options.selection.reset();
    //}
    //}, this);
    //});
    //});

    // Site Title Color Section.
    /*
    wp.customize.section.add(
        new wp.customize.Section("zzztestsection", {
            title: "zzz this is a test"
            //panel: 'myPanel',
            //customizeAction: 'Customizing ▸ Site Title Color', // String above title's Section.
            //priority: 5 // The order of this section in the panel.
        })
    );
    */

    // Site Title Color Setting.
    /*
    wp.customize.add(
        new wp.customize.Setting("", "#fff", {
            transport: "postMessage"
        })
    );

    // Site Title Color Control.
    wp.customize.control.add(
        new wp.customize.ColorControl("siteTitleColorControl", {
            section: "siteTitleColorSection",
            label: "Site Title Color Control",
            setting: "siteTitleColorSetting",
            priority: 5 // The order of this control in the section.
        })
    );
    */

    //
    //let z = wp.customize.panel("nav_menus");

    //wp.customize.control("blogname").panel("nav_menus");

    //console.log(z);
    //console.log(wp.customize.section.add());
    // Create theme options panel.
    /*
		api.panel.add(
			new api.Panel('hannover_theme_options', {
				title: 'Theme Options',
			})
        );
        */
    // Add section.
    /*
    wp.customize.section.add(
        new wp.customize.Section("footer_options", {
            title: "Footer Options.",
            panel: "widgets",
            //customizeAction: "Customizing ▸ Theme Options",
            customizeAction: "Customizing",
            priority: -1
        })
    );

    // Add checkbox control.
    wp.customize.control.add(
        new wp.customize.Control("footer_widgets_control", {
            setting: "footer_widgets",
            type: "range",
            section: "colors",
            //panel: "hannover_example_section",
            label: "Check this box to do something.",
            description: "this is a description.",
            input_attrs: {
                min: 0,
                max: 4,
                step: 1
            }
        })
    );
    // Add checkbox control.
    wp.customize.control.add(
        new wp.customize.Control("diym_ggg_control", {
            setting: "diym_ggg[test]",
            type: "text",
            section: "social_media",
            //panel: "hannover_example_section",
            label: "Check this box to do something.",
            description: "this is a description."
        })
    );
    wp.customize("sidebars_widgets[footer-1]", value => {
        // Add a listener for accent-color changes.
        value.bind(to => {
            console.log(to);
        });
    });
    */

    /*
    wp.customize("footer_widgets", value => {
        // Add a listener for accent-color changes.
        value.bind(to => {
            console.log(wp.customize.section("sidebar-widgets-footer-" + to));
            wp.customize.section("sidebar-widgets-footer-" + to).active.set(true);
            //
            //_,isUndefined() {

            //}

            //for (let i = 1; i < 5; i++) {
            //if(_,isUndefined(wp.customize.section("sidebar-widgets-footer-" + i))) {
            //break;
            //}

            /*
                
                if (i <= to) {
                    wp.customize.section("sidebar-widgets-footer-" + i).active.set(true);
                } else {
                    wp.customize.section("side
                    
                    bar-widgets-footer-" + i).active.set(false);
                }
                */
    //}

    //wp.customize.section("sidebar-widgets-footer-1").deactivate(); //.toggle();
    //console.log(ggg);
    //});
    //});

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
            content: colors.getContentColor(),
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
