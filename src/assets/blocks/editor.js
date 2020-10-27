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

import "./inc/meta";
import "./plugins/sidebar";

// prevent user from deleting meta block...
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
