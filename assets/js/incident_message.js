$(document).ready(function() {
    $("#incident-message-button").on("click", function() {
        var form = $(this).parents("form");
        var form_data = $(form).serializeArray();
        var button_name = $(this)[0].attributes.id.value;
        var split = button_name.split("-");

        if(split[0] === "incident") {
            var span = "incident-alert-text";
            var div = "incident-alert";
        } else if(split[0] === "maintenance") {
            var span = "maintenance-alert-text";
            var div = "maintenance-alert";
        }

        var i = 0;
        var len = form_data.length;
        for(const element of form_data) {
            if(element.value === "") {
                $("#" + element.name).toggleClass("form-error", true);
                $("#" + span).text("Missing form value(s)!");
                $("#" + div).toggleClass("alert-danger", true);
            } else {
                $("#" + element.name).toggleClass("form-error", false);
                $("#" + span).text("");
                $("#" + div).toggleClass("alert-danger", false);
                i++;
            }
        }

        if(i === len) {
            var message = form_data[2].value;

            reset_alert_box("incident");
            $("#" + div).toggleClass("alert-success", true);
            $("#" + div).toggleClass("alert-danger", false);
            $("#" + span).text(message);
            $("#incident-copy").val(message);
            $("#incident-copy-button").toggleClass("visually-hidden", false);
        }
    });
});