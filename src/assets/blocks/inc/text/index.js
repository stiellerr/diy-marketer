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
import { TEXT_ALIGNMENT_CONTROLS, getSelectValueFromFontSize, SPACING_LEVELS } from "../helper";
import { getMarginClass, SpacingControl } from "../spacing-control";
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

/*
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
*/

const fontSizes = [
    {
        name: __("Small", "diy-marketer"),
        slug: "small",
        size: "0.875em"
    },
    {
        name: __("Lead", "diy-marketer"),
        slug: "lead",
        size: "1.25rem",
        style: { fontSize: "3.5rem", fontWeight: 300 },
        className: "zzz"
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
    edit: ({ attributes, setAttributes }) => {
        const { content, textAlign, fontSize, spacingBottom, spacingTop, level, size } = attributes;

        const tagName = level ? "h" + level : "p";

        //const value = ...options.find(option => option.key === size)
        //console;

        const blockProps = useBlockProps({
            style: {
                ...options.find(option => option.key === size)?.style,
                textAlign: textAlign,
                paddingTop: spacingTop !== undefined ? SPACING_LEVELS[spacingTop] : undefined,
                paddingBottom:
                    spacingBottom !== undefined ? SPACING_LEVELS[spacingBottom] : undefined
            }
        });

        //console.log(blockProps);

        return (
            <>
                <InspectorControls>
                    {/*
                    <PanelBody title={__("Typography zzz", "diy-marketer")}>
                        <FontSizePicker
                            fontSizes={fontSizes}
                            value={options}
                            disableCustomFontSizes={true}
                            onChange={fontSize => {
                                setAttributes({ fontSize });
                            }}
                        />
                    </PanelBody>
                    
                    <PanelBody title={__("Typography", "diy-marketer")}>
                        <FontSizePicker
                            fontSizes={fontSizes}
                            value={options}
                            disableCustomFontSizes={true}
                            onChange={fontSize => {
                                setAttributes({ fontSize });
                            }}
                        /> alignItems: "center"
                    </PanelBody>
                        */}
                    <PanelBody title={__("Typography", "diy-marketer")}>
                        <div style={{ display: "flex" }}>
                            <CustomSelectControl
                                label={__("font size", "diy-marketer")}
                                options={options}
                                value={size ? options.find(option => option.key === size) : []}
                                onChange={({ selectedItem }) => {
                                    console.log(selectedItem);
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
                            spacingTop={spacingTop}
                            spacingBottom={spacingBottom}
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
                getMarginClass(spacingTop, spacingBottom),
                //getSelectValueFromFontSize(fontSizes, fontSize),
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
