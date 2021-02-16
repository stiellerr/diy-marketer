/**
 * External dependencies
 */
import { createBlock, registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import {
    RichText,
    BlockControls,
    AlignmentToolbar,
    InspectorControls,
    useBlockProps
} from "@wordpress/block-editor";

import { Button, PanelBody, ToolbarGroup, CustomSelectControl } from "@wordpress/components";

import { typography } from "@wordpress/icons";

import classnames from "classnames";
import { TEXT_ALIGNMENT_CONTROLS } from "../helper";
import { SpacingControl, getEditorSpacing, getFrontEndSpacing } from "../spacing-control";
import "./editor.scss";

import HeadingLevelDropdown from "./heading-level-dropdown";

const options = [
    //
    { key: "small", name: "Small", style: { fontSize: "0.875em" } },
    { key: "lead", name: "Lead", style: { fontSize: "1.25rem", fontWeight: 300 } },
    //{ key: "lead", name: "Lead", style: { fontSize: "1.25rem" } },
    { key: "h6", name: "H6", style: { fontSize: "1rem", fontWeight: 500 } },
    //{ key: "h6", name: "H6", style: { fontSize: "1rem", fontWeight: "bold" } },
    { key: "h5", name: "H5", style: { fontSize: "1.25rem", fontWeight: 500 } },
    //{ key: "h5", name: "H5", style: { fontSize: "1.25rem", fontWeight: "bold" } },
    { key: "h4", name: "H4", style: { fontSize: "1.5rem", fontWeight: 500 } },
    //{ key: "h4", name: "H4", style: { fontSize: "1.5rem", fontWeight: "bold" } },
    { key: "h3", name: "H3", style: { fontSize: "1.75rem", fontWeight: 500 } },
    //{ key: "h3", name: "H3", style: { fontSize: "1.75rem", fontWeight: "bold" } },
    { key: "h2", name: "H2", style: { fontSize: "2rem", fontWeight: 500 } },
    //{ key: "h2", name: "H2", style: { fontSize: "2rem", fontWeight: "bold" } },
    { key: "h1", name: "H1", style: { fontSize: "2.5rem", fontWeight: 500 } },
    /*
    { key: "display-6", name: "D6", style: { fontSize: "2.5rem", fontWeight: 300 } },
    { key: "display-5", name: "D5", style: { fontSize: "3rem", fontWeight: 300 } },
    { key: "display-4", name: "D4", style: { fontSize: "3.5rem", fontWeight: 300 } },
    { key: "display-3", name: "D3", style: { fontSize: "4rem", fontWeight: 300 } },
    { key: "display-2", name: "D2", style: { fontSize: "4.5rem", fontWeight: 300 } },
    { key: "display-1", name: "D1", style: { fontSize: "5rem", fontWeight: 300 } }
    */
    //{ key: "h1", name: "H1", style: { fontSize: "2.25rem", fontWeight: 500 } },
    //{ key: "h1", name: "H1", style: { fontSize: "2.25rem", fontWeight: "bold" } },
    { key: "display-6", name: "D6", style: { fontSize: "2.25rem", fontWeight: 300 } },
    { key: "display-5", name: "D5", style: { fontSize: "2.5rem", fontWeight: 300 } },
    { key: "display-4", name: "D4", style: { fontSize: "2.75rem", fontWeight: 300 } },
    { key: "display-3", name: "D3", style: { fontSize: "3rem", fontWeight: 300 } },
    { key: "display-2", name: "D2", style: { fontSize: "3.25rem", fontWeight: 300 } },
    { key: "display-1", name: "D1", style: { fontSize: "3.5rem", fontWeight: 300 } }
    //{ key: "display-1", name: "D1", style: { fontSize: 56, fontWeight: 300 } }
];

registerBlockType("diym/text", {
    apiVersion: 2,
    title: __("Text", "diy-marketer"),
    description: __("Start with the building block of all narrative.", "diy-marketer"),
    category: "diy-marketer",
    icon: {
        foreground: "#007bff",
        src: typography
    },
    keywords: [
        __("heading", "diy-marketer"),
        __("subhead", "diy-marketer"),
        __("paragraph", "diy-marketer"),
        __("text", "diy-marketer")
    ],
    supports: {
        html: false,
        reusable: false,
        //className: false,
        color: {
            background: false
        },
        customClassName: false
    },
    attributes: {
        content: {
            type: "string",
            source: "html",
            selector: "h1,h2,h3,h4,h5,h6,p"
        },
        level: {
            type: "number",
            default: 0
        },
        textAlign: {
            type: "string"
        },
        fontSize: {
            type: "number"
        },
        spacingTop: {
            type: "number"
        },
        spacingBottom: {
            type: "number"
        },
        size: {
            type: "string"
        }
    },
    transforms: {
        from: [
            {
                type: "block",
                blocks: ["diym/subhead", "diym/heading"],
                transform: ({ content, textAlign }) => {
                    return createBlock("diym/text", { content, textAlign });
                }
            }
        ]
    },
    edit: ({ attributes, setAttributes, isSelected }) => {
        const { content, textAlign, spacingBottom, spacingTop, level, size } = attributes;

        const tagName = level ? "h" + level : "p";

        const spacingStyles = getEditorSpacing(
            { top: spacingTop, bottom: spacingBottom },
            isSelected
        );

        const blockProps = useBlockProps({
            style: {
                ...options.find(option => option.key === size)?.style,
                textAlign: textAlign,
                ...spacingStyles
            }
        });

        return (
            <>
                <InspectorControls>
                    <PanelBody title={__("Spacing", "diy-marketer")} initialOpen={false}>
                        <SpacingControl
                            values={{ top: spacingTop, bottom: spacingBottom }}
                            onChange={({ top, bottom }) => {
                                setAttributes({ spacingTop: top, spacingBottom: bottom });
                            }}
                        ></SpacingControl>
                    </PanelBody>
                    <PanelBody title={__("Typography", "diy-marketer")}>
                        <div style={{ display: "flex" }}>
                            <CustomSelectControl
                                label={__("font size", "diy-marketer")}
                                options={options}
                                value={size ? options.find(option => option.key === size) : []}
                                onChange={({ selectedItem }) => {
                                    setAttributes({ size: selectedItem.key });
                                }}
                            />
                            <Button
                                disabled={size === undefined}
                                isSmall
                                isSecondary
                                style={{ marginTop: "26px", marginLeft: "8px" }}
                                onClick={() => {
                                    setAttributes({ size: undefined });
                                }}
                            >
                                {__("Reset", "diy-marketer")}
                            </Button>
                        </div>
                    </PanelBody>
                </InspectorControls>
                <BlockControls>
                    <ToolbarGroup>
                        <HeadingLevelDropdown
                            selectedLevel={level}
                            onChange={level => setAttributes({ level })}
                        />
                    </ToolbarGroup>
                    <AlignmentToolbar
                        value={textAlign}
                        alignmentControls={TEXT_ALIGNMENT_CONTROLS}
                        onChange={textAlign => {
                            setAttributes({ textAlign });
                        }}
                    />
                </BlockControls>
                <RichText
                    tagName={tagName}
                    {...blockProps}
                    onChange={content => {
                        setAttributes({ content });
                    }}
                    value={content}
                    allowedFormats={[
                        "core/text-color",
                        "diym/underline",
                        "diym/icon",
                        "core/bold",
                        "core/italic",
                        "core/link",
                        "core/strikethrough",
                        "core/subscript",
                        "core/superscript"
                    ]}
                    placeholder={__("Start writing or type / to choose a block", "diy-marketer")}
                />
            </>
        );
    },
    save: ({ attributes }) => {
        const {
            content,
            textAlign,
            spacingTop,
            spacingBottom,
            textColor,
            level,
            size
        } = attributes;

        const TagName = level ? "h" + level : "p";

        let className =
            classnames(
                size,
                getFrontEndSpacing(
                    {
                        top: spacingTop,
                        bottom: spacingBottom
                    },
                    "m"
                ),
                {
                    [`text-${textColor}`]: textColor,
                    [`text-${textAlign}`]: textAlign
                }
            ) || undefined;

        return (
            <TagName {...useBlockProps.save()} className={className}>
                <RichText.Content value={content} />
            </TagName>
        );
    }
});
