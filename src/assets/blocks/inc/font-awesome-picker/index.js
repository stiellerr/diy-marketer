import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
//import { RichText } from "@wordpress/block-editor";

//import { Component } from "@wordpress/element";

import Edit from "./edit";

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

    attributes: {
        value: {
            type: "string"
            //source: "html",
            //selector: "h4"
        }
        /*
        content: {
            type: "string",
            source: "html",
            selector: "p"
        }
        */
    },

    edit: Edit,
    //class extends Component {
    /*
        onChangeSelect = val => {
            this.props.setAttributes({ val });
        };
        */

    //onChangeSelect(value) {
    //console.log(value);
    //this.props.setAttributes({ content });
    //}
    /*
        handleChange = event => {
            this.setState({ value: event.target.value });
        };
        */
    /*
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
    },*/

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
