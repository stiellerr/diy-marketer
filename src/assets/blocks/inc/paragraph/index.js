import { createBlock, registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { RichText, BlockControls, AlignmentToolbar } from "@wordpress/block-editor";
import { ToolbarGroup, ToolbarButton, Popover } from "@wordpress/components";
import { create, insert, toHTMLString } from "@wordpress/rich-text";
import { select, dispatch } from "@wordpress/data";

//import "./editor.scss";

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

import { withState } from "@wordpress/compose";

import IconPicker2 from "../icon-picker2";

const MyPopover = withState({
    isVisible: false
})(({ isVisible, setState }) => {
    const toggleVisible = () => {
        setState(state => ({ isVisible: !state.isVisible }));
    };
    return (
        <>
            <ToolbarGroup>
                <ToolbarButton icon={"wordpress"} onClick={toggleVisible}></ToolbarButton>
            </ToolbarGroup>
            {isVisible && (
                <Popover>
                    <IconPicker2
                        onSelect={icon => {
                            //
                            let blockEditor = select("core/block-editor");
                            let content = blockEditor.getSelectedBlock().attributes.content;

                            let richTextValue = create({ html: content ? content : "" });

                            richTextValue["start"] = blockEditor.getSelectionStart().offset;
                            richTextValue["end"] = blockEditor.getSelectionEnd().offset;
                            //console.log(richTextValue);
                            /*
                                richTextValue.push({
                                    start: blockEditor.getSelectionStart().offset,
                                    end: blockEditor.getSelectionEnd().offset
                                });
                                */
                            //console.log(richTextValue);
                            let updated = insert(richTextValue, create({ html: icon }));
                            console.log(updated);
                            let newHTML = toHTMLString({ value: updated });
                            console.log(newHTML);

                            dispatch("core/block-editor").updateBlock(
                                blockEditor.getSelectedBlock().clientId,
                                {
                                    attributes: {
                                        content: newHTML
                                    }
                                }
                            );
                        }}
                    />
                </Popover>
            )}
        </>
    );
});

registerBlockType("diym/paragraph", {
    title: __("Paragraph", "diy-marketer"),
    description: __("Start with the building block of all narrative.", "diy-marketer"),
    category: "diy-marketer",
    icon: {
        foreground: "#007bff",
        src: "editor-paragraph"
    },
    keywords: [__("paragraph", "diymarketer"), __("text", "diymarketer")],
    supports: {
        html: false,
        reusable: false,
        //
        //anchor: true,
        className: false,
        __experimentalColor: {
            linkColor: true
        },
        __experimentalFontSize: true
        //__experimentalLineHeight: true,
        //__experimentalSelector: "p",
        //__unstablePasteTextInline: true
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
    transforms: {
        from: [
            {
                type: "block",
                blocks: ["diym/subhead", "diym/heading"],
                transform: ({ content, align }) => {
                    return createBlock("diym/paragraph", { content, align });
                }
            }
        ]
    },
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
                    <MyPopover />
                </BlockControls>
                <RichText
                    tagName="p"
                    className={classnames(className, `has-text-align-${align}`)}
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
                    placeholder={__("Start writing or type / to choose a block", "diy-marketer")}
                />
            </>
        );
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
