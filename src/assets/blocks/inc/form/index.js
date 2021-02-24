//import "./editor.scss";

import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { InnerBlocks, InspectorControls } from "@wordpress/block-editor";

import { PanelBody } from "@wordpress/components";
import classnames from "classnames";

import { SpacingControl, getEditorSpacing, getFrontEndSpacing } from "../spacing-control";
import { pickBy, isNumber } from "lodash";

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

        const DEFAULTS = {
            top: 3,
            bottom: 3,
            left: 3,
            right: 3
        };

        const SPACING = {
            // defaults
            ...DEFAULTS,
            // pick out the numbers
            ...pickBy(
                { top: spacingTop, bottom: spacingBottom, left: spacingLeft, right: spacingRight },
                isNumber
            )
        };

        const spacingStyles = getEditorSpacing(SPACING, isSelected);

        return (
            <>
                <InspectorControls>
                    <PanelBody title={__("Spacing", "diy-marketer")} initialOpen={"false"}>
                        <SpacingControl
                            values={SPACING}
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
                <div style={{ ...spacingStyles }}>
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
        const { spacingTop, spacingBottom, spacingLeft, spacingRight } = attributes;
        //const { backgroundColor, offerColor, customOfferColor } = attributes;
        let className = classnames(
            "needs-validation",
            getFrontEndSpacing(
                {
                    top: spacingTop,
                    bottom: spacingBottom,
                    left: spacingLeft,
                    right: spacingRight
                },
                "p"
            )
        );

        return (
            <form className={className} noValidate>
                <InnerBlocks.Content />
            </form>
        );
    }
});
