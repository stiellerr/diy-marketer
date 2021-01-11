/* global */

import $ from "jquery";

/**
 * External dependencies
 */
//import { compose, ifCondition } from "@wordpress/compose";
//import { withSelect, withDispatch, select, subscribe } from "@wordpress/data";
//import { select, subscribe } from "@wordpress/data";
//import { RichTextToolbarButton } from "@wordpress/editor";
import { RichTextShortcut, RichTextToolbarButton } from "@wordpress/block-editor";
import {
    toggleFormat,
    registerFormatType,
    insert,
    create,
    insertObject,
    toHTMLString
} from "@wordpress/rich-text";
import { Popover } from "@wordpress/components";
import classnames from "classnames";
import IconPicker2 from "../icon-picker2";
import { __ } from "@wordpress/i18n";

// styles
import "./editor.scss";

//import { tree } from "gulp";
//import { get } from "lodash";
/*
const unsubscribe = subscribe(() => {
    const underlineFormat = select("core/rich-text").getFormatType("core/underline");
    if (!underlineFormat) {
        return;
    }
    unsubscribe();
    const settings = unregisterFormatType("core/underline");
    */

$(document).ready(function () {
    console.log("ready");
    /*
    wp.customizerRepeater.init();

    $(".iconpicker-search").on("keyup", function () {
        wp.customizerRepeater.search($(this));
    });

    $(".icp-auto").on("click", function () {
        wp.customizerRepeater.iconPickerToggle($(this));
    });

    $(document).mouseup(function (e) {
        var container = $(".iconpicker-popover");

        if (!container.is(e.target) && container.has(e.target).length === 0) {
            container.removeClass("iconpicker-visible");
        }
    });
    */
});

registerFormatType("diym/icon", {
    title: __("Inline Icon", "diy-marketer"),
    tagName: "inlineicon",
    className: null,
    active: false,
    // edit.
    edit({ isActive, value, onChange }) {
        const onChangeIcon = v => {
            console.log(value);
            console.log(v);
            //wp.richText.create({ html: '<i class="fas fa-home"></i>' });
            onChange(
                insert(
                    value,
                    //create({ html: `<i class='${v.name}' data-content='${v.unicode}'>&nbsp;</i>&nbsp;</i` })
                    create({ html: `<i class='fas fa-home' />` })
                )
            );
        };

        //create()

        //console.log(isActive);
        if (isActive) {
            //$(".diym-icon-picker").height("300px");

            return (
                <Popover
                    //className="diym-icon-popover"
                    position="middle center"
                    //focusOnMount="container"
                    //key="charmap-popover"
                    onClick={() => {}}
                    onFocusOutside={() => {
                        //return false;
                        onChange(toggleFormat(value, { type: "diym/icon" }));
                    }}
                    //getAnchorRect={ anchorRect }
                    //expandOnMobile={true}
                    //headerTitle={__("Insert Special Character", "diy-marketer")}
                    onClose={() => {
                        onChange(toggleFormat(value, { type: "diym/icon" }));
                    }}
                >
                    {/*}
                    <IconPicker onChange={onChangeIcon} value={{ unicode: "f033" }}></IconPicker> */}
                    <IconPicker2
                        onSelect={icon => {
                            //console.log("zzz");
                            console.log(icon);
                            //onChangeIcon(icon);
                            console.log(value);

                            onChange(
                                insert(
                                    value,
                                    create({
                                        html: icon
                                    })
                                )
                            );

                            //onChange(toggleFormat(value, { type: "diym/icon" }));
                        }}
                    ></IconPicker2>
                </Popover>
            );
            //console.log("hello world!");
        }

        //console.log(value);

        const onToggle = () =>
            onChange(
                //insertObject(value, { type: "diym/icon" })
                //insert(value, { formats: "diym/icon", text: "&nbsp;" })
                //insert(value, "hello world!!!")
                //insert(value, create({ html: `<i class='fas fa-home' data-content=''></i>&nbsp;` }))

                //"zzz"
                toggleFormat(value, {
                    type:
                        "diym/icon" /*,
                    attributes: {
                        style: "text-decoration: underline;"
                    }*/
                })
            );

        return (
            <>
                <RichTextShortcut type="primary" character="i" onUse={onToggle} />
                <RichTextToolbarButton
                    icon="insert"
                    title="Inline icon"
                    onClick={onToggle}
                    isActive
                    shortcutType="primary"
                    shortcutCharacter="i"
                />
            </>
        );
    }
});
//});

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
