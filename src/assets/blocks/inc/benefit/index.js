import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { RichText, BlockControls, AlignmentToolbar } from "@wordpress/block-editor";
import IconPicker from "../icon-picker";
import { withColors, InspectorControls, PanelColorSettings } from "@wordpress/block-editor";
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
    //parent: ["diym/benefits"],
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
            type: "string",
            default: "fas fa-check" // Added default value
        },
        iconColor: {
            type: "string"
        },
        textColor: {
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
        { iconColor: "color" },
        { textColor: "color" }
    )(props => {
        console.log(props);
        const {
            attributes,
            setAttributes,
            iconColor,
            textColor,
            setIconColor,
            setTextColor,
            className
        } = props;

        console.log(className);

        //edit: ({ attributes, setAttributes }) => {

        //console.log(props);

        const { icon, content, align } = attributes;

        const onChangeIcon = icon => {
            setAttributes({ icon });
        };

        const onChangeContent = content => {
            setAttributes({ content });
        };

        const onChangeAlign = align => {
            setAttributes({ align });
        };
        // classnames(icon, "fa-2x")
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
                                value: textColor.color,
                                onChange: setTextColor,
                                label: __("Text Color", "diy-marketer")
                            }
                        ]}
                    />
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
                    <i className={classnames(icon, "fa-lg")} style={{ color: iconColor.color }}></i>
                    <RichText
                        tagName="p"
                        className={`has-text-align-${align}`}
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
                            "list a feature, benefit or unique selling proposition",
                            "diy-marketer"
                        )}
                    />
                </div>
            </>
        );
    }),
    save: ({ attributes, iconColor }) => {
        const { content, icon, align } = attributes;

        const contentClass = classnames("mb-0", "flex-grow-1", align ? `text-${align}` : null);

        //const test = () '<div>' . content . '</div>';

        //const test = <div>{content}</div>;style={{ color: iconColor.color }

        return (
            <>
                <div className="d-flex pb-3">
                    <i className={classnames(icon, "align-self-center", "text-center")}></i>
                    <RichText.Content tagName="p" className={contentClass} value={content} />
                </div>
            </>
        );
    }
});
