// scripts.js
document.addEventListener("DOMContentLoaded", function() {
    var ctalpenStatusElement = document.getElementById("ctalpenStatus");
    var ctsktStatusElement = document.getElementById("ctsktStatus");
    var ctthnStatusElement = document.getElementById("ctthnStatus");

    var ctalpenStatus = ctalpenStatusElement.getAttribute("data-status");
    var ctsktStatus = ctsktStatusElement.getAttribute("data-status");
    var ctthnStatus = ctthnStatusElement.getAttribute("data-status");

    var authenticatedUserId = parseInt(ctalpenStatusElement.getAttribute("data-user-id"));

    if (
        ctalpenStatus === "disetujui" &&
        ctsktStatus === "disetujui" &&
        ctthnStatus === "disetujui" &&
        authenticatedUserId === authUserId
    ) {
        var button = document.getElementById("myButton");
        if (button) {
            button.click();
        }
    }
});
