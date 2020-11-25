/* global _, js_data */

import { Component } from "@wordpress/element";
import { InspectorControls } from "@wordpress/block-editor";
import { PanelBody } from "@wordpress/components";
import { __ } from "@wordpress/i18n";

import classNames from "classnames";

// jquery
import $ from "jquery";

// select2
import "select2";

// styles
import "./editor.scss";

class Edit extends Component {
    select2 = null;

    dropDownData = [];

    constructor(props) {
        super(props);

        // init dropDown array
        $.getJSON(js_data.icons_json, data => {
            const icons = JSON.parse(JSON.stringify(data));

            _.each(icons, (data, name) => {
                _.each(data.free, suffix => {
                    this.dropDownData.push(`fa${suffix[0]} fa-${name}`);
                });
            });
        });

        console.log(this.dropDownData);
    }

    onChangeSelect2 = event => {
        this.props.setAttributes({ value: event.target.value });
    };

    formatOption = option => {
        if (option.id) {
            //
            return $(
                '<span><i class="' +
                    option.id +
                    '" style="width:20px;"></i>' +
                    option.text +
                    "</span>"
            );
        }
        return $("<span style='color: red;'>" + option.text + "</span>");
        //
        //let $option = $("<span style='color: red;'>" + option.text + "</span>");
        //return $option;
    };

    setSelect2Ref = e => {
        let { value } = this.props.attributes;
        //
        //this.select2 = element;

        if (null == e) {
            $(this.select2).select2("destroy");
            this.select2 = null;
        } else {
            this.select2 = e;
            $(this.select2).select2({
                //dropdownAutoWidth: true,
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
                                //console.log(f);
                            });

                        //console.log(results);

                        //.map(function(f){
                        // your custom mapping here.
                        //return { id: f, text: f};
                        //});

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

            // check if pre defined value exists...

            //value = value ? value : "fas fa-check";

            if (value) {
                /*
                let item = this.dropDown.filter(f => {
                    return f == value;
                });
                */

                //console.log(item[0]);
                //console.log(value);

                let newOption = new Option(value, value, false, false);

                $(this.select2).append(newOption).trigger("change");
            }

            $(this.select2).on("change", this.onChangeSelect2);
        }
    };

    //self = createRef();

    render() {
        const { value } = this.props.attributes;

        const className = value ? classNames(value, "fa-2x") : null;
        return (
            <>
                <InspectorControls>
                    <PanelBody title={__("Icon Picker", "diy-marketer")}>
                        {/*<label>{__("Choose An Icon Below.", "diy-marketer")}</label>*/}
                        <select
                            ref={this.setSelect2Ref}
                            //ref={this.setSelect2Ref}
                            //ref={element => (this.select2 = element)}
                            //style={{ width: "250px" }}
                        ></select>
                    </PanelBody>
                </InspectorControls>
                <div>
                    <i className={className}></i>
                </div>
            </>
        );
    }

    componentDidMount() {
        //console.log(this.dropDown);
    }
}

export default Edit;
