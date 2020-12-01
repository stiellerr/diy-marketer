/* global diymMailVars */
//import "../../../node_modules/bootstrap/js/dist/util";
//import "../../../node_modules/bootstrap/js/dist/collapse";

//import "./components/mailer";

import bootstrap from "bootstrap";

//("use strict");

// Fetch all the forms we want to apply custom Bootstrap validation styles to
var forms = document.querySelectorAll(".needs-validation");

// Loop over them and prevent submission
Array.prototype.slice.call(forms).forEach(form => {
    form.addEventListener(
        "submit",
        event => {
            //if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
            //}
            if (form.checkValidity()) {
                const XHR = new XMLHttpRequest();
                var formData = new FormData(event.target);

                formData.append("action", "send_form");
                formData.append("security", diymMailVars.ajax_nonce);

                // Define what happens on successful data submission
                /*
                XHR.addEventListener("load", event => {
                    alert("Yeah! Data sent and response loaded.");
                });
                */

                XHR.onerror = event => {
                    alert("onerror");
                };

                XHR.onloadend = event => {
                    alert("onloadend");
                    form.querySelector(".btn").removeAttribute("disabled");

                    // reset the form...
                    form.reset();

                    // remove invalid class
                    form.classList.remove("was-validated");
                };

                XHR.onload = event => {
                    alert("onload");
                    console.log(event);
                };

                XHR.onloadstart = event => {
                    alert("onloadstart");
                    form.querySelector(".btn").setAttribute("disabled", true);
                };

                // Set up our request
                XHR.open("POST", diymMailVars.ajax_url);

                // Send our FormData object; HTTP headers are set automatically
                XHR.send(formData);
            } else {
                form.classList.add("was-validated");
            }
        },
        false
    );
});
