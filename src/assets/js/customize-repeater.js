/* global _ */
/* eslint no-unused-vars: off */

import $ from "jquery";

const repeater_refresh = () => {
    let repeater = $(".diym-repeater-sortable");

    let arr_values = [];

    for (var con of repeater.children(".diym-repeater-container")) {
        let image_url = $(con).find(".diym-repeater-url").val();

        if (image_url) {
            arr_values.push({
                url: image_url,
                heading: $(con).find(".diym-repeater-heading").val()
            });
        }
    }

    console.log(arr_values);
};

//$(".diym-repeater-heading").on("change", () => {
// Does some stuff and logs the event to the console
//console.log("ggg");
//});

//$(document).on("change", ".diym-repeater-heading, .diym-repeater-url", () => {
// Does some stuff and logs the event to the console
//console.log("ggg");
//});

$(document).ready(() => {
    let theme_controls = $("#customize-theme-controls");

    theme_controls.on("change", ".diym-repeater-url", () => {
        repeater_refresh();
    });

    $(".diym-repeater-heading").keyup(() => {
        //$("input").css("background-color", "pink");
        console.log("sss");
        repeater_refresh();
    });

    //theme_controls.on("keyup", ".diym-repeater-heading", () => {
    //console.log("sss");
    //repeater_refresh();
    //});

    console.log(theme_controls);
    //customize-control-title-zzz
    //$(".diym-repeater-heading").change(() => {
    //console.log("ggg");
    //repeater_refresh();
    //});

    $(".diym-add-image").click(evt => {
        let self = $(evt.currentTarget);

        evt.preventDefault();

        //If the uploader object has already been created, reopen the dialog
        if (frame) {
            frame.open();
            return;
        }

        //Extend the wp.media object
        let frame = (wp.media.frames.file_frame = wp.media({
            title: "Choose File",
            button: {
                text: "Choose File"
            },
            multiple: false
        }));

        frame.open();

        //When a file is selected, grab the URL and set it as the text field's value
        frame.on("select", () => {
            let attachment = frame.state().get("selection").first().toJSON();
            self.parent().find(".diym-repeater-url").val(attachment.url);

            repeater_refresh();

            //$('#cc-image-upload-file').val(attachment.url);
        });

        /*
        wp.media.editor.send.attachment = (props, attachment) => {
            console.log(props);
            console.log(attachment);
        };
        wp.media.editor.open(".diym-add-image");

        console.log("Hello!");*/
        //self.parent().find("input").val("hello");
    });

    //customize-control-title-zzz
    $(".diym-repeater-new-field").click(evt => {
        let self = $(evt.currentTarget);
        let th = self.parent();
        //let th = self.before();

        if (!_.isUndefined(th)) {
            var field = th.find(".diym-repeater-container:first").clone(true, true);

            // clear inputs
            field.find("input").val("");

            //th.add("p").addClass("hello World").text("vvvv");
            //var field = th.find(".diym-repeater-container:first").html("hello world");
            //var field = $("<p>paragraph 1</p>");
            //field.add("p").addClass("zzz");

            /*Append new box*/
            th.find(".diym-repeater-container:first").parent().append(field);

            repeater_refresh();
        }
        console.log(field);
    });

    // xxx
    $(".diym-repeater-title").click(evt => {
        let self = $(evt.currentTarget);

        self.next().slideToggle("fast", () => {});
        //console.log(self);
    });

    /*Drag and drop to change icons order*/
    $(".diym-repeater-sortable").sortable({
        //axis: 'y',
        //update: function () {
        //customizer_repeater_refresh_general_control_values();
        //}
    });
});
