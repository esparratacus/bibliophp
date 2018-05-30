<?php
require_once '../../includes/includes.php';

include_once ROOT_PATH . '/Model/Mapper/LoanMapper.php';
include_once ROOT_PATH . '/Model/Loan.php';
include_once ROOT_PATH . '/Model/Book.php';
$lm = new LoanMapper($con);
$loans = $lm->find("status = " .$_POST['status'] ." and is_approved = ". $_POST['is_approved']);
?>

<?php foreach($loans as $l):?>
<div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title"><?=$l->user->load()->username?></h5>
    <h6 class="card-subtitle mb-2 text-muted"><?=$l->book->load()->title?></h6>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <a href="#" class="card-link">Aprobar</a>
    <a href="#" class="card-link">rechazar</a>
  </div>
</div>
<?php endforeach;?>