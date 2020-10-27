import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { TextControl } from "@wordpress/components";

registerBlockType("diym/meta", {
    title: __("Meta Block", "diy-marketer"),
    description: __("Block for editing meta field", "diy-marketer"),
    category: "diy-marketer",
    icon: {
        foreground: "#007bff",
        src: "admin-tools"
    },
    attributes: {
        post_subtitle: {
            type: "string",
            source: "meta",
            meta: "_diym_seo_page_title"
        }
    },
    supports: {
        html: false,
        inserter: false,
        multiple: false,
        reusable: false
    },
    edit({ attributes, setAttributes }) {
        function onChange(value) {
            setAttributes({ post_subtitle: value });
        }

        return (
            <div>
                <TextControl
                    label={__("Title", "diy-marketer")}
                    value={attributes.post_subtitle}
                    onChange={onChange}
                />
                <TextControl
                    label={__("Description", "diy-marketer")}
                    value={attributes.post_subtitle}
                    onChange={onChange}
                />
            </div>
        );
    },
    save() {
        return null;
    }
});
