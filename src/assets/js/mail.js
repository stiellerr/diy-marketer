import $ from "jquery";

$(document).ready(() => {
    //alert("mail document ready...");
    //diymGenerateColorPreviewStyles("content");
    //diymGenerateColorPreviewStyles("banner-footer");
    $(".contact-form").submit(evt => {
        // prevent fpage refresh
        evt.preventDefault();

        var form_data = $(evt.currentTarget).serializeArray();

        console.log(this);
        console.log(form_data);
        alert("mail document ready...");
    });
});
