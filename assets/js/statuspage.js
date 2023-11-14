var statuspage = {
    init: function() {
        statuspage.form_error = "form-error";
        statuspage.alert_error = "alert-danger";
        statuspage.alert_success = "alert-success";
        statuspage.hide = "visually-hidden";
    },

    highlight_input: function(id, status) {
        $("#" + id).toggleClass(statuspage.form_error, status);
    },

    show_success_message: function(alert_div, alert_message_span, copy_button, msg) {
        $(alert_div).toggleClass(statuspage.alert_error, false);
        $(alert_div).toggleClass(statuspage.alert_success, true);
        $(alert_message_span).text(msg);
        $(copy_button).toggleClass(statuspage.hide, false);
    },

    show_error_message: function(alert_div, alert_message_span, copy_button, msg) {
        $(alert_div).toggleClass(statuspage.alert_error, true);
        $(alert_div).toggleClass(statuspage.alert_success, false);
        $(alert_message_span).text(msg);
        $(copy_button).toggleClass(statuspage.hide, true);
    },

    clear_error_message: function(alert_div, alert_message_span) {
        $(alert_div).toggleClass(statuspage.alert_error, false);
        $(alert_message_span).text("");
    }
}

$(document).ready(statuspage.init);