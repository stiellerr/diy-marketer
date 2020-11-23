import { Component } from "@wordpress/element";

// jquery
import $ from "jquery";

// select2
import "select2";
import "select2/src/scss/core.scss";

var data = [
    {
        id: 0,
        text: "enhancement"
    },
    {
        id: 1,
        text: "bug"
    },
    {
        id: 2,
        text: "duplicate"
    },
    {
        id: 3,
        text: "invalid"
    },
    {
        id: 4,
        text: "wontfix"
    }
];

class Edit extends Component {
    onChangeSelect2 = event => {
        this.props.setAttributes({ value: event.target.value });
    };

    render() {
        return <select className="test-select" style={{ width: "250px" }}></select>;
    }

    componentDidMount() {
        const { value } = this.props.attributes;

        // init
        $(".test-select").select2({ placeholder: "Select an option", data: data });

        // set to saved value...
        $(".test-select").val(value).trigger("change");

        // attach on change event...
        $(".test-select").on("change", this.onChangeSelect2);
    }
}

export default Edit;
