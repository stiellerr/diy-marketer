const { registerBlockType } = wp.blocks;
const { __ } = wp.i18n;

registerBlockType("diy-marketer/heading1", {
    title: __("Heading 1", "diy-marketer"),
    description: __(
        "Introduce the page with a main headline to help visitors (and search engines) understand what your page is about.",
        "diy-marketer"
    ),
    supports: {
        align: true,
        html: false,
        reusable: false,
        multiple: false
    },
    category: "media",
    icon: {
        foreground: "#007bff",
        src: "heading"
    },
    keywords: [__("heading", "diymarketer"), __("h1", "diymarketer")],
    edit: () => {
        return <p>Editorssss</p>;
    },
    save: () => {
        return <p>Saved Content</p>;
    }
});
