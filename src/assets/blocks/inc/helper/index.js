/**
 * WordPress dependencies
 */
import { __ } from "@wordpress/i18n";
import { positionLeft, positionRight, positionCenter, stretchWide } from "@wordpress/icons";

export const SPACING_LEVELS = ["0rem", "0.25rem", "0.5rem", "1rem", "1.5rem", "3rem"];

export const TEXT_ALIGNMENT_CONTROLS = [
    {
        icon: "editor-alignleft",
        title: __("Align text left", "diy-marketer"),
        align: "left"
    },
    {
        icon: "editor-aligncenter",
        title: __("Align text center", "diy-marketer"),
        align: "center"
    },
    {
        icon: "editor-alignright",
        title: __("Align text right", "diy-marketer"),
        align: "right"
    },
    {
        icon: "editor-justify",
        title: __("Align text justify", "diy-marketer"),
        align: "justify"
    }
];

export const BLOCK_ALIGNMENT_CONTROLS = [
    {
        icon: positionLeft,
        title: __("Align button left", "diy-marketer"),
        align: "left"
    },
    {
        icon: positionCenter,
        title: __("Align button center", "diy-marketer"),
        align: "center"
    },
    {
        icon: positionRight,
        title: __("Align button right", "diy-marketer"),
        align: "right"
    },
    {
        icon: stretchWide,
        title: __("Align button full", "diy-marketer"),
        align: "full"
    }
];

export const BUTTON_SIZES = [
    {
        name: __("Small", "diy-marketer"),
        slug: "btn-sm",
        size: 14
    },
    {
        name: __("Large", "diy-marketer"),
        slug: "btn-lg",
        size: 20
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
