$(document).ready(function() {
    var clipboard = new ClipboardJS(".btn");
    clipboard.on("success", function(e) {
        $("#" + e.trigger.id).text("Copied!");
    });
});