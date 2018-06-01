$.post("../admin/rental_loans.php",
    {
        status: 'pending_aproval',
        is_approved: 0
    },
    function (data, status) {
        $('#loan_list').html(data);
    });
$('.approve,.deny').click(function () {
    $.post("../admin/rental_loans.php",
        {
            status: 'pending_aproval',
            is_approved: 0
        },
        function (data, status) {
            $('#loan_list').html(data);
        });
});