//import "./editor.scss";

import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { InnerBlocks } from "@wordpress/block-editor";

//import edit from "./edit";

const TEMPLATE = [["diym/form"]];

registerBlockType("diym/modal", {
    title: __("Modal", "diy-marketer"),
    description: __("Add a modal to your page.", "diy-marketer"),
    category: "diy-marketer",
    icon: {
        foreground: "#007bff",
        src: "external"
    },
    keywords: [__("modal", "diy-marketer"), __("pop", "diy-marketer")],
    supports: {
        html: false,
        reusable: false,
        customClassName: false
    },
    attributes: {
        /*
        postMeta: {
            type: "object",
            source: "meta",
            meta: "_diym_post_meta"
        },
        
        meta_test: {
            type: "string",
            source: "meta",
            meta: "_diym_meta_test"
        },
        
        backgroundColor: {
            type: "string"
        },
        offerColor: {
            type: "string"
        },
        customOfferColor: {
            type: "string"
        }
        */
    },
    edit: props => {
        return (
            <InnerBlocks
                template={TEMPLATE}
                //templateLock="all"
                allowedBlocks={["diym/text"]}
                renderAppender={() => <InnerBlocks.ButtonBlockAppender />}
            />
        );
    },
    save: props => {
        const { attributes } = props;
        //const { backgroundColor, offerColor, customOfferColor } = attributes;

        return <div>zzz</div>;
    }
});
