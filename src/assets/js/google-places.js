/* global ajaxurl */
import $ from "jquery";

$(document).ready(() => {
    //
    $("#sync_places").click(evt => {
        // disable button
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
                console.log("before send");
                $(".notice").remove();

                //self.find(".button").prop("disabled", true);
                //console.log(form_data);
                // disable btn to prevent multiple submits
                //self.find(".btn").prop("disabled", true);
            },
            success: response => {
                console.log(response);
                //
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
