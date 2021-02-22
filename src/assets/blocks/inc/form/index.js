//import "./editor.scss";

import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { InnerBlocks, InspectorControls } from "@wordpress/block-editor";

import { PanelBody } from "@wordpress/components";

import { SpacingControl, getEditorSpacing, getFrontEndSpacing } from "../spacing-control";

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
        spacingTop: {
            type: "number"
        },
        spacingBottom: {
            type: "number"
        },
        spacingLeft: {
            type: "number"
        },
        spacingRight: {
            type: "number"
        }
    },
    edit: props => {
        const { attributes, setAttributes, isSelected } = props;
        const { spacingTop, spacingBottom, spacingLeft, spacingRight } = attributes;

        const spacingStyles = getEditorSpacing(
            { top: spacingTop, bottom: spacingBottom, left: spacingLeft, right: spacingRight },
            isSelected
        );

        return (
            <>
                <InspectorControls>
                    <PanelBody title={__("Spacing", "diy-marketer")} initialOpen={"false"}>
                        <SpacingControl
                            values={{
                                top: spacingTop,
                                bottom: spacingBottom,
                                left: spacingLeft,
                                right: spacingRight
                            }}
                            onChange={({ top, bottom, left, right }) => {
                                setAttributes({
                                    spacingTop: top,
                                    spacingBottom: bottom,
                                    spacingLeft: left,
                                    spacingRight: right
                                });
                            }}
                            onReset={() => {
                                setAttributes({
                                    spacingTop: undefined,
                                    spacingBottom: undefined,
                                    spacingLeft: undefined,
                                    spacingRight: undefined
                                });
                            }}
                        ></SpacingControl>
                    </PanelBody>
                </InspectorControls>
                <div style={{ padding: "1rem" }}>
                    <InnerBlocks
                        allowedBlocks={["diym/input", "diym/text", "diym/button"]}
                        renderAppender={() => <InnerBlocks.ButtonBlockAppender />}
                    />
                </div>
            </>
        );
    },
    save: props => {
        const { attributes } = props;
        //const { backgroundColor, offerColor, customOfferColor } = attributes;

        return (
            <form className={"p-3 needs-validation"} noValidate>
                <InnerBlocks.Content />
            </form>
        );
    }
});
