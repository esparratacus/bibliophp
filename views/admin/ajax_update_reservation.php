<?php
require_once '../../includes/includes.php';

include_once ROOT_PATH . '/Model/Mapper/ReservationMapper.php';
$rm = new ReservationMapper($con);
$reservation = $rm->findById($_POST['id']);

switch($_POST['action']) {
    case 'approve':
        $reservation->status ='approved';
        $reservation->is_approved = 1;
        
        $rm->update($reservation,$reservation);
        //mail($reservation->user->load()->email,'prestamo aprobado','Prestamo aprobado para el libro '. $reservation->book->load()->title .'con entrega para '. $reservation->return_date);
        break;
    case 'reject':
        $reservation->status ='rejected';
        $rm->update($reservation,$reservation);
        //mail($reservation->user->load()->email,'prestamo denegado','Prestamo denegado para el libro '. $reservation->book->load()->title);
        break;
}
$reservations = $rm->find("status = 'pending_for_approval' and status = 0");
?>

<?php foreach($reservations as $r):?>
<div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title"><?=$r->user->load()->username?></h5>
    <h6 class="card-subtitle mb-2 text-muted"><?=$r->room->load()->name?></h6>
    <p class="card-text">reserva de sala.</p>
    <form class="loan_request" action="ajax_update_reservation.php" method="post">
            <input type="hidden" name="id" value="<?= $r->id?>">
            <input type="hidden" name="action" value="approve">
            <input type="submit" class="btn btn-primary btn-sm" value="Aprobar">
    </form>
    <form class="loan_request" action="ajax_update_reservation.php" method="post">
            <input type="hidden" name="id" value="<?= $r->id?>">
            <input type="hidden" name="action" value="reject">
            <input type="submit" class="btn btn-danger btn-sm" value="Rechazar">
    </form>
  </div>
</div>
<?php endforeach;?>