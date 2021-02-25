/**
 * External dependencies
 */
import {
    noop,
    isNumber,
    uniq,
    isArray,
    valuesIn,
    forIn,
    pickBy,
    isEmpty,
    keysIn,
    mapValues
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

export function SpacingControl({ onChange = noop, onReset = noop, values = {}, defaults = {} }) {
    // merge values with defaults

    defaults = {
        ...mapValues(values, () => {
            return 0;
        }),
        ...defaults
    };

    // merge defaults...
    const mergedValues = {
        ...defaults,
        ...pickBy(values, isNumber)
    };

    const SIDES = keysIn(mergedValues);

    const [side, setSide] = useState(SIDES);

    const { spaceTop, spaceRight, spaceBottom, spaceLeft } = mergedValues;

    const isDefault = () => {
        //
        const uniques = uniq(valuesIn(values));

        if (1 === uniques.length) {
            if (undefined === uniques[0]) {
                return true;
            }
        }

        return false;
    };

    const isUnique2 = obj => {
        //
        const uniques = uniq(valuesIn(obj));

        if (1 === uniques.length) {
            return true;
        }
        return false;
    };

    const isUnique3 = () => {
        //
        const uniques = uniq(valuesIn(mergedValues));

        if (1 === uniques.length) {
            if (isNumber(uniques[0])) {
                return uniques[0];
            }
        }
        return false;
    };

    //
    const [isLinked, setIsLinked] = useState(isUnique2(mergedValues));

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
                            setIsLinked(isUnique2(defaults));
                        }}
                        disabled={isDefault()}
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
                            onChange={createHandleOnChange(SIDES)}
                            onFocus={createHandleOnFocus(SIDES)}
                            style={{ maxWidth: "58px" }}
                            value={isUnique3() || ""}
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
                            setSide(SIDES);
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
                            onChange={createHandleOnChange("spaceTop")}
                            onFocus={createHandleOnFocus("spaceTop")}
                            value={spaceTop}
                            readOnly={!SIDES.includes("spaceTop")}
                        ></TextControl>
                    </FlexBlock>
                    <FlexBlock>
                        <TextControl
                            {...props}
                            label={__("Right", "diy-marketer")}
                            onChange={createHandleOnChange("spaceRight")}
                            onFocus={createHandleOnFocus("spaceRight")}
                            value={spaceRight}
                            readOnly={!SIDES.includes("spaceRight")}
                        ></TextControl>
                    </FlexBlock>
                    <FlexBlock>
                        <TextControl
                            {...props}
                            label={__("Bottom", "diy-marketer")}
                            onChange={createHandleOnChange("spaceBottom")}
                            onFocus={createHandleOnFocus("spaceBottom")}
                            value={spaceBottom}
                            readOnly={!SIDES.includes("spaceBottom")}
                        ></TextControl>
                    </FlexBlock>
                    <FlexBlock>
                        <TextControl
                            {...props}
                            label={__("Left", "diy-marketer")}
                            onChange={createHandleOnChange("spaceLeft")}
                            onFocus={createHandleOnFocus("spaceLeft")}
                            value={spaceLeft}
                            readOnly={!SIDES.includes("spaceLeft")}
                        ></TextControl>
                    </FlexBlock>
                </Flex>
            )}
        </>
    );
}

export function getEditorSpacing(isSelected = false, borders = {}, defaults = {}) {
    let styles = {};

    styles.borderTopWidth = 0;
    styles.borderBottomWidth = 0;
    styles.borderLeftWidth = 0;
    styles.borderRightWidth = 0;

    styles.borderStyle = "solid";
    styles.borderColor = isSelected ? "rgba(128, 128, 128, 0.3)" : "transparent";

    // merge defaults...
    borders = {
        ...defaults,
        ...pickBy(borders, isNumber)
        //...pickBy(borders)
    };

    forIn(borders, (value, key) => {
        if (value) {
            styles[`border${key.replace("space", "")}Width`] = SPACING_LEVELS[value];
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
        arr.push(`${key.replace("space", "")[0].toLowerCase()}-${val}`);
    });

    return arr;
}

export function getFrontEndSpacing(pre = "m", spacing = {}, defaults = {}) {
    // merge defaults...
    spacing = {
        ...defaults,
        ...pickBy(spacing)
    };
    //
    const { spaceTop, spaceBottom, spaceLeft, spaceRight } = spacing;

    let y = groupSpacing({ spaceTop, spaceBottom });
    let x = groupSpacing({ spaceLeft, spaceRight });

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
