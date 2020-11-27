import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { RichText } from "@wordpress/block-editor";
import IconPicker from "../icon-picker";
import { withColors, InspectorControls, PanelColorSettings } from "@wordpress/block-editor";
import { PanelBody } from "@wordpress/components";

import classnames from "classnames";

registerBlockType("diym/benefit", {
    title: __("Benefit", "diy-marketer"),
    description: __("a single benefits for choosing you, and your services.", "diy-marketer"),
    category: "diy-marketer",
    parent: ["diym/benefits"],
    icon: {
        foreground: "#007bff",
        src: "saved"
    },
    keywords: [__("benefits", "diy-marketer")],
    supports: {
        html: false,
        reusable: false,
        //
        //anchor: true,
        className: false,
        //__experimentalColor: {
        //    linkColor: true
        //},
        __experimentalFontSize: true
        //__experimentalLineHeight: true,
        //__experimentalSelector: "p",
        //__unstablePasteTextInline: true
    },

    attributes: {
        icon: {
            type: "string",
            default: "fas fa-check" // Added default value
        },
        iconColor: {
            type: "string"
        },
        textColor: {
            type: "string"
        },
        content: {
            type: "string",
            source: "html",
            selector: "p"
        }
    },

    edit: withColors(
        "iconColor",
        "textColor"
    )(({ attributes, setAttributes, iconColor, textColor }) => {
        //edit: ({ attributes, setAttributes }) => {

        console.log(iconColor);

        const { icon, content } = attributes;

        const onChangeIcon = icon => {
            setAttributes({ icon });
        };

        const onChangeContent = content => {
            setAttributes({ content });
        };

        const onChangeIconColor = iconColor => {
            setAttributes({ iconColor });
        };

        const onChangeTextColor = textColor => {
            setAttributes({ textColor });
        };

        return (
            <>
                <InspectorControls>
                    <PanelColorSettings
                        title={__("Color settings", "diy-marketer")}
                        colorSettings={[
                            {
                                value: iconColor,
                                onChange: onChangeIconColor,
                                label: __("Icon Color", "diy-marketer")
                            },
                            {
                                value: textColor,
                                onChange: onChangeTextColor,
                                label: __("Text Color", "diy-marketer")
                            }
                        ]}
                    />
                    <PanelBody title={__("Icon Picker", "diy-marketer")}>
                        <IconPicker onChange={onChangeIcon} value={icon}></IconPicker>
                    </PanelBody>
                </InspectorControls>
                <li>
                    <i className={classnames(icon, "fa-2x")}></i>
                    <RichText
                        tagName="p"
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
                        placeholder={__(
                            "Start writing or type / to choose a block",
                            "diy-marketer"
                        )}
                    />
                </li>
            </>
        );
    }),
    save: ({ attributes }) => {
        const { heading, content } = attributes;

        //const test = () '<div>' . content . '</div>';

        //const test = <div>{content}</div>;

        return (
            <>
                <RichText.Content tagName="h4" value={heading} />
                <RichText.Content tagName="p" value={content} />
            </>
        );
    }
});
