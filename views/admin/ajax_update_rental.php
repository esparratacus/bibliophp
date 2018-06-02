<?php
require_once '../../includes/includes.php';

include_once ROOT_PATH . '/Model/Mapper/RentalMapper.php';
include_once ROOT_PATH . '/Model/Rental.php';
include_once ROOT_PATH . '/Model/Equipment.php';
$rm = new RentalMapper($con);
$rental =$rm->findById($_POST['id']);
switch($_POST['action']) {
    case 'approve':
       $rental->status ='approved';
       $rental->is_approved = 1;
       $rental->creation_date = $_POST['creation_date'];
       $rental->return_date = $_POST['return_date'];
       $rental->report_interval = $_POST['report_every'] ." ". $_POST['time_unit'];
        $rm->update($rental,$rental);
        mail($rental->user->load()->email,'prestamo aprobado','Prestamo aprobado para el equipo '.$rental->equipment->load()->name .'con entrega para '.$rental->return_date);
        break;
    case 'reject':
       $rental->status ='rejected';
        $rm->update($rental,$rental);
        mail($rental->user->load()->email,'Préstamo denegado','Préstamo denegado para el libro '.$rental->equipment->load()->name );
        break;
}
$rentals = $rm->find("status = 'pending_for_approval' and status = 0");
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
                <input type="text" readonly class="form_datetime form-control" name="creation_date" value="<?php echo date("Y-m-d h:i");?>" required>
            </div>
            <div class="form-group">
                <label for="return_date">Fin de préstamo</label>
                <input type="text" readonly class="form_datetime form-control" name="return_date" value="<?php echo date("Y-m-d h:i");?>" required>
            </div>
            <div class="form-group">
                <label for="report_every">reportar cada</label>
                <input type="text" readonly class="form-control" name="report_every" required>
            </div>
            <div class="form-group">
                <select name="time_unit">
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