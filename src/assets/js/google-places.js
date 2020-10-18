/* global ajaxurl, _ */
import $ from "jquery";
//import Moment from "../../../node_modules/moment";

// parse hours
function parseGeometry(context) {
    $("input[name$='[lat]']").val(context.location.lat);
    $("input[name$='[lng]']").val(context.location.lng);
}

// parse hours
function parseHours(context) {
    // init hours.
    var hours = [
        { day: "sunday" },
        { day: "monday" },
        { day: "tuesday" },
        { day: "wednesday" },
        { day: "thursday" },
        { day: "friday" },
        { day: "saturday" }
    ];

    hours.forEach(day => {
        day.open = "00:00";
        day.close = "00:00";
    });

    // build array
    let pattern = /^(\d{2})(\d{2})$/;

    context.forEach(e => {
        hours[e.open.day].open = pattern.test(e.open.time) ? RegExp.$1 + ":" + RegExp.$2 : "";

        if (e.open.time == e.close.time) {
            hours[e.open.day].close = "23:59";
        } else {
            hours[e.open.day].close = pattern.test(e.close.time) ? RegExp.$1 + ":" + RegExp.$2 : "";
        }
    });

    hours.forEach(e => {
        $("input[name$='[" + e.day + "_open]']").val(e.open);
        $("input[name$='[" + e.day + "_close]']").val(e.close);
    });
}

function extractAddress(context) {
    //
    const fields = {
        /*
        streetAddress: ["subpremise", "street_number", "route"],
        subLocality: "sublocality",
        addressLocality: "locality",
        addressRegion: "administrative_area_level_1",
        addressCountry: "country",
        postalCode: "postal_code"
        */
        street_address: ["subpremise", "street_number", "route"],
        suburb: "sublocality",
        city: "locality",
        region: "administrative_area_level_1",
        country: "country",
        post_code: "postal_code"
    };

    let data = {};

    // initialise object with props (but not values)
    _.each(_.keys(fields), prop => {
        data[prop] = "";
    });

    _.each(fields, (values, key) => {
        // convert string to array for loop
        if (_.isString(values)) {
            values = values.split();
        }
        _.each(values, val => {
            _.each(context, element => {
                if (_.contains(element.types, val)) {
                    if (data[key]) {
                        data[key] += (val == "street_number" ? "/" : " ") + element.long_name;
                    } else {
                        data[key] = element.long_name;
                    }
                }
            });
        });
    });

    // update values on options page
    _.each(data, (value, key) => {
        $("input[name$='[" + key + "]']").val(value);
    });
}

$(document).ready(() => {
    // jquery date picker ui
    $(".timepicker").timepicker({ timeFormat: "HH:mm", timeInput: true });

    //
    $("#diym_google_settings\\[place_id\\]").change(e => {
        $(e.currentTarget).css("border", "3px solid red");

        //console.log(e);
        //.css( "border", "3px solid red" );
        //alert("The text has been changed.");
    });

    //
    $("#sync_places").click(evt => {
        // disable button

        //extractAddress("zzz");

        $(evt.currentTarget).prop("disabled", true);

        let data = {
            action: "sync_data",
            _wpnonce: $("input[name='_wpnonce']").val(),
            _wp_http_referer: $("input[name='_wp_http_referer']").val()
        };

        $.ajax({
            url: ajaxurl,
            type: "post",
            dataType: "JSON", // Set this so we don't need to decode the response...
            data,
            beforeSend: () => {
                //console.log("before send");
                $(".notice").remove();

                //self.find(".button").prop("disabled", true);
                //console.log(form_data);
                // disable btn to prevent multiple submits
                //self.find(".btn").prop("disabled", true);
            },
            success: response => {
                console.log(response);
                if (response.success == true) {
                    if (response.data.status == "OK") {
                        let place_data = response.data.result;
                        //console.log(place_data);

                        extractAddress(place_data.address_components);
                        parseHours(place_data.opening_hours.periods);
                        parseGeometry(place_data.geometry);

                        $("input[name$='[url]']").val(place_data.url);
                        $("input[name$='[phone]']").val(place_data.formatted_phone_number);
                        $("input[name='blogname']").val(place_data.name);
                        $("input[name='admin_email']").val(place_data.name);
                        //console.log(place_data.address_components);
                    }
                }
            },
            complete: r => {
                // remove any alerts that exist...

                //console.log(r);
                //self.find(".button").prop("disabled", false);
                $(evt.currentTarget).prop("disabled", false);
                //                        self.prepend(
                //   "<div class='alert alert-success'>" + response.data + "</div>"
                // );
            },
            error: ({ responseJSON }) => {
                console.log(responseJSON);

                $("h1").append('<div class="notice notice-error"><p>Snychronise failed!</p></div>');
                //<div class="notice notice-error"><p>Error notice</p></div>
                //self.find(".button").prop("disabled", false);
                //$(evt.currentTarget).prop("disabled", false);
                //
            }
        });
    });

    $("#google-places").submit(evt => {
        // prevent page refresh
        evt.preventDefault();

        let self = $(evt.currentTarget);

        //if (self[0].checkValidity()) {
        //self.addClass("was-validated");
        //console.log("hello");
        //return;
        //} else {
        //console.log("world");
        //self.addClass("was-validated");
        //}

        let form_data = self.serializeArray();

        //alert("hi");
        // add action + nonce to form data
        form_data.push({
            name: "action",
            value: "sync_data"
        });

        $.ajax({
            url: ajaxurl,
            type: "post",
            dataType: "JSON", // Set this so we don't need to decode the response...
            data: form_data,
            beforeSend: () => {
                self.find(".button").prop("disabled", true);
                console.log(form_data);
                // disable btn to prevent multiple submits
                //self.find(".btn").prop("disabled", true);
            },
            success: response => {
                console.log(response);
                //
            },
            complete: r => {
                console.log(r);
                self.find(".button").prop("disabled", false);
                //
            }
        });
        //console.log(evt);
        //alert("button");
    });
});
