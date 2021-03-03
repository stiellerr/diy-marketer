//import "./editor.scss";

import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { InnerBlocks } from "@wordpress/block-editor";
import { box } from "@wordpress/icons";

registerBlockType("diym/container", {
    title: __("Container", "diy-marketer"),
    description: __("Add a container to your page.", "diy-marketer"),
    category: "diy-marketer",
    icon: {
        foreground: "#007bff",
        src: box
    },
    keywords: [__("container", "diy-marketer"), __("box", "diy-marketer")],
    supports: {
        html: false,
        reusable: false,
        customClassName: false
    },
    attributes: {
        spacing: {
            type: "object"
        },
        spacingInside: {
            type: "object"
        }
    },
    edit: props => {
        const { attributes } = props;
        const { spacing } = attributes;

        return (
            <InnerBlocks
                allowedBlocks={["diym/text", "diym/form", "diym/progress"]}
                renderAppender={() => <InnerBlocks.ButtonBlockAppender />}
            />
        );
    },
    save: props => {
        const { attributes } = props;
        const { spacing } = attributes;

        return <InnerBlocks.Content />;
    }
});
