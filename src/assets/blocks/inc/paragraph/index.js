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

import classnames from "classnames";
import { TEXT_ALIGNMENT_CONTROLS, getSelectValueFromFontSize, MARGINS } from "../helper";
import { getMarginClass, SpacingControl } from "../spacing-control";
import "./editor.scss";

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
    apiVersion: 2,
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
            selector: "p"
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
        }
    },
    transforms: {
        from: [
            {
                type: "block",
                blocks: ["diym/subhead", "diym/heading"],
                transform: ({ content, textAlign }) => {
                    return createBlock("diym/paragraph", { content, textAlign });
                }
            }
        ]
    },
    edit: ({ attributes, setAttributes }) => {
        const { content, textAlign, fontSize, marginBottom, marginTop } = attributes;

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
                    <AlignmentToolbar
                        value={textAlign}
                        alignmentControls={TEXT_ALIGNMENT_CONTROLS}
                        onChange={textAlign => {
                            setAttributes({ textAlign });
                        }}
                    />
                </BlockControls>
                <RichText
                    tagName="p"
                    {...blockProps}
                    onChange={content => {
                        setAttributes({ content });
                    }}
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
    save: ({ attributes }) => {
        const { content, textAlign, fontSize, marginTop, marginBottom, textColor } = attributes;

        let className = classnames(
            getMarginClass(marginTop, marginBottom),
            getSelectValueFromFontSize(fontSizes, fontSize),
            {
                [`text-${textColor}`]: textColor,
                [`text-${textAlign}`]: textAlign
            }
        );

        return (
            <p {...useBlockProps.save()} className={className}>
                <RichText.Content value={content} />
            </p>
        );
    }
});
