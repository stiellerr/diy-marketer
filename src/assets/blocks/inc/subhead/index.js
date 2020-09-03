/**
 * External dependencies
 */

/**
 * WordPress dependencies
 */
import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import {
    RichText,
    BlockControls,
    AlignmentToolbar,
    __experimentalBlock as Block
} from "@wordpress/block-editor";
import { Icon, heading } from "@wordpress/icons";
import { ToolbarGroup } from "@wordpress/components";

/**
 * Internal dependencies
 */
import HeadingLevelDropdown from "./heading-level-dropdown.native.js";
//import "./editor.scss";

//console.log(heading);

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

registerBlockType("diy-marketer/subhead", {
    title: __("Subhead", "diy-marketer"),
    description: __(
        "Introduce the page with a main headline to help visitors (and search engines) understand what your page is about.",
        "diy-marketer"
    ),
    supports: {
        html: false,
        reusable: false
    },
    attributes: {
        content: {
            type: "string",
            source: "html",
            selector: "h2,h3,h4,h5,h6",
            default: ""
        },
        align: {
            type: "string"
        },
        level: {
            type: "number",
            default: 2
        }
    },
    category: "media",
    icon: {
        foreground: "#007bff",
        //src: heading
        //src: icon
        src: () => {
            return <Icon icon={heading} />;
        }
    },
    keywords: [__("subhead", "diy-marketer")],
    edit: ({ className, attributes, setAttributes }) => {
        const { content, align, level } = attributes;
        const tagName = "h" + level;

        const onChangeContent = content => {
            setAttributes({ content });
        };

        const onChangeAlign = align => {
            setAttributes({ align });
        };

        return (
            <>
                <BlockControls>
                    <ToolbarGroup>
                        <HeadingLevelDropdown
                            selectedLevel={level}
                            onChange={newLevel => setAttributes({ level: newLevel })}
                        />
                    </ToolbarGroup>
                    <AlignmentToolbar
                        value={align}
                        alignmentControls={DEFAULT_ALIGNMENT_CONTROLS}
                        onChange={onChangeAlign}
                    />
                </BlockControls>
                <RichText
                    tagName={Block[tagName]}
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
                    placeholder={__("Write subhead…", "diy-marketer")}
                />
            </>
        );
    },
    save: ({ attributes }) => {
        const { content, align, level } = attributes;
        const tagName = "h" + level;

        const className = align ? `text-${align}` : false;

        return (
            <RichText.Content
                tagName={tagName}
                value={content}
                className={className ? className : undefined}
            />
        );
    }
});
