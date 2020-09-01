/**
 * External dependencies
 */
//import { compose, ifCondition } from "@wordpress/compose";
//import { withSelect, withDispatch, select, subscribe } from "@wordpress/data";
import { select, subscribe } from "@wordpress/data";
//import { RichTextToolbarButton } from "@wordpress/editor";
import { RichTextShortcut, RichTextToolbarButton } from "@wordpress/block-editor";
import { toggleFormat, registerFormatType, unregisterFormatType } from "@wordpress/rich-text";
//import { get } from "lodash";

const unsubscribe = subscribe(() => {
    const underlineFormat = select("core/rich-text").getFormatType("core/underline");
    if (!underlineFormat) {
        return;
    }
    unsubscribe();
    const settings = unregisterFormatType("core/underline");
    registerFormatType("diym/underline", {
        ...settings,
        name: "diym/underline",
        edit({ isActive, value, onChange }) {
            const onToggle = () =>
                onChange(
                    toggleFormat(value, {
                        type: "diym/underline",
                        attributes: {
                            style: "text-decoration: underline;"
                        }
                    })
                );

            return (
                <>
                    <RichTextShortcut type="primary" character="u" onUse={onToggle} />
                    <RichTextToolbarButton
                        icon="editor-underline"
                        title={settings.title}
                        onClick={onToggle}
                        isActive={isActive}
                        shortcutType="primary"
                        shortcutCharacter="u"
                    />
                </>
            );
        }
    });
});

/*
const RichTextJustifyButton = ({ blockId, isBlockJustified, updateBlockAttributes }) => {
    const onToggle = () =>
        updateBlockAttributes(blockId, { align: isBlockJustified ? null : "justify" });

    return (
        <RichTextToolbarButton
            icon="editor-justify"
            title={"justify"}
            onClick={onToggle}
            isActive={isBlockJustified}
        />
    );
};

const ConnectedRichTextJustifyButton = compose(
    withSelect(wpSelect => {
        const selectedBlock = wpSelect("core/editor").getSelectedBlock();
        if (!selectedBlock) {
            return {};
        }
        return {
            blockId: selectedBlock.clientId,
            blockName: selectedBlock.name,
            isBlockJustified: "justify" === get(selectedBlock, "attributes.align")
        };
    }),
    withDispatch(dispatch => ({
        updateBlockAttributes: dispatch("core/editor").updateBlockAttributes
    })),
    ifCondition(props => "core/paragraph" === props.blockName)
)(RichTextJustifyButton);

registerFormatType("diym2/justify", {
    title: "justify",
    tagName: "p",
    className: null,
    edit: ConnectedRichTextJustifyButton
});
*/
