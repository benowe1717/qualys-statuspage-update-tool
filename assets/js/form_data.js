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
                    $("#incident-alert-text").html();
                    $("#incident-alert").removeClass("alert-danger");
                    $("#incident-alert").addClass("alert-success");
                    $("#incident-alert-text").text(arr.platform_name + ": " + title);
                } else {
                    $("#incident-alert-text").html();
                    $("#incident-alert").removeClass("alert-success");
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
        $("#incident-alert-text").html();
        $("#incident-alert").removeClass("alert-danger");
        $("#incident-alert").addClass("alert-success");
        $("#incident-alert-text").text(message);
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
                    $("#maintenance-alert-text").html();
                    $("#maintenance-alert").removeClass("alert-danger");
                    $("#maintenance-alert").addClass("alert-success");
                    $("#maintenance-alert-text").text(arr.platform_name + ": " + title);
                } else {
                    $("#maintenance-alert-text").html();
                    $("#maintenance-alert").removeClass("alert-success");
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
                ref: ref_link
            },
            success: function(data) {
                var arr = JSON.parse(data);
                if(arr.ticket_status == 1 && arr.ref_status == 1) {
                    $("#maintenance-alert-text").html();
                    $("#maintenance-alert").removeClass("alert-danger");
                    $("#maintenance-alert").addClass("alert-success");
                    var formatted_message = build_maintenance_message(ticket, message, ref_link);
                    $("#maintenance-alert").text(formatted_message);
                } else {
                    $("#maintenance-alert-text").html();
                    $("#maintenance-alert").removeClass("alert-success");
                    $("#maintenance-alert").addClass("alert-danger");
                    $("#maintenance-alert-text").text("Ticket Number of Reference Link are invalid!");
                }
            }
        });
    });
}

function build_maintenance_message(ticket, message, ref) {
    var message = '<div class="scheduled_maintenance">';
    var message = message + '<p class="ticket_no">' + ticket + '</p>';
    var message = message + '<p class="message">' + message + '</p>';
    var message = message + '<p class="reference_link">' + ref + '</p>';
    var message = message + '</div>';
    return message;
}