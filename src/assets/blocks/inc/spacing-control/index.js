/**
 * WordPress dependencies
 */
import { Button, TextControl, Flex, FlexItem } from "@wordpress/components";
import { __ } from "@wordpress/i18n";

import "./editor.scss";

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

export function SpacingControl({ spacingTop, spacingBottom, onChange }) {
    const updateSpacing = (newSpacingTop, newSpacingBottom) => {
        return () => {
            onChange({ spacingTop: newSpacingTop, spacingBottom: newSpacingBottom });
        };
    };

    return (
        <>
            <Flex>
                <FlexItem>
                    <TextControl
                        type="number"
                        label={__("Top", "diy-marketer")}
                        onChange={value => onChange({ spacingTop: parseInt(value, 10) })}
                        min={0}
                        max={5}
                        value={Number.isInteger(spacingTop) ? spacingTop : ""}
                        autoComplete="off"
                    ></TextControl>
                    <TextControl
                        type="number"
                        label={__("Bottom", "diy-marketer")}
                        onChange={value => onChange({ spacingBottom: parseInt(value, 10) })}
                        min={0}
                        max={5}
                        value={Number.isInteger(spacingBottom) ? spacingBottom : ""}
                        autoComplete="off"
                    ></TextControl>
                </FlexItem>
            </Flex>
            {/*
            <div className="diym-spacing-control">
                <TextControl
                    type="number"
                    label={__("Top", "diy-marketer")}
                    onChange={value => onChange({ spacingTop: parseInt(value, 10) })}
                    min={0}
                    max={5}
                    value={Number.isInteger(spacingTop) ? spacingTop : ""}
                    autoComplete="off"
                ></TextControl>
                <TextControl
                    type="number"
                    label={__("Bottom", "diy-marketer")}
                    onChange={value => onChange({ spacingBottom: parseInt(value, 10) })}
                    min={0}
                    max={5}
                    value={Number.isInteger(spacingBottom) ? spacingBottom : ""}
                    autoComplete="off"
                ></TextControl>
            </div>
            <div className="diym-spacing-control__button">
                <Button isSmall isSecondary onClick={updateSpacing()}>
                    {__("Reset", "diy-marketer")}
                </Button>
            </div>
        */}
        </>
    );
}
