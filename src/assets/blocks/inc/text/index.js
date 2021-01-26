import { createBlock, registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import {
    RichText,
    BlockControls,
    AlignmentToolbar,
    InspectorControls,
    useBlockProps
} from "@wordpress/block-editor";
import {
    FontSizePicker,
    Button,
    PanelBody,
    ToolbarGroup,
    CustomSelectControl
} from "@wordpress/components";

import classnames from "classnames";
import { TEXT_ALIGNMENT_CONTROLS, getSelectValueFromFontSize, MARGINS } from "../helper";
import { getMarginClass, SpacingControl } from "../spacing-control";
import "./editor.scss";

import HeadingLevelDropdown from "./heading-level-dropdown";

const options = [
    { key: "small", name: "Small", style: { fontSize: "87.5%" } },
    { key: "lead", name: "Lead", style: { fontSize: "125%" } },
    { key: "h1", name: "H6", style: { fontSize: "125%" } },
    { key: "h2", name: "H5", style: { fontSize: "125%" } },
    { key: "h3", name: "H4", style: { fontSize: "125%", fontWeight: "bold" } }
];

const fontSizes = [
    {
        name: __("Small", "diy-marketer"),
        slug: "small",
        size: 14
    },
    {
        name: __("Lead", "diy-marketer"),
        slug: "lead",
        size: 18
    },
    {
        name: __("h6", "diy-marketer"),
        slug: "h6",
        size: 16
    },
    {
        name: __("h5", "diy-marketer"),
        slug: "h5",
        size: 20
    },
    {
        name: __("h4", "diy-marketer"),
        slug: "h4",
        size: 24
    },
    {
        name: __("h3", "diy-marketer"),
        slug: "h3",
        size: 28
    },
    {
        name: __("h2", "diy-marketer"),
        slug: "h2",
        size: 32
    },
    {
        name: __("h1", "diy-marketer"),
        slug: "h1",
        size: 40
    },
    {
        name: __("d4", "diy-marketer"),
        slug: "display-4",
        size: 56
    }
];

registerBlockType("diym/text", {
    apiVersion: 2,
    title: __("Text", "diy-marketer"),
    description: __("Start with the building block of all narrative.", "diy-marketer"),
    category: "diy-marketer",
    icon: {
        foreground: "#007bff",
        //src: "editor-paragraph"
        src: "text-page"
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
        className: false,
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
        marginTop: {
            type: "number"
        },
        marginBottom: {
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
    edit: ({ attributes, setAttributes }) => {
        const { content, textAlign, fontSize, marginBottom, marginTop, level, size } = attributes;

        const tagName = level ? "h" + level : "p";

        const blockProps = useBlockProps({
            style: {
                textAlign: textAlign,
                fontSize: fontSize || null,
                paddingTop: MARGINS[marginTop],
                paddingBottom: MARGINS[marginBottom]
            }
        });

        return (
            <>
                <InspectorControls>
                    {/*
                    <PanelBody title={__("Typography", "diy-marketer")}>
                        <FontSizePicker
                            fontSizes={fontSizes}
                            value={options}
                            disableCustomFontSizes={true}
                            onChange={fontSize => {
                                setAttributes({ fontSize });
                            }}
                        />
                    </PanelBody>
                        */}
                    <PanelBody title={__("Typography", "diy-marketer")}>
                        <div style={{ display: "flex", alignItems: "center" }}>
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
                    <PanelBody title={__("Spacing", "diy-marketer")} initialOpen={false}>
                        <SpacingControl
                            onChange={value => {
                                setAttributes(value);
                            }}
                            marginTop={marginTop}
                            marginBottom={marginBottom}
                        ></SpacingControl>
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
            fontSize,
            marginTop,
            marginBottom,
            textColor,
            level
        } = attributes;

        const TagName = level ? "h" + level : "p";

        let className = classnames(
            getMarginClass(marginTop, marginBottom),
            getSelectValueFromFontSize(fontSizes, fontSize),
            {
                [`text-${textColor}`]: textColor,
                [`text-${textAlign}`]: textAlign
            }
        );

        return (
            <TagName {...useBlockProps.save()} className={className}>
                <RichText.Content value={content} />
            </TagName>
        );
    }
});
