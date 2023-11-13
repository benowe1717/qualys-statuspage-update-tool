$(document).ready(function() {
    $("#incident-title-button").on("click", function() {
        var form = $(this).parents("form");
        var form_data = $(form).serializeArray();
        console.log(form_data);
    });
});