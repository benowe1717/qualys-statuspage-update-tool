$(document).ready(function() {
    $("#incident-title-button").on("click", function() {
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
            var platform = form_data[0].value;
            var title = form_data[1].value;

            $.ajax({
                type: "POST",
                url: "/scripts/get_platform_name.php",
                data: {
                    platform_id: platform
                },
                success: function(data) {
                    var arr = JSON.parse(data);
                    if(arr.platform_name !== "None") {
                        reset_alert_box("incident");
                        $("#" + div).toggleClass("alert-success", true);
                        $("#" + div).toggleClass("alert-danger", false);
                        $("#" + span).text(arr.platform_name + ": " + title);
                        $("#incident-copy").val(arr.platform_name + ": " + title);
                        $("#incident-copy-button").toggleClass("visually-hidden", false);
                    } else {
                        reset_alert_box("incident");
                        $("#" + div).toggleClass("alert-danger", true);
                        $("#" + div).toggleClass("alert-success", false);
                        $("#" + span).text("Error getting platform name!");
                        $("#incident-copy-button").toggleClass("visually-hidden", true);
                    }
                },
                error: function(data) {
                    reset_alert_box("incident");
                    $("#" + div).toggleClass("alert-danger", true);
                    $("#" + div).toggleClass("alert-success", false);
                    $("#" + span).text("ERROR: Unable to generate Title! Check your browser's console for logs");
                    console.log(data);
                }
            })
        }
    });
});