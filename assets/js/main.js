function reset_alert_box(name) {
    if(name == "incident") {
        $("#incident-alert").removeClass("alert-danger");
        $("#incident-alert").removeClass("alert-success");
        $("#incident-alert").html('<span id="incident-alert-text"></span>');
        $("#incident-copy").val("");
        $("#incident-copy-button").text("Copy to Clipboard");
    } else if(name == "maintenance") {
        $("#maintenance-alert").removeClass("alert-danger");
        $("#maintenance-alert").removeClass("alert-success");
        $("#maintenance-alert").html('<span id="maintenance-alert-text"></span>');
        $("#maintenance-copy").val("");
        $("#maintenance-copy-button").text("Copy to Clipboard");
    }
}

function display_error(id) {
    // toggle error class on
    // display error message
}