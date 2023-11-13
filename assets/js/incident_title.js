$(document).ready(function() {
    $("#incident-title-button").on("click", function() {
        var form = $(this).parents("form");
        var form_data = $(form).serializeArray();
        var split = this.split("-");

        if(split[0] === "incident") {
            var span = "incident-alert-text";
        } else if(split[0] === "maintenance") {
            var span = "maintenance-alert-text";
        }

        for(const element of form_data) {
            if(element.value === "") {
                $("#" + element.name).toggleClass("form-error");
                $("#" + span).text("Missing form value(s)!");
            } else {
                $("#" + element.name).toggleClass("form-error");
                $("#" + span).text("");
            }
        }
    });
});