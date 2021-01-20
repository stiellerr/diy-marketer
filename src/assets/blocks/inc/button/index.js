import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { RichText, useBlockProps, BlockControls, AlignmentToolbar } from "@wordpress/block-editor";
import {
    withColors,
    InspectorControls,
    PanelColorSettings,
    ContrastChecker
} from "@wordpress/block-editor";
import { PanelBody } from "@wordpress/components";

import "./editor.scss";

import { getMarginClass } from "../spacing-control";

import edit from "./edit.js";

import classnames from "classnames";

registerBlockType("diym/button", {
    apiVersion: 2,
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
        //alignWide: false,
        reusable: false,
        color: true

        //__experimentalSelector: ".wp-block-button > a"
        //
        //anchor: true,
        //className: true
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
            type: "string",
            default: "left"
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
        },
        buttonSize: {
            type: "string",
            default: "normal"
        },
        paddingSize: {
            type: "string"
        },
        marginTop: {
            type: "number"
        },
        marginBottom: {
            type: "number"
        }
    },
    //style: "zzzz",
    edit,

    // save
    save: props => {
        const { attributes } = props;

        const {
            text,
            url,
            linkTarget,
            rel,
            align,
            buttonSize,
            marginBottom,
            marginTop
        } = attributes;

        let wrapperClass = classnames(getMarginClass(marginTop, marginBottom), {
            [`text-${align}`]: "center" === align || "right" === align
        });

        return (
            <div className={wrapperClass ? wrapperClass : null}>
                <RichText.Content
                    tagName="a"
                    className={classnames("btn", "btn-primary", {
                        "w-100": "full" === align,
                        [`btn-${buttonSize}`]: "sm" === buttonSize || "lg" === buttonSize
                    })}
                    value={text}
                    href={url}
                    target={linkTarget}
                    rel={rel}
                />
            </div>
        );
    }
});
