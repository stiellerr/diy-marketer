/**
 * WordPress dependencies
 */
//const { __ } = wp.i18n;
import { __ } from "@wordpress/i18n"; //} = wp.blocks;
import { toggleFormat } from "@wordpress/rich-text";
import { RichTextToolbarButton, RichTextShortcut } from "@wordpress/block-editor";
import { select } from "@wordpress/data";
//const { Fragment } = wp.element;
//const { toggleFormat } = wp.richText;
//const { RichTextToolbarButton, RichTextShortcut } = wp.blockEditor;
//const { select } = wp.data;

/**
 * Block constants
 */
const name = "diym/underline";

export const underline = {
    name,
    title: __("Underline", "diy-marketer"),
    tagName: "span",
    className: "ek-underline",
    attributes: {
        style: "style"
    },
    edit({ isActive, value, onChange }) {
        /*
        const isDisabled = select("core/edit-post").isFeatureActive(
            "disableEditorsKitUnderlineFormats"
        );
        */
        const formatTypes = select("core/rich-text").getFormatTypes();
        const checkFormats = formatTypes.filter(formats => formats.name === "wpcom/underline");

        const onToggle = () => {
            onChange(
                toggleFormat(value, {
                    type: name,
                    attributes: {
                        style: "text-decoration: underline;"
                    }
                })
            );
        };

        return (
            <>
                <RichTextShortcut type="primary" character="u" onUse={onToggle} />
                {checkFormats.length === 0 && (
                    <RichTextToolbarButton
                        icon="editor-underline"
                        title={__("Underline", "diy-marketer")}
                        onClick={onToggle}
                        isActive={isActive}
                        shortcutType="primary"
                        shortcutCharacter="u"
                    />
                )}
            </>
        );
    }
};
