/* global _, js_data */

import { Component } from "@wordpress/element";

// jquery
import $ from "jquery";

// select 2
import "select2";

// styles
import "./editor.scss";

export default class IconPicker extends Component {
    dropDownData = [];

    select = null;

    constructor() {
        super();
        //console.log(this.test());
        // init dropDownData array
        $.getJSON(js_data.icons_json, data => {
            const icons = JSON.parse(JSON.stringify(data));

            _.each(icons, (data, name) => {
                _.each(data.free, suffix => {
                    this.dropDownData.push(`fa${suffix[0]} fa-${name}`);
                });
            });
        });
    }

    componentWillUnmount() {
        // reset
        this.select.select2("destroy");
        this.select = null;
        this.dropDownData = [];
    }

    onChangeSelect2 = e => {
        // return filtered event to react components onchange event...
        this.props.onChange(e.target.value);
    };

    formatOption = option => {
        //
        if (option.id) {
            //return $('<span><i class="' + option.id + ' fa-fw"></i>' + option.text + "</span>");
            return $(
                '<span><i class="' +
                    option.id +
                    '" style="width:20px;"></i>' +
                    option.text +
                    "</span>"
            );
        }
        return $("<span>" + option.text + "</span>");
    };

    select2Init = element => {
        this.select = $(element);

        // init select2
        this.select.select2({
            placeholder: "Select an option",
            width: "100%",
            theme: "classic",
            ajax: {
                transport: (params, success, failure) => {
                    //
                    let pageSize = 20;
                    let term = (params.data.term || "").toLowerCase();
                    let page = params.data.page || 1;

                    let results = this.dropDownData
                        .filter(f => {
                            return f.toLowerCase().includes(term);
                        })
                        .map(f => {
                            return { id: f, text: f };
                        });

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

        // attach on change event
        this.select.on("change", this.onChangeSelect2);
    };

    render = () => {
        return <select ref={this.select2Init}></select>;
    };
}
