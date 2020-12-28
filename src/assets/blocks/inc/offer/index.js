import "./editor.scss";

import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
//import { InnerBiocks } from "@wordpress/block-editor";
import { InnerBlocks } from "@wordpress/block-editor";
import { RichText, BlockControls, AlignmentToolbar } from "@wordpress/block-editor";
//import "./inner";
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

registerBlockType("diym/offer", {
    title: __("Offer", "diy-marketer"),
    description: __("Add an offer for your services.", "diy-marketer"),
    category: "diy-marketer",
    icon: {
        foreground: "#007bff",
        src: "tickets-alt"
    },
    keywords: [__("offer", "diy-marketer")],
    supports: {
        html: false,
        reusable: false
        //className: false
    },
    edit: ({ className, attributes, setAttributes }) => {
        const { content, align } = attributes;

        const onChangeContent = content => {
            setAttributes({ content });
        };

        const onChangeAlign = align => {
            setAttributes({ align });
        };

        return (
            <>
                <BlockControls>
                    <AlignmentToolbar
                        value={align}
                        alignmentControls={DEFAULT_ALIGNMENT_CONTROLS}
                        onChange={onChangeAlign}
                    />
                </BlockControls>
                <div className={className}>
                    <i className="fas fa-share fa-4x"></i>
                    <div>
                        <i className="fas fa-cut fa-2x"></i>
                        <InnerBlocks
                            allowedBlocks={["diym/subhead", "diym/paragraph", "diym/countdown"]}
                        />
                    </div>
                    <i className="fas fa-reply fa-flip-vertical fa-4x"></i>
                </div>
            </>
        );
    },
    save: ({ attributes }) => {
        const { content, align } = attributes;

        //const className = align ? `text-${align}` : false;

        //const className = classnames(   )

        const pClass = classnames("rounded", "flex-grow-1", align ? `text-${align}` : undefined);

        return (
            <>
                <div className="d-md-flex">
                    <i className="fas fa-share fa-4x fa-rotate-90 m-1"></i>
                    <div>
                        <InnerBlocks.Content />
                    </div>
                    <i className="fas fa-share fa-4x fa-rotate-90 m-1"></i>
                </div>
            </>
        );
    }
});