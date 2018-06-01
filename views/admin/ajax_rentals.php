<?php
require_once '../../includes/includes.php';

include_once ROOT_PATH . '/Model/Mapper/RentalMapper.php';
include_once ROOT_PATH . '/Model/Rental.php';
include_once ROOT_PATH . '/Model/Equipment.php';
$rm = new RentalMapper($con);
$rentals = $rm->find("status = '" .$_POST['status'] ."' and is_approved = '". $_POST['is_approved'] ."'");
?>

<?php foreach($rentals as $r):?>
<div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title"><?=$r->user->load()->username?></h5>
    <h6 class="card-subtitle mb-2 text-muted"><?=$r->equipment->load()->name?></h6>
    <p class="card-text">Solicitud de préstamo</p>
    <form class="rental_request" action="ajax_update_rental.php" method="post">
            <input type="hidden" name="id" value="<?= $r->id?>">
            <input type="hidden" name="action" value="approve">
            <div class="form-group">
                <label for="pickup_date">Inicio de préstamo</label>
                <input type="text" class="form_datetime form-control" name="creation_date" value="<?php echo date("Y-m-d h:i");?>" required>
            </div>
            <div class="form-group">
                <label for="return_date">Fin de préstamo</label>
                <input type="text" class="form_datetime form-control" name="return_date" value="<?php echo date("Y-m-d h:i");?>" required>
            </div>
            <div class="form-group">
                <label for="report_every">Reportar cada</label>
                <input type="text" class="form-control" name="report_every" required>
            </div>
            <div class="form-group">
                
                <select name="time_unit" id="">
                <option value="DAY">Dias</option>
                <option value="HOUR">horas</option>
                <option value="MINUTES">minutos</option>
                </select>
            </div>
            <input type="submit" class="btn btn-primary btn-sm" value="Aprobar">
    </form>
    <form class="rental_request" action="ajax_update_rental.php" method="post">
            <input type="hidden" name="id" value="<?= $r->id?>">
            <input type="hidden" name="action" value="reject">
            <input type="submit" class="btn btn-danger btn-sm" value="Rechazar">
    </form>
  </div>
</div>
<?php endforeach;?>