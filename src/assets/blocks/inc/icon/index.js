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
    getActiveFormat,
    getActiveObject,
    insertObject,
    toHTMLString
} from "@wordpress/rich-text";
import { Popover } from "@wordpress/components";
import classnames from "classnames";
import IconPicker2 from "../icon-picker2";
import { __ } from "@wordpress/i18n";
//import { plusCircle } from "@wordpress/icons";
import { getRectangleFromRange } from "@wordpress/dom";

// styles
import "./editor.scss";

import { SVG, Path } from "@wordpress/primitives";

const customChar = (
    <SVG xmlns="http://www.w3.org/2000/svg" viewBox="-2 -2 24 24">
        <Path d="M10 5.4c1.27 0 2.24.36 2.91 1.08c.66.71 1 1.76 1 3.13c0 1.28-.23 2.37-.69 3.27c-.47.89-1.27 1.52-2.22 2.12v2h6v-2h-3.69c.92-.64 1.62-1.34 2.12-2.34c.49-1.01.74-2.13.74-3.35c0-1.78-.55-3.19-1.65-4.22S11.92 3.54 10 3.54s-3.43.53-4.52 1.57c-1.1 1.04-1.65 2.44-1.65 4.2c0 1.21.24 2.31.73 3.33c.48 1.01 1.19 1.71 2.1 2.36H3v2h6v-2c-.98-.64-1.8-1.28-2.24-2.17c-.45-.89-.67-1.96-.67-3.22c0-1.37.33-2.41 1-3.13C7.75 5.76 8.72 5.4 10 5.4z" />
    </SVG>
);

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

//$(document).ready(function () {
//console.log("ready");
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
//});

let anchorRange;

registerFormatType("diym/icon", {
    title: __("Icon", "diy-marketer"),
    tagName: "inserticon",
    className: null,
    active: false,
    // edit.
    edit({ isActive, value, onChange }) {
        const onToggle = () => {
            // Set up the anchorRange when the Popover is opened.
            const selection = window.getSelection();
            anchorRange = selection.rangeCount > 0 ? selection.getRangeAt(0) : null;
            onChange(
                toggleFormat(value, {
                    type: "diym/icon"
                })
            );
        };

        // Pin the Popover to the caret position.
        const anchorRect = () => {
            return getRectangleFromRange(anchorRange);
        };

        //const onChangeIcon = v => {
        //console.log(value);
        //console.log(v);
        //wp.richText.create({ html: '<i class="fas fa-home"></i>' });
        //onChange(
        //insert(
        //value,
        //create({ html: `<i class='${v.name}' data-content='${v.unicode}'>&nbsp;</i>&nbsp;</i` })
        //create({ html: `<i class='fas fa-home' />` })
        //)
        //);
        //};

        //create()

        //console.log(isActive);
        if (isActive) {
            //$(".diym-icon-picker").height("300px");

            //onst t = () => {
            //  console.log("hello world");
            //};

            return (
                <Popover
                    //className="diym-icon-popover"
                    position="center"
                    //focusOnMount="container"
                    //key="charmap-popover"
                    onClick={() => {}}
                    getAnchorRect={anchorRect}
                    //onFocusOutside={() => {
                    //return false;
                    //onChange(toggleFormat(value, { type: "diym/icon" }));
                    //}}
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
                            //console.log(icon);
                            //onChangeIcon(icon);
                            //console.log(value);
                            //let y = getActiveFormat(value, "diym/icon");
                            //let y = getActiveObject(value);
                            console.log(value);

                            //getActiv
                            //onChange(toggleFormat(value, { type: "diym/icon" }));

                            onChange(
                                insert(
                                    value,
                                    create({
                                        html: icon
                                    })
                                )
                            );
                            //toggleFormat(value, { type: "diym/icon" })
                            //);

                            // onChange(toggleFormat(value, { type: "diym/icon" }));
                        }}
                    ></IconPicker2>
                </Popover>
            );
            //console.log("hello world!");
        }

        //console.log(value);

        return (
            <>
                <RichTextShortcut type="primary" character="i" onUse={onToggle} />
                <RichTextToolbarButton
                    title="Insert icon"
                    onClick={onToggle}
                    isActive={isActive}
                    shortcutType="primary"
                    shortcutCharacter="i"
                    //icon={plusCircle}
                    icon={customChar}
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
