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
const SPACING_LEVELS = ["0", "0.25rem", "0.5rem", "1rem", "1.5rem", "3rem"];

export function SpacingControl({ onChange = noop, onReset = noop, values = {} }) {
    const KEYS = keysIn(values);

    const [side, setSide] = useState(KEYS);

    const { top, right, bottom, left } = values;

    const isUnique = (includeUndef = false) => {
        //
        const uniques = uniq(valuesIn(values));

        console.log(uniques);

        if (1 === uniques.length) {
            if (includeUndef) {
                return true;
            }
            if (isNumber(uniques[0])) {
                return uniques[0];
            }
        }
        return "";
    };

    var hasValues = () => {
        let nextValue = { ...values };

        hasValues = true;

        forIn(nextValue, val => {
            if (isNumber(val)) {
                hasValues = false;
            }
        });
        return hasValues;
    };

    const [isLinked, setIsLinked] = useState(isUnique(true));

    const createHandleOnFocus = side => () => {
        setSide(side);
    };

    const checkValue = (old, newValue) => {
        const numb = parseInt(newValue, 10);

        if (isNumber(numb) && numb >= 0 && numb <= 5) {
            return numb;
        }
        return old;
    };

    const createHandleOnChange = side => next => {
        //
        let nextValue = { ...values };

        if (isArray(side)) {
            side.forEach(e => {
                nextValue[e] = checkValue(nextValue[e], next);
            });
        } else {
            nextValue[side] = checkValue(nextValue[side], next);
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

    return (
        <>
            <Flex style={{ paddingBottom: "8px" }}>
                <FlexItem>
                    <Text>{__("Spacing Control", "diy-marketer")}</Text>
                </FlexItem>
                <FlexItem>
                    <Button
                        isSecondary
                        isSmall
                        onClick={() => {
                            onReset();
                            if (isUnique(true)) {
                                console.log(1);
                            } else {
                                console.log(2);
                            }
                            //console.log(isUnique(true));
                            setIsLinked(isUnique(true) || false);
                        }}
                        disabled={hasValues()}
                    >
                        {__("Reset", "diy-marketer")}
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

    styles.borderTopWidth = 0;
    styles.borderBottomWidth = 0;
    styles.borderLeftWidth = 0;
    styles.borderRightWidth = 0;

    styles.borderStyle = "solid";
    styles.borderColor = isSelected ? "rgba(128, 128, 128, 0.3)" : "transparent";

    forIn(borders, (value, key) => {
        //if (isNumber(value)) {
        if (value) {
            styles[`border${capitalize(key)}Width`] = SPACING_LEVELS[value];
        }
    });

    return styles;
}

function groupSpacing(spacing = {}) {
    spacing = pickBy(spacing);

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
