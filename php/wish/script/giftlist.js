$(window).load(function(){
    $(document).on("click", "input.delete.gifts", function (e) {
        e.preventDefault();
        var selectedItems = new Array();
        $('.gift input:checkbox[name=gift]:checked').each(function() {
            selectedItems.push($(this).attr('value'));
        });
        modal.open({post:"?page=delete_gift&zajax=modal", data : selectedItems.join(",")});
    });
});