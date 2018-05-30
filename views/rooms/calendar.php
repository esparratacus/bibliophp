<?php
require_once '../../includes/includes.php';

include_once ROOT_PATH . '/Model/Mapper/RoomMapper.php';


  $resMapper = new ReservationMapper($con);
  $rm = new RoomMapper($con,$resMapper);
  $rooms = $rm->find();
  $room = $rm->findById(1);
  $reservations = $resMapper->find();

  $calendarData = array();
  foreach($reservations as $r):
    $u = $r->user->load();
    $s = $r->room->load();
    array_push($calendarData,array('title'=>$s->name .":". $u->FullName,'start'=> $r->reservation_starts,'end'=>$r->reservation_ends,'allDay'=> false));
  endforeach;
   

  require_head('/lib/fullCalendar/fullcalendar.min.css');
?>


<main role="main" class="container" style="margin-top: 60px;">

    <div id="calendar">
    </div>

</main>

<script>
    var calendarData = <?php echo json_encode($calendarData); ?>
</script>

<?php
require_foot(
    '/lib/fullCalendar/lib/moment.min.js',
    '/lib/fullCalendar/fullcalendar.js',
    '/js/calendar.js'
);
?>
