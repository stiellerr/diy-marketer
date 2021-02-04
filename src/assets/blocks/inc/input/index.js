//import "./editor.scss";

import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { InnerBlocks, RichText, PlainText } from "@wordpress/block-editor";

import { TextControl } from "@wordpress/components";

//import edit from "./edit";

registerBlockType("diym/input", {
    title: __("Input", "diy-marketer"),
    description: __("Add an input field to your form.", "diy-marketer"),
    category: "diy-marketer",
    icon: {
        foreground: "#007bff",
        src: "edit-large"
    },
    keywords: [__("input", "diy-marketer")],
    supports: {
        html: false,
        reusable: false,
        className: false,
        customClassName: false
    },
    attributes: {
        label: {
            type: "string"
        },
        placeholder: {
            type: "string"
        }
    },
    edit: props => {
        const { attributes, setAttributes } = props;
        const { label, placeholder } = attributes;
        return (
            <div>
                <PlainText
                    value={label}
                    style={{ backgroundColor: "transparent" }}
                    onChange={label => {
                        setAttributes({ label });
                    }}
                ></PlainText>
                <TextControl
                    value={placeholder}
                    onChange={placeholder => {
                        setAttributes({ placeholder });
                    }}
                />
            </div>
        );
    },
    save: props => {
        const { attributes } = props;
        const { label, placeholder } = attributes;

        return (
            <>
                <label htmlFor={label} className={"form-label"}>
                    {label}
                </label>
                <div className={"input-group"}>
                    <input id={label} className={"form-control"} placeholder={placeholder} />
                </div>
            </>
        );
    }
});
