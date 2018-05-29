<?php
  include_once dirname(__FILE__) . '/../../Database/credentials.php';
  include_once dirname(__FILE__) . '/../../Database/MysqlAdapter.php';
  include_once dirname(__FILE__) . '/../../Model/Mapper/RoomMapper.php';

  $con = new MysqlAdapter(array(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME));
  $resMapper = new ReservationMapper($con);
  $rm = new RoomMapper($con,$resMapper);
  $rooms = $rm->find();
  $room = $rm->findById(1);
  $reservations = $resMapper->find();

  
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Biblioteca | Salas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

 <!-- Custom styles for this template
Esta pagina usa un calendario de bootstrap. La documentación se puede encontrar en https://fullcalendar.io
-->
  <!-- Custom styles for this template -->
    <link href="https://v4-alpha.getbootstrap.com/examples/starter-template/starter-template.css" rel="stylesheet">
    <link rel="stylesheet" href="../../lib/fullCalendar/fullcalendar.min.css"> 
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="../../lib/fullCalendar/lib/moment.min.js"></script>
    <script src="../../lib/fullCalendar/fullcalendar.js"></script>
  </head>

  <body>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      
      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="#">Inicio <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="#">Eventos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Salas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Equipos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Libros</a>
          </li> 
        </ul>
      </div>
    </nav>

    <main role="main" class="container" style="margin-top: 60px;">
      <div>
      <?php foreach($reservations as $r): ?>
      <p><?php echo $r->reservation_starts; ?></p>
      <p><?php echo $r->reservation_ends; ?></p>
      <?php $user = $r->user; ?>
      <p><?php echo $user->load()->Email; ?></p>
      <?php endforeach;?>
      </div>

      <div id="calendar">

      </div>

    </main>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
   
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
<script>
    $(function() {
        $('#calendar').fullCalendar({weekends: false});
    });
</script>

  </body>
</html>
