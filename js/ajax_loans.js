function setRentalsBehavior(){
    $(".rental_request").each(function(){
        $(this).submit(function(event){
            event.preventDefault();
            console.log('hice click');
            var formData = $(this).serialize();
            console.log(formData);
            $.post($(this).attr('action'),formData,function(data,status){
                getRentals();
            });
        });
    });
    };
function setLoansBehavior(){
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

    function setReservationsBehavior(){
        $(".reservation_request").each(function(){
            $(this).submit(function(event){
                event.preventDefault();
                console.log('hice click');
                var formData = $(this).serialize();
                console.log(formData);
                $.post($(this).attr('action'),formData,function(data,status){
                    getReservations();
                });
            });
        });
};

function getRentals(){
    $.post("../admin/ajax_rentals.php",
    {
        status:'pending_for_approval',
        is_approved: 0
    }, 
    function(data, status){
        $('#rental_list').html(data);
        setRentalsBehavior();
    });
};
function getLoans(){
    $.post("../admin/ajax_loans.php",
    {
        status:'pending_for_approval',
        is_approved: 0
    }, 
    function(data, status){
        $('#loan_list').html(data);
        setLoansBehavior();
    });
};


function getReservations(){
    $.post("../admin/ajax_reservations.php",
    {
        status:'pending_for_approval',
        is_approved: 0
    }, 
    function(data, status){
        $('#reservations_list').html(data);
        setReservationsBehavior();
    });
};

getLoans();
getReservations();
getRentals();