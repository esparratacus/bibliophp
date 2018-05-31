function setBehavior(){
    $(".loan_request").each(function(){
        $(this).submit(function(event){
            event.preventDefault();
            console.log('hice click');
            var formData = $(this).serialize();
            console.log(formData);
            $.post($(this).attr('action'),formData,function(data,status){
                getLoans();
            });
        });
    });
    };
function getLoans(){
    $.post("/biblioteca/views/admin/ajax_loans.php",
    {
        status:'pending_for_approval',
        is_approved: 0
    }, 
    function(data, status){
        $('#loan_list').html(data);
        setBehavior();
    });
};

getLoans();