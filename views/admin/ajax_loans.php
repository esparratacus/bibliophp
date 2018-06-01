<?php
require_once '../../includes/includes.php';

include_once ROOT_PATH . '/Model/Mapper/LoanMapper.php';
include_once ROOT_PATH . '/Model/Loan.php';
include_once ROOT_PATH . '/Model/Book.php';
$lm = new LoanMapper($con);
$loans = $lm->find("status = '" .$_POST['status'] ."' and is_approved = '". $_POST['is_approved'] ."'");
?>

<?php foreach($loans as $l):?>
<div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title"><?=$l->user->load()->username?></h5>
    <h6 class="card-subtitle mb-2 text-muted"><?=$l->book->load()->title?></h6>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <form class="loan_request" action="ajax_update_loan.php" method="post">
            <input type="hidden" name="id" value="<?= $l->id?>">
            <input type="hidden" name="action" value="approve">
            <input type="submit" class="btn btn-primary btn-sm" value="Aprobar">
    </form>
    <form class="loan_request" action="ajax_update_loan.php" method="post">
            <input type="hidden" name="id" value="<?= $l->id?>">
            <input type="hidden" name="action" value="reject">
            <input type="submit" class="btn btn-danger btn-sm" value="Rechazar">
    </form>
  </div>
</div>
<?php endforeach;?>