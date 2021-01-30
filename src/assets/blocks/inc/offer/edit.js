import { __ } from "@wordpress/i18n";

import {
    withColors,
    PanelColorSettings,
    MediaPlaceholder,
    InnerBlocks,
    BlockIcon
} from "@wordpress/block-editor";
import { InspectorControls } from "@wordpress/block-editor";

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
    ColorPicker
} from "@wordpress/components";

function OfferEdit(props) {
    const { className, attributes, setAttributes, offerColor, setOfferColor } = props;
    const { url } = attributes;

    const renderCustomColorPicker = () => (
        <ColorPicker color={""} onChangeComplete={color => console.log(color)} />
    );

    const placeholderIcon = <BlockIcon icon={icon} />;

    return (
        <>
            <InspectorControls>
                <PanelBody title={__("Background image", "diy-marketer")}>
                    {url && (
                        <>
                            <img src={url} />
                            <PanelRow>
                                <Button
                                    isSecondary
                                    isSmall
                                    onClick={() => {
                                        setAttributes({ url: undefined });
                                    }}
                                    style={{ marginLeft: "auto" }}
                                >
                                    {__("Clear Image", "diy-marketer")}
                                </Button>
                            </PanelRow>
                        </>
                    )}
                    <MediaPlaceholder
                        labels={{ title: __("Image", "diy-marketer") }}
                        icon={placeholderIcon}
                        onSelect={({ url }) => {
                            setAttributes({ url });
                        }}
                        disableMediaButtons={url}
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
                    <span>Background Color</span>
                    <>
                        <ColorIndicator
                            //color="#fff"
                            style={{ verticalAlign: "text-bottom" }}
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
                                        {__("Custom colour", "diy-marketer")}
                                    </Button>
                                )}
                                renderContent={renderCustomColorPicker}
                            ></Dropdown>
                            <Button onClick={{}} isSecondary isSmall>
                                {__("Clear", "diy-marketer")}
                            </Button>
                        </Flex>
                    </>
                </PanelColorSettings>
            </InspectorControls>
            <Flex>
                <FlexItem>
                    <i className={"fas fa-share fa-4x"}></i>
                </FlexItem>
                <FlexBlock
                    style={{ borderStyle: "dashed", padding: "0.5rem", position: "relative" }}
                >
                    <i
                        className={"fas fa-cut fa-2x"}
                        style={{
                            position: "absolute",
                            top: 0,
                            left: "10%",
                            transform: "translate(-50%, -50%)"
                        }}
                    ></i>
                    <InnerBlocks
                        allowedBlocks={["diym/text", "diym/countdown", "diym/button"]}
                        renderAppender={() => <InnerBlocks.ButtonBlockAppender />}
                    />
                </FlexBlock>
                <FlexItem>
                    <i className={"fas fa-reply fa-flip-vertical fa-4x"}></i>
                </FlexItem>
            </Flex>
        </>
    );
}

export default withColors("offerColor")(OfferEdit);
