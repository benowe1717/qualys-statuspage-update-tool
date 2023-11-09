$(document).ready(function() {
    var clipboard = new ClipboardJS(".btn");
    clipboard.on("success", function(e) {
        console.log("Action: ", e.action);
        console.log("Text: ", e.text);
        console.log("Trigger: ", e.trigger);
    });
});