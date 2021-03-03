//import "./editor.scss";

import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { InnerBlocks } from "@wordpress/block-editor";

const TEMPLATE = [["diym/field"]];

registerBlockType("diym/inputs", {
    title: __("Inputs", "diy-marketer"),
    description: __("Add inputs to your form.", "diy-marketer"),
    category: "diy-marketer",
    icon: {
        foreground: "#007bff",
        src: "edit-large"
    },
    keywords: [__("input", "diy-marketer")],
    supports: {
        html: false,
        reusable: false,
        customClassName: false
    },
    attributes: {
        spacing: {
            type: "object",
            default: {
                top: undefined,
                bottom: undefined
            }
        }
    },
    edit: props => {
        const { attributes } = props;
        //const { spacing } = attributes;

        return (
            <InnerBlocks
                template={TEMPLATE}
                allowedBlocks={["diym/field"]}
                renderAppender={() => <InnerBlocks.ButtonBlockAppender />}
            />
        );
    },
    save: props => {
        const { attributes } = props;
        //const { spacing } = attributes;

        return <InnerBlocks.Content />;
    }
});
