/**
 * WordPress dependencies
 */
import { __ } from "@wordpress/i18n";

export const TEXT_ALIGNMENT_CONTROLS = [
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

export function getSelectValueFromFontSize(fontSizes, value) {
    if (value) {
        const fontSizeValue = fontSizes.find(font => font.size === value);
        if (fontSizeValue) {
            return fontSizeValue.slug;
        }
    }
    return null;
}
