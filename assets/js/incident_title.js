var incident_post = {
    init: function(settings) {
        incident_post.config = {
            button: $("#incident-title-button"),
            copy_button: $("#incident-copy-button"),
            form: $("#incident"),
            fields: [
                "incident-platform",
                "incident-title"
            ],
            alert_div: $("#incident-alert"),
            alert_message_span: $("#incident-alert-text"),
            type: "title"
        };

        $.extend(incident_post.config, settings);
        incident_post.setup();
    },

    setup: function() {
        $(incident_post.config.button).on("click", function() {
            incident_post.form_data = $(incident_post.config.form).serializeArray();
            var errors = 0;
            for(const element of incident_post.form_data) {
                if(incident_post.config.fields.includes(element.name)) {
                    if(element.value === "") {
                        incident_post.highlight_input(element.name, true);
                        errors++;
                    } else {
                        incident_post.highlight_input(element.name, false);
                    }
                }
            }
            
            incident_post.errors(errors);
            if(errors === 0) {
                if(incident_post.config.type === "title") {
                    var platform_name = incident_post.get_platform_name(incident_post.form_data[0].value);
                    if(platform_name !== -1) {
                        incident_post.show_success_message(platform_name + ": " + incident_post.form_data[1].value);
                    } else {
                        incident_post.show_error_message("Error getting platform name!");
                    }
                } else if(incident_post.config.type === "message") {
                    incident_post.show_success_message(incident_post.form_data[2].value);
                }
            }
        });
    },

    highlight_input: function(id, status) {
        $("#" + id).toggleClass("form-error", status);
    },

    show_error_message: function(msg) {
        $(incident_post.config.alert_div).toggleClass("alert-danger", true);
        $(incident_post.config.alert_div).toggleClass("alert-success", false);
        $(incident_post.config.alert_message_span).text(msg);
        $(incident_post.config.copy_button).toggleClass("visually-hidden", true);
    },

    clear_error_message: function() {
        $(incident_post.config.alert_div).toggleClass("alert-danger", false);
        $(incident_post.config.alert_message_span).text("");
    },

    show_success_message: function(msg) {
        $(incident_post.config.alert_div).toggleClass("alert-danger", false);
        $(incident_post.config.alert_div).toggleClass("alert-success", true);
        $(incident_post.config.alert_message_span).text(msg);
        $(incident_post.config.copy_button).toggleClass("visually-hidden", false);
    },

    errors: function(errors) {
        if(errors > 0) {
            incident_post.show_error_message("Missing form value(s)!");
        } else {
            incident_post.clear_error_message();
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
                incident_post.show_error_message("ERROR: Unable to generate Title! Check your browser's console for debug logs!");
                console.log(data);
                return -1;
            }
        })
    }
}

$(document).ready(incident_post.init);