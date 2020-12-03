function bwregistration_resizeParent() {
    console.log("resize");
    const plugin = $('.tx-bw-leibniz-registration');
    const container = plugin.closest('.container-fluid');
    const height = container.outerHeight();

    window.parent.postMessage(["setIframeHeight", height], "*");
}

$(document).ready(function() {
    bwregistration_resizeParent();
});
$(window).resize(function() {
    bwregistration_resizeParent();
});