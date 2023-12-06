var maintenance_post = {
    init: function(settings) {
        maintenance_post.config = {
            title_button: $("#maintenance-title-button"),
            message_button: $("#maintenance-message-button"),
            copy_button: $("#maintenance-copy-button"),
            copy_from: $("#maintenance-copy"),
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
            maintenance_post.config.copy_button.text("Copy to Clipboard");
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
                var platform_id = maintenance_post.form_data[0].value;
                var title = maintenance_post.form_data[1].value;
                maintenance_post.get_platform_name(platform_id, function(output) {
                    var arr = JSON.parse(output);
                    var msg = maintenance_post.format_title(arr.platform_name, title);
                    maintenance_post.statuspage.show_success_message(
                        maintenance_post.config.alert_div, maintenance_post.config.alert_message_span,
                        maintenance_post.config.copy_button, msg
                    );
                    maintenance_post.config.copy_from.val(msg);
                });
            }
        });

        $(maintenance_post.config.message_button).on("click", function() {
            maintenance_post.config.copy_button.text("Copy to Clipboard");
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

                maintenance_post.get_maintenance_details(ticket, ref, message, function(output) {
                    var arr = JSON.parse(output);
                    if(typeof arr["error"] === 'undefined') {
                        if(arr.ticket_status === 1 && arr.ref_status === 1) {
                            maintenance_post.statuspage.show_success_message(
                                maintenance_post.config.alert_div, maintenance_post.config.alert_message_span,
                                maintenance_post.config.copy_button, arr.message
                            );
                            maintenance_post.config.copy_from.val(msg);
                        } else {
                            var msg = "Ticket Number or Reference Link are invalid!";
                            maintenance_post.statuspage.show_error_message(
                                maintenance_post.config.alert_div, maintenance_post.config.alert_message_span,
                                maintenance_post.config.copy_button, msg
                            );
                        }
                    } else {
                        maintenance_post.statuspage.show_error_message(
                            maintenance_post.config.alert_div, maintenance_post.config.alert_message_span,
                            maintenance_post.config.copy_button, arr.message
                        );
                    }
                });
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

    format_title: function(platform_name, title) {
        var message = platform_name + ": " + title;
        return message;
    },

    get_platform_name: function(platform_id, handle_data) {
        $.ajax({
            type: "POST",
            url: "/scripts/get_platform_name.php",
            data: {
                platform_id: platform_id
            },
            success: function(data) {
                handle_data(data);
            },
            error: function(data) {
                var msg = "ERROR: Unable to generate Title! Check your browser's console for debug logs!";
                maintenance_post.statuspage.show_error_message(
                    maintenance_post.config.alert_div, maintenance_post.config.alert_message_span,
                    maintenance_post.config.copy_button, msg
                );
                console.log(data);
            }
        });
    },

    get_maintenance_details: function(ticket, ref, message, handle_data) {
        $.ajax({
            type: "POST",
            url: "/scripts/validate_maintenance_details.php",
            data: {
                ticket: ticket,
                ref: ref,
                message: message
            },
            success: function(data) {
                handle_data(data);
            },
            error: function(data) {
                var msg = "ERROR: Unable to validate Ticket Number or Reference Link! Check your browser's console for debug logs!";
                maintenance_post.statuspage.show_error_message(
                    maintenance_post.config.alert_div, maintenance_post.config.alert_message_span,
                    maintenance_post.config.copy_button, msg
                );
                console.log(data);
            }
        });
    }
}

$(document).ready(maintenance_post.init);