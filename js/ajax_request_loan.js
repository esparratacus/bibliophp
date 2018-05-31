$(".loan_request").each(function(){
    $(this).submit(function(event){
        event.preventDefault();
        console.log('hice click');
        var formData = $(this).serialize();
        console.log(formData);
        $.post($(this).attr('action'),formData,function(data,status){
            $('#messages').html(data);
        });
    });
});