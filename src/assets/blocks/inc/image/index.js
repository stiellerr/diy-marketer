import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { image } from "@wordpress/icons";
import { MediaPlaceholder } from "@wordpress/block-editor";

import classNames from "classnames";

registerBlockType("diym/image", {
    title: __("Image", "diy-marketer"),
    description: __(
        "Introduce the page with a main headline to help visitors (and search engines) understand what your page is about.",
        "diy-marketer"
    ),
    attributes: {
        id: {
            type: "number"
        },
        alt: {
            type: "string",
            source: "attribute",
            selector: "img",
            attribute: "alt",
            default: ""
        },
        url: {
            type: "string",
            source: "attribute",
            selector: "img",
            attribute: "src"
        }
    },
    supports: {
        html: false,
        reusable: false,
        className: false
    },
    category: "diy-marketer",
    icon: {
        foreground: "#007bff",
        src: image
    },
    keywords: [
        __("image", "diymarketer"),
        __("photo", "diymarketer"),
        __("picture", "diymarketer")
    ],
    edit: ({ attributes, setAttributes }) => {
        const { url } = attributes;
        // on select image.
        /*
        const onSelectImage = ({ id, url, alt }) => {
            setAttributes({ id, url, alt });
            //console.log(v);
        };
        */
        // on select image.
        const onSelectImage = ({ id, url, alt }) => {
            setAttributes({ id, url, alt });
            //console.log(media);
        };

        return (
            <>
                {url && <img src={url} />}
                {
                    <MediaPlaceholder
                        icon="format-image"
                        accept="image/*"
                        allowedTypes={["image"]}
                        onSelect={onSelectImage}
                        disableMediaButtons={url}
                    />
                }
            </>
        );
    },
    save: ({ attributes }) => {
        const { url, alt, id } = attributes;

        const className = classNames("img-fluid", id ? `wp-image-${id}` : null);

        return (
            <figure>
                <img
                    src={url}
                    alt={alt}
                    //width="100%"
                    //height="auto"
                    //className={"img-fluid".id ? ` wp-image-${id}` : null}
                    className={className}
                />
            </figure>
        );
    }
});
