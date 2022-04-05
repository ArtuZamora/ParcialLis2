$(document).ready(function() {
    var video = document.getElementById('video');
    var canvas = document.getElementById('canvas');
    var context = canvas.getContext('2d');
    var strr;

    function streamWebCam(stream) {
        const mediaSource = new MediaSource(stream);
        try {
            video.srcObject = stream;
        } catch (error) {
            video.src = URL.createObjectURL(mediaSource);
        }
        video.play();
        strr = stream;
    }

    function throwError(e) {
        alert(e.name);
    }

    function opencam() {
        navigator.getUserMedia = navigator.getUserMedia ||
            navigator.webkitGetUserMedia ||
            navigator.mozGetUserMedia ||
            navigator.oGetUserMedia ||
            navigator.msGetUserMedia;
        if (navigator.getUserMedia) {
            navigator.getUserMedia({ video: true }, streamWebCam, throwError);
        }
    }
    opencam();
    $("#assistanceFrm").on('submit', function(e) {
        canvas.width = video.clientWidth * 1.60;
        canvas.height = video.clientHeight * 1.60;
        context.drawImage(video, 0, 0);
        var capture = canvas.toDataURL('image/png');
        $("#assistanceFrm input[name=capture]").attr('value', capture);
    })
});