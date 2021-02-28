import "./editor.scss";

import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { InnerBlocks } from "@wordpress/block-editor";

import { getFrontEndSpacing } from "../spacing-control";

import edit from "./edit";

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
        reusable: false,
        customClassName: false
    },
    attributes: {
        postMeta: {
            type: "object",
            source: "meta",
            meta: "_diym_post_meta"
        },
        spaceTop: {
            type: "number"
        },
        spaceBottom: {
            type: "number"
        },
        spaceLeft: {
            type: "number"
        },
        spaceRight: {
            type: "number"
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
    },
    edit,
    save: props => {
        const { attributes } = props;
        const {
            backgroundColor,
            offerColor,
            customOfferColor,
            spaceTop,
            spaceBottom,
            spaceLeft,
            spaceRight
        } = attributes;

        const SPACING = {
            spaceTop,
            spaceBottom,
            spaceLeft,
            spaceRight
        };

        const DEFAULTS = {
            spaceTop: 3,
            spaceBottom: 3,
            spaceLeft: 3,
            spaceRight: 3
        };

        const wrapperClass = getFrontEndSpacing("m", SPACING, DEFAULTS);

        return (
            <>
                <div className="d-flex flex-column flex-lg-row">
                    <i
                        className="fas fa-share fa-4x lg-rotate-90 align-self-center m-1"
                        //className={'fas', ...{   }}
                        data-content="f064"
                        style={{ color: customOfferColor }}
                    ></i>
                    <div
                        className="flex-grow-1 position-relative border-dashed"
                        style={{ backgroundColor, borderColor: customOfferColor }}
                    >
                        <i
                            className="fas fa-cut fa-2x position-absolute translate-middle left-10"
                            data-content="f0c4"
                            style={{ color: customOfferColor }}
                        ></i>
                        <div className={wrapperClass}>
                            <InnerBlocks.Content />
                        </div>
                    </div>
                    <i
                        className="fas fa-reply fa-4x lg-rotate-90 fa-flip-vertical align-self-center m-1"
                        data-content="f3e5"
                        style={{ color: customOfferColor }}
                    ></i>
                </div>
            </>
        );
    }
});
