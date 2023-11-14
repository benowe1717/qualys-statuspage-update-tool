var incident_post = {
    init: function(settings) {
        incident_post.config = {
            title_button: $("#incident-title-button"),
            message_button: $("#incident-message-button"),
            copy_button: $("#incident-copy-button"),
            form: $("#incident"),
            title_fields: [
                "incident-platform",
                "incident-title"
            ],
            message_fields: [
                "incident-message"
            ],
            alert_div: $("#incident-alert"),
            alert_message_span: $("#incident-alert-text"),
        };

        $.extend(incident_post.config, settings);
        incident_post.statuspage = statuspage;
        incident_post.statuspage.init;
        incident_post.setup();
    },

    setup: function() {
        $(incident_post.config.title_button).on("click", function() {
            incident_post.form_data = $(incident_post.config.form).serializeArray();
            var errors = 0;
            for(const element of incident_post.form_data) {
                if(incident_post.config.title_fields.includes(element.name)) {
                    if(element.value === "") {
                        incident_post.statuspage.highlight_input(element.name, true);
                        errors++;
                    } else {
                        incident_post.statuspage.highlight_input(element.name, false);
                    }
                }
            }
            
            incident_post.errors(errors);
            if(errors === 0) {
                var platform_name = incident_post.get_platform_name(incident_post.form_data[0].value);
                var title = incident_post.form_data[1].value;
                if(platform_name !== -1) {
                    var msg = platform_name + ": " + title;
                    incident_post.statuspage.show_success_message(
                        incident_post.config.alert_div, incident_post.config.alert_message_span,
                        incident_post.config.copy_button, msg
                    );
                } else {
                    var msg = "Error getting platform name!";
                    incident_post.statuspage.show_error_message(
                        incident_post.config.alert_div, incident_post.config.alert_message_span,
                        incident_post.config.copy_button, msg
                    );
                }
            }
        });

        $(incident_post.config.message_button).on("click", function() {
            incident_post.form_data = $(incident_post.config.form).serializeArray();
            var errors = 0;
            for(const element of incident_post.form_data) {
                if(incident_post.config.message_fields.includes(element.name)) {
                    if(element.value === "") {
                        incident_post.statuspage.highlight_input(element.name, true);
                        errors++;
                    } else {
                        incident_post.statuspage.highlight_input(element.name, false);
                    }
                }
            }

            incident_post.errors(errors);
            if(errors === 0) {
                var msg = incident_post.form_data[2].value;
                incident_post.statuspage.show_success_message(
                    incident_post.config.alert_div, incident_post.config.alert_message_span,
                    incident_post.config.copy_button, msg
                );
            }
        });
    },

    errors: function(errors) {
        if(errors > 0) {
            var msg = "Missing form value(s)!";
            incident_post.statuspage.show_error_message(
                incident_post.config.alert_div, incident_post.config.alert_message_span,
                incident_post.config.copy_button, msg
            );
        } else {
            incident_post.statuspage.clear_error_message(
                incident_post.config.alert_div, incident_post.config.alert_message_span
            );
        }
    },

    get_platform_name: function(platform_id) {
        var response = -1;
        response = $.ajax({
            type: "POST",
            url: "/scripts/get_platform_name.php",
            data: {
                platform_id: platform_id
            },
            success: function(data) {
                var arr = JSON.parse(data);
                if(arr.platform_name != "None") {
                    response = arr.platform_name;
                }
            },
            error: function(data) {
                var msg = "ERROR: Unable to generate Title! Check your browser's console for debug logs!";
                incident_post.statuspage.show_error_message(
                    incident_post.config.alert_div, incident_post.config.alert_message_span,
                    incident_post.config.copy_button, msg
                );
                console.log(data);
                response = -1;
            }
        });
        return response;
    }
}

$(document).ready(incident_post.init);