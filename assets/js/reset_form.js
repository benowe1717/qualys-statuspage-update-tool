function reset_form(form_id) {
    $(":input", form_id).not(
        ":button, :submit, :reset, :hidden"
    ).val("").prop("checked", false).prop(
        "selected", false
    ).toggleClass("form-error", false);

    if(form_id == "#incident") {
        $("#incident-alert").removeClass("alert-danger");
        $("#incident-alert").removeClass("alert-success");
        $("#incident-alert-text").text("");
        $("#incident-copy-button").text("Copy to Clipboard");
        $("#incident-copy-button").addClass("visually-hidden");
    } else if(form_id == "#maintenance") {
        $("#maintenance-alert").removeClass("alert-danger");
        $("#maintenance-alert").removeClass("alert-success");
        $("#maintenance-alert-text").text("");
        $("#maintenance-copy-button").text("Copy to Clipboard");
        $("#maintenance-copy-button").addClass("visually-hidden");
    }
}