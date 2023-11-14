var maintenance_post = {
    init: function(settings) {
        maintenance_post.config = {
            title_button: $("#maintenance-title-button"),
            message_button: $("#maintenance-message-button"),
            copy_button: $("#maintenance-copy-button"),
            form: $("#maintenance"),
            title_fields: [
                "maintenance-platform",
                "maintenance-title"
            ],
            message_fields: [
                "maintenance-message",
                "maintenance-ticket",
                "maintenance-ref-link"
            ],
            alert_div: $("#maintenance-alert"),
            alert_message_span: $("#maintenance-alert-text"),
        };

        $.extend(maintenance_post.config, settings);
        maintenance_post.statuspage = statuspage;
        maintenance_post.statuspage.init;
        maintenance_post.setup();
    },

    setup: function() {
        $(maintenance_post.config.title_button).on("click", function() {
            maintenance_post.form_data = $(maintenance_post.config.form).serializeArray();
            var errors = 0;
            for(const element of maintenance_post.form_data) {
                if(maintenance_post.config.title_fields.includes(element.name)) {
                    if(element.value === "") {
                        maintenance_post.statuspage.highlight_input(element.name, true);
                        errors++;
                    } else {
                        maintenance_post.statuspage.highlight_input(element.name, false);
                    }
                }
            }
            
            maintenance_post.errors(errors);
            if(errors === 0) {
                var platform_name = maintenance_post.get_platform_name(maintenance_post.form_data[0].value);
                var title = maintenance_post.form_data[1].value;
                if(platform_name !== -1) {
                    var msg = platform_name + ": " + title;
                    maintenance_post.statuspage.show_success_message(
                        maintenance_post.config.alert_div, maintenance_post.config.alert_message_span,
                        maintenance_post.config.copy_button, msg
                    );
                } else {
                    var msg = "Error getting platform name!";
                    maintenance_post.statuspage.show_error_message(
                        maintenance_post.config.alert_div, maintenance_post.config.alert_message_span,
                        maintenance_post.config.copy_button, msg
                    );
                }
            }
        });

        $(maintenance_post.config.message_button).on("click", function() {
            maintenance_post.form_data = $(maintenance_post.config.form).serializeArray();
            var errors = 0;
            for(const element of maintenance_post.form_data) {
                if(maintenance_post.config.message_fields.includes(element.name)) {
                    if(element.value === "") {
                        maintenance_post.statuspage.highlight_input(element.name, true);
                        errors++;
                    } else {
                        maintenance_post.statuspage.highlight_input(element.name, false);
                    }
                }
            }

            maintenance_post.errors(errors);
            if(errors === 0) {
                var ticket = maintenance_post.form_data[2].value;
                var message = maintenance_post.form_data[3].value;
                var ref = maintenance_post.form_data[4].value;

                var msg = maintenance_post.get_maintenance_details(ticket, message, ref);
                if(msg !== -1) {
                    maintenance_post.statuspage.show_success_message(
                        maintenance_post.config.alert_div, maintenance_post.config.alert_message_span,
                        maintenance_post.config.copy_button, msg
                    );
                } else {
                    var msg = "Ticket Number or Reference Link are invalid!";
                    maintenance_post.statuspage.show_error_message(
                        maintenance_post.config.alert_div, maintenance_post.config.alert_message_span,
                        maintenance_post.config.copy_button, msg
                    );
                }
            }
        });
    },

    errors: function(errors) {
        if(errors > 0) {
            var msg = "Missing form value(s)!";
            maintenance_post.statuspage.show_error_message(
                maintenance_post.config.alert_div, maintenance_post.config.alert_message_span,
                maintenance_post.config.copy_button, msg
            );
        } else {
            maintenance_post.statuspage.clear_error_message(
                maintenance_post.config.alert_div, maintenance_post.config.alert_message_span
            );
        }
    },

    get_platform_name: function(platform_id) {
        $.ajax({
            type: "POST",
            url: "/scripts/get_platform_name.php",
            data: {
                platform_id: platform_id
            },
            success: function(data) {
                var arr = JSON.parse(data);
                if(arr.platform_name != "None") {
                    return arr.platform_name;
                } else {
                    return -1;
                }
            },
            error: function(data) {
                var msg = "ERROR: Unable to generate Title! Check your browser's console for debug logs!";
                maintenance_post.statuspage.show_error_message(
                    maintenance_post.config.alert_div, maintenance_post.config.alert_message_span,
                    maintenance_post.config.copy_button, msg
                );
                console.log(data);
                return -1;
            }
        })
    },

    get_maintenance_details: function(ticket, ref, message) {
        $.ajax({
            type: "POST",
            url: "/scripts/validate_maintenance_details.php",
            data: {
                ticket: ticket,
                ref: ref,
                message: message
            },
            success: function(data) {
                var arr = JSON.parse(data);
                if(arr.ticket_status === 1 && arr.ref_status === 1) {
                    return arr.message;
                } else {
                    return -1;
                }
            },
            error: function(data) {
                var arr = JSON.parse(data);
                maintenance_post.statuspage.show_error_message(
                    maintenance_post.config.alert_div, maintenance_post.config.alert_message_span,
                    maintenance_post.config.copy_button, arr.message
                );
                console.log(data);
                return -1;
            }
        })
    }
}

$(document).ready(maintenance_post.init);