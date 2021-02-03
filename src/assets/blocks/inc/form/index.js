//import "./editor.scss";

import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { InnerBlocks, InspectorControls } from "@wordpress/block-editor";

import {
    __experimentalBoxControl as BoxControl,
    __experimentalInputControl as InputControl,
    PanelBody,
    TextControl,
    Flex,
    FlexItem,
    PanelRow
} from "@wordpress/components";

const { __Visualizer } = BoxControl;

//import edit from "./edit";
const ddd = () => {
    return <div>zzz</div>;
};

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
            type: "object"
        }
    },
    edit: props => {
        const { attributes, setAttributes } = props;
        const { spacing } = attributes;

        const zzz = value => {
            return value.split("px")[0];
        };

        return (
            <>
                <InspectorControls>
                    <PanelBody title={__("Spacing", "diy-marketer")} initialOpen={"false"}>
                        <BoxControl
                            inputProps={{
                                min: 0,
                                max: 5,
                                type: "number",
                                disableUnits: true,
                                unit: ""
                            }}
                            units={false}
                            values={spacing}
                            onChange={values => {
                                console.log(values);
                                setAttributes({ spacing: values });
                            }}
                        />
                    </PanelBody>
                </InspectorControls>
                <div>
                    <InnerBlocks
                        allowedBlocks={["diym/input"]}
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
            <form>
                <InnerBlocks.Content />
            </form>
        );
    }
});
