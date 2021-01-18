import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
import { useCallback, useState } from "@wordpress/element";
import { RichText, BlockControls, AlignmentToolbar } from "@wordpress/block-editor";
import {
    withColors,
    InspectorControls,
    PanelColorSettings,
    ContrastChecker,
    useBlockProps,
    __experimentalLinkControl as LinkControl
} from "@wordpress/block-editor";

import {
    Button,
    ButtonGroup,
    KeyboardShortcuts,
    PanelBody,
    RangeControl,
    TextControl,
    ToggleControl,
    ToolbarButton,
    ToolbarGroup,
    Popover
} from "@wordpress/components";
import { rawShortcut, displayShortcut } from "@wordpress/keycodes";
import {
    link,
    linkOff,
    positionLeft,
    positionRight,
    positionCenter,
    stretchWide,
    stretchFullWidth
} from "@wordpress/icons";

import "./editor.scss";

import classnames from "classnames";

const NEW_TAB_REL = "noreferrer noopener";

const DEFAULT_ALIGNMENT_CONTROLS = [
    {
        icon: positionLeft,
        title: __("Align button left"),
        align: "left"
    },
    {
        icon: positionCenter,
        title: __("Align button center"),
        align: "center"
    },
    {
        icon: positionRight,
        title: __("Align button right"),
        align: "right"
    },
    {
        icon: stretchWide,
        title: __("Align button wide"),
        align: "justify"
    }
];

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

    const { attributes, setAttributes, className, isSelected, onReplace, mergeBlocks } = props;
    const { borderRadius, linkTarget, placeholder, rel, text, url, width, align } = attributes;

    console.log(className);

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

    console.log(url);

    const onChangeAlign = align => {
        setAttributes({ align });
    };
    //const blockProps = useBlockProps();
    //console.log(blockProps.className);

    //let style = align === "justify" ? { width: "100%" } : { textAlign: align };

    //console.log(style);<div {...blockProps} style={"justify" !== align ? { textAlign: align } : undefined}>

    const blockProps = useBlockProps();

    console.log(blockProps);

    return (
        <>
            <BlockControls>
                <AlignmentToolbar
                    value={align}
                    alignmentControls={DEFAULT_ALIGNMENT_CONTROLS}
                    onChange={onChangeAlign}
                />
            </BlockControls>
            <div {...blockProps}>
                <RichText
                    aria-label={__("Button text")}
                    placeholder={placeholder || __("Add text…")}
                    value={text}
                    onChange={value => setAttributes({ text: value })}
                    withoutInteractiveFormatting
                    className={classnames(className)}
                    style={"justify" === align ? { width: "100%" } : undefined}
                    identifier="text"
                    textAlign={align}
                />
            </div>
            <URLPicker
                url={url}
                setAttributes={setAttributes}
                isSelected={isSelected}
                opensInNewTab={linkTarget === "_blank"}
                onToggleOpenInNewTab={onToggleOpenInNewTab}
                //anchorRef={blockProps.ref}
            />
        </>
    );
}

export default ButtonEdit;
