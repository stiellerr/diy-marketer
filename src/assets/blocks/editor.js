/* eslint no-unused-vars: off */

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

// register blocks.
import heading from "./inc/heading";
import subhead from "./inc/subhead";
import paragraph from "./inc/paragraph";
import image from "./inc/image";
import benefit from "./inc/benefit";
//import font_awesome_picker from "./inc/font-awesome-picker";

//import "./inc/meta";
import "./plugins/sidebar";

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

import { select, subscribe } from "@wordpress/data";
const { isSavingPost } = select("core/editor");

var checked = true; // Start in a checked state.
subscribe(() => {
    if (isSavingPost()) {
        checked = false;
    } else {
        if (!checked) {
            // grab all blocks
            const blockList = wp.data.select("core/block-editor").getBlocks();

            let icons = [];

            blockList.forEach(({ name, attributes }) => {
                //console.log(block);
                if ("diym/benefit" === name) {
                    icons[attributes.icon] = 33;
                    //console.log(block.attributes);
                }
            });

            console.log(icons);
            checked = true;
        }
    }
});
