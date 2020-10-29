import { registerPlugin } from "@wordpress/plugins";
import { PluginDocumentSettingPanel } from "@wordpress/edit-post";
import { TextControl, TextareaControl } from "@wordpress/components";
import { withSelect, withDispatch } from "@wordpress/data";
import { __ } from "@wordpress/i18n";
//import { compose } from "@wordpress/compose";
import { compose } from "@wordpress/compose";

import "./sidebar.scss";

let PluginMetaFields = ({ onMetaChange, meta }) => {
    return (
        <>
            <TextControl
                value={meta.title}
                label={__("Page Title", "diy-marketer")}
                onChange={value => onMetaChange(value, meta.description)}
            />
            <p>
                Max 70 characters, <span className="diym-seo-count">{meta.title.length}</span>
            </p>
            <TextareaControl
                value={meta.description}
                label={__("Page Description", "diy-marketer")}
                onChange={value => onMetaChange(meta.title, value)}
            />
            <p>
                Max 144 characters,{" "}
                <span className="diym-seo-count">{meta.description.length}</span>
            </p>
            {meta.title.length > 0 && <span className="diym-seo-title">{meta.title}</span>}
            {meta.description.length > 0 && (
                <p className="diym-seo-description">{meta.description}</p>
            )}
        </>
    );
};

PluginMetaFields = compose([
    withSelect(select => {
        return {
            meta: select("core/editor").getEditedPostAttribute("meta")["_diym_post_meta"]
        };
    }),
    withDispatch(dispatch => {
        return {
            onMetaChange: (title, description) => {
                dispatch("core/editor").editPost({
                    meta: { _diym_post_meta: { title, description } }
                });
            }
        };
    })
])(PluginMetaFields);

registerPlugin("diym-sidebar", {
    icon: null,
    render: () => {
        return (
            <>
                <PluginDocumentSettingPanel title={__("SEO", "diy-marketer")}>
                    <PluginMetaFields />
                </PluginDocumentSettingPanel>
            </>
        );
    }
});
