import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
//import { RichText } from "@wordpress/block-editor";

//import domReady from "@wordpress/dom-ready";

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

/*
domReady(() => {
    console.log("hello");
});
*/

/*
import Select from "react-select";

const options = [
    { value: "chocolate", label: "Chocolate" },
    { value: "strawberry", label: "Strawberry" },
    { value: "vanilla", label: "Vanilla" }
];
*/

registerBlockType("diym/font-awesome-picker", {
    title: __("Icon Picker", "diy-marketer"),
    description: __("Choose icon's to display, from the font awesome library.", "diy-marketer"),
    category: "diy-marketer",
    icon: {
        foreground: "#007bff",
        src: "image-filter"
    },
    keywords: [__("Icon", "diy-marketer"), __("font awesome", "diy-marketer")],
    supports: {
        html: false,
        reusable: false,
        //
        //anchor: true,
        className: false,
        __experimentalColor: {
            linkColor: true
        },
        __experimentalFontSize: true
        //__experimentalLineHeight: true,
        //__experimentalSelector: "p",
        //__unstablePasteTextInline: true
    },

    /*
    attributes: {
        heading: {
            type: "string",
            source: "html",
            selector: "h4"
        },
        content: {
            type: "string",
            source: "html",
            selector: "p"
        }
    },
    */
    edit: class extends Component {
        /*
        onChangeSelect = val => {
            this.props.setAttributes({ val });
        };
        */

        //onChangeSelect(value) {
        //console.log(value);
        //this.props.setAttributes({ content });
        //}

        handleChange = event => {
            this.setState({ value: event.target.value });
        };

        render() {
            return (
                <select
                    className="test-select"
                    style={{ width: "250px" }}
                    onChange={this.handleChange}
                ></select>
            );
        }
        componentDidMount() {
            $(".test-select").select2({ placeholder: "Select an option", data: data });
        }
    },

    /*
    edit: ({ attributes, setAttributes }) => {
        return (
            <select>
                <option>1</option>
            </select>
        );
    },
    */
    save: ({ attributes }) => {
        //const { heading, content } = attributes;

        //const test = () '<div>' . content . '</div>';

        //const test = <div>{content}</div>;

        return (
            <>
                <input />
            </>
        );
    }
});
