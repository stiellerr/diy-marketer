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
                value={props.subtitle}
                label={__("Page Title", "diy-marketer")}
                onChange={value => props.onSubtitleChange(value)}
            />
            <TextareaControl label={__("Page Description", "diy-marketer")} />

            <span className="diym-seo-title">{props.subtitle}</span>
        </>
    );
};

PluginMetaFields = compose([
    withSelect(select => {
        return {
            subtitle: select("core/editor").getEditedPostAttribute("meta")["_diym_seo_page_title"]
        };
    }),
    withDispatch(dispatch => {
        return {
            onSubtitleChange: subtitle => {
                dispatch("core/editor").editPost({ meta: { _diym_seo_page_title: subtitle } });
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
