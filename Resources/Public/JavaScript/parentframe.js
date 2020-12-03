window.addEventListener('message', function(e) {
    var iframe = document.getElementById('bw_registration_frame');
    var eventName = e.data[0];
    var height = e.data[1];
    switch(eventName) {
        case 'setIframeHeight':
            iframe.height = height;
            break;
    }
}, false);