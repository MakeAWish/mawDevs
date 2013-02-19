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
        var targetText = "";
        if(settings.content && settings.content != "") {
             method.showModal(settings.content, settings.width, settings.height);
        }
        else if (settings.url && settings.url != "") {
            var jqxhr = $.get(settings.url, function(result) {
                 method.showModal(result, settings.width, settings.height);
            })
            .fail(function() {  method.showModal("Une erreur s'est produite", settings.width, settings.height); })
        }
        else if (settings.post && settings.post != "" && settings.data) {
            var jqxhr = $.post(settings.post, {gift : settings.data});

            /* Put the results in a div */
            jqxhr.done(function(result) {
                 method.showModal(result, settings.width, settings.height);
            })
            .fail(function() {  method.showModal("Une erreur s'est produite", settings.width, settings.height); })
        }
    };

    method.showModal = function (targetText, width, height) {
        $contenttext.empty().append(targetText);

        $modal.css({
            width: width || 'auto',
            height: height || 'auto'
        });

        method.center();
        $(window).bind('resize.modal', method.center);
        $modal.show();
        $overlay.show();
    }

    // Close the modal
    method.close = function () {
        $modal.hide();
        $overlay.hide();
        $contenttext.empty();
        $(window).unbind('resize.modal');
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