/* global diymMailVars */

import $ from "jquery";

$(document).ready(() => {
    //alert("mail document ready...");
    //diymGenerateColorPreviewStyles("content");
    //diymGenerateColorPreviewStyles("banner-footer");
    $(".contact-form").submit(evt => {
        // prevent page refresh
        evt.preventDefault();

        //var form_data = $(evt.currentTarget).serializeArray();
        let self = $(evt.currentTarget);

        console.log(self);
        console.log(self[0]);

        // drop focus on click
        self.find("button").blur();

        //console.log(evt());
        // validate...
        //if (!self[0].checkValidity()) {
        //self.classList.add("was-validated");
        // self.addClass("was-validated");
        //}
        //var form_data = $(evt).serializeArray();

        //console.log(self.serializeArray());
        //console.log($(this));
        //console.log(this_form);
        //alert("mail document ready...");

        if (self[0].checkValidity()) {
            //console.log(self.serialize());

            // reset the form...
            //self[0].reset();

            // remove invalid class
            // self.removeClass("was-validated");

            let form_data = self.serializeArray();
            //let form_data = self.serialize();

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

            console.log(form_data);

            //
            //console.log(diymMailVars.ajax_url);

            //let form_data = { action: "send_form" };

            $.ajax({
                url: diymMailVars.ajax_url,
                //url: "/wp-admin/admin-ajax.php", // Let WordPress figure this url out...
                type: "post",
                dataType: "JSON", // Set this so we don't need to decode the response...
                //data: self.serialize(), // One-liner form data prep...
                data: form_data,

                beforeSend: function () {
                    //let is_sending = true;
                    // You could do an animation here...
                },

                error: response => {
                    //let is_sending = true;
                    // You could do an animation here...
                    console.log("error");
                    console.log(response);
                    //console.log(res);
                },
                //error: handleFormError,

                success: response => {
                    //console.log("success");
                    //console.log(response);

                    if (response.success) {
                        // reset the form...
                        self[0].reset();

                        // remove invalid class
                        self.removeClass("was-validated");
                        self.prepend(
                            "<div class='alert alert-success'>Thank you! Your message has been sent.</div>"
                        );
                        //console.log("success");
                        console.log(response);
                        //self.trigger("blur");
                        // is_sending = false

                        // alert(this_form.innerHTML);
                        // alert(this_form.html());
                        //  alert('hi');
                        //$("#name").val("");
                        //$("#phone").val("");
                        //$("#email").val("");
                        //$("#message").val("");
                        //this_form.reset();
                        //$( "#contact-form" ).prepend( "<div class='alert alert-success mt-1'>Thank you! Your message has been sent.</div>" );
                        //alert(this_form.html());
                        // Here, you could trigger a success message
                        //} else {
                        //console.log("failure");
                        // handleFormError(); // If we don't get the expected response, it's an error...
                    }
                }
            });
        } else {
            //console.log(2);
            self.addClass("was-validated");
        }
    });
});
