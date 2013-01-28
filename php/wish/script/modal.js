var modal = (function () {
    var
    method = {},
    $overlay,
    $modal,
    $content,
    $contenttext,
    $basket,
    $close;

    // Center the modal in the viewport
    method.center = function () {
        var top, left;

        top = Math.max($(window).height() - $modal.outerHeight(), 0) / 2;
        left = Math.max($(window).width() - $modal.outerWidth(), 0) / 2;

        $modal.css({
            top: top + $(window).scrollTop(),
            left: left + $(window).scrollLeft()
        });
    };

    // Open the modal
    method.open = function (settings) {
        $contenttext.empty().append(settings.content);

        $modal.css({
            width: settings.width || 'auto',
            height: settings.height || 'auto'
        });

        method.center();
        $(window).bind('resize.modal', method.center);
        $modal.show();
        $overlay.show();
    };

    // Close the modal
    method.close = function () {
        $modal.hide();
        $overlay.hide();
        $contenttext.empty();
        $(window).unbind('resize.modal');
    };

    // Generate the HTML and add it to the document
    $overlay = $('<div id="popin-overlay"></div>');
    $modal = $('<div id="popin-modal"></div>');
    $content = $('<div id="popin-content"></div>');
    $contenttext = $('<p id="popin-text"></p>');
    $validate = $('<a id="popin-validate" href="#">Valider</a>');
    $close = $('<a id="popin-close" href="#">Annuler</a>');

    $modal.hide();
    $overlay.hide();
    $content.append($contenttext, $validate, $close);
    $modal.append($content);

    $(document).ready(function () {
        $('body').append($overlay, $modal);
    });

    $close.click(function (e) {
        e.preventDefault();
        method.close();
    });

    return method;
}());