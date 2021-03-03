/**
 * Internal dependencies
 */

import {
    Root,
    Viewbox,
    TopStroke,
    RightStroke,
    BottomStroke,
    LeftStroke
} from "./box-control-icon-styles"; //"./styles/box-control-icon-styles";

const BASE_ICON_SIZE = 24;

export default function BoxControlIcon({ size = 24, side = "all", ...props }) {
    const top = getSide(side, "top");
    const right = getSide(side, "right");
    const bottom = getSide(side, "bottom");
    const left = getSide(side, "left");

    // Simulates SVG Icon scaling
    const scale = size / BASE_ICON_SIZE;

    return (
        <Root style={{ transform: `scale(${scale})` }} {...props}>
            <Viewbox>
                <TopStroke isFocused={top} />
                <RightStroke isFocused={right} />
                <BottomStroke isFocused={bottom} />
                <LeftStroke isFocused={left} />
            </Viewbox>
        </Root>
    );
}

function getSide(side, value) {
    return side === "all" || side === value;
}
