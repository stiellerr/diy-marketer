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

    styles: [
        {
            name: "rounded",
            label: __("rounded", "diy-marketer")
        }
    ],
    /*
    variations: [
        {
            name: 'wordpress',
            isDefault: true,
            title: __( 'WordPress' ),
            description: __( 'Code is poetry!' ),
            icon: WordPressIcon,
            attributes: { service: 'wordpress' },
        },
        {
            name: 'google',
            title: __( 'Google' ),
            icon: GoogleIcon,
            attributes: { service: 'google' },
        },
        {
            name: 'twitter',
            title: __( 'Twitter' ),
            icon: TwitterIcon,
            attributes: { service: 'twitter' },
            keywords: [ __('tweet') ],
        },
    ],
    */

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
                {url && (
                    <figure>
                        <img src={url} />
                    </figure>
                )}
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

        //console.log(width);
        //console.log(height);

        //const className = classNames("img-fluid", id ? `wp-image-${id}` : null);

        return (
            <figure>
                <img
                    src={url}
                    alt={alt}
                    //width="800"
                    //height="600"
                    //className={"img-fluid".id ? ` wp-image-${id}` : null}
                    //className={className}
                    className={id ? `wp-image-${id}` : null}
                />
            </figure>
        );
    }
});
