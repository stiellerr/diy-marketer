import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { RichText } from "@wordpress/block-editor";

registerBlockType("diym/benefits", {
    title: __("Benefits", "diy-marketer"),
    description: __("list of benefits for choosing you, and your services.", "diy-marketer"),
    category: "diy-marketer",
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
        __experimentalColor: {
            linkColor: true
        },
        __experimentalFontSize: true
        //__experimentalLineHeight: true,
        //__experimentalSelector: "p",
        //__unstablePasteTextInline: true
    },

    attributes: {
        heading: {
            type: "string",
            source: "html",
            selector: "h4"
        },
        content: {
            type: "string",
            source: "html",
            selector: "p"
        }
    },

    edit: ({ attributes, setAttributes }) => {
        const { heading, content } = attributes;

        const onChangeHeading = heading => {
            setAttributes({ heading });
        };

        const onChangeContent = content => {
            setAttributes({ content });
        };

        return (
            <>
                <RichText
                    tagName="h4"
                    onChange={onChangeHeading}
                    value={heading}
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
                        "core/superscript",
                        "core/image"
                    ]}
                    placeholder={__("Start writing or type / to choose a block", "diy-marketer")}
                />
            </>
        );
    },
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
