/* global diymMailVars */

//import "jquery";
//import "bootstrap";

import $ from "jquery";

$(document).ready(() => {
    // from submit event
    // to do... datalayer.push google tag manager, deferentiate between footer and side bar forms...
    $(".contact-form").submit(evt => {
        // prevent page refresh
        evt.preventDefault();

        let self = $(evt.currentTarget);

        // remove any alerts that exist...
        self.children(".alert").remove();

        if (self[0].checkValidity()) {
            let form_data = self.serializeArray();

            // add action + nonce to form data
            form_data.push(
                {
                    name: "action",
                    value: "send_form"
                },
                {
                    name: "security",
                    value: diymMailVars.ajax_nonce
                }
            );

            $.ajax({
                url: diymMailVars.ajax_url,
                type: "post",
                dataType: "JSON", // Set this so we don't need to decode the response...
                data: form_data,
                beforeSend: () => {
                    // disable btn to prevent multiple submits
                    self.find(".btn").prop("disabled", true);
                },
                error: ({ responseJSON, status, statusText }) => {
                    if (!responseJSON.success) {
                        self.prepend(
                            "<div class='alert alert-danger'>Error: " +
                                status +
                                " " +
                                statusText +
                                "</div>"
                        );
                    }
                },
                success: response => {
                    if (response.success) {
                        self.prepend(
                            "<div class='alert alert-success'>" + response.data + "</div>"
                        );
                        // drop focus on click
                        //self.find("button").blur();
                    }
                },
                complete: () => {
                    // re enable btn
                    self.find(".btn").prop("disabled", false);

                    // reset the form...
                    self[0].reset();

                    // remove invalid class
                    self.removeClass("was-validated");
                }
            });
        } else {
            self.addClass("was-validated");
        }
    });
});
