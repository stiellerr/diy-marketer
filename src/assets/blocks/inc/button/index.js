import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { RichText, BlockControls, AlignmentToolbar } from "@wordpress/block-editor";
import {
    withColors,
    InspectorControls,
    PanelColorSettings,
    ContrastChecker
} from "@wordpress/block-editor";
import { PanelBody } from "@wordpress/components";

import "./editor.scss";

import edit from "./edit.js";

import classnames from "classnames";

registerBlockType("diym/button", {
    title: __("Button", "diy-marketer"),
    description: __("Add a button to your web page", "diy-marketer"),
    category: "diy-marketer",
    icon: {
        foreground: "#007bff",
        src: "button"
    },
    keywords: [__("button", "diy-marketer")],
    supports: {
        anchor: true,
        //align: true,
        alignWide: false,
        reusable: false
        //__experimentalSelector: ".wp-block-button > a"
        //
        //anchor: true,
        //className: false
        //__experimentalColor: {
        //    linkColor: true
        //},
        //__experimentalFontSize: true
        //__experimentalLineHeight: true,
        //__experimentalSelector: "p",
        //__unstablePasteTextInline: true
    },

    attributes: {
        buttonColor: {
            type: "string",
            default: "accent"
        },
        contentColor: {
            type: "string"
        },
        align: {
            type: "string"
        },
        text: {
            type: "string",
            source: "html",
            selector: "a"
        },
        url: {
            type: "string",
            source: "attribute",
            selector: "a",
            attribute: "href"
        },
        linkTarget: {
            type: "string",
            source: "attribute",
            selector: "a",
            attribute: "target"
        },
        rel: {
            type: "string",
            source: "attribute",
            selector: "a",
            attribute: "rel"
        }
    },
    style: "zzzz",
    edit,

    // save
    save: props => {
        const { attributes } = props;

        const { text, url, linkTarget, rel } = attributes;

        return (
            <>
                <RichText.Content
                    tagName="a"
                    className={"btn btn-primary"}
                    value={text}
                    href={url}
                    target={linkTarget}
                    rel={rel}
                />
            </>
        );
    }
});
