import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { RichText, useBlockProps, BlockControls, AlignmentToolbar } from "@wordpress/block-editor";

import classnames from "classnames";

import "./editor.scss";

registerBlockType("diym/test", {
    apiVersion: 2,
    title: __("test", "diy-marketer"),
    description: __("test block...", "diy-marketer"),
    supports: {
        html: false,
        reusable: false,
        multiple: false,
        className: true,
        //color: true
        // align
        supports: {
            align: true
            //align: ["left", "right"]
        },
        color: true,

        // color
        //color: {
        //background: false,
        //gradients: true,
        //text: true
        //},
        // cant get this to work
        spacing: {
            padding: true
        },
        //font size
        fontSize: true
        //padding: true
        //__experimentalFontSize: true,
        // Remove the Default Style picker.
        //defaultStylePicker: true
    },
    attributes: {
        fontSize: {
            type: "string"
            //default: 'some-value',
        },
        backgroundColor: {
            type: "string",
            default: "accent"
        },
        content: {
            type: "string",
            source: "html",
            selector: "a"
        }
        /*
        align: {
            type: "string"
        }
        */
    },
    category: "diy-marketer",
    icon: {
        foreground: "#007bff",
        src: "sos"
    },
    keywords: [__("test", "diymarketer")],
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
    edit: ({ attributes, setAttributes }) => {
        //const { content, align } = attributes;
        const { content } = attributes;

        const onChangeContent = content => {
            setAttributes({ content });
        };

        /*
        const onChangeAlign = align => {
            setAttributes({ align });
        };
        */

        const blockProps = useBlockProps();

        //console.log(className);

        return (
            <>
                {/*
                <div>
                    
                <BlockControls>
                    <AlignmentToolbar
                        value={align}
                        alignmentControls={DEFAULT_ALIGNMENT_CONTROLS}
                        onChange={onChangeAlign}
                    />
                </BlockControls>

                    <RichText
                        tagName="h1"
                        //className={classnames(className, `has-text-align-${align}`)}
                        className={className}
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
                        {...blockProps}
                    />
                </div>
                        */}
                {/* new button */}
                <div {...blockProps} style={{}}>
                    <RichText
                        aria-label={__("Button text")}
                        //placeholder={placeholder || __("Add text…")}
                        placeholder={__("Add text…")}
                        //value={text}
                        onChange={content => setAttributes({ content })}
                        withoutInteractiveFormatting
                        //className={classnames(className)}
                        //className={className}
                        //style={"justify" === align ? { width: "100%" } : undefined}
                        style={{ ...blockProps.style }}
                        identifier="text"
                    />
                </div>
            </>
        );
    },
    save: ({ attributes }) => {
        const { content, align, fontSize, backgroundColor } = attributes;

        const blockProps = useBlockProps.save();

        //const className = align ? `text-${align}` : false;
        const className = classnames(
            "btn",
            "btn-primary",
            backgroundColor ? `btn-${backgroundColor}` : false,
            fontSize ? fontSize : false
        );

        console.log(fontSize);

        return (
            <div>
                <a className={className} style={{ ...blockProps.style }}>
                    <RichText.Content value={content} />
                </a>
            </div>
        );
    }
});
