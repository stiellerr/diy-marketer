import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { RichText, useBlockProps, BlockControls, AlignmentToolbar } from "@wordpress/block-editor";

import classnames from "classnames";

//import "./editor.scss";

registerBlockType("diym/test", {
    title: __("test", "diy-marketer"),
    description: __("test block...", "diy-marketer"),
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
        /*
        content: {
            type: "string",
            source: "html",
            selector: "h1"
        },
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
    edit: ({ className, attributes, setAttributes }) => {
        const { content, align } = attributes;

        const onChangeContent = content => {
            setAttributes({ content });
        };

        const onChangeAlign = align => {
            setAttributes({ align });
        };

        const blockProps = useBlockProps();

        console.log(blockProps);

        return (
            <>
                <div {...blockProps} className="zzz">
                    {/*
                <BlockControls>
                    <AlignmentToolbar
                        value={align}
                        alignmentControls={DEFAULT_ALIGNMENT_CONTROLS}
                        onChange={onChangeAlign}
                    />
                </BlockControls>
        */}
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
                </div>
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
