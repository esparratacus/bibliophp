<?php
require_once '../../includes/includes.php';
include_once ROOT_PATH . '/Model/Mapper/LoanMapper.php';

$lm = new LoanMapper($con);
$loans = $lm->find("'status' = 'pending_aproval' and 'is_approved' = 0");


require_head('/lib/fullCalendar/fullcalendar.min.css','/lib/datetimepicker/css/bootstrap-datetimepicker.min.css');

?>
<main role="main" class="container">
    <h3>Solicitudes pendientes</h3>
    <div class="row">
        <div id="loan_list" class="col-md-4">
        </div>
        <div id="rental_list" class="col-md-4">
        </div>
        <div id="reservations_list" class="col-md-4">
        </div>
    </div>
</main>

<?php require_foot('/js/ajax_loans.js','/js/ajax_rentals.js','/lib/datetimepicker/js/bootstrap-datetimepicker.js',
    '/js/datetime.js') ?>

