import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { image } from "@wordpress/icons";
import { MediaPlaceholder } from "@wordpress/block-editor";

registerBlockType("diym/image", {
    title: __("Image", "diy-marketer"),
    description: __(
        "Introduce the page with a main headline to help visitors (and search engines) understand what your page is about.",
        "diy-marketer"
    ),
    supports: {
        html: false,
        reusable: false,
        className: false
    },
    attributes: {},
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

    edit: () => {
        return (
            <>
                <MediaPlaceholder
                    icon="format-image"
                    accept="image/*"
                    allowedTypes={["image"]}
                    onSelect={image => {
                        console.log(image);
                    }}
                />
            </>
        );
    },
    save: () => {
        return <h1>hello</h1>;
    }
});
