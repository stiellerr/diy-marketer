//import "./editor.scss";

import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { InspectorControls, useBlockProps } from "@wordpress/block-editor";

import {
    TextControl,
    PanelBody,
    CheckboxControl,
    TextareaControl,
    RangeControl
} from "@wordpress/components";

import "./editor.scss";

import classnames from "classnames";

import { SpacingControl, getEditorSpacing, getFrontEndSpacing } from "../spacing-control";

registerBlockType("diym/progress", {
    apiVersion: 2,
    title: __("Progress Bar", "diy-marketer"),
    description: __("Add a progress bar to your form.", "diy-marketer"),
    category: "diy-marketer",
    //parent: ["diym/form"],
    icon: {
        foreground: "#007bff",
        src: "ellipsis"
    },
    keywords: [__("progress", "diy-marketer"), __("bar", "diy-marketer")],
    supports: {
        html: false,
        reusable: false,
        className: true,
        customClassName: false
    },
    attributes: {
        fill: {
            type: "number",
            default: 50
        },
        spacing: {
            type: "object",
            default: {
                top: undefined,
                bottom: undefined
            }
        }
    },
    edit: props => {
        const { attributes, setAttributes, isSelected } = props;
        const { fill, spacing } = attributes;

        //const ref = useRef();
        const blockProps = useBlockProps({
            style: { ...getEditorSpacing(isSelected, spacing) }
        });

        return (
            <>
                <InspectorControls>
                    <PanelBody title={__("Settings", "diy-marketer")}>
                        <RangeControl
                            label={__("Fill percentage.", "diy-marketer")}
                            value={fill}
                            onChange={fill => setAttributes({ fill })}
                            min={0}
                            max={100}
                        ></RangeControl>
                        <SpacingControl
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
                <div {...blockProps}>
                    <progress
                        max="100"
                        value={fill}
                        style={{ width: "100%", height: "30px" }}
                    ></progress>
                </div>
            </>
        );
    },
    save: props => {
        const { attributes } = props;
        const { fill, spacing } = attributes;

        let className = classnames("progress", getFrontEndSpacing("m", spacing));

        return (
            <div className={className}>
                <div
                    className="progress-bar progress-bar-striped progress-bar-animated"
                    role="progressbar"
                    aria-valuenow={fill}
                    aria-valuemin="0"
                    aria-valuemax="100"
                    style={`width: ${fill}%`}
                ></div>
            </div>
        );
    }
});
