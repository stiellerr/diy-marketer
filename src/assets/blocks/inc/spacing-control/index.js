/**
 * External dependencies
 */
import {
    noop,
    isNumber,
    uniq,
    isArray,
    has,
    valuesIn,
    capitalize,
    forIn,
    pickBy,
    isEmpty,
    keysIn
} from "lodash";

/**
 * WordPress dependencies
 */
import {
    Button,
    TextControl,
    Flex,
    FlexItem,
    FlexBlock,
    __experimentalText as Text
} from "@wordpress/components";

import { link, linkOff } from "@wordpress/icons";
import { useState } from "@wordpress/element";
import { __ } from "@wordpress/i18n";

/**
 * Internal dependencies
 */
import BoxControlIcon from "./icon";

// constants
const SPACING_LEVELS = ["0rem", "0.25rem", "0.5rem", "1rem", "1.5rem", "3rem"];

/*
const DEFAULT_VALUES = {
    top: null,
    bottom: null,
    left: null,
    right: null
};
*/

export function SpacingControl({ onChange = noop, onReset = noop, values = {} }) {
    //
    const KEYS = keysIn(values);

    const [side, setSide] = useState(KEYS);

    const { top, right, bottom, left } = values;

    const isUnique = () => {
        const uniques = uniq(valuesIn(values));

        if (1 === uniques.length) {
            if (isNumber(uniques[0])) {
                return uniques[0];
            }
            return true;
        }
        return false;
    };

    const [isLinked, setIsLinked] = useState(isUnique);

    const createHandleOnFocus = side => () => {
        setSide(side);
    };

    const createHandleOnChange = side => next => {
        //
        let nextValue = { ...values };

        if (isArray(side)) {
            side.forEach(e => {
                nextValue[e] = parseInt(next, 10);
            });
        } else {
            nextValue[side] = parseInt(next, 10);
        }

        onChange(nextValue);
    };

    const props = {
        type: "number",
        min: 0,
        max: 5,
        step: 1,
        style: { width: "auto" },
        autoComplete: "off",
        inputMode: "numeric"
    };

    // onClick={onReset()}

    return (
        <>
            <Flex style={{ paddingBottom: "8px" }}>
                <FlexItem>
                    <Text>Spacing Control</Text>
                </FlexItem>
                <FlexItem>
                    <Button
                        isSecondary
                        isSmall
                        onClick={() => {
                            onReset(null);
                            //console.log("hi");
                        }}
                    >
                        Reset
                    </Button>
                </FlexItem>
            </Flex>
            <Flex>
                <FlexItem>
                    <BoxControlIcon side={side}></BoxControlIcon>
                </FlexItem>
                {isLinked && (
                    <FlexBlock style={{ marginTop: "8px" }}>
                        <TextControl
                            {...props}
                            onChange={createHandleOnChange(KEYS)}
                            onFocus={createHandleOnFocus(KEYS)}
                            style={{ maxWidth: "58px" }}
                            value={isUnique()}
                        ></TextControl>
                    </FlexBlock>
                )}
                <FlexItem>
                    <Button
                        isSmall
                        isPrimary={isLinked}
                        isSecondary={!isLinked}
                        icon={isLinked ? link : linkOff}
                        iconSize={16}
                        onClick={() => {
                            setIsLinked(!isLinked);
                        }}
                    ></Button>
                </FlexItem>
            </Flex>
            {!isLinked && (
                <Flex style={{ paddingTop: "8px" }}>
                    <FlexBlock>
                        <TextControl
                            {...props}
                            label={__("Top", "diy-marketer")}
                            onChange={createHandleOnChange("top")}
                            onFocus={createHandleOnFocus("top")}
                            value={top}
                            readOnly={!has(values, "top")}
                        ></TextControl>
                    </FlexBlock>
                    <FlexBlock>
                        <TextControl
                            {...props}
                            label={__("Right", "diy-marketer")}
                            onChange={createHandleOnChange("right")}
                            onFocus={createHandleOnFocus("right")}
                            value={right}
                            readOnly={!has(values, "right")}
                        ></TextControl>
                    </FlexBlock>
                    <FlexBlock>
                        <TextControl
                            {...props}
                            label={__("Bottom", "diy-marketer")}
                            onChange={createHandleOnChange("bottom")}
                            onFocus={createHandleOnFocus("bottom")}
                            value={bottom}
                            readOnly={!has(values, "bottom")}
                        ></TextControl>
                    </FlexBlock>
                    <FlexBlock>
                        <TextControl
                            {...props}
                            label={__("Left", "diy-marketer")}
                            onChange={createHandleOnChange("left")}
                            onFocus={createHandleOnFocus("left")}
                            value={left}
                            readOnly={!has(values, "left")}
                        ></TextControl>
                    </FlexBlock>
                </Flex>
            )}
        </>
    );
}

export function getEditorSpacing(borders = {}, isSelected = false) {
    let styles = {};

    forIn(borders, (value, key) => {
        if (isNumber(value)) {
            styles[`border${capitalize(key)}Width`] = SPACING_LEVELS[value];
        }
    });

    if (isEmpty(styles)) {
        return;
    }

    styles.border = "0 solid";
    styles.borderColor = isSelected ? "rgba(128, 128, 128, 0.3)" : "transparent";

    return styles;
}

function groupSpacing(spacing = {}) {
    //
    spacing = pickBy(spacing, isNumber);

    if (isEmpty(spacing)) {
        return false;
    }

    const values = valuesIn(spacing);
    const uniques = uniq(values);

    if (values.length > 1 && 1 === uniques.length) {
        return `-${uniques[0]}`;
    }

    let arr = [];

    forIn(spacing, (val, key) => {
        arr.push(`${key[0]}-${val}`);
    });

    return arr;
}

export function getFrontEndSpacing(spacing = {}, pre = "m") {
    //
    const { top, bottom, left, right } = spacing;

    let y = groupSpacing({ top, bottom });
    let x = groupSpacing({ left, right });

    let arr = [];

    if (x) {
        if (y) {
            if (x === y) {
                return pre + x;
            }
            arr = [...(isArray(x) ? x : ["x" + x]), ...(isArray(y) ? y : ["y" + y])];
        } else {
            arr = isArray(x) ? x : ["x" + x];
        }
    } else if (y) {
        arr = isArray(y) ? y : ["y" + y];
    } else {
        return;
    }

    // add prefix to all elements
    arr = arr.map(v => {
        return pre + v;
    });

    return arr.join(" ");
}
