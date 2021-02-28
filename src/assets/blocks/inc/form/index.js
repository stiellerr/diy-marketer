//import "./editor.scss";

import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { InnerBlocks, InspectorControls } from "@wordpress/block-editor";

import { PanelBody } from "@wordpress/components";
import classnames from "classnames";

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
        spacing: {
            type: "object",
            default: {
                top: undefined,
                bottom: undefined
            }
        },
        spacingInside: {
            type: "object",
            default: {
                top: undefined,
                bottom: undefined,
                left: undefined,
                right: undefined
            }
        }
    },
    edit: props => {
        const { attributes, setAttributes, isSelected } = props;
        const { spacing, spacingInside } = attributes;

        const defaults = {
            top: 3,
            bottom: 3,
            left: 3,
            right: 3
        };

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
                        <SpacingControl
                            title={__("Space Control (inside)", "diy-marketer")}
                            defaults={defaults}
                            values={spacingInside}
                            onChange={spacingInside => {
                                setAttributes({ spacingInside });
                            }}
                            onReset={() => {
                                setAttributes({
                                    spacingInside: {
                                        top: undefined,
                                        bottom: undefined,
                                        left: undefined,
                                        right: undefined
                                    }
                                });
                            }}
                        ></SpacingControl>
                    </PanelBody>
                </InspectorControls>
                <div style={{ ...getEditorSpacing(isSelected, spacing) }}>
                    <div style={{ ...getEditorSpacing(isSelected, spacingInside, defaults) }}>
                        <InnerBlocks
                            allowedBlocks={["diym/input", "diym/text", "diym/button"]}
                            renderAppender={() => <InnerBlocks.ButtonBlockAppender />}
                        />
                    </div>
                </div>
            </>
        );
    },
    save: props => {
        const { attributes } = props;
        const { spacing, spacingInside } = attributes;

        const defaults = {
            top: 3,
            bottom: 3,
            left: 3,
            right: 3
        };

        let className = classnames(
            "needs-validation",
            getFrontEndSpacing("m", spacing),
            getFrontEndSpacing("p", spacingInside, defaults)
        );

        return (
            <form className={className} noValidate>
                <InnerBlocks.Content />
            </form>
        );
    }
});
