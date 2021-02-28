import { __ } from "@wordpress/i18n";
import { useCallback, useState } from "@wordpress/element";
import {
    RichText,
    withColors,
    BlockControls,
    AlignmentToolbar,
    PanelColorSettings,
    ContrastChecker
} from "@wordpress/block-editor";
import {
    InspectorControls,
    useBlockProps,
    __experimentalLinkControl as LinkControl
} from "@wordpress/block-editor";

import { select, useSelect, withSelect } from "@wordpress/data";

import {
    FontSizePicker,
    KeyboardShortcuts,
    PanelBody,
    ToolbarButton,
    ToolbarGroup,
    Popover,
    PanelRow
} from "@wordpress/components";
import { rawShortcut, displayShortcut } from "@wordpress/keycodes";
import { link, linkOff } from "@wordpress/icons";

import "./editor.scss";

import { SpacingControl, getEditorSpacing } from "../spacing-control";
import { BLOCK_ALIGNMENT_CONTROLS, SPACING_LEVELS, BUTTON_SIZES } from "../helper";

const NEW_TAB_REL = "noreferrer noopener";

function URLPicker({
    isSelected,
    url,
    setAttributes,
    opensInNewTab,
    onToggleOpenInNewTab,
    anchorRef
}) {
    const [isURLPickerOpen, setIsURLPickerOpen] = useState(false);
    const urlIsSet = !!url;
    const urlIsSetandSelected = urlIsSet && isSelected;
    const openLinkControl = () => {
        setIsURLPickerOpen(true);
        return false; // prevents default behaviour for event
    };
    const unlinkButton = () => {
        setAttributes({
            url: undefined,
            linkTarget: undefined,
            rel: undefined
        });
        setIsURLPickerOpen(false);
    };
    const linkControl = (isURLPickerOpen || urlIsSetandSelected) && (
        <Popover
            position="bottom center"
            onClose={() => setIsURLPickerOpen(false)}
            anchorRef={anchorRef?.current}
        >
            <LinkControl
                className="wp-block-navigation-link__inline-link-input"
                value={{ url, opensInNewTab }}
                onChange={({ url: newURL = "", opensInNewTab: newOpensInNewTab }) => {
                    setAttributes({ url: newURL });

                    if (opensInNewTab !== newOpensInNewTab) {
                        onToggleOpenInNewTab(newOpensInNewTab);
                    }
                }}
            />
        </Popover>
    );
    return (
        <>
            <BlockControls>
                <ToolbarGroup>
                    {!urlIsSet && (
                        <ToolbarButton
                            name="link"
                            icon={link}
                            title={__("Link")}
                            shortcut={displayShortcut.primary("k")}
                            onClick={openLinkControl}
                        />
                    )}
                    {urlIsSetandSelected && (
                        <ToolbarButton
                            name="link"
                            icon={linkOff}
                            title={__("Unlink")}
                            shortcut={displayShortcut.primaryShift("k")}
                            onClick={unlinkButton}
                            isActive={true}
                        />
                    )}
                </ToolbarGroup>
            </BlockControls>
            {isSelected && (
                <KeyboardShortcuts
                    bindGlobal
                    shortcuts={{
                        [rawShortcut.primary("k")]: openLinkControl,
                        [rawShortcut.primaryShift("k")]: unlinkButton
                    }}
                />
            )}
            {linkControl}
        </>
    );
}

// return parents
/*
const getParents = clientId => {
    //
    const parents = useSelect(
        select => select("core/block-editor").getBlockParentsByBlockName(clientId, "diym/form"),
        []
    );

    if (parents.length) {
        return true;
    }

    return false;
};
*/

