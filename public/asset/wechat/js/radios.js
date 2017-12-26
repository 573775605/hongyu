function select_radio(element) {
    $(element).on("click", function() {
        
        var input = $(this).find("input[type=checkbox]");
        if(input.length > 0){
            if(input.attr("checked") == 'checked') {
                input.attr('checked', false);
                $(this).find('.check_box').removeClass('checked');
            } else {
                input.attr('checked', true);
                $(this).find('.check_box').addClass('checked');

            }
        }
        




        var radio = $(this).find("input[type=radio]");
        if(radio.length > 0){
            $(element).find('input').attr('checked', false);
            $(element).find('.check_box').removeClass('checked');

            radio.attr('checked', true);
            $(this).find('.check_box').addClass('checked');
        }
    });
}

