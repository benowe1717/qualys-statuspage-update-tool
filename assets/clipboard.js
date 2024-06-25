$(document).ready(function() {
    var clipboard = new ClipboardJS(".btn");
    clipboard.on("success", function(e) {
        var button_id = $('#' + e.trigger.id);
        var button_name = button_id.attr('id');
        if (button_name == 'title-copy-button') {
            button_id.text('Copied!');
            setTimeout(function() {
                button_id.text('Copy Title to Clipboard');
            }, 5000);
        } else if (button_name == 'message-copy-button') {
            button_id.text('Copied!');
            setTimeout(function() {
                button_id.text('Copy Message to Clipboard');
            }, 5000);
        }
    });
});
