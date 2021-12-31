function bwregistration_resizeParent() {
    var plugin = $('.tx-bw-leibniz-registration');
    var container = plugin.closest('.container-fluid');
    var height = container.outerHeight();

    window.parent.postMessage(["setIframeHeight", height], "*");
}

function bwregistration_loop() {
    bwregistration_resizeParent();
    setTimeout(bwregistration_loop, 2000);
}

$(document).ready(function() {
    bwregistration_loop();
});
$(window).resize(function() {
    bwregistration_resizeParent();
});