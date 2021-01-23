import { __ } from "@wordpress/i18n";
import { useCallback, useState } from "@wordpress/element";
import { RichText, BlockControls, AlignmentToolbar } from "@wordpress/block-editor";
import {
    InspectorControls,
    useBlockProps,
    __experimentalLinkControl as LinkControl
} from "@wordpress/block-editor";

import {
    FontSizePicker,
    KeyboardShortcuts,
    PanelBody,
    ToolbarButton,
    ToolbarGroup,
    Popover
} from "@wordpress/components";
import { rawShortcut, displayShortcut } from "@wordpress/keycodes";
import { link, linkOff } from "@wordpress/icons";

import "./editor.scss";

import { SpacingControl } from "../spacing-control";
import { BLOCK_ALIGNMENT_CONTROLS, MARGINS } from "../helper";

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

function ButtonEdit(props) {
    console.log(props);

    const { attributes, setAttributes, isSelected } = props;
    const {
        linkTarget,
        rel,
        text,
        url,
        textAlign,
        buttonSize,
        marginTop,
        marginBottom
    } = attributes;

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

    const blockProps = useBlockProps({
        style: {
            width: "full" === textAlign ? "100%" : null,
            fontSize: buttonSize || null
        }
    });

    const buttonSizes = [
        {
            name: __("Small", "diy-marketer"),
            slug: "btn-sm",
            size: 14
        },
        {
            name: __("Large", "diy-marketer"),
            slug: "btn-lg",
            size: 20
        }
    ];

    return (
        <>
            <InspectorControls>
                <PanelBody title={__("Size", "diy-marketer")}>
                    <FontSizePicker
                        fontSizes={buttonSizes}
                        value={buttonSize}
                        disableCustomFontSizes={true}
                        onChange={buttonSize => {
                            setAttributes({ buttonSize });
                        }}
                    />
                </PanelBody>
                <PanelBody title={__("Spacing", "diy-marketer")} initialOpen={false}>
                    <SpacingControl
                        onChange={value => {
                            setAttributes(value);
                        }}
                        marginTop={marginTop}
                        marginBottom={marginBottom}
                    ></SpacingControl>
                </PanelBody>
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
            <div
                {...blockProps}
                style={{
                    textAlign: "center" === textAlign || "right" === textAlign ? textAlign : null,
                    paddingTop: MARGINS[marginTop],
                    paddingBottom: MARGINS[marginBottom]
                }}
            >
                <RichText
                    aria-label={__("Button text", "diy-marketer")}
                    placeholder={__("Add text…", "diy-marketer")}
                    value={text}
                    onChange={text => setAttributes({ text })}
                    withoutInteractiveFormatting
                    style={{ ...blockProps.style }}
                    identifier="text"
                    textAlign={textAlign}
                />
            </div>
            <URLPicker
                url={url}
                setAttributes={setAttributes}
                isSelected={isSelected}
                opensInNewTab={linkTarget === "_blank"}
                onToggleOpenInNewTab={onToggleOpenInNewTab}
                anchorRef={blockProps.ref}
            />
        </>
    );
}

export default ButtonEdit;