function ButtonEdit(props) {
    const {
        //context,
        attributes,
        setAttributes,
        isSelected,
        textColor,
        buttonColor,
        setTextColor,
        setButtonColor,
        clientId
    } = props;
    const {
        type,
        linkTarget,
        rel,
        text,
        url,
        textAlign,
        buttonSize,
        spacing,
        className
    } = attributes;

    //console.log(hasParents(clientId));

    const onToggleOpenInNewTab = useCallback(
        value => {
            const newLinkTarget = value ? "_blank" : undefined;

            let updatedRel = rel;
            if (newLinkTarget && !rel) {
                updatedRel = NEW_TAB_REL;
            } else if (!newLinkTarget && rel === NEW_TAB_REL) {
                updatedRel = undefined;
            }

            setAttributes({
                linkTarget: newLinkTarget,
                rel: updatedRel
            });
        },
        [rel, setAttributes]
    );

    const spacingStyles = getEditorSpacing(isSelected, spacing);

    const blockProps = useBlockProps({
        style: {
            textAlign: "center" === textAlign || "right" === textAlign ? textAlign : undefined,
            ...spacingStyles
            //paddingTop: spacingTop ? SPACING_LEVELS[spacingTop] : undefined,
            //paddingBottom: spacingBottom ? SPACING_LEVELS[spacingBottom] : undefined
        }
    });

    const setType = () => {
        const parents = useSelect(
            select => select("core/block-editor").getBlockParentsByBlockName(clientId, "diym/form"),
            []
        );
        //
        if (parents.length) {
            setAttributes({ type: "submit" });
        }
    };
    //
    setType();

    return (
        <>
            <InspectorControls>
                <PanelBody title={__("Size", "diy-marketer")}>
                    <FontSizePicker
                        fontSizes={BUTTON_SIZES}
                        value={buttonSize}
                        disableCustomFontSizes={true}
                        onChange={buttonSize => {
                            setAttributes({ buttonSize });
                        }}
                    />
                </PanelBody>
                <PanelBody title={__("Spacing", "diy-marketer")} initialOpen={false}>
                    <SpacingControl
                        values={spacing}
                        onChange={spacing => {
                            setAttributes(spacing);
                        }}
                        onReset={() => {
                            setAttributes({
                                spacing: {
                                    top: undefined,
                                    bottom: undefined,
                                    left: undefined,
                                    right: undefined
                                }
                            });
                        }}
                    ></SpacingControl>
                </PanelBody>
                <PanelColorSettings
                    title={__("Color settings", "diy-marketer")}
                    colorSettings={[
                        {
                            label: __("Text Color", "diy-marketer"),
                            value: textColor.color,
                            onChange: setTextColor,
                            disableAlpha: false
                        },
                        {
                            label: __("Button Color", "diy-marketer"),
                            disableCustomColors: true,
                            value: buttonColor.color,
                            onChange: setButtonColor
                        }
                    ]}
                ></PanelColorSettings>
                <ContrastChecker
                    textColor={textColor.color}
                    backgroundColor={className !== "is-style-outline" ? buttonColor.color : "#fff"}
                />
            </InspectorControls>
            <BlockControls>
                <AlignmentToolbar
                    value={textAlign}
                    alignmentControls={BLOCK_ALIGNMENT_CONTROLS}
                    onChange={textAlign => {
                        setAttributes({ textAlign });
                    }}
                />
            </BlockControls>
            <div {...blockProps}>
                <RichText
                    aria-label={__("Button text", "diy-marketer")}
                    placeholder={__("Add text…", "diy-marketer")}
                    value={text}
                    onChange={text => setAttributes({ text })}
                    withoutInteractiveFormatting
                    style={{
                        color: textColor.color,
                        backgroundColor: buttonColor.color,
                        borderColor: buttonColor.color,
                        width: "full" === textAlign ? "100%" : null,
                        fontSize: buttonSize || null
                    }}
                    identifier="text"
                    textAlign={textAlign}
                />
            </div>
            {"submit" !== type && (
                <URLPicker
                    url={url}
                    setAttributes={setAttributes}
                    isSelected={isSelected}
                    opensInNewTab={linkTarget === "_blank"}
                    onToggleOpenInNewTab={onToggleOpenInNewTab}
                    anchorRef={blockProps.ref}
                />
            )}
        </>
    );
}

export default withColors("textColor", "buttonColor")(ButtonEdit);
