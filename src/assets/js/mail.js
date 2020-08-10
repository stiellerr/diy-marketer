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

        // validate...
        if (!self[0].checkValidity()) {
            //self.classList.add("was-validated");
            self.addClass("was-validated");
        }
        //var form_data = $(evt).serializeArray();

        console.log(self.serializeArray());
        //console.log($(this));
        //console.log(this_form);
        //alert("mail document ready...");
    });
});
