function reset_form(form_id) {
    $(":input", form_id).not(
        ":button, :submit, :reset, :hidden"
    ).val("").prop("checked", false).prop(
        "selected", false
    ).toggleClass("form-error", false);

    $("#statusPageOutput").text("");
    $("#statusPageOutput").addClass("visually-hidden");
    $("#title-copy-button").text("Copy to Clipboard");
    $("#title-copy-button").addClass("visually-hidden");
    $("#message-copy-button").text("Copy to Clipboard");
    $("#message-copy-button").addClass("visually-hidden");
}

$(document).ready(function() {
    $("#incident_update_form_reset_form").on("click", function() {
        reset_form("#incident-form");
    });

    $("#maintenance_update_form_reset_form").on("click", function() {
        reset_form("#maintenance-form");
    })
});
