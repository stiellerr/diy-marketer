/**
 * External dependencies
 */
import { noop } from "lodash";

/**
 * Internal dependencies
 */
import { Flex, TextControl, FlexItem, FlexBlock, Autocomplete } from "@wordpress/components";
import { LABELS } from "./utils";
//import { __ } from "@wordpress/i18n/build-types";
//import { number } from "yargs";
//import { LayoutContainer, Layout } from "./styles/box-control-styles";

export default function BoxInputControls({
    onChange = noop,
    onFocus = noop,
    //onHoverOn = noop,
    //onHoverOff = noop,
    values,
    ...props
}) {
    const createHandleOnFocus = side => event => {
        onFocus(event, { side });
    };
    /*
    const createHandleOnHoverOn = side => () => {
        console.log(side);
        onHoverOn({ [side]: true });
    };

    const createHandleOnHoverOff = side => () => {
        console.log(side);
        onHoverOff({ [side]: false });
    };
*/
    const handleOnChange = nextValues => {
        onChange(nextValues);
    };

    const { top, right, bottom, left } = values;

    const createHandleOnChange = side => next => {
        //const { altKey } = event;
        const nextValues = { ...values };

        nextValues[side] = next;

        /**
         * Supports changing pair sides. For example, holding the ALT key
         * when changing the TOP will also update BOTTOM.
         */
        /*
        if (altKey) {
            switch (side) {
                case "top":
                    nextValues.bottom = next;
                    break;
                case "bottom":
                    nextValues.top = next;
                    break;
                case "left":
                    nextValues.right = next;
                    break;
                case "right":
                    nextValues.left = next;
                    break;
            }
        }
*/
        handleOnChange(nextValues);
    };

    const inputProps = {
        type: "number",
        min: 0,
        max: 5,
        style: { width: "auto" },
        autoComplete: "off"
    };

    return (
        <>
            <FlexBlock>
                <TextControl
                    {...inputProps}
                    label="Top"
                    onChange={createHandleOnChange("top")}
                    onFocus={createHandleOnFocus("top")}
                ></TextControl>
            </FlexBlock>
            <FlexBlock>
                <TextControl
                    {...inputProps}
                    label="Right"
                    onChange={createHandleOnChange("right")}
                    onFocus={createHandleOnFocus("right")}
                ></TextControl>
            </FlexBlock>
            <FlexBlock>
                <TextControl
                    {...inputProps}
                    label="Bottom"
                    onChange={createHandleOnChange("bottom")}
                    onFocus={createHandleOnFocus("bottom")}
                ></TextControl>
            </FlexBlock>
            <FlexBlock>
                <TextControl
                    {...inputProps}
                    label="Left"
                    onChange={createHandleOnChange("left")}
                    onFocus={createHandleOnFocus("left")}
                ></TextControl>
            </FlexBlock>
        </>
    );
}
