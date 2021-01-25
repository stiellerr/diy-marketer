import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { RichText, useBlockProps } from "@wordpress/block-editor";

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
    styles: [
        // Mark style as default.
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
        //className: false,
        //color: true,
        customClassName: false
    },
    //wp-block-diym-button
    //style: "wp-block-diym-button",
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
            url,
            linkTarget,
            rel
        } = attributes;

        let wrapperClass = classnames(getMarginClass(marginTop, marginBottom), {
            [`text-${textAlign}`]: "center" === textAlign || "right" === textAlign
        });

        const blockProps = useBlockProps.save();
        //console.log(useBlockProps);
        console.log(blockProps);

        return (
            <>
                <div {...blockProps}></div>
                <div className={wrapperClass ? wrapperClass : null}>
                    <RichText.Content
                        tagName="a"
                        className={classnames("btn", "btn-primary", {
                            "w-100": "full" === textAlign,
                            [buttonSize]: buttonSize
                        })}
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
