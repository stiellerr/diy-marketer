import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { RichText, useBlockProps } from "@wordpress/block-editor";

import "./editor.scss";

import { getMarginClass } from "../spacing-control";
import { BUTTON_SIZES, getSelectValueFromFontSize } from "../helper";
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
    styles: [
        {
            name: "fill",
            label: __("Fill", "diy-marketer"),
            isDefault: true
        },
        {
            name: "outline",
            label: __("Outline", "diy-marketer")
        }
    ],
    supports: {
        html: false,
        reusable: false,
        customClassName: false
    },
    attributes: {
        textAlign: {
            type: "string",
            default: "left"
        },
        text: {
            type: "string",
            source: "html",
            selector: "a"
        },
        buttonSize: {
            type: "string"
        },
        marginTop: {
            type: "number"
        },
        marginBottom: {
            type: "number"
        },
        textColor: {
            type: "string"
        },
        buttonColor: {
            type: "string"
        },
        //
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
    edit,
    save: props => {
        console.log(props);
        const { attributes } = props;

        const {
            text,
            textAlign,
            buttonSize,
            marginBottom,
            marginTop,
            textColor,
            buttonColor,
            url,
            linkTarget,
            rel
        } = attributes;

        let wrapperClass = classnames(getMarginClass(marginTop, marginBottom), {
            [`text-${textAlign}`]: "center" === textAlign || "right" === textAlign
        });

        //const blockProps = useBlockProps.save();
        //console.log(useBlockProps);
        //console.log(blockProps);

        let className = classnames("btn", getSelectValueFromFontSize(BUTTON_SIZES, buttonSize), {
            [`text-${textColor}`]: textColor,
            [`btn-${buttonColor}`]: buttonColor,
            "w-100": "full" === textAlign
        });

        return (
            <>
                {/*<div {...blockProps}
                ></div>*/}
                <div className={wrapperClass ? wrapperClass : null}>
                    <RichText.Content
                        tagName="a"
                        className={className}
                        value={text}
                        href={url}
                        target={linkTarget}
                        rel={rel}
                    />
                </div>
            </>
        );
    }
});
