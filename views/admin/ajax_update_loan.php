<?php
require_once '../../includes/includes.php';

include_once ROOT_PATH . '/Model/Mapper/LoanMapper.php';
include_once ROOT_PATH . '/Model/Loan.php';
include_once ROOT_PATH . '/Model/Book.php';
$lm = new LoanMapper($con);
$loan = $lm->findById($_POST['id']);

switch($_POST['action']) {
    case 'approve':
        $loan->status ='approved';
        $loan->is_approved = 1;
        $loan->pickup_date = $_POST['pickup_date'];
        $loan->return_date = $_POST['return_date'];
        $lm->update($loan,$loan);
        mail($loan->user->load()->email,'prestamo aprobado','Prestamo aprobado para el libro '. $loan->book->load()->title .'con entrega para '. $loan->return_date);
        break;
    case 'reject':
        $loan->status ='rejected';
        $lm->update($loan,$loan);
        mail($loan->user->load()->email,'prestamo denegado','Prestamo denegado para el libro '. $loan->book->load()->title);
        break;
}
$loans = $lm->find("status = 'pending_for_approval' and status = 0");
?>

<?php foreach($loans as $l):?>
<div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title"><?=$l->user->load()->username?></h5>
    <h6 class="card-subtitle mb-2 text-muted"><?=$l->book->load()->title?></h6>
    <p class="card-text">Solicitud de préstamo</p>
    <form class="loan_request" action="ajax_update_loan.php" method="post">
            <input type="hidden" name="id" value="<?= $l->id?>">
            <input type="hidden" name="action" value="approve">
            <div class="form-group">
                <label for="pickup_date">Inicio de préstamo</label>
                <input type="text" readonly class="form_datetime form-control" name="pickup_Date" value="<?php echo date("Y-m-d h:i");?>" required>
            </div>
            <div class="form-group">
                <label for="return_date">Fin de préstamo</label>
                <input type="text" readonly class="form_datetime form-control" name="return_date" value="<?php echo date("Y-m-d h:i");?>" required>
            </div>
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