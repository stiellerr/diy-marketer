import { registerPlugin } from "@wordpress/plugins";
import { PluginDocumentSettingPanel } from "@wordpress/edit-post";
import { TextControl, TextareaControl } from "@wordpress/components";
import { withSelect, withDispatch } from "@wordpress/data";
import { __ } from "@wordpress/i18n";
//import { compose } from "@wordpress/compose";
import { compose } from "@wordpress/compose";

import "./sidebar.scss";

let PluginMetaFields = props => {
    return (
        <>
            <TextControl
                value={props.meta.title}
                label={__("Page Title", "diy-marketer")}
                onChange={value => props.onMetaChange(value, props.meta.description)}
            />
            <TextareaControl
                value={props.meta.description}
                label={__("Page Description", "diy-marketer")}
                onChange={value => props.onMetaChange(props.meta.title, value)}
            />
            <span className="diym-seo-title">{props.meta.title}</span>
            <span className="diym-seo-description">{props.meta.description}</span>
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
