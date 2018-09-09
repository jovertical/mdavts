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

    setTimeout(function() {
        // remove icon.
        if (el.has('i')) {
            el.children('i').remove();
        }
    }, 30000);
});

// Disable children submit button on submission.
$('form[submit-once]').on('submit', function (event) {
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