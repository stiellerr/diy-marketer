import { __ } from "@wordpress/i18n";

import {
    withColors,
    PanelColorSettings,
    MediaPlaceholder,
    InnerBlocks,
    BlockIcon
} from "@wordpress/block-editor";
import { InspectorControls } from "@wordpress/block-editor";

import { SpacingControl, getEditorSpacing } from "../spacing-control";

import { cover as icon } from "@wordpress/icons";
import {
    PanelBody,
    PanelRow,
    Button,
    ColorIndicator,
    Flex,
    Dropdown,
    FlexItem,
    FlexBlock,
    ColorPicker,
    RangeControl,
    SelectControl
} from "@wordpress/components";

function OfferEdit(props) {
    const { attributes, setAttributes, offerColor, setOfferColor, isSelected } = props;
    const { backgroundColor, spaceTop, spaceBottom, spaceLeft, spaceRight } = attributes;

    //make a copy of the post meta so it can be manipulated
    const postMeta = { ...attributes.postMeta };

    const SPACING = {
        spaceTop,
        spaceBottom,
        spaceLeft,
        spaceRight
    };

    const DEFAULTS = {
        spaceTop: 3,
        spaceBottom: 3,
        spaceLeft: 3,
        spaceRight: 3
    };

    const spacingStyles = getEditorSpacing(isSelected, SPACING, DEFAULTS);

    const backgroundColorPicker = () => (
        <ColorPicker
            color={backgroundColor ? backgroundColor : "fff"}
            onChangeComplete={({ color }) =>
                setAttributes({ backgroundColor: color.toRgbString() })
            }
        />
    );

    const placeholderIcon = <BlockIcon icon={icon} />;

    return (
        <>
            <InspectorControls>
                <PanelBody title={__("Alignment", "diy-marketer")} initialOpen={false}>
                    <PanelRow>
                        <div style={{ marginTop: "12px" }}>
                            <SelectControl
                                label={__("Vertical Align", "diy-marketer")}
                                labelPosition="Right"
                                value={postMeta.verticalAlign}
                                options={[
                                    { label: "Top", value: "" },
                                    { label: "Middle", value: "center" },
                                    { label: "Bottom", value: "flex-end" }
                                ]}
                                onChange={value => {
                                    postMeta.verticalAlign = value;
                                    setAttributes({ postMeta });
                                }}
                            ></SelectControl>
                        </div>
                    </PanelRow>
                </PanelBody>
                <PanelBody title={__("Background image", "diy-marketer")} initialOpen={false}>
                    {postMeta.background_image && (
                        <>
                            <img
                                src={postMeta.background_image}
                                style={{ opacity: postMeta.opacity }}
                            />
                            <PanelRow>
                                <Button
                                    isSecondary
                                    isSmall
                                    onClick={() => {
                                        postMeta.background_image = "";
                                        setAttributes({ postMeta });
                                    }}
                                    style={{ marginLeft: "auto" }}
                                >
                                    {__("Clear Image", "diy-marketer")}
                                </Button>
                            </PanelRow>
                            <RangeControl
                                label={__("Opactiy")}
                                value={postMeta.opacity}
                                onChange={value => {
                                    postMeta.opacity = value;
                                    setAttributes({ postMeta });
                                }}
                                min={0.0}
                                max={1.0}
                                step={0.01}
                            ></RangeControl>
                        </>
                    )}
                    <MediaPlaceholder
                        labels={{ title: __("Image", "diy-marketer") }}
                        icon={placeholderIcon}
                        onSelect={({ url }) => {
                            postMeta.background_image = url;
                            setAttributes({ postMeta });
                        }}
                        disableMediaButtons={postMeta.background_image}
                    ></MediaPlaceholder>
                </PanelBody>
                <PanelColorSettings
                    title={__("Color settings", "diy-marketer")}
                    colorSettings={[
                        {
                            label: __("Offer Color", "diy-marketer"),
                            value: offerColor.color,
                            onChange: setOfferColor
                        }
                    ]}
                >
                    {__("Background Color", "diy-marketer")}
                    <ColorIndicator
                        style={{ verticalAlign: "text-bottom", backgroundColor }}
                    ></ColorIndicator>
                    <Flex justify={"flex-end"} style={{ minHeight: "36px" }}>
                        <Dropdown
                            renderToggle={({ isOpen, onToggle }) => (
                                <Button
                                    aria-expanded={isOpen}
                                    aria-haspopup="true"
                                    onClick={onToggle}
                                    isLink
                                    style={{ marginRight: "8px" }}
                                >
                                    {__("Custom color", "diy-marketer")}
                                </Button>
                            )}
                            renderContent={backgroundColorPicker}
                        ></Dropdown>
                        <Button
                            onClick={() => {
                                setAttributes({ backgroundColor: undefined });
                            }}
                            isSecondary
                            isSmall
                        >
                            {__("Clear", "diy-marketer")}
                        </Button>
                    </Flex>
                </PanelColorSettings>
                <PanelBody title={__("Spacing", "diy-marketer")} initialOpen={false}>
                    <SpacingControl
                        defaults={DEFAULTS}
                        values={SPACING}
                        onChange={newSpacing => {
                            setAttributes(newSpacing);
                        }}
                        onReset={() => {
                            setAttributes({
                                spaceTop: undefined,
                                spaceBottom: undefined,
                                spaceLeft: undefined,
                                spaceRight: undefined
                            });
                        }}
                    ></SpacingControl>
                </PanelBody>
            </InspectorControls>
            <Flex>
                <FlexItem>
                    <i className={"fas fa-share fa-4x"} style={{ color: offerColor.color }}></i>
                </FlexItem>
                <FlexBlock
                    style={{
                        backgroundColor: backgroundColor,
                        borderStyle: "dashed",
                        borderColor: offerColor.color,
                        //padding: "0.5rem",
                        position: "relative"
                    }}
                >
                    <i
                        className={"fas fa-cut fa-2x"}
                        style={{
                            position: "absolute",
                            top: 0,
                            left: "10%",
                            transform: "translate(-50%, -50%)",
                            color: offerColor.color
                        }}
                    ></i>
                    <div style={spacingStyles}>
                        <InnerBlocks
                            allowedBlocks={["diym/text", "diym/countdown", "diym/button"]}
                            renderAppender={() => <InnerBlocks.ButtonBlockAppender />}
                        />
                    </div>
                </FlexBlock>
                <FlexItem>
                    <i
                        className={"fas fa-reply fa-flip-vertical fa-4x"}
                        style={{ color: offerColor.color }}
                    ></i>
                </FlexItem>
            </Flex>
        </>
    );
}

export default withColors("offerColor")(OfferEdit);
