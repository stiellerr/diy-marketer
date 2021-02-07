//import "./editor.scss";

import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { InnerBlocks, RichText, PlainText, InspectorControls } from "@wordpress/block-editor";

import {
    TextControl,
    PanelBody,
    CheckboxControl,
    TextareaControl,
    SelectControl,
    CustomSelectControl
} from "@wordpress/components";

//import "./editor.scss";

import classnames from "classnames";

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
        inputSize: {
            type: "string"
        },
        required: {
            type: "boolean",
            source: "attribute",
            selector: "input,textarea",
            attribute: "required"
        },
        feedback: {
            type: "string",
            source: "text",
            selector: ".invalid-feedback"
        },
        type: {
            type: "string",
            source: "attribute",
            selector: "input,textarea",
            attribute: "type"
        },
        label: {
            type: "string",
            source: "text",
            selector: "label"
        },
        placeholder: {
            type: "string",
            source: "attribute",
            selector: "input,textarea",
            attribute: "placeholder"
        }
    },
    edit: props => {
        const { attributes, setAttributes, isSelected } = props;
        const { label, placeholder, required, feedback, type, inputSize } = attributes;

        const sizes = [
            {
                key: "form-control-sm",
                name: "Small",
                style: { fontSize: "50%" }
            },
            {
                name: "Default",
                style: { fontSize: "100%" }
            },
            {
                key: "form-control-lg",
                name: "Large",
                style: { fontSize: "200%" }
            }
        ];

        // props
        const inputProps = {
            style: {
                fontSize:
                    "form-control-sm" === inputSize
                        ? "0.875em"
                        : "form-control-lg" === inputSize
                        ? "1.25em"
                        : undefined
            },
            type,
            value: placeholder,
            onChange: placeholder => {
                setAttributes({ placeholder });
            }
        };

        return (
            <>
                <InspectorControls>
                    <PanelBody title={__("Settings", "diy-marketer")}>
                        <SelectControl
                            label={__("Field Type", "diy-marketer")}
                            value={type}
                            options={[
                                { label: "text", value: "text" },
                                { label: "number", value: "number" },
                                { label: "email", value: "email" },
                                { label: "url", value: "url" },
                                { label: "tel", value: "tel" },
                                { label: "textarea", value: "textarea" }
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
                                label={__("Invalid feedback message", "diy-marketer")}
                                value={feedback}
                                onChange={feedback => {
                                    setAttributes({ feedback });
                                }}
                            ></TextControl>
                        )}
                    </PanelBody>
                    <PanelBody title={__("Size", "diy-marketer")}>
                        <CustomSelectControl
                            label={__("Size", "diy-marketer")}
                            options={sizes}
                            value={sizes.find(size => size.key === inputSize)}
                            onChange={({ selectedItem }) => {
                                setAttributes({ inputSize: selectedItem.key });
                            }}
                        ></CustomSelectControl>
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
                {"textarea" === type ? (
                    <TextareaControl {...inputProps} />
                ) : (
                    <TextControl {...inputProps} />
                )}
            </>
        );
    },
    save: props => {
        const { attributes } = props;
        const { label, placeholder, feedback, required, type, inputSize } = attributes;
        // default tag
        let TagName = "input";

        if ("textarea" == type) {
            TagName = type;
        }

        const inputClass = classnames("form-control", inputSize);

        return (
            <>
                <label htmlFor={label} className={"form-label"}>
                    {label}
                </label>
                <div className={"input-group"}>
                    <TagName
                        id={label}
                        type={type}
                        className={inputClass}
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
