/**
 * External dependencies
 */
import {
    noop,
    isNumber,
    //keys,
    isArray,
    has,
    valuesIn,
    capitalize,
    forIn,
    pickBy,
    isEmpty,
    size,
    uniqWith,
    isEqual
    //keys
    //values
} from "lodash";

/**
 * WordPress dependencies
 */
import { Button, TextControl, Flex, FlexItem, FlexBlock } from "@wordpress/components";
import { link, linkOff } from "@wordpress/icons";
import { useState } from "@wordpress/element";
import { __ } from "@wordpress/i18n";

/**
 * Internal dependencies
 */
import BoxControlIcon from "./icon";

//
export const SPACING_LEVELS = ["0rem", "0.25rem", "0.5rem", "1rem", "1.5rem", "3rem"];

//import InputControls from "./input-controls";

const DEFAULT_VALUES = {
    top: null,
    bottom: null,
    left: null,
    right: null
};

export function SpacingControl({ onChange = noop, values = DEFAULT_VALUES }) {
    //
    //console.log(values);

    const [side, setSide] = useState("top");

    const [isLinked, setIsLinked] = useState(false);

    const { top, right, bottom, left } = values;

    const getAllValues = values => {
        //
        //const allValues = Object.values(values);
        const allValues = valuesIn(values);

        const value = allValues.every(v => v === allValues[0]) ? allValues[0] : "";

        const allValue = isNumber(value) ? value : null;

        return allValue;
    };

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

    return (
        <>
            <Flex>
                <FlexItem>
                    <BoxControlIcon side={side}></BoxControlIcon>
                </FlexItem>
                {isLinked && (
                    <FlexBlock style={{ marginTop: "8px" }}>
                        <TextControl
                            {...props}
                            onChange={createHandleOnChange(keys(values))}
                            onFocus={createHandleOnFocus(keys(values))}
                            style={{ maxWidth: "58px" }}
                            value={getAllValues(values)}
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
                <Flex>
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

export function getMarginClass(spacingTop, spacingBottom) {
    //
    if (undefined === spacingTop && undefined == spacingBottom) {
        return null;
    }

    if (spacingTop === spacingBottom) {
        return `my-${spacingTop}`;
    }

    if (spacingTop === spacingBottom) {
        return `my-${spacingTop}`;
    }

    if (undefined === spacingTop) {
        return `mb-${spacingBottom}`;
    }

    if (undefined === spacingBottom) {
        return `mt-${spacingTop}`;
    }

    return `mt-${spacingTop} mb-${spacingBottom}`;
}

//
export function getEditorSpacing(borders = {}, isSelected = false) {
    //
    const styles = {
        border: "0 solid",
        borderColor: isSelected ? "rgba(128, 128, 128, 0.1)" : "transparent"
    };

    forIn(borders, (value, key) => {
        if (isNumber(value)) {
            styles[`border${capitalize(key)}Width`] = SPACING_LEVELS[value];
        }
    });

    return styles;
}

export function getFrontEndSpacing(spacing = {}) {
    //
    const keys = [];

    // pick out valid keys from object
    forIn(spacing, (value, key) => {
        if (value && isNumber(value)) {
            keys.push(key);
        }
    });

    console.log(keys);
    //
    const nextSpacing = pickBy(spacing, v => {
        if (v && isNumber(v)) {
            return true;
        }
    });

    console.log(uniqWith(nextSpacing, isEqual));

    //uniqBy();

    //console.log(nextSpacing.top);

    //if (isEmpty(nextSpacing)) {
    //return;
    //}

    //
    if (4 === size(nextSpacing) && 1 === uniqBy(nextSpacing).length) {
        console.log(11);
    }
    //if
    //if (spacing.top &&  )

    //if( nextSpacing.top == )

    console.log(nextSpacing);

    return;
}
