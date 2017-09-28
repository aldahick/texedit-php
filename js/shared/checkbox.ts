/*
Author: Alex Hicks
Date Created: September 7, 2017
Filename: final/js/shared/checkbox.ts
*/
export namespace shared_checkbox {
    const $icon: JQuery = $("<span class='glyphicon glyphicon-unchecked checkbox-icon'>");
    function onCheckboxChange(this: HTMLInputElement): void {
        const $label: JQuery = $(this).parent()
            .removeClass("focus") // the focus class is ugly
            .find(".checkbox-icon")
                .toggleClass("glyphicon-ok glyphicon-unchecked");
        if (this.getAttribute("type") === "radio") {
            // uncheck all not-this in the group
            $(this).closest(".btn-group")
                .find("input").not(this)
                .siblings("span")
                .removeClass("glyphicon-ok")
                .addClass("glyphicon-unchecked");
        }
    }

    function setupCheckbox($label: JQuery): void {
        $label.find("input").on("change", onCheckboxChange);
        $label.prepend($icon.clone());
    }

    $(document).ready(() => {
        $("input[type='checkbox'],input[type='radio']").each((i, e) => {
            setupCheckbox($(e).parent());
        }).filter("[checked]").trigger("change").parent().addClass("active");
    });
}
