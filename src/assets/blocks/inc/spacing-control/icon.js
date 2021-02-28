import { isArray } from "lodash";

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

export default function BoxControlIcon({
    size = 24,
    //side,
    side = ["top", "right", "bottom", "left"],
    ...props
}) {
    let sides = {};

    if (isArray(side)) {
        side.forEach(e => {
            sides[e] = true;
        });
    } else {
        sides[side] = true;
    }

    // Simulates SVG Icon scaling
    const scale = size / BASE_ICON_SIZE;

    const { top, bottom, left, right } = sides;

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
