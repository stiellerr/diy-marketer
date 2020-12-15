import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { RichText, BlockControls, AlignmentToolbar } from "@wordpress/block-editor";
import IconPicker from "../icon-picker";
import {
    withColors,
    InspectorControls,
    PanelColorSettings,
    ContrastChecker
} from "@wordpress/block-editor";
import { PanelBody } from "@wordpress/components";

import "./editor.scss";

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

registerBlockType("diym/benefit", {
    title: __("Benefit", "diy-marketer"),
    description: __(
        "list a feature, benefit or unique selling point which puts you ahead of your competitors",
        "diy-marketer"
    ),
    category: "diy-marketer",
    icon: {
        foreground: "#007bff",
        src: "saved"
    },
    keywords: [__("benefit", "diy-marketer")],
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
        icon: {
            type: "object",
            default: {
                name: "fas fa-check",
                unicode: "f00c"
            }
        },

        //icon: {
        //type: "string",
        //default: "fas fa-check" //Added default value
        //source: "meta",
        //meta: "_diym_fa"
        //},
        iconColor: {
            type: "string",
            default: "accent"
        },
        contentColor: {
            type: "string"
        },
        customIconColor: {
            type: "string"
        },
        customContentColor: {
            type: "string"
        },
        align: {
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
                <InspectorControls>
                    <PanelColorSettings
                        title={__("Color settings", "diy-marketer")}
                        colorSettings={[
                            {
                                value: iconColor.color,
                                onChange: setIconColor,
                                label: __("Icon Color", "diy-marketer")
                            },
                            {
                                value: contentColor.color,
                                onChange: setContentColor,
                                label: __("Content Color", "diy-marketer")
                            }
                        ]}
                    >
                        <ContrastChecker textColor={iconColor.color} backgroundColor="#FFF" />
                        <ContrastChecker textColor={contentColor.color} backgroundColor="#FFF" />
                    </PanelColorSettings>
                    <PanelBody title={__("Icon Picker", "diy-marketer")}>
                        <IconPicker onChange={onChangeIcon} value={icon}></IconPicker>
                    </PanelBody>
                </InspectorControls>
                <BlockControls>
                    <AlignmentToolbar
                        value={align}
                        alignmentControls={DEFAULT_ALIGNMENT_CONTROLS}
                        onChange={onChangeAlign}
                    />
                </BlockControls>
                <div className={className}>
                    <i
                        className={classnames(icon.name, "fa-lg")}
                        style={{ color: iconColor.color }}
                    ></i>
                    <RichText
                        tagName="p"
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
                        style={{ textAlign: align, color: contentColor.color }}
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

        const {
            content,
            icon,
            align,
            contentColor,
            customContentColor,
            iconColor,
            customIconColor
        } = attributes;

        const iconClass = classnames(
            icon.name,
            "mw-1",
            "fa-lg",
            "align-self-center",
            "text-center",
            iconColor ? `text-bd-${iconColor}` : undefined
        );

        const contentClass = classnames(
            "mb-0",
            "flex-grow-1",
            align ? `text-${align}` : undefined,
            contentColor ? `text-bd-${contentColor}` : undefined
        );

        return (
            <>
                <div className="d-flex pb-3">
                    <i
                        className={classnames(iconClass)}
                        style={{ color: iconColor ? undefined : customIconColor }}
                    ></i>
                    <RichText.Content
                        tagName="p"
                        className={contentClass}
                        value={content}
                        style={{ color: contentColor ? undefined : customContentColor }}
                    />
                </div>
            </>
        );
    }
});
