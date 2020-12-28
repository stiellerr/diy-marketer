import "./editor.scss";

import { registerBlockType } from "@wordpress/blocks";
import { __ } from "@wordpress/i18n";
//import { InnerBiocks } from "@wordpress/block-editor";
import { DateTimePicker } from "@wordpress/components";
import { RichText, InspectorControls } from "@wordpress/block-editor";
import { PanelBody, RadioControl } from "@wordpress/components";
//import { RadioControl } from '@wordpress/components';

//import "./inner";
import classnames from "classnames";

registerBlockType("diym/countdown", {
    title: __("Countdown", "diy-marketer"),
    description: __("Add a countdown timer.", "diy-marketer"),
    category: "diy-marketer",
    icon: {
        foreground: "#007bff",
        src: "clock"
    },
    keywords: [__("countdown", "diy-marketer")],
    parent: ["diym/offer"],
    supports: {
        html: false,
        reusable: false
        //className: false
    },
    attributes: {
        endTime: {
            type: "string",
            source: "attribute",
            selector: "div",
            attribute: "data-end-time"
            //default: "accent"
        },
        frequency: {
            type: "string",
            source: "attribute",
            selector: "div",
            attribute: "data-frequency",
            default: "3"
        }
    },
    edit: ({ attributes, setAttributes }) => {
        const { endTime, frequency } = attributes;

        //console.log(frequency);
        const onChangeDateTime = endTime => {
            //let d = new Date(dateTime);
            //console.log(d);
            setAttributes({ endTime });

            //console.log("dispatch");
            //}currentDate={myData}label="My Date/Time Picker"selected={option}setState({ option });
        };
        const onChangeFrequency = frequency => {
            //let d = new Date(dateTime);
            //console.log(d);
            setAttributes({ frequency });

            //console.log(frequency);
            //}currentDate={myData}label="My Date/Time Picker"selected={option}setState({ option });
        };
        return (
            <>
                <InspectorControls>
                    <PanelBody title={__("Datetime Picker", "diy-marketer")}>
                        <DateTimePicker
                            currentDate={endTime}
                            onChange={onChangeDateTime}
                            is12Hour={true}
                        ></DateTimePicker>
                        <RadioControl
                            label="Repeat Interval ?"
                            selected={frequency}
                            options={[
                                { label: "None", value: "1" },
                                { label: "Hourly", value: "2" },
                                { label: "Weekly", value: "3" },
                                { label: "Monthly", value: "4" },
                                { label: "Annually", value: "5" }
                            ]}
                            onChange={onChangeFrequency}
                        ></RadioControl>
                    </PanelBody>
                </InspectorControls>
                <div data-end-time={endTime} data-frequency={frequency}>
                    Countdown
                </div>
            </>
        );
    },
    save: ({ attributes }) => {
        const { endTime, frequency } = attributes;

        return (
            <>
                <div className="countdown" data-end-time={endTime} data-frequency={frequency}>
                    Countdown
                </div>
            </>
        );
    }
});
