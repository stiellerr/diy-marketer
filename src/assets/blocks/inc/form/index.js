//import "./editor.scss";

import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { InnerBlocks, InspectorControls, PlainText, RichText } from "@wordpress/block-editor";

import { PanelBody, Button } from "@wordpress/components";
import classnames from "classnames";

import { SpacingControl, getEditorSpacing, getFrontEndSpacing } from "../spacing-control";

const TEMPLATE = [["diym/inputs"], ["diym/button"]];

registerBlockType("diym/form", {
    title: __("Form", "diy-marketer"),
    description: __("Add a form to your page.", "diy-marketer"),
    category: "diy-marketer",
    icon: {
        foreground: "#007bff",
        src: "text-page"
    },
    keywords: [__("form", "diy-marketer")],
    supports: {
        html: false,
        reusable: false,
        customClassName: false,
        color: true
    },
    attributes: {
        spacing: {
            type: "object",
            default: {
                top: undefined,
                bottom: undefined
            }
        },
        text: {
            type: "string",
            default: "SUBMIT."
        }
    },
    edit: props => {
        const { attributes, setAttributes, isSelected } = props;
        const { spacing, text } = attributes;

        return (
            <>
                <InspectorControls>
                    <PanelBody title={__("Spacing", "diy-marketer")} initialOpen={"false"}>
                        <SpacingControl
                            title={__("Space Control", "diy-marketer")}
                            values={spacing}
                            onChange={spacing => {
                                setAttributes({ spacing });
                            }}
                            onReset={() => {
                                setAttributes({
                                    spacing: {
                                        top: undefined,
                                        bottom: undefined
                                    }
                                });
                            }}
                        ></SpacingControl>
                    </PanelBody>
                </InspectorControls>
                <div style={{ ...getEditorSpacing(isSelected, spacing) }}>
                    <InnerBlocks
                        template={[["diym/input"]]}
                        allowedBlocks={["diym/input"]}
                        renderAppender={() => <InnerBlocks.ButtonBlockAppender />}
                    />
                    <RichText
                        placeholder={__("Submit", "diy-marketer")}
                        style={{
                            //color: textColor.color,
                            textAlign: "center",
                            backgroundColor: "lightblue",
                            display: "block",
                            lineHeight: 1.5,
                            padding: "0.375rem 0.75rem"
                            //borderColor: buttonColor.color,
                            //width: "full" === textAlign ? "100%" : null,
                            //fontSize: buttonSize || null
                        }}
                        value={text}
                        //onChange={text => setAttributes({ text })}
                        withoutInteractiveFormatting
                    ></RichText>
                </div>
            </>
        );
    },
    save: props => {
        const { attributes } = props;
        const { spacing } = attributes;

        const className = classnames("needs-validation", getFrontEndSpacing("m", spacing));

        return (
            <form className={className} noValidate>
                <InnerBlocks.Content />
            </form>
        );
    }
});
