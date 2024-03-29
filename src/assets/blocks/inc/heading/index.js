import { createBlock, registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { RichText, BlockControls, AlignmentToolbar } from "@wordpress/block-editor";

import classnames from "classnames";

//import "./editor.scss";

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

registerBlockType("diym/heading", {
    title: __("Heading", "diy-marketer"),
    description: __(
        "Introduce the page with a main headline to help visitors (and search engines) understand what your page is about.",
        "diy-marketer"
    ),
    supports: {
        html: false,
        reusable: false,
        multiple: false,
        className: false,
        __experimentalColor: {
            linkColor: true
        }
        //__experimentalFontSize: true,
        // Remove the Default Style picker.
        //defaultStylePicker: true
    },
    attributes: {
        content: {
            type: "string",
            source: "html",
            selector: "h1"
        },
        align: {
            type: "string"
        }
    },
    category: "diy-marketer",
    icon: {
        foreground: "#007bff",
        src: "heading"
    },
    keywords: [__("heading", "diymarketer"), __("h1", "diymarketer")],
    /*
    transforms: {
        from: [
            {
                type: "block",
                blocks: ["diym/subhead", "diym/paragraph"],
                transform: ({ content, align }) => {
                    return createBlock("diym/heading", { content, align });
                }
            }
        ]
    },
    */
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
                    tagName="h1"
                    className={classnames(className, `has-text-align-${align}`)}
                    onChange={onChangeContent}
                    value={content}
                    //style={{ whiteSpace: "normal", backgroundColor: "blue" }}
                    //style={{ "background-color": "blue;" }}
                    preserveWhiteSpace={false}
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
                    placeholder={__("Write heading…", "diy-marketer")}
                />
            </>
        );
    },
    save: ({ attributes }) => {
        const { content, align } = attributes;

        const className = align ? `text-${align}` : false;

        return (
            <RichText.Content
                tagName="h1"
                value={content}
                className={className ? className : undefined}
                //style={("white-space": "pre-wrap;")}
                //style={{
                //"white-space": "initial"
                // backgroundColor: backgroundColor,
                //color: textColor
                //}}
            />
        );
    }
});
