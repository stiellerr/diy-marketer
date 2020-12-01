/* global diymMailVars */

// attach document on ready event
document.addEventListener("DOMContentLoaded", () => {
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
                    const XHR = new XMLHttpRequest();
                    let formData = new FormData(event.target);

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
