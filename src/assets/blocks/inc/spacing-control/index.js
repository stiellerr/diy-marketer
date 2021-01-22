/**
 * WordPress dependencies
 */
import { Button, TextControl } from "@wordpress/components";
import { __ } from "@wordpress/i18n";

import "./editor.scss";

export function getMarginClass(marginTop, marginBottom) {
    //
    if (undefined === marginTop && undefined == marginBottom) {
        return null;
    }

    if (marginTop === marginBottom) {
        return `my-${marginTop}`;
    }

    if (marginTop === marginBottom) {
        return `my-${marginTop}`;
    }

    if (undefined === marginTop) {
        return `mb-${marginBottom}`;
    }

    if (undefined === marginBottom) {
        return `mt-${marginTop}`;
    }

    return `mt-${marginTop} mb-${marginBottom}`;
}

export function SpacingControl({ marginTop, marginBottom, onChange }) {
    const updateSpacing = (newMarginTop, newMarginBottom) => {
        return () => {
            onChange({ marginTop: newMarginTop, marginBottom: newMarginBottom });
        };
    };

    return (
        <>
            <div className="diym-spacing-control">
                <TextControl
                    type="number"
                    label={__("Top", "diy-marketer")}
                    onChange={value => onChange({ marginTop: parseInt(value, 10) })}
                    min={0}
                    max={5}
                    value={Number.isInteger(marginTop) ? marginTop : ""}
                    autoComplete="off"
                ></TextControl>
                <TextControl
                    type="number"
                    label={__("Bottom", "diy-marketer")}
                    onChange={value => onChange({ marginBottom: parseInt(value, 10) })}
                    min={0}
                    max={5}
                    value={Number.isInteger(marginBottom) ? marginBottom : ""}
                    autoComplete="off"
                ></TextControl>
            </div>
            <div className="diym-spacing-control__button">
                <Button isSmall isSecondary onClick={updateSpacing()}>
                    {__("Reset", "diy-marketer")}
                </Button>
            </div>
        </>
    );
}
