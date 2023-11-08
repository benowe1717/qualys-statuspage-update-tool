function get_incident_title() {
    $(document).ready(function() {
        var platform = $("#incident-platform").val();
        var title = $("#incident-title").val();
        console.log(platform + ": " + title);
    });
}

function get_incident_message() {
    $(document).ready(function() {
        var message = $("#incident-message").val();
        console.log(message);
    });
}

function get_maintenance_title() {
    $(document).ready(function() {
        var platform = $("#maintenance-platform").val();
        var title = $("#maintenance-title").val();
        console.log(platform + ": " + title);
    });
}

function get_maintenance_details() {
    $(document).ready(function() {
        var ticket = $("#maintenance-ticket").val();
        var message = $("#maintenance-message").val();
        var ref_link = $("#maintenance-ref-link").val();
        console.log("Ticket: " + ticket + " :: Message: " + message + " :: Reference Link: " + ref_link);
    });
}