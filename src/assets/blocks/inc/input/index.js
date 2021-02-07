//import "./editor.scss";

import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { InnerBlocks, RichText, PlainText, InspectorControls } from "@wordpress/block-editor";

import {
    TextControl,
    PanelBody,
    CheckboxControl,
    TextareaControl,
    SelectControl
} from "@wordpress/components";

//import "./editor.scss";

//import classnames from "classnames";

//import edit from "./edit";

registerBlockType("diym/input", {
    title: __("Input", "diy-marketer"),
    description: __("Add an input field to your form.", "diy-marketer"),
    category: "diy-marketer",
    parent: ["diym/form"],
    icon: {
        foreground: "#007bff",
        src: "edit-large"
    },
    keywords: [__("input", "diy-marketer")],
    supports: {
        html: false,
        reusable: false,
        //className: true,
        customClassName: false
    },
    attributes: {
        required: {
            type: "boolean"
        },
        feedback: {
            type: "string"
        },
        type: {
            type: "string"
        },
        label: {
            type: "string"
        },
        placeholder: {
            type: "string"
        }
    },
    edit: props => {
        const { attributes, setAttributes, isSelected } = props;
        const { label, placeholder, required, feedback, type } = attributes;
        return (
            <>
                <InspectorControls>
                    <PanelBody title={__("Settings", "diy-marketer")}>
                        <SelectControl
                            label={__("Field Type", "diy-marketer")}
                            value={type}
                            options={[
                                { label: "text", value: "text" },
                                { label: "url", value: "url" },
                                { label: "number", value: "number" }
                            ]}
                            onChange={type => {
                                setAttributes({ type });
                            }}
                        ></SelectControl>
                        <CheckboxControl
                            label={__("Required field?", "diy-marketer")}
                            checked={required}
                            onChange={required => {
                                setAttributes({ required });
                            }}
                        />
                        {required && (
                            <TextControl
                                label={__("Invalid feedback", "diy-marketer")}
                                value={feedback}
                                onChange={feedback => {
                                    setAttributes({ feedback });
                                }}
                            ></TextControl>
                        )}
                    </PanelBody>
                </InspectorControls>
                {(isSelected || label?.length > 0) && (
                    <PlainText
                        value={label}
                        style={{ backgroundColor: "transparent" }}
                        onChange={label => {
                            setAttributes({ label });
                        }}
                    ></PlainText>
                )}
                <TextControl
                    value={placeholder}
                    onChange={placeholder => {
                        setAttributes({ placeholder });
                    }}
                />
            </>
        );
    },
    save: props => {
        const { attributes } = props;
        const { label, placeholder, feedback, required, type } = attributes;

        return (
            <>
                <label htmlFor={label} className={"form-label"}>
                    {label}
                </label>
                <div className={"input-group"}>
                    <input
                        id={label}
                        type={type}
                        className={"form-control"}
                        name={label}
                        placeholder={placeholder}
                        required={required}
                    />
                    {feedback && (
                        <div className={__("invalid-feedback", "diy-marketer")}>{feedback}</div>
                    )}
                </div>
            </>
        );
    }
});
