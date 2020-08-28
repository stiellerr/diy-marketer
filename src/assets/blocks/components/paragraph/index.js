//const { registerBlockType } = wp.blocks;

import { registerBlockType } from "@wordpress/blocks"; //} = wp.blocks;
import { __ } from "@wordpress/i18n"; //} = wp.blocks;
import { RichText, BlockControls, AlignmentToolbar } from "@wordpress/block-editor";
import { Toolbar } from "@wordpress/components";

//const { __ } = wp.i18n;

import "./styles.editor.scss";

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

registerBlockType("diy-marketer/paragraph", {
    title: __("Paragraph", "diy-marketer"),
    description: __("Start with the building block of all narrative.", "diy-marketer"),
    category: "media",
    icon: {
        foreground: "#007bff",
        src: "editor-paragraph"
    },
    keywords: [__("paragraph", "diymarketer"), __("text", "diymarketer")],
    supports: {
        //align: true,
        html: false,
        reusable: false
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
    edit: ({ className, attributes, setAttributes }) => {
        //console.log(attributes);

        console.log(className);

        const { content, align } = attributes;

        const onChangeContent = content => {
            setAttributes({ content });
        };

        const onChangeAlign = align => {
            setAttributes({ align });
        };

        return (
            <>
                <BlockControls
                    controls={[
                        [
                            {
                                icon: "wordpress",
                                title: __("test", "diy-marketer"),
                                onClick: () => alert(true),
                                isActive: true
                            },
                            {
                                icon: "wordpress",
                                title: __("test", "diy-marketer"),
                                onClick: () => alert(true),
                                isActive: false
                            }
                        ],
                        [
                            {
                                icon: "wordpress",
                                title: __("test", "diy-marketer"),
                                onClick: () => alert(true),
                                isActive: false
                            }
                        ]
                    ]}
                >
                    <Toolbar
                        isCollapsed
                        controls={[
                            [
                                {
                                    icon: "wordpress",
                                    title: __("test", "diy-marketer"),
                                    onClick: () => alert(true),
                                    isActive: true
                                },
                                {
                                    icon: "wordpress",
                                    title: __("test", "diy-marketer"),
                                    onClick: () => alert(true),
                                    isActive: false
                                }
                            ],
                            [
                                {
                                    icon: "wordpress",
                                    title: __("test", "diy-marketer"),
                                    onClick: () => alert(true),
                                    isActive: false
                                }
                            ]
                        ]}
                    />
                </BlockControls>
                <BlockControls>
                    <AlignmentToolbar
                        value={align}
                        alignmentControls={DEFAULT_ALIGNMENT_CONTROLS}
                        onChange={onChangeAlign}
                    />
                </BlockControls>

                <RichText
                    tagName="p"
                    //className={className}
                    className={classnames(className, `has-text-align-${align}`)}
                    onChange={onChangeContent}
                    value={content}
                    allowedFormats={[
                        "core/bold",
                        "core/code",
                        "core/image",
                        "core/italic",
                        "core/link",
                        "core/strikethrough",
                        "wpcom/underline",
                        "core/text-color",
                        "core/subscript",
                        "core/superscript"
                    ]}
                    //style={{ textAlign: align }}
                />
            </>
        );

        //return <p className={className}>Editor</p>;
    },
    save: ({ attributes }) => {
        const { content, align } = attributes;

        const className = align ? `text-${align}` : false;

        return (
            <RichText.Content
                tagName="p"
                value={content}
                className={className ? className : undefined}
            />
        );
    }
});
