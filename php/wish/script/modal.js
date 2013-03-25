var modal = (function () {
    var $timer,
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
        var nbSec, targetText = "";
        if(settings.timeout && settings.timeout != "") {
            nbSec = settings.timeout;
        }

        if(settings.content && settings.content != "") {
            $overlay.fadeIn(200);
            method.showModal(settings.content, settings.width, settings.height, nbSec);
        }
        else if (settings.url && settings.url != "") {
            $overlay.fadeIn(200);
            var jqxhr = $.get(settings.url, function(result) {
                 method.showModal(result, settings.width, settings.height, nbSec);
            })
            .fail(function() {  method.showModal("Une erreur s'est produite", settings.width, settings.height, 20000); })
        }
        else if (settings.post && settings.post != "" && settings.data) {
            $overlay.fadeIn(200);
            var jqxhr = $.post(settings.post, {data : settings.data});

            /* Put the results in a div */
            jqxhr.done(function(result) {
                 method.showModal(result, settings.width, settings.height, nbSec);
            })
            .fail(function() {  method.showModal("Une erreur s'est produite", settings.width, settings.height, 20000); })
        }
    };

    method.showModal = function (targetText, width, height, timeout) {
        $contenttext.empty().append(targetText);

        $modal.css({
            width: width || 'auto',
            height: height || 'auto'
        });

        method.center();
        $(window).bind('resize.modal', method.center);
        $overlay.fadeIn(200);
        $modal.fadeIn(200);

        if(!isNaN(timeout)) {
            $timer = setTimeout(method.close, parseInt(timeout, 10));
        }
    }

    // Close the modal
    method.close = function () {
        clearTimeout($timer);
        $overlay.fadeOut(200);
        $modal.fadeOut(200, function () {
            $contenttext.empty();
            $(window).unbind('resize.modal');
        });
    };

    // Generate the HTML and add it to the document
    $overlay = $('<div id="popin-overlay" class="popin-close"></div>');
    $modal = $('<div id="popin-modal"></div>');
    $content = $('<div id="popin-content"></div>');
    $contenttext = $('<p id="popin-text"></p>');
    $close = $('<span class="close popin-close"><!-- --></span>');

    $modal.hide();
    $overlay.hide();
    $content.append($contenttext, $close);
    $modal.append($content);

    $(document).ready(function () {
        $('body').append($overlay, $modal);
    });

    $(document).on("click", ".popin-close", function (e) {
        e.preventDefault();
        method.close();
    });

    return method;
}());