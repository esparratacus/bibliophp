<?php
require_once '../../includes/includes.php';
include_once ROOT_PATH . '/Model/Mapper/LoanMapper.php';

$lm = new LoanMapper($con);
$loans = $lm->find("'status' = 'pending_aproval' and 'is_approved' = 0");


require_head();
?>
<main role="main" class="container">
    <div class="row">
        <div id="loan_list" class="col-md-6">
        </div>
        <div id="rental_list" class="col-md-6"></div>
    </div>
</main>

<?php require_foot('/js/ajax_loans.js','/js/ajax_rentals.js') ?>

