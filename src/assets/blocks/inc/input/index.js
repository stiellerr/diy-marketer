//import "./editor.scss";

import { useRef } from "@wordpress/element";
import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { PlainText, InspectorControls, useBlockProps } from "@wordpress/block-editor";

import {
    TextControl,
    PanelBody,
    CheckboxControl,
    TextareaControl,
    SelectControl,
    CustomSelectControl
} from "@wordpress/components";

import "./editor.scss";

import classnames from "classnames";

// Input field...
const InputField = props => {
    if ("textarea" === props.type) {
        return <TextareaControl {...props} />;
    }
    return <TextControl {...props} />;
};

registerBlockType("diym/input", {
    apiVersion: 2,
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
        className: true,
        customClassName: false
    },
    attributes: {
        inputSize: {
            type: "string"
        },
        labelPosition: {
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
            source: "attribute",
            selector: "input",
            attribute: "id"
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
        const {
            label,
            placeholder,
            labelPosition,
            required,
            feedback,
            type,
            inputSize
        } = attributes;

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

        //const ref = useRef();
        const blockProps = useBlockProps();

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
                        {labelPosition && (
                            <TextControl
                                label={__("Label value", "diy-marketer")}
                                value={label}
                                onChange={label => {
                                    setAttributes({ label });
                                }}
                            ></TextControl>
                        )}
                        <SelectControl
                            label={__("Label position", "diy-marketer")}
                            value={labelPosition}
                            options={[
                                { label: "Top", value: "" },
                                { label: "Floating", value: "floating" },
                                { label: "Hidden", value: "hidden" }
                            ]}
                            onChange={labelPosition => {
                                setAttributes({ labelPosition });
                            }}
                        ></SelectControl>
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
                <div {...blockProps}>
                    {!labelPosition && (isSelected || label?.length > 0) && (
                        <PlainText
                            value={label}
                            style={{ backgroundColor: "transparent" }}
                            onChange={label => {
                                setAttributes({ label });
                            }}
                        ></PlainText>
                    )}
                    <InputField {...inputProps}></InputField>
                </div>
            </>
        );
    },
    save: props => {
        const { attributes } = props;
        const {
            label,
            placeholder,
            feedback,
            required,
            type,
            inputSize,
            labelPosition
        } = attributes;
        // default tag
        let TagName = "input";

        if ("textarea" == type) {
            TagName = type;
        }

        const inputClass = classnames("form-control", inputSize);

        // Label =>
        const Label = () => {
            return (
                <label htmlFor={label} className={"form-label"}>
                    {label}
                </label>
            );
        };

        return (
            <>
                {!labelPosition && <Label></Label>}
                <div
                    className={
                        !labelPosition
                            ? "input-group"
                            : "floating" === labelPosition
                            ? "form-floating"
                            : undefined
                    }
                >
                    <TagName
                        id={label}
                        type={type}
                        className={inputClass}
                        name={label}
                        placeholder={placeholder}
                        required={required}
                    />
                    {"floating" === labelPosition && <Label></Label>}
                    {feedback && (
                        <div className={__("invalid-feedback", "diy-marketer")}>{feedback}</div>
                    )}
                </div>
            </>
        );
    }
});
