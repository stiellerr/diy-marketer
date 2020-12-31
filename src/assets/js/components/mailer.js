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

// grab inline css tag
let css = document.getElementById("diym-inline-css");

//let fa = "i[data-content]"console.log(paragraph.search(regex));
let fa = document.querySelectorAll("i[data-content]");

Array.prototype.forEach.call(fa, i => {
    const content = i.dataset.content;

    // bail early if icon already exist.
    if (css.innerText.indexOf(content) !== -1) {
        return;
    }

    // grab icon
    const icon = i.className.match(/fa-[a-z]+/)[0];

    //css.innerText = css.innerText + `.${icon}:before { content: "\\${content}"; }`;

    //console.log(css.innerText);
    //console.log(icon);
    //console.log(content);
    //let icon = i.className.match(/fa-[a-z]+/);
    //console.log(css.innerText.indexOf(i.dataset.content));

    //let content
    //if ( icon.innerText.ind )x.innerText.indexOf("bar")

    //console.log(i.dataset.content);
});

//console.log(fa.classList);

document.addEventListener("DOMContentLoaded", () => {
    // zzz
    let counters = document.getElementsByClassName("countdown");

    Array.prototype.forEach.call(counters, c => {
        if (undefined !== c.dataset.endTime) {
            //console.log("defined");
            const ENDTIME = new Date(c.dataset.endTime);
            let now = new Date();

            if (ENDTIME > now) {
                //console.log("future");
                // countdown timer...
                const SECOND = 1000;
                const MINUTE = 60000;
                const HOUR = 3600000;
                const DAY = 86400000;

                const countdown = setInterval(() => {
                    now = new Date();
                    const REMAINING = ENDTIME - now;

                    if (REMAINING < 0) {
                        clearInterval(countdown);
                        return;
                    }

                    const DAYS = Math.floor(REMAINING / DAY);
                    const HOURS = Math.floor((REMAINING % DAY) / HOUR);
                    const MINUTES = Math.floor((REMAINING % HOUR) / MINUTE);
                    const SECONDS = Math.floor((REMAINING % MINUTE) / SECOND);

                    console.log(DAYS);
                    console.log(HOURS);
                    console.log(MINUTES);
                    console.log(SECONDS);
                }, 1000);
            } else {
                //clearInterval(countdown);
                console.log("past");
            }

            //console.log(endTime);
        }
    });

    //fff.forEach(element => {s
    //console.log(element);
    //});
    //console.log(fff);

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
