//const { registerBlockType } = wp.blocks;

import { registerBlockType } from "@wordpress/blocks"; //} = wp.blocks;
import { __ } from "@wordpress/i18n"; //} = wp.blocks;

//const { __ } = wp.i18n;

import "./styles.editor.scss";

registerBlockType("diy-marketer/paragraph", {
    title: __("Paragraph", "diy-marketer"),
    description: __("Start with the building block of all narrative.", "diy-marketer"),
    category: "media",
    icon: {
        foreground: "#007bff",
        src: "editor-paragraph"
    },
    keywords: [__("paragraph", "diymarketer"), __("text", "diymarketer")],
    edit: ({ className }) => {
        return <p className={className}>Editor</p>;
    },
    save: function () {
        return <p>Caved Content</p>;
    }
});
