$(function () {
    $('#book_form').hide();
    $('#equipment_form').hide();
    $('#kind').on('change', function() {
        if(this.value == '1'){
            $('#book_form').hide();
            $('#equipment_form').show();
        }
        if(this.value == '2') {
            $('#book_form').show();
            $('#equipment_form').hide();
        }
    });
});