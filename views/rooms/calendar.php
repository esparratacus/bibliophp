<?php
require_once '../../includes/includes.php';

include_once ROOT_PATH . '/Model/Mapper/RoomMapper.php';


if(isset($_SESSION['success'])){
    unset($_SESSION['success']);
}
if(isset($_SESSION['error'])){
    unset($_SESSION['error']);
}

  $resMapper = new ReservationMapper($con);
  $rm = new RoomMapper($con,$resMapper);
  $rooms = $rm->find();
  $reservations = $resMapper->find();

  $calendarData = array();
  foreach($reservations as $r){
    $u = $r->user->load();
    $s = $r->room->load();
    array_push($calendarData,array('title'=>$s->name .":". $u->username,'start'=> $r->reservation_starts,'end'=>$r->reservation_ends,'allDay'=> false));
  }

  if(isset($_POST['new_reservation'])){
    $reservation = new Reservation($_POST['new_reservation']);
    $reservation->setIsApproved(0);
    $reservation->setStatus('pending_for_approval');
    $result = $resMapper->insert($reservation,$reservation);
    if($result !==null){
        $_SESSION['success']='Reservación de sala solicitada exitosamente';
    }
    else{
    $_SESSION['error']='Reservación fallida. Contacte a un administrador';
    }
  }

  if(isset($_POST['new_room'])){
    $room = new Room($_POST['new_room']);
  }
   

  require_head('/lib/fullCalendar/fullcalendar.min.css','/lib/datetimepicker/css/bootstrap-datetimepicker.min.css');
?>


<main role="main" class="container" style="margin-top: 60px;">
    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error'];?>
        </div>
    <?php endif;?>
    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success'];?>
        </div>
    <?php endif;?>

    <div class="row">
    <a class="nav-link" href="<?php echo nav_link("/views/rooms/index.php") ?>">Lista de salas</a>
    </div>

    <div class="row">
        <h3>Asignación de salas</h3>
        <div  id="calendar">
        </div>
    </div>
    
    <div class="row">
        <h3>Solicitud de reserva</h3>
    </div>
    <div class="row">
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <div class="form-group">
                <input type="hidden" name="new_reservation[user_id]" value="<?=$_SESSION['current_user']->id?>">
                <label for="new_reservation[room_id]">sala</label>
                <select  class="custom-select" name="new_reservation[room_id]"  required>
                    <?php foreach($rooms as $r): ?>
                        <option value="<?= $r->id ?>"><?= $r->name?></option>
                    <?php endforeach?> 
                </select>
            </div>
            <div class="form-group">
                <label for="new_reservation[reservation_starts]">Inicio de reserva</label>
                <input type="text" readonly class="form_datetime form-control" name="new_reservation[reservation_starts]" value="<?php echo date("Y-m-d h:i");?>" required>
            </div>
            <div class="form-group">
                <label for="new_reservation[reservation_ends]">Fin de reserva</label>
                <input type="text" readonly class="form_datetime form-control" name="new_reservation[reservation_ends]" value="<?php echo date("Y-m-d h:i");?>" required>
            </div>
            <input type="submit" class="btn btn-primary" value="Solicitar reserva">
        </form>
    </div>
</main>

<script>
    var calendarData = <?php echo json_encode($calendarData); ?>
</script>

<?php
require_foot(
    '/lib/fullCalendar/lib/moment.min.js',
    '/lib/fullCalendar/fullcalendar.js',
    '/js/calendar.js',
    '/lib/datetimepicker/js/bootstrap-datetimepicker.js',
    '/js/datetime.js'
);
?>
