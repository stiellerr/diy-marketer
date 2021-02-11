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
    side = ["top", "right", "bottom", "left"],
    ...props
}) {
    //
    const SIDES = {
        top: undefined,
        bottom: undefined,
        left: undefined,
        right: undefined
    };

    if (isArray(side)) {
        side.forEach(e => {
            SIDES[e] = true;
        });
    } else {
        SIDES[side] = true;
    }

    // Simulates SVG Icon scaling
    const scale = size / BASE_ICON_SIZE;

    return (
        <Root style={{ transform: `scale(${scale})` }} {...props}>
            <Viewbox>
                <TopStroke isFocused={SIDES.top} />
                <RightStroke isFocused={SIDES.right} />
                <BottomStroke isFocused={SIDES.bottom} />
                <LeftStroke isFocused={SIDES.left} />
            </Viewbox>
        </Root>
    );
}
