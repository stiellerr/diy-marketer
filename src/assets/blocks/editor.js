/* eslint no-unused-vars: off */
/* global _ */

/*
import React from "react";
import ReactDom from "react-dom";
import MyComponent from "./components/MyComponent";

import "./index.scss";

ReactDom.render(
    React.createElement(MyComponent, { title: "hello" }),
    document.getElementById("root")
);
*/

//import paragraph from "./inc/paragraph";

import "./editor.scss";

// block underline control.
import underline from "./inc/underline";
import icon from "./inc/icon";

// register blocks.
import test from "./inc/aaatest";
import heading from "./inc/heading";
import subhead from "./inc/subhead";
//import paragraph from "./inc/paragraph";
import text from "./inc/text";
import image from "./inc/image";
import benefit from "./inc/benefit";
import offer from "./inc/offer";
import countdown from "./inc/countdown";
import button from "./inc/button";
//import font_awesome_picker from "./inc/font-awesome-picker";

//import "./inc/meta";
import "./plugins/sidebar";

/*
import { addFilter } from "@wordpress/hooks";

const replaceDefaultClassNames = (props, blockType, attributes) => {
    //console.log(blockType);
    //
    if ("diym/test" === blockType.name) {
        if (props.className) {
            //props.className = props.className.replace(/has-(display-1)-font-size/, "$&");
            props.className = props.className.replace(/has-(display-[1-6])-font-size/, "$1");
        }
        console.log(props);
        console.log(blockType);
        console.log(attributes);
    }

    return props;
};

wp.hooks.addFilter(
    "blocks.getSaveContent.extraProps",
    "diym/replace-default-classnames",
    replaceDefaultClassNames
);
*/

/*
import { addFilter } from "@wordpress/hooks";

function addBlockClassName(element, block, attributes) {
    if ("diym/image" == block.name) {
        //
        if (element.props.className) {
            element.props.className = element.props.className.replace("is-style-", "");

            //console.log(element.props.className);
        }
        //if( element.props )
        //console.log(element.props);
        //console.log(block);
        //console.log(attributes);
    }
    
    if (blockType.name === "core/list") {
        return Object.assign(props, { class: "wp-block-list" });
    }
    
    return element;
}

addFilter(
    //"blocks.getBlockDefaultClassName",
    "blocks.getSaveElement",
    "diym/add-block-class-name",
    addBlockClassName
);
*/

// prevent user from deleting meta block...
/*
const getBlockList = () => wp.data.select("core/block-editor").getBlocks();
let blockList = getBlockList();
wp.data.subscribe(() => {
    const newBlockList = getBlockList();
    if (
        newBlockList.length < blockList.length &&
        newBlockList.every(block => block.name !== "diym/meta")
    ) {
        wp.data.dispatch("core/block-editor").resetBlocks(blockList);
    }
    blockList = newBlockList;
});
*/
/*
import { select, dispatch, withDispatch, subscribe } from "@wordpress/data";
const { isSavingPost } = select("core/editor");

var checked = true; // Start in a checked state.
subscribe(() => {
    if (isSavingPost()) {
        //console.log("hi");
        checked = false;
    } else {
        if (!checked) {
            */
// grab all blocks
/*
            const blockList = select("core/block-editor").getBlocks();

            let iconsNew = [];

            blockList.forEach(({ name, attributes }) => {
                if ("diym/benefit" === name) {
                    // only add items with unique names...
                    if (!_.findWhere(iconsNew, { name: attributes.icon.name })) {
                        iconsNew.push({
                            name: attributes.icon.name,
                            unicode: attributes.icon.unicode
                        });
                    }
                }
            });

            const icons = select("core/editor").getEditedPostAttribute("meta")["_diym_fa"];

            console.log(icons);

            if (JSON.stringify(iconsNew) !== JSON.stringify(icons)) {
                dispatch("core/editor").editPost({ meta: { _diym_fa: iconsNew } });
                console.log("dispatch");
            }
            */

//zzzz("gggg");

/*
            withDispatch(dispatch => {
                console.log("aaaa");
                //dispatch("core/editor").editPost({ meta: { _diym_fa: icons } });
                dispatch("core/editor").editPost({ meta: { _diym_fa: "hello world!!!" } });
            });
            */

//dispatch('core/editor').editPost({meta: {_diym_fa: ['hello':'1']}})

//console.log(icons);
/*
            checked = true;
        }
    }
});
*/
/*
import { select, withDispatch, dispatch, subscribe } from "@wordpress/data";
const { isSavingPost } = select("core/editor");

let checked = false;

subscribe(() => {
    if (isSavingPost()) {
        if (checked === false) {
            checked = true;
            console.log("saving post...");
            dispatch("core/editor").editPost({ meta: { _diym_fa: [{ name: "fas fa-reece" }] } });
        }
        */

//console.log("saving post...");
//dispatch("core/editor").editPost({ meta: [{ _diym_fa: { hello: "1" } }] });
//withDispatch(dispatch => {
//console.log("aaaa");
//dispatch("core/editor").editPost({ meta: { _diym_fa: icons } });
//dispatch("core/editor").editPost({ meta: { _diym_fa: "hello world!!!" } });
//});

//checked = false;
//    }
//});
