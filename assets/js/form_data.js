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
                    $("#alert-text").html();
                    $("#alert").removeClass("alert-danger");
                    $("#alert").addClass("alert-success");
                    $("#alert-text").html(arr.platform_name + ": " + title);
                } else {
                    $("#alert-text").html();
                    $("#alert").removeClass("alert-success");
                    $("#alert").addClass("alert-danger");
                    $("#alert-text").html("Error getting platform name!");
                }
            }
        });
    });
}

function get_incident_message() {
    $(document).ready(function() {
        var message = $("#incident-message").val();
        $("#alert-text").html();
        $("#alert").removeClass("alert-danger");
        $("#alert").addClass("alert-success");
        $("#alert-text").html(message);
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
                    $("#alert-text").html();
                    $("#alert").removeClass("alert-danger");
                    $("#alert").addClass("alert-success");
                    $("#alert-text").html(arr.platform_name + ": " + title);
                } else {
                    $("#alert-text").html();
                    $("#alert").removeClass("alert-success");
                    $("#alert").addClass("alert-danger");
                    $("#alert-text").html("Error getting platform name!");
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
                    $("#alert-text").html();
                    $("#alert").removeClass("alert-danger");
                    $("#alert").addClass("alert-success");
                    var formatted_message = build_maintenance_message(ticket, message, ref_link);
                    $("#alert").html(formatted_message);
                } else {
                    $("#alert-text").html();
                    $("#alert").removeClass("alert-success");
                    $("#alert").addClass("alert-danger");
                    $("#alert-text").html("Ticket Number of Reference Link are invalid!");
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