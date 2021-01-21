import { createBlock, registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import {
    RichText,
    BlockControls,
    AlignmentToolbar,
    InspectorControls,
    useBlockProps
} from "@wordpress/block-editor";
import { FontSizePicker, PanelBody } from "@wordpress/components";

//import "./editor.scss";

import classnames from "classnames";

import { TEXT_ALIGNMENT_CONTROLS, getSelectValueFromFontSize } from "../helper";
import { getMarginClass, SpacingControl } from "../spacing-control";

const fontSizes = [
    {
        name: __("Small", "diy-marketer"),
        slug: "small",
        size: 14
    },
    {
        name: __("Lead", "diy-marketer"),
        slug: "lead",
        size: 20
    }
];

registerBlockType("diym/paragraph", {
    //apiVersion: 2,
    title: __("Paragraph", "diy-marketer"),
    description: __("Start with the building block of all narrative.", "diy-marketer"),
    category: "diy-marketer",
    icon: {
        foreground: "#007bff",
        src: "editor-paragraph"
    },
    keywords: [__("paragraph", "diymarketer"), __("text", "diymarketer")],
    supports: {
        html: false,
        reusable: false,
        //
        //anchor: true,
        className: false,
        __experimentalColor: {
            linkColor: true
        }
        //__experimentalFontSize: true
        //fontSize: true
        //__experimentalLineHeight: true,
        //__experimentalSelector: "p",
        //__unstablePasteTextInline: true
    },
    attributes: {
        content: {
            type: "string",
            source: "html",
            selector: "p"
        },
        align: {
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
        }
    },
    transforms: {
        from: [
            {
                type: "block",
                blocks: ["diym/subhead", "diym/heading"],
                transform: ({ content, align }) => {
                    return createBlock("diym/paragraph", { content, align });
                }
            }
        ]
    },
    edit: ({ attributes, setAttributes }) => {
        const { content, align, fontSize, marginBottom, marginTop } = attributes;

        const onChangeContent = content => {
            setAttributes({ content });
        };

        const onChangeAlign = align => {
            setAttributes({ align });
        };

        const padding = ["0rem", "0.25rem", "0.5rem", "1rem", "1.5rem", "3rem"];

        return (
            <>
                <InspectorControls>
                    <PanelBody title={__("Typography", "diy-marketer")}>
                        <FontSizePicker
                            fontSizes={fontSizes}
                            value={fontSize}
                            disableCustomFontSizes={true}
                            onChange={fontSize => {
                                setAttributes({ fontSize });
                            }}
                        />
                    </PanelBody>
                    <PanelBody title={__("Spacing", "diy-marketer")}>
                        <SpacingControl
                            onChange={value => {
                                console.log(value);
                                setAttributes(value);
                            }}
                            marginTop={marginTop}
                            marginBottom={marginBottom}
                        ></SpacingControl>
                    </PanelBody>
                </InspectorControls>
                <BlockControls>
                    <AlignmentToolbar
                        value={align}
                        alignmentControls={TEXT_ALIGNMENT_CONTROLS}
                        onChange={onChangeAlign}
                    />
                </BlockControls>
                <RichText
                    tagName="p"
                    style={{
                        textAlign: align,
                        fontSize: fontSize || null,
                        paddingTop: padding[marginTop],
                        paddingBottom: padding[marginBottom]
                    }}
                    onChange={onChangeContent}
                    value={content}
                    allowedFormats={[
                        "core/text-color",
                        "diym/underline",
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
    save: ({ attributes, className }) => {
        const { content, align, fontSize, marginTop, marginBottom } = attributes;

        //const size = fontSizes.find(element => {
        //return element.size === fontSize;
        //});

        const size = getSelectValueFromFontSize(fontSizes, fontSize);

        console.log(size);

        className = classnames(getMarginClass(marginTop, marginBottom), {
            //size ? size.slug : null, {
            [`text-${align}`]: align,
            [size]: size
        });

        return (
            <RichText.Content
                tagName="p"
                value={content}
                className={className ? className : null}
            />
        );
    }
});
