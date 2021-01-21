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
    __experimentalLinkControl as LinkControl,
    DimensionControl
} from "@wordpress/block-editor";

//import { __experimentalNumberControl as NumberControl } from "@wordpress/components";
//import { NumberControl } from "@wordpress/components";

import { partialRight } from "lodash";

import {
    CustomSelectControl,
    RangeControl,
    AlignmentMatrixControl,
    Button,
    ButtonGroup,
    KeyboardShortcuts,
    PanelBody,
    TextControl,
    ToggleControl,
    ToolbarButton,
    ToolbarGroup,
    Popover
} from "@wordpress/components";
import { rawShortcut, displayShortcut } from "@wordpress/keycodes";
import {
    link,
    more,
    linkOff,
    positionLeft,
    positionRight,
    positionCenter,
    stretchWide,
    stretchFullWidth
} from "@wordpress/icons";

import "./editor.scss";

import classnames from "classnames";

import SpacingControl from "../spacing-control";

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
        title: __("Align button full"),
        align: "full"
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
    const {
        borderRadius,
        linkTarget,
        placeholder,
        rel,
        text,
        url,
        width,
        align,
        buttonSize,
        paddingSize,
        marginTop,
        marginBottom
    } = attributes;

    const updateSpacing = (dimension, size, device = "") => {
        setAttributes({
            [`${dimension}${device}`]: size
        });
    };

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

    //console.log(blockProps.style);

    const options = [
        {
            key: "sm",
            name: "Small",
            style: { fontSize: "75%" }
        },
        {
            key: "normal",
            name: "Normal",
            style: { fontSize: "100%" }
        },
        {
            key: "lg",
            name: "Large",
            style: { fontSize: "200%" }
        }
    ];

    return (
        <>
            <InspectorControls>
                <PanelBody title={__("Size", "diy-marketer")}>
                    <CustomSelectControl
                        label="Button Size"
                        options={options}
                        onChange={({ selectedItem }) =>
                            setAttributes({ buttonSize: selectedItem.key })
                        }
                        value={options.find(option => option.key === buttonSize)}
                    />
                </PanelBody>
                <PanelBody title={__("Spacing", "diy-marketer")}>
                    <SpacingControl
                        onChange={value => {
                            setAttributes(value);
                        }}
                        marginTop={marginTop || 0}
                        marginBottom={marginBottom || 0}
                    ></SpacingControl>
                </PanelBody>
            </InspectorControls>
            <BlockControls>
                <AlignmentToolbar
                    value={align}
                    alignmentControls={DEFAULT_ALIGNMENT_CONTROLS}
                    onChange={onChangeAlign}
                />
            </BlockControls>
            <div {...blockProps} style={"justify" !== align ? { textAlign: align } : undefined}>
                <RichText
                    aria-label={__("Button text")}
                    placeholder={placeholder || __("Add text…")}
                    value={text}
                    onChange={value => setAttributes({ text: value })}
                    withoutInteractiveFormatting
                    //className={classnames(className)}
                    style={{ ...blockProps.style }}
                    //style={"justify" === align ? { width: "100%" } : undefined}
                    identifier="text"
                    //textAlign={align}
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
