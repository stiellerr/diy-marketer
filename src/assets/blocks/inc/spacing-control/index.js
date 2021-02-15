/**
 * External dependencies
 */
import {
    noop,
    isNumber,
    uniq,
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
    isEqual,
    uniqBy
    //keys
    //values
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
    withFocusReturn
} from "@wordpress/components";
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

function groupSpacing(spacing = {}) {
    //
    spacing = pickBy(spacing, isNumber);

    if (isEmpty(spacing)) {
        return false;
    }

    const values = valuesIn(spacing);
    const uniques = uniq(values);

    if (values.length > 1 && uniques.length === 1) {
        return uniques[0];
    }

    //let obj = {};
    let arr = [];

    forIn(spacing, (val, key) => {
        //obj[key[0]] = val;
        arr.push(`${key[0]}-${val}`);
    });

    return arr;
}

export function getFrontEndSpacing(spacing = {}, pre = "m") {
    //
    const { top, bottom, left, right } = spacing;

    let x = groupSpacing({ top, bottom });
    let y = groupSpacing({ left, right });

    x = isArray(x) ? x : [`x-${1}`];
    y = isArray(y) ? y : [`y-${y}`];

    let arr = [];

    if (x) {
        if (y) {
            if (isEqual(x, y)) {
                return `${pre}-${x}`;
            }
            arr = [...x, ...y];
        }
        arr = x;
    } else if (y) {
        arr = y;
    }

    console.log(arr);

    //return str;

    //console.log(ttt);
    //const { top, bottom, left, right} = spacing;
    //
    //spacing = pickBy(spacing, isNumber);

    //if (isEmpty(spacing)) {
    //return;
    //}
    //const { top, bottom, left, right } = spacing;
    //
    //const x = { top, bottom };
    //const y = { left, right };
    /*

    const values = valuesIn(spacing);
    const uniques = uniq(values);

    const { top, bottom, left, right } = spacing

    if (1 === uniques.length) {
        if ( 4 === values.length ) {
            return `m-${uniques[0]}`;
        }
        if ( 2 === values.length ) {
            if (top  )
        }
    }

    let arr = [];

    //const

    if (4 === size(spacing)) {
        
        //const { top, bottom, left, right } = spacing
        
        // y axis...
        arr.push(getFrontEndSpacing({top, bottom}));
        arr.push(getFrontEndSpacing({left, right}));

        return arr;
    }
*/
    //}
    //const { top, bottom, left, right } = spacing;
    //if (top === bottom)
    //if
    //}
    //uniques = uniqBy({ top, bottom }, isNumber);
    //if (1 === uniques.length) {
    //return `m-${uniques[0]}`;
    //}
    //console.log(size(spacing));
    //console.log(spacing);
    //if isEmpty(next2) {
    //return;
    //}
    //console.log(next2);
    //
    //console.log(next);
    //let margin = false;
    //margin =
    //
    /*
    if (getSpacingClass(valuesIn(next))) {
        console.log("true");
    } else {
        console.log("false");
    }

    if (getSpacingClass([next.top, next.bottom])) {
        console.log("true");
    } else {
        console.log("false");
    }
    */
    //
    //
    /*
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
*/
    //console.log(uniqWith(nextSpacing, isEqual));
    //uniqBy();
    //console.log(nextSpacing.top);
    //if (isEmpty(nextSpacing)) {
    //return;
    //}
    //
    //if (4 === size(nextSpacing) && 1 === uniqBy(nextSpacing).length) {
    //  console.log(11);
    //}
    //if
    //if (spacing.top &&  )
    //if( nextSpacing.top == )
    //console.log(nextSpacing);
    //console.log("efault exit");
    //return;
}
