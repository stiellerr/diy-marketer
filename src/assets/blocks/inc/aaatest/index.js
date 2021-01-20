import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import {
    RichText,
    useBlockProps,
    InspectorControls,
    PanelBody,
    BlockControls,
    AlignmentToolbar
} from "@wordpress/block-editor";

import { CustomSelectControl } from "@wordpress/components";

import classnames from "classnames";

//import positionLeft from "@wordpress/icons";

import "./editor.scss";

registerBlockType("diym/test", {
    //apiVersion: 2,
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
        },
        align: {
            type: "string"
        }
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

        return (
            <>
                <InspectorControls>
                    <PanelBody title={__("Size Controls", "diy-marketer")}></PanelBody>
                </InspectorControls>
                <RichText
                    tagName="h1"
                    //className={classnames(className, `has-text-align-${align}`)}
                    //className={className}
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
        const { content } = attributes;

        return (
            <div>
                <RichText.Content tagName="a" value={content} />
            </div>
        );
    }
});
