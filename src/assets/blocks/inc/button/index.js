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
    usesContext: ["diym/buttonType"],
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
    variations: [
        {
            name: "diym/submit",
            title: __("Submit", "diy-marketer"),
            description: __("Add a submit button to your form", "diy-marketer")
            //scope: ["block"]
            //parent: ["diym/form"]
        }
    ],
    supports: {
        html: false,
        reusable: false,
        customClassName: false
    },

    //usesContext: ["diym/buttonType"],
    attributes: {
        textAlign: {
            type: "string",
            default: "left"
        },
        type: {
            type: "string",
            default: "link"
        },
        text: {
            type: "string",
            source: "html",
            selector: "a,button"
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
        //console.log(props);
        const { attributes } = props;

        const {
            text,
            textAlign,
            buttonSize,
            marginBottom,
            marginTop,
            textColor,
            buttonColor,
            type,
            url,
            linkTarget,
            rel
        } = attributes;

        //console.log(type);

        //con;

        let wrapperClass = classnames(getMarginClass(marginTop, marginBottom), {
            [`text-${textAlign}`]: "center" === textAlign || "right" === textAlign
        });

        //const blockProps = useBlockProps.save();
        //console.log(useBlockProps);
        //console.log(blockProps);
        //const parentClientId = select( 'core/block-editor' ).getBlockHierarchyRootClientId( this.props.clientId ); //Pass Child's Client Id.

        let className = classnames("btn", getSelectValueFromFontSize(BUTTON_SIZES, buttonSize), {
            [`text-${textColor}`]: textColor,
            [`btn-${buttonColor}`]: buttonColor,
            "w-100": "full" === textAlign
        });

        const buttonProps =
            type === "link"
                ? { tagName: "a", href: url, target: linkTarget, rel }
                : { tagName: "button", type: "submit" };

        //console.log(buttonProps);

        return (
            <>
                {/*<div {...blockProps}
                ></div>*/}
                <div className={wrapperClass ? wrapperClass : null}>
                    <RichText.Content
                        {...buttonProps}
                        //tagName="a"
                        className={className}
                        value={text}
                        //href={url}
                        //target={linkTarget}
                        //rel={rel}
                    />
                </div>
            </>
        );
    }
});
