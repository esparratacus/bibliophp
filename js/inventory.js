$(function () {
    $('#book_form').hide();
    $('#equipment_form').show();
    $("[name^='new_book']").each(function(){
        $(this).removeAttr('required')
    })
    $('#kind').on('change', function() {
        if(this.value == '1'){
            $('#book_form').hide();
            $('#equipment_form').show();
            $("[name^='new_book']").each(function(){
                $(this).removeAttr('required')
            })

            $("[name^='new_equipment']").each(function(){
                $(this).attr("required", "true");
            })
        }
        if(this.value == '2') {
            $('#book_form').show();
            $('#equipment_form').hide();
            $("[name^='new_book']").each(function(){

                $(this).attr("required", "true");
                console.log(this);
            })
            $("[name^='new_equipment']").each(function(){
                $(this).removeAttr('required')

            })
        }
    });
});