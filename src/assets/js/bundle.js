import "bootstrap";
import $ from "jquery";

//import strip_tags from "locutus/php/strings/strip_tags";

// Generate styles on load. Handles page-changes on the preview pane
$(document).ready(() => {
    var aFrame = $("<iframe>");
    var bFrame = $("<iframe>");

    $(aFrame).attr(
        "src",
        "https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fmichaelsurealestate%2F&tabs&width=340&height=154&small_header=true&adapt_container_width=true&hide_cover=false&show_facepile=true&appId"
    );

    $(bFrame).attr(
        "src",
        "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d24669.084839974566!2d174.3257661386322!3d-39.387124033464005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6d1508d759008c9f%3A0x9e9b129c17d969b4!2s582%20Skinner%20Road%2C%20Ngaere%204393!5e0!3m2!1sen!2snz!4v1597520728312!5m2!1sen!2snz"
    );

    //$(".widget_diym_facebook").append(aFrame);
    //$(".widget_diym_google_map").append(bFrame);
});

//$(document).ready(() => {
//  alert("hi");

/*
    var aFrame = $("<iframe>");
    var bFrame = $("<iframe>");

    $(aFrame).attr(
        "src",
        "https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fmichaelsurealestate%2F&tabs&width=340&height=154&small_header=true&adapt_container_width=true&hide_cover=false&show_facepile=true&appId"
    );

    $(bFrame).attr(
        "src",
        "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d24669.084839974566!2d174.3257661386322!3d-39.387124033464005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6d1508d759008c9f%3A0x9e9b129c17d969b4!2s582%20Skinner%20Road%2C%20Ngaere%204393!5e0!3m2!1sen!2snz!4v1597520728312!5m2!1sen!2snz"
    );

    $(".widget_diym_facebook").append(aFrame);
    $(".widget_diym_google_map").append(bFrame);
*/
/*
    $("#diym-fb").attr(
        "src",
        "https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fmichaelsurealestate%2F&tabs&width=340&height=154&small_header=true&adapt_container_width=true&hide_cover=false&show_facepile=true&appId"
    );

    $("#diym-gmap").attr(
        "src",
        "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d24669.084839974566!2d174.3257661386322!3d-39.387124033464005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6d1508d759008c9f%3A0x9e9b129c17d969b4!2s582%20Skinner%20Road%2C%20Ngaere%204393!5e0!3m2!1sen!2snz!4v1597520728312!5m2!1sen!2snz"
    );
    */
//});
