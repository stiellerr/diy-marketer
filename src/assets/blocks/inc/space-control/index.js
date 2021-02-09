import { noop } from "lodash";
import { isEmpty, isNumber } from "lodash";

/**
 * WordPress dependencies
 */
import { Button, TextControl, Flex, FlexItem, FlexBlock } from "@wordpress/components";
import { link, linkOff } from "@wordpress/icons";
import { useState } from "@wordpress/element";
import { __ } from "@wordpress/i18n";

import BoxControlIcon from "./icon";

//import InputControls from "./input-controls";
const DEFAULT_VALUES = {
    top: null,
    bottom: null,
    left: null,
    right: null
};

export function SpaceControl({ onChange = noop, values = DEFAULT_VALUES }) {
    //
    const [side, setSide] = useState("top");

    const [isLinked, setIsLinked] = useState(false);

    const { top, right, bottom, left } = values;

    const getAllValues = values => {
        const allValues = Object.values(values).map(value => parseInt(value));

        const value = allValues.every(v => v === allValues[0]) ? allValues[0] : "";

        const allValue = isNumber(value) ? value : null;

        return allValue;
    };

    const createHandleOnFocus = side => () => {
        setSide(side);
    };

    const createHandleOnChange = side => next => {
        const nextValues = { ...values };

        if ("all" !== side) {
            nextValues[side] = next;
        } else {
            nextValues.top = next;
            nextValues.bottom = next;
            nextValues.left = next;
            nextValues.right = next;
        }

        onChange(nextValues);
    };

    const props = {
        type: "number",
        min: 0,
        max: 5,
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
                            onChange={createHandleOnChange("all")}
                            onFocus={createHandleOnFocus("all")}
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
                        ></TextControl>
                    </FlexBlock>
                    <FlexBlock>
                        <TextControl
                            {...props}
                            label={__("Right", "diy-marketer")}
                            onChange={createHandleOnChange("right")}
                            onFocus={createHandleOnFocus("right")}
                            value={right}
                        ></TextControl>
                    </FlexBlock>
                    <FlexBlock>
                        <TextControl
                            {...props}
                            label={__("Bottom", "diy-marketer")}
                            onChange={createHandleOnChange("bottom")}
                            onFocus={createHandleOnFocus("bottom")}
                            value={bottom}
                        ></TextControl>
                    </FlexBlock>
                    <FlexBlock>
                        <TextControl
                            {...props}
                            label={__("Left", "diy-marketer")}
                            onChange={createHandleOnChange("left")}
                            onFocus={createHandleOnFocus("left")}
                            value={left}
                        ></TextControl>
                    </FlexBlock>
                </Flex>
            )}
        </>
    );
}
