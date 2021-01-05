import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { RichText, BlockControls, AlignmentToolbar } from "@wordpress/block-editor";
import {
    withColors,
    InspectorControls,
    PanelColorSettings,
    ContrastChecker
} from "@wordpress/block-editor";
import { PanelBody } from "@wordpress/components";

//import "./editor.scss";

import classnames from "classnames";

registerBlockType("diym/button", {
    title: __("Button", "diy-marketer"),
    description: __("Add a button to your web page", "diy-marketer"),
    category: "diy-marketer",
    icon: {
        foreground: "#007bff",
        src: "button"
    },
    keywords: [__("button", "diy-marketer")],
    supports: {
        html: false,
        reusable: false
        //
        //anchor: true,
        //className: false
        //__experimentalColor: {
        //    linkColor: true
        //},
        //__experimentalFontSize: true
        //__experimentalLineHeight: true,
        //__experimentalSelector: "p",
        //__unstablePasteTextInline: true
    },

    attributes: {
        buttonColor: {
            type: "string",
            default: "accent"
        },
        contentColor: {
            type: "string"
        },
        align: {
            type: "string"
        },
        content: {
            type: "string",
            source: "html",
            selector: "button"
        }
    },

    edit: withColors(
        "iconColor",
        "contentColor"
    )(props => {
        const {
            className,
            attributes,
            setAttributes,
            iconColor,
            contentColor,
            setIconColor,
            setContentColor
        } = props;

        const { icon, content, align } = attributes;

        const onChangeIcon = icon => {
            //console.log(icon);
            setAttributes({ icon });

            //console.log("dispatch");
            //}
        };

        const onChangeContent = content => {
            setAttributes({ content });
        };

        const onChangeAlign = align => {
            setAttributes({ align });
        };

        // set default icon value to be a check
        //if (undefined == attributes.icon) {
        //onChangeIcon("fas fa-check");
        //}

        return (
            <>
                <BlockControls>
                    <AlignmentToolbar value={align} onChange={onChangeAlign} />
                </BlockControls>
                <div className={className} style={{ textAlign: align }}>
                    <RichText
                        tagName="button"
                        //className={`has-text-align-${align}`}
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
                        style={{ color: contentColor.color }}
                        placeholder={__(
                            "List a feature, benefit or unique selling proposition",
                            "diy-marketer"
                        )}
                    />
                </div>
            </>
        );
    }),
    // save
    save: props => {
        const { attributes } = props;

        const { content } = attributes;

        return (
            <>
                <RichText.Content
                    tagName="button"
                    className={"btn btn-primary"}
                    value={content}
                    href="/"
                />
            </>
        );
    }
});
