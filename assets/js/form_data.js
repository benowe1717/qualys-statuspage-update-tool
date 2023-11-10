function get_incident_title() {
    $(document).ready(function() {
        var platform = $("#incident-platform").val();
        var title = $("#incident-title").val();

        $.ajax({
            type: "POST",
            url: "/scripts/get_platform_name.php",
            data: {
                platform_id: platform
            },
            success: function(data) {
                var arr = JSON.parse(data);
                if(arr.platform_name != "None") {
                    reset_alert_box("incident");
                    $("#incident-alert").addClass("alert-success");
                    $("#incident-alert-text").text(arr.platform_name + ": " + title);
                    $("#incident-copy").val(arr.platform_name + ": " + title);
                    $("#incident-copy-button").removeClass("visually-hidden");
                } else {
                    reset_alert_box("incident");
                    $("#incident-alert").addClass("alert-danger");
                    $("#incident-alert-text").text("Error getting platform name!");
                }
            }
        });
    });
}

function get_incident_message() {
    $(document).ready(function() {
        var message = $("#incident-message").val();
        reset_alert_box("incident");
        $("#incident-alert").addClass("alert-success");
        $("#incident-alert-text").text(message);
        $("#incident-copy").val(message);
        $("#incident-copy-button").removeClass("visually-hidden");
    });
}

function get_maintenance_title() {
    $(document).ready(function() {
        var platform = $("#maintenance-platform").val();
        var title = $("#maintenance-title").val();
        
        $.ajax({
            type: "POST",
            url: "/scripts/get_platform_name.php",
            data: {
                platform_id: platform
            },
            success: function(data) {
                var arr = JSON.parse(data);
                if(arr.platform_name != "None") {
                    reset_alert_box("maintenance");
                    $("#maintenance-alert").addClass("alert-success");
                    $("#maintenance-alert-text").text(arr.platform_name + ": " + title);
                    $("#maintenance-copy").val(arr.platform_name + ": " + title);
                    $("#maintenance-copy-button").removeClass("visually-hidden");
                } else {
                    reset_alert_box("maintenance");
                    $("#maintenance-alert").addClass("alert-danger");
                    $("#maintenance-alert-text").text("Error getting platform name!");
                }
            }
        });
    });
}

function get_maintenance_details() {
    $(document).ready(function() {
        var ticket = $("#maintenance-ticket").val();
        var message = $("#maintenance-message").val();
        var ref_link = $("#maintenance-ref-link").val();
        
        $.ajax({
            type: "POST",
            url: "/scripts/validate_maintenance_details.php",
            data: {
                ticket: ticket,
                ref: ref_link,
                message: message
            },
            success: function(data) {
                var arr = JSON.parse(data);
                if(arr.ticket_status == 1 && arr.ref_status == 1) {
                    reset_alert_box("maintenance");
                    $("#maintenance-alert").addClass("alert-success");
                    // var formatted_message = build_maintenance_message(ticket, message, ref_link);
                    $("#maintenance-alert").text(arr.message);
                    $("#maintenance-copy").val(arr.message);
                    $("#maintenance-copy-button").removeClass("visually-hidden");
                } else {
                    reset_alert_box("maintenance");
                    $("#maintenance-alert").addClass("alert-danger");
                    $("#maintenance-alert-text").text("Ticket Number of Reference Link are invalid!");
                }
            },
            error: function(data) {
                var arr = JSON.parse(data);
                reset_alert_box("maintenance");
                $("#maintenance-alert").addClass("alert-danger");
                $("#maintenance-alert-text").text(arr.message);
            }
        });
    });
}

function build_maintenance_message(ticket, message, ref) {
    var msg = '<div class="scheduled_maintenance">';
    var msg = msg + '<p class="ticket_no">' + ticket + '</p>';
    var msg = msg + '<p class="message">' + message + '</p>';
    var msg = msg + '<p class="reference_link">' + ref + '</p>';
    var msg = msg + '</div>';
    return msg;
}

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