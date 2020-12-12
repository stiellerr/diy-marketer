/* global diymMailVars, ga */

// attach document on ready event
document.addEventListener("DOMContentLoaded", () => {
    // grab all tel & mailto link tags
    let hrefs = document.querySelectorAll('a[href^="tel:"],a[href^="mailto:"]');
    Array.prototype.slice.call(hrefs).forEach(href => {
        href.addEventListener("click", ({ target }) => {
            // get event location
            let location = "";

            if (target.closest("header")) {
                //console.log("header");
                location = "header";
            }
            if (target.closest("main")) {
                //console.log("main");
                location = "main";
            }
            if (target.closest("aside")) {
                //console.log("aside");
                location = "aside";
            }
            if (target.closest("footer")) {
                //console.log("footer");
                location = "footer";
            }

            const data = target.href.split(":");

            ga("send", "event", data[0], data[1], location);

            //console.log(data[0]);
        });
    });

    // grab all the forms
    let forms = document.querySelectorAll(".needs-validation");

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms).forEach(form => {
        form.addEventListener(
            "submit",
            event => {
                // prevent form submit
                event.preventDefault();
                event.stopPropagation();

                // find any alerts and remove them from the dom
                let div = form.parentNode.querySelector(".alert");

                if (div) {
                    form.parentNode.removeChild(div);
                }

                // check if form is valid
                if (form.checkValidity()) {
                    let formData = new FormData(event.target);
                    // Sends the event to Google Analytics and
                    // resubmits the form once the hit is done.
                    ga("send", "event", "form", "submit", formData.get("email"), {
                        hitCallback: () => {
                            //form.submit();

                            const XHR = new XMLHttpRequest();
                            //let formData = new FormData(event.target);

                            formData.append("action", "send_form");
                            formData.append("security", diymMailVars.ajax_nonce);

                            // create a new alert
                            div = document.createElement("div");
                            div.classList.add("alert");

                            // before send...
                            XHR.onloadstart = () => {
                                // disable but to prevent multiple submits
                                form.querySelector(".btn").setAttribute("disabled", true);
                            };

                            // on success...
                            XHR.onload = ({ currentTarget }) => {
                                if (currentTarget.status == 200) {
                                    const response = JSON.parse(currentTarget.response);
                                    // success
                                    div.innerHTML = response.data;
                                    div.classList.add("alert-success");
                                    // ga("send", "event", "form", "submit", formData.get("email")
                                } else {
                                    // failure
                                    div.innerHTML = `Error: ${currentTarget.status} ${currentTarget.statusText}`;
                                    div.classList.add("alert-danger");
                                }
                            };

                            XHR.onerror = ({ currentTarget }) => {
                                // failure
                                div.innerHTML = `Error: ${currentTarget.status} ${currentTarget.statusText}`;
                                div.classList.add("alert-danger");
                            };

                            XHR.onloadend = () => {
                                // re enable button
                                form.querySelector(".btn").removeAttribute("disabled");

                                // reset the form...
                                form.reset();

                                // remove invalid class
                                form.classList.remove("was-validated");

                                // add the alert
                                form.parentNode.insertBefore(div, form);
                            };

                            // Set up our request
                            XHR.open("POST", diymMailVars.ajax_url, true);

                            // Send our FormData object; HTTP headers are set automatically
                            XHR.send(formData);
                        }
                    });
                } else {
                    form.classList.add("was-validated");
                }
            },
            false
        );
    });
});
