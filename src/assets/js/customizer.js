import $ from "jquery";

$(document).ready(function () {
    /**
     * Dropdown Select2 Custom Control
     *
     * @author Anthony Hortin <http://maddisondesigns.com>
     * @license http://www.gnu.org/licenses/gpl-2.0.html
     * @link https://github.com/maddisondesigns
     */
    $(".customize-control-dropdown-select2").each(function () {
        $(".customize-control-select2").select2({
            allowClear: true
        });
    });

    $(".customize-control-select2").on("change", function () {
        var select2Val = $(this).val();
        $(this)
            .parent()
            .find(".customize-control-dropdown-select2")
            .val(select2Val)
            .trigger("change");
    });

    /**
     * Google Font Select Custom Control
     *
     * @author Anthony Hortin <http://maddisondesigns.com>
     * @license http://www.gnu.org/licenses/gpl-2.0.html
     * @link https://github.com/maddisondesigns
     */
    $(".google-fonts-list").each(function (i, obj) {
        if (!$(obj).hasClass("select2-hidden-accessible")) {
            $(obj).select2();
        }
    });

    $(".google-fonts-list").on("change", function () {
        var elementRegularWeight = $(this)
            .parent()
            .parent()
            .find(".google-fonts-regularweight-style");
        var elementItalicWeight = $(this)
            .parent()
            .parent()
            .find(".google-fonts-italicweight-style");
        var elementBoldWeight = $(this).parent().parent().find(".google-fonts-boldweight-style");
        var selectedFont = $(this).val();
        var customizerControlName = $(this).attr("control-name");
        var elementItalicWeightCount = 0;
        var elementBoldWeightCount = 0;

        // Clear Weight/Style dropdowns
        elementRegularWeight.empty();
        elementItalicWeight.empty();
        elementBoldWeight.empty();
        // Make sure Italic & Bold dropdowns are enabled
        elementItalicWeight.prop("disabled", false);
        elementBoldWeight.prop("disabled", false);

        // Get the Google Fonts control object
        var bodyfontcontrol = _wpCustomizeSettings.controls[customizerControlName];

        // Find the index of the selected font
        var indexes = $.map(bodyfontcontrol.skyrocketfontslist, function (obj, index) {
            if (obj.family === selectedFont) {
                return index;
            }
        });
        var index = indexes[0];

        // For the selected Google font show the available weight/style variants
        $.each(bodyfontcontrol.skyrocketfontslist[index].variants, function (val, text) {
            elementRegularWeight.append($("<option></option>").val(text).html(text));
            if (text.indexOf("italic") >= 0) {
                elementItalicWeight.append($("<option></option>").val(text).html(text));
                elementItalicWeightCount++;
            } else {
                elementBoldWeight.append($("<option></option>").val(text).html(text));
                elementBoldWeightCount++;
            }
        });

        if (elementItalicWeightCount == 0) {
            elementItalicWeight.append(
                $("<option></option>").val("").html("Not Available for this font")
            );
            elementItalicWeight.prop("disabled", "disabled");
        }
        if (elementBoldWeightCount == 0) {
            elementBoldWeight.append(
                $("<option></option>").val("").html("Not Available for this font")
            );
            elementBoldWeight.prop("disabled", "disabled");
        }

        // Update the font category based on the selected font
        $(this)
            .parent()
            .parent()
            .find(".google-fonts-category")
            .val(bodyfontcontrol.skyrocketfontslist[index].category);

        skyrocketGetAllSelects($(this).parent().parent());
    });

    $(".google_fonts_select_control select").on("change", function () {
        skyrocketGetAllSelects($(this).parent().parent());
    });

    function skyrocketGetAllSelects($element) {
        var selectedFont = {
            font: $element.find(".google-fonts-list").val(),
            regularweight: $element.find(".google-fonts-regularweight-style").val(),
            italicweight: $element.find(".google-fonts-italicweight-style").val(),
            boldweight: $element.find(".google-fonts-boldweight-style").val(),
            category: $element.find(".google-fonts-category").val()
        };

        // Important! Make sure to trigger change event so Customizer knows it has to save the field
        $element
            .find(".customize-control-google-font-selection")
            .val(JSON.stringify(selectedFont))
            .trigger("change");
    }
});
