/* global diymMailVars, ga */

// retrive location on page where link was clicked
const getLocation = target => {
    if (typeof target.closest !== "function") {
        return null;
    }

    if (target.closest("header")) {
        return "header";
    }
    if (target.closest("main")) {
        return "main";
    }
    if (target.closest("aside")) {
        return "aside";
    }
    if (target.closest("footer")) {
        return "footer";
    }
    // default
    return null;
};

document.addEventListener("DOMContentLoaded", () => {
    // if google analytics exists, attach an event listener to all tel & mailto link clicks
    if (typeof ga !== "undefined") {
        let hrefs = document.querySelectorAll('a[href^="tel:"],a[href^="mailto:"]');
        Array.prototype.slice.call(hrefs).forEach(href => {
            href.addEventListener("click", ({ target }) => {
                const data = target.href.split(":");
                ga("send", "event", data[0], data[1], getLocation(target));
            });
        });
    }

    // grab all the forms
    let forms = document.querySelectorAll(".needs-validation");
    Array.prototype.slice.call(forms).forEach(form => {
        form.addEventListener(
            "submit",
            event => {
                // prevent form submit
                event.preventDefault();
                event.stopPropagation();
                // find any alerts and remove them from the dom
                let div = form.parentNode.querySelector(".alert");

                if (div !== null) {
                    form.parentNode.removeChild(div);
                }

                // check if form is valid
                if (form.checkValidity()) {
                    let formData = new FormData(event.target);
                    const XHR = new XMLHttpRequest();

                    formData.append("action", "send_form");
                    formData.append("security", diymMailVars.ajax_nonce);

                    // create a new alert
                    div = document.createElement("div");
                    div.classList.add("alert");

                    // before send...
                    XHR.onloadstart = () => {
                        // disable btn to prevent multiple submits
                        form.querySelector(".btn").setAttribute("disabled", true);
                    };

                    // on success...
                    XHR.onload = ({ currentTarget }) => {
                        if (currentTarget.status == 200) {
                            const response = JSON.parse(currentTarget.response);
                            // success
                            div.innerHTML = response.data;
                            div.classList.add("alert-success");
                            // if google analytics exists, send the event
                            if (typeof ga !== "undefined") {
                                ga(
                                    "send",
                                    "event",
                                    "form",
                                    formData.get("email"),
                                    getLocation(form)
                                );
                            }
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
                } else {
                    form.classList.add("was-validated");
                }
            },
            false
        );
    });
});
