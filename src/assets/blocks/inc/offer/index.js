import "./editor.scss";

import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { InnerBlocks } from "@wordpress/block-editor";
import { PanelBody, Button } from "@wordpress/components";

import { InspectorControls, MediaPlaceholder } from "@wordpress/block-editor";

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
        customClassName: false
    },
    attributes: {
        url: {
            type: "string"
        }
    },
    edit: ({ className, attributes, setAttributes }) => {
        const { url } = attributes;

        console.log(url);

        return (
            <>
                <InspectorControls>
                    <PanelBody title={__("Background image", "diy-marketer")}>
                        {url && (
                            <>
                                <img src={url} />
                                <div style={{ marginTop: "2px", textAlign: "right" }}>
                                    <Button
                                        isSecondary
                                        onClick={() => {
                                            setAttributes({ url: undefined });
                                        }}
                                    >
                                        Remove
                                    </Button>
                                </div>
                            </>
                        )}
                        <MediaPlaceholder
                            onSelect={({ url }) => {
                                setAttributes({ url });
                                console.log(url);
                            }}
                            disableMediaButtons={url}
                        ></MediaPlaceholder>
                    </PanelBody>
                </InspectorControls>
                <div className={className}>
                    <i className="fas fa-share fa-4x"></i>
                    <div>
                        <i className="fas fa-cut fa-2x"></i>
                        <InnerBlocks
                            allowedBlocks={["diym/text", "diym/countdown", "diym/button"]}
                            renderAppender={() => <InnerBlocks.ButtonBlockAppender />}
                        />
                    </div>
                    <i className="fas fa-reply fa-flip-vertical fa-4x" data-content="f112"></i>
                </div>
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
