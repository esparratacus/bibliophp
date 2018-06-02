<?php
require_once '../../includes/includes.php';

include_once ROOT_PATH . '/Model/Mapper/ReservationMapper.php';
$rm = new ReservationMapper($con);
$reservations = $rm->find("status = '" .$_POST['status'] ."' and is_approved = '". $_POST['is_approved'] ."'");
?>

<?php foreach($reservations as $r):?>
<div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title"><?=$r->user->load()->username?></h5>
    <h6 class="card-subtitle mb-2 text-muted"><?=$r->room->load()->name?></h6>
    <p class="card-text">Reserva de sala</p>
    <p><?=$r->reservation_starts?></p>
    <form class="reservation_request" action="ajax_update_reservation.php" method="post">
            <input type="hidden" name="id" value="<?= $r->id?>">
            <input type="hidden" name="action" value="approve">
            <input type="submit" class="btn btn-primary btn-sm" value="Aprobar">
    </form>
    <form class="reservation_request" action="ajax_update_reservation.php" method="post">
            <input type="hidden" name="id" value="<?= $r->id?>">
            <input type="hidden" name="action" value="reject">
            <input type="submit" class="btn btn-danger btn-sm" value="Rechazar">
    </form>
  </div>
</div>
<?php endforeach;?>