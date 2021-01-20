import { createBlock, registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { RichText, BlockControls, AlignmentToolbar } from "@wordpress/block-editor";

//import "./editor.scss";

import classnames from "classnames";

const DEFAULT_ALIGNMENT_CONTROLS = [
    {
        icon: "editor-alignleft",
        title: __("Align text left"),
        align: "left"
    },
    {
        icon: "editor-aligncenter",
        title: __("Align text center"),
        align: "center"
    },
    {
        icon: "editor-alignright",
        title: __("Align text right"),
        align: "right"
    },
    {
        icon: "editor-justify",
        title: __("Align text justify"),
        align: "justify"
    }
];

registerBlockType("diym/paragraph", {
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
        },
        //__experimentalFontSize: true
        fontSize: true
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
    edit: ({ className, attributes, setAttributes }) => {
        const { content, align } = attributes;

        const onChangeContent = content => {
            setAttributes({ content });
        };

        const onChangeAlign = align => {
            setAttributes({ align });
        };

        return (
            <>
                <BlockControls>
                    <AlignmentToolbar
                        value={align}
                        alignmentControls={DEFAULT_ALIGNMENT_CONTROLS}
                        onChange={onChangeAlign}
                    />
                </BlockControls>
                <RichText
                    tagName="p"
                    className={classnames(className, `has-text-align-${align}`)}
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
        const { content, align } = attributes;

        console.log(className);

        className = align ? `text-${align}` : false;

        return (
            <RichText.Content
                tagName="p"
                value={content}
                className={className ? className : undefined}
            />
        );
    }
});
