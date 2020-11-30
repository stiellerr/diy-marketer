import "./editor.scss";

import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
//import { InnerBiocks } from "@wordpress/block-editor";
import { InnerBlocks } from "@wordpress/block-editor";
import "./inner";

registerBlockType("diym/benefits", {
    title: __("Benefits", "diy-marketer"),
    description: __("list of benefits for choosing you, and your services.", "diy-marketer"),
    category: "diy-marketer",
    icon: {
        foreground: "#007bff",
        src: "saved"
    },
    keywords: [__("benefit", "diy-marketer")],
    supports: {
        html: false,
        reusable: false
        //className: false
    },

    edit: ({ className }) => {
        return (
            <ul className={className}>
                <InnerBlocks allowedBlocks={["diym/benefit"]} />
            </ul>
        );
    },

    save: () => {
        return (
            <div className="media">
                <InnerBlocks.Content />
            </div>
        );
    }
});
