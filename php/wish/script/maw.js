$(window).load(function () {

    // Input radio
    $('.gift input:radio').addClass('input_hidden');
    $('.bought input:radio').addClass('input_hidden');

    // Input radio
    $('.gift input:checkbox').addClass('input_hidden');
    $('.bought input:checkbox').addClass('input_hidden');

    $('.gift.exclusive').click(function () {
        $(this).addClass('selected').siblings().removeClass('selected');
        $(this).find('input:radio').attr('checked', true);
    });

    $('.gift.non_exclusive').click(function () {
        $(this).toggleClass('selected');
        var isChecked = $(this).find('input:checkbox').attr('checked');
        $(this).find('input:checkbox').attr('checked', !isChecked);
    });

    var intro = introJs();
    intro.setOptions({ skipLabel: 'Fermer', nextLabel: '&rarr;', prevLabel: '&larr;' });
    $('.helpLink a').click(function(event) {
        event.preventDefault();
        intro.start();
    });
});
