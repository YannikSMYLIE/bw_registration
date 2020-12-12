function bwregistration_resizeParent() {
    const plugin = $('.tx-bw-leibniz-registration');
    const container = plugin.closest('.container-fluid');
    const height = container.outerHeight();

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