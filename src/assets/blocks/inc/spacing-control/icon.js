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
    side = ["spaceTop", "spaceRight", "spaceBottom", "spaceLeft"],
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

    const { spaceTop, spaceBottom, spaceLeft, spaceRight } = sides;

    return (
        <Root style={{ transform: `scale(${scale})` }} {...props}>
            <Viewbox>
                <TopStroke isFocused={spaceTop} />
                <RightStroke isFocused={spaceRight} />
                <BottomStroke isFocused={spaceBottom} />
                <LeftStroke isFocused={spaceLeft} />
            </Viewbox>
        </Root>
    );
}
