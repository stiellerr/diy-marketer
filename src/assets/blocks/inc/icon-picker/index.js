/* global _, js_data */

import { Component } from "@wordpress/element";
import { select, dispatch } from "@wordpress/data";

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
                //console.log(data.unicode);
                //console.log(name);
                _.each(data.free, suffix => {
                    //this.dropDownData.push(`fa${suffix[0]} fa-${name}`);
                    //{ id: f, text: f }
                    this.dropDownData.push({
                        id: `fa${suffix[0]} fa-${name}`,
                        text: data.unicode
                    });
                    //this.dropDownData.push(`fa${suffix[0]} fa-${name}`);
                });
            });
        });
        //console.log(this.dropDownData);
    }

    componentWillUnmount() {
        // reset
        this.select.select2("destroy");
        this.select = null;
        this.dropDownData = [];
        this.updatePostMeta("unmount");
    }

    updatePostMeta = msg => {
        console.log(msg);

        const blockList = select("core/block-editor").getBlocks();
        //console.log(blockList);
        let icons = [];
        let icons2 = [];

        blockList.forEach(({ name, attributes }) => {
            if ("diym/benefit" === name) {
                // only add items with unique names...
                if (!_.findWhere(icons, { name: attributes.icon.name })) {
                    icons.push({
                        name: attributes.icon.name,
                        unicode: attributes.icon.unicode
                    });
                    icons2[attributes.icon.name] = attributes.icon.unicode;
                }
            }
        });

        dispatch("core/editor").editPost({ meta: { _diym_fa: icons } });
    };

    onChangeSelect2 = ({ target }) => {
        //console.log("onChange");
        this.props.onChange({
            name: target.value,
            unicode: target.options[target.selectedIndex].text
        });

        // update post meta
        this.updatePostMeta("onchange");

        //console.log(target.value);
        //console.log(target.options[target.selectedIndex].text);
        //console.log(target.options[target.selectedIndex].value);
        //this.select.val(null).trigger("change");
        // return filtered event to react components onchange event...
        /*
        console.log("ttt");
        let zzz = this.dropDownData.filter(f => {
            return f.id.toLowerCase().includes(e.target.value);
        });

        console.log(zzz);

        this.props.onChange(e.target.value);
        */
    };

    formatOption = ({ id }) => {
        //
        if (id) {
            //return $('<span><i class="' + option.id + ' fa-fw"></i>' + option.text + "</span>");
            return $('<span><i class="' + id + '" style="width:20px;"></i>' + id + "</span>");
        }
        return $("<span>" + id + "</span>");
    };

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
        this.select.on("change", this.onChangeSelect2);

        let newOption = new Option(value.unicode, value.name, false, false);
        //let newOption = new Option("fa fa-b", "f307", false, false);
        this.select.append(newOption).trigger("change"); //.trigger("select2:select");
        //$('#mySelect2').val(data.id).trigger('change');
    };

    render = () => {
        return <select ref={this.select2Init}></select>;
    };
}
