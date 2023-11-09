function reset_form(form_id) {
    $(":input", form_id).not(
        ":button, :submit, :reset, :hidden"
    ).val("").prop("checked", false).prop(
        "selected", false
    );

    if(form_id == "#incident") {
        $("#incident-alert").removeClass("alert-danger");
        $("#incident-alert").removeClass("alert-success");
        $("#incident-alert").html('<span id="incident-alert-text"></span>');
        $("#incident-copy-button").text("Copy to Clipboard");
        $("#incident-copy-button").addClass("visually-hidden");
    } else if(form_id == "#maintenance") {
        $("#maintenance-alert").removeClass("alert-danger");
        $("#maintenance-alert").removeClass("alert-success");
        $("#maintenance-alert").html('<span id="maintenance-alert-text"></span>');
        $("#maintenance-copy-button").text("Copy to Clipboard");
        $("#maintenance-copy-button").addClass("visually-hidden");
    }
}