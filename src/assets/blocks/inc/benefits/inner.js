import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { RichText, BlockControls, AlignmentToolbar } from "@wordpress/block-editor";
import IconPicker from "../icon-picker";
import { withColors, InspectorControls, PanelColorSettings } from "@wordpress/block-editor";
import { PanelBody } from "@wordpress/components";

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
        className: false
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
            setTextColor
        } = props;

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
                <li>
                    <i className={classnames(icon, "fa-2x")} style={{ color: iconColor.color }}></i>
                    <BlockControls>
                        <AlignmentToolbar
                            value={align}
                            alignmentControls={DEFAULT_ALIGNMENT_CONTROLS}
                            onChange={onChangeAlign}
                        />
                    </BlockControls>
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
