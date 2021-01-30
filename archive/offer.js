import "./editor.scss";

import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { BlockIcon, InnerBlocks, PanelColorSettings } from "@wordpress/block-editor";
import {
    PanelBody,
    Button,
    PanelRow,
    Flex,
    FlexItem,
    FlexBlock,
    ColorPicker,
    ColorIndicator,
    Dropdown,
    Text,
    ColorPalette
} from "@wordpress/components";

import { cover as icon } from "@wordpress/icons";

//import { View } from "react-native";

import { InspectorControls, MediaPlaceholder } from "@wordpress/block-editor";
//import { View } from "react-native";

registerBlockType("diym/offer", {
    title: __("Offer", "diy-marketer"),
    description: __("Add an offer for your services.", "diy-marketer"),
    category: "diy-marketer",
    icon: {
        foreground: "#007bff",
        src: "tickets-alt"
    },
    keywords: [__("offer", "diy-marketer")],
    supports: {
        html: false,
        reusable: false,
        customClassName: false,
        color: {
            gradients: true
        }
    },
    attributes: {
        url: {
            type: "string"
        }
    },
    edit: ({ className, attributes, setAttributes }) => {
        const { url } = attributes;

        console.log(url);

        const colors = [{ name: "Accent Color", slug: "accent", color: "#f00" }];

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
                                label: __("Text Color", "diy-marketer"),
                                value: "#fff"
                                //onChange: {},
                                //disableAlpha: false
                            },
                            {
                                label: __("Button Color", "diy-marketer"),
                                disableCustomColors: true,
                                value: "#000000"
                                //onChange: setButtonColor
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
                    <PanelBody title={__("Color settings", "diy-marketer")}></PanelBody>
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
                {/*
                <div className={className}>
                    <i className="fas fa-share fa-4x"></i>
                    <div>
                        <i className="fas fa-cut fa-2x"></i>
                        <InnerBlocks
                            allowedBlocks={["diym/text", "diym/countdown", "diym/button"]}
                            renderAppender={() => <InnerBlocks.ButtonBlockAppender />}
                        />
                    </div>
                    <i className="fas fa-reply fa-flip-vertical fa-4x"></i>
                </div>
                */}
            </>
        );
    },
    save: () => {
        return (
            <>
                <div className="d-flex flex-column flex-lg-row">
                    <i
                        className="fas fa-share fa-4x lg-rotate-90 align-self-center m-1"
                        data-content="f064"
                    ></i>
                    <div className="flex-grow-1 position-relative border-dashed">
                        <i
                            className="fas fa-cut fa-2x position-absolute translate-middle left-10"
                            data-content="f0c4"
                        ></i>
                        <div className="p-2">
                            <InnerBlocks.Content />
                        </div>
                    </div>
                    <i
                        className="fas fa-reply fa-4x lg-rotate-90 fa-flip-vertical align-self-center m-1"
                        data-content="f3e5"
                    ></i>
                </div>
            </>
        );
    }
});
