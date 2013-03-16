$(window).load(function(){
    $(document).on("click", "input.add", function (e) {
        e.preventDefault();
        modal.open({url:"/?page=add_wish&zajax=modal"});
    });

    $(document).on("click", "input.edit", function (e) {
        e.preventDefault();
        var checkedElement = $('.gift input:radio[name=gift]:checked').val();
        modal.open({post:"/?page=edit_wish&zajax=modal", data : checkedElement});
    });

    $(document).on("click", "input.delete", function (e) {
        e.preventDefault();
        var checkedElement = $('.gift input:radio[name=gift]:checked').val();
        modal.open({post:"/?page=delete_wish&zajax=modal", data : checkedElement});
    });

    $(document).on("click", "input.validate.offer", function (e) {
        e.preventDefault();
        var selectedItems = new Array();
        $('.gift input:checkbox[name=gift]:checked').each(function() {
            selectedItems.push($(this).attr('value'));
        });
        modal.open({post:"/?page=make_gift&zajax=modal", data : selectedItems.join(",")});
    });

    $(document).on("click", "input.offered", function (e) {
        e.preventDefault();
        modal.open({post:"/?page=receive_gift&zajax=modal", data : $(e.currentTarget).siblings('input').val()});
    });
});