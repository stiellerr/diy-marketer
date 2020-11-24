/* global _ */

import { createRef, Component } from "@wordpress/element";

// jquery
import $ from "jquery";

// select2
import "select2";
import "select2/src/scss/core.scss";

class Edit extends Component {
    //
    dropdownData = () => {
        return _.map(_.range(1, 200000), i => {
            return {
                id: i,
                text: "item: " + i
            };
        });
    };

    onChangeSelect2 = event => {
        this.props.setAttributes({ value: event.target.value });
        //console.log(event.target.value);
    };

    formatOption = option => {
        if (option.id) {
            //
            //return '<span><i class="' + opt.id + '" style="width:20px;"></i>' + opt.text + '</span>';
        }
        //
        let $option = $("<span style='color: red;'>" + option.text + "</span>");
        return $option;
    };

    self = createRef();

    render() {
        return <select ref={this.self} className="test-select" style={{ width: "250px" }}></select>;
    }

    componentDidMount() {
        const { value } = this.props.attributes;

        const node = this.self.current;

        // init
        $(node).select2({
            placeholder: "Select an option",
            ajax: {
                transport: (params, success, failure) => {
                    //
                    let pageSize = 20;
                    let term = (params.data.term || "").toLowerCase();
                    let page = params.data.page || 1;

                    let results = this.dropdownData().filter(f => {
                        return f.text.toLowerCase().includes(term);
                    });

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
        if (value) {
            let item = this.dropdownData().filter(f => {
                return f.id == value;
            });

            let newOption = new Option(item[0].text, value, false, false);

            $(node).append(newOption).trigger("change");
        }
        $(node).on("change", this.onChangeSelect2);
    }
}

export default Edit;
