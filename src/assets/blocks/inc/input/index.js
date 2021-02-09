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
    CustomSelectControl,
    Flex,
    FlexItem,
    PanelRow,
    Button,
    FlexBlock
} from "@wordpress/components";

import BoxControlIcon from "./icon";

import InputControls from "./input-controls";

//import "./editor.scss";

import classnames from "classnames";
import { useState } from "@wordpress/element";

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

        //const [side, setSide] = useState(isLinked ? "all" : "top");
        const [side, setSide] = useState("top");

        const handleOnFocus = (event, { side: nextSide }) => {
            //console.log(event);
            //console.log(nextSide);
            setSide(nextSide);
        };

        return (
            <>
                <InspectorControls>
                    <PanelBody title={__("Spacing", "diy-marketer")}>
                        <Flex>
                            <FlexItem>
                                <BoxControlIcon side={side}></BoxControlIcon>
                            </FlexItem>
                            <FlexItem style={{ marginTop: "8px" }}>
                                <TextControl
                                    inputMode={"numeric"}
                                    style={{ maxWidth: "58px" }}
                                ></TextControl>
                            </FlexItem>
                            <FlexBlock style={{ textAlign: "right" }}>
                                <Button isPrimary isSmall>
                                    Click
                                </Button>
                            </FlexBlock>
                        </Flex>
                        <Flex gap={3}>
                            <InputControls
                                values={{ top: 0 }}
                                onChange={v => {
                                    console.log(v);
                                    console.log("on change");
                                }}
                                onFocus={handleOnFocus}
                            ></InputControls>
                        </Flex>
                    </PanelBody>
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
                {!labelPosition && (isSelected || label?.length > 0) && (
                    <PlainText
                        value={label}
                        style={{ backgroundColor: "transparent" }}
                        onChange={label => {
                            //

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
