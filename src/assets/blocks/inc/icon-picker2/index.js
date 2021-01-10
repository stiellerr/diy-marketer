/* global _, js_data */

import { Component } from "@wordpress/element";
import { __experimentalInputControl as InputControl } from "@wordpress/components";
//nputControl
//import { select, dispatch } from "@wordpress/data";

// jquery
import $ from "jquery";

// select 2
//import "select2";

// styles
import "./editor.scss";

export default class IconPicker2 extends Component {
    iconData = [];

    //select = null;

    /*
    constructor() {
        super();
        console.log("constructor...");

        // init iconData array
        $.getJSON(js_data.icons_json, data => {
            const icons = JSON.parse(JSON.stringify(data));
            _.each(icons, (data, name) => {
                _.each(data.free, suffix => {
                    this.iconData.push({
                        class: `fa${suffix[0]} fa-${name}`,
                        unicode: data.unicode
                    });
                });
            });
        });
        //
        console.log(this.iconData);
    }
    */

    componentDidMount() {
        console.log("componentDidMount");

        // init icon picker...
        $.getJSON(js_data.icons_json, data => {
            const icons = JSON.parse(JSON.stringify(data));
            _.each(icons, (data, name) => {
                let arr = [];
                if (data.search.terms.length) {
                    arr = data.search.terms;
                }
                arr.push(name);
                _.each(data.free, suffix => {
                    $(".diym-icon-picker__items").append(
                        `<i class="fa${suffix[0]} fa-${name}" data-content="${
                            data.unicode
                        }" data-query="${arr.join(" ")}"></i>`
                    );
                });
            });

            // hide children
            $(".diym-icon-picker__items").children().hide();

            // add click event listener
            $(".diym-icon-picker__items > i").on("click", ({ currentTarget }) => {
                let e = $(currentTarget);

                let icon = `<i class="${e.attr("class")}" data-content="${e.data(
                    "content"
                )}">&nbsp;</i>`;
                this.props.onSelect(icon);
                //var s = $(e.currentTarget).data("content");
                //var c = $(e.currentTarget).data("content");
                //var z = $(e.currentTarget).removeAttr("style");
                //var z = $(e.currentTarget).attr("class");
                //console.log(h);
            });
        });

        //console.log("done...");

        // populate icon picker
        //this.iconData.forEach(i => {
        //console.log(i);
        //$(".diym-icon-picker__items").append(`<i class="${i.class}"></i>`);
        //});

        //$(".diym-icon-picker__items > i").on("click", function () {

        /*
            var iconClass = $(this).attr('class').slice(3);
            var classInput = $(this).parents('.iconpicker-popover').prev().find('.icp');
            classInput.val(iconClass);
            classInput.attr('value', iconClass);

            var iconPreview = classInput.next('.input-group-addon');
            var iconElement = '<i class="fa '.concat(iconClass, '"><\/i>');
            iconPreview.empty();
            iconPreview.append(iconElement);

            var th = $(this).parent().parent().parent();
            classInput.trigger('change');
            customizer_repeater_refresh_social_icons(th);
            return false;
            */
        //});

        //$(".diym-icon-picker__search > input").on("keyup", () => {
        //console.log("xxx");
        //wp.customizerRepeater.search($(this));
        //});
    }

    componentWillUnmount() {
        /*
        // reset
        this.select.select2("destroy");
        this.select = null;
        this.dropDownData = [];
        //this.updatePostMeta("unmount");
        */
    }

    /*
    select2Init = element => {
        //
        if (element == null) {
            return;
        }

        console.log(element);

        this.select = $(element);

        // init select2
        this.select.select2({
            placeholder: "Select an option",
            dropdownParent: $(".diym-icon-popover"),
            width: "100%",
            theme: "classic",
            ajax: {
                transport: (params, success, failure) => {
                    //
                    let pageSize = 20;
                    let term = (params.data.term || "").toLowerCase();
                    let page = params.data.page || 1;

                    let results = this.dropDownData.filter(f => {
                        return f.id.toLowerCase().includes(term);
                    });
                    /*
                        .map((f, i) => {
                            return { id: i, text: f.label };
                        });
                        */
    /*
                    let paged = results.slice((page - 1) * pageSize, page * pageSize);

                    let options = {
                        results: paged,
                        pagination: {
                            more: results.length >= page * pageSize
                        }
                    };
                    success(options);
                }
            },
            templateResult: this.formatOption,
            templateSelection: this.formatOption
        });

        // set default value
        let value = this.props.value;
        console.log(value);
        //let zzz =
        //let zzz = this.dropDownData.filter(f => {
        //return f.id.toLowerCase().includes("fa");
        //});

        //console.log(zzz);
        // attach on change event
        //this.select.on("change", this.onChangeSelect2);

        let newOption = new Option(value.unicode, value.name, false, false);
        //let newOption = new Option("fa fa-b", "f307", false, false);
        this.select.append(newOption).trigger("change"); //.trigger("select2:select");
        //$('#mySelect2').val(data.id).trigger('change');
        this.select.on("change", this.onChangeSelect2);
    };
*/
    onChangeInput = value => {
        console.log("onChangeInput");

        let itemsList = $(".diym-icon-picker__items");

        itemsList.children().hide();

        if (value && value.trim()) {
            itemsList.children().filter(`[data-query*="${value.trim().toLowerCase()}"]`).show();
        }

        // bail early if search term is <= 1 char
        /*
        if (value.length <= 0) {
            return;
        }

        console.log(value);

        // query items...
        itemsList.children().filter(`[data-query*="${value.toLowerCase()}"]`).show();
        */
    };

    render = () => {
        console.log("render");

        return (
            <>
                <div className="diym-icon-picker">
                    <div className="diym-icon-picker__search">
                        {/*<input type="search" placeholder="Type to filter" />*/}
                        <InputControl
                            onChange={this.onChangeInput}
                            type="search"
                            placeholder="Type to filter"
                        />
                    </div>
                    <div className="diym-icon-picker__items"></div>
                </div>
            </>
        );
    };
}
