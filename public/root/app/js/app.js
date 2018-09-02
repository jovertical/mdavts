/* View in fullscreen */
var openFullscreen = function (elem) {
    if (elem.requestFullscreen) {
        elem.requestFullscreen();
    } else if (elem.mozRequestFullScreen) { /* Firefox */
        elem.mozRequestFullScreen();
    } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari and Opera */
        elem.webkitRequestFullscreen();
    } else if (elem.msRequestFullscreen) { /* IE/Edge */
        elem.msRequestFullscreen();
    }
}

/* Close fullscreen */
var closeFullscreen = function () {
    if (document.exitFullscreen) {
        document.exitFullscreen();
    } else if (document.mozCancelFullScreen) { /* Firefox */
        document.mozCancelFullScreen();
    } else if (document.webkitExitFullscreen) { /* Chrome, Safari and Opera */
        document.webkitExitFullscreen();
    } else if (document.msExitFullscreen) { /* IE/Edge */
        document.msExitFullscreen();
    }
}

// Loading animation in buttons.
$('.btn-loading').on('click', function(event) {
    var el = $(this);
    var icon = '<i class="fas fa-spinner fa-spin mr-1"></i>';

    // remove previous icon.
    if (el.has('i')) {
        el.children('i').remove();
    }

    // prepend loading icon.
    $(el).prepend(icon);
});

// Disable children submit button on submission.
$('form').on('submit', function (event) {
    $(this).find('button[type=submit]').attr({disabled: 1});
});

// Put it to apply magnification (what a word!) on images
$('.magnifiable').magnificPopup({
    type: 'image',
    zoom: {
        enabled: true,
        duration: 500,
        easing: 'ease-in-out',
        opener: function(openerElement) {
            return ! openerElement.is('img')
                ? openerElement.find('img')
                : openerElement;
        }
    }
});