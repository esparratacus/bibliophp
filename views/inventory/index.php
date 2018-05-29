<?php
include_once dirname(__FILE__) . '/../../Database/credentials.php';
include_once dirname(__FILE__) . '/../../Database/MysqlAdapter.php';
include_once dirname(__FILE__) . '/../../Model/Mapper/BookMapper.php';
include_once dirname(__FILE__) . '/../../Model/Mapper/EquipmentMapper.php';

$con = new MysqlAdapter(array(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME));
$bm = new BookMapper($con);
$em = new EquipmentMapper($con);
 
if($_POST['element']!=null){ 
    if ($_POST['element'] == '2') {
        $book = new Book($_POST['new_book']);
        $bm->insert($book,$book); // toca ponerlo 2 veces. Asi funciona y asi se queda 
    }
    if ($_POST['element'] == '1') {
        $equipment = new Equipment($_POST['new_equipment']);
        $em->insert($equipment,$equipment);
    }
}
// performs a SELECT * from books with no condition
$books = $bm->find();
$equipos = $em->find();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Biblioteca | Inventario</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

  <!-- Custom styles for this template -->

  </head>

  <body>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top" >

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item ">
            <a class="nav-link" href="#">Inicio <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
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
          <li class="nav-item active">
            <a class="nav-link" href="#">Inventario</a>
          </li>
        </ul>
      </div>
    </nav>
    
    <main role="main" class="container" style="margin-top: 60px;">

        
            <h3>Agregar</h3>
            <form action="index.php" method="POST">
                <div class="form-group">
                    <label for="element">Elija una opción</label>
                    <select id="kind" class="form-control" name ="element" placeholder="s" required>
                        <option value="1">Equipo</option>
                        <option value="2">Libro</option>
                    </select>
                </div>
                <div id="equipment_form">
                    <div class="form-group">
                        <label for="new_equipment[name]">Nombre</label>
                        <input type="text" class="form-control" name="new_equipment[name]" required>
                    </div>
                    <div class="form-group">
                        <label for="new_equipment[maker]">Fabricante</label>
                        <input type="text" class="form-control" name="new_equipment[maker]" required>
                    </div>
                    <div class="form-group">
                        <label for="new_equipment[serial_number]"># Serial</label>
                        <input type="text" class="form-control" name="new_equipment[serial_number]" required>
                    </div>
                    <div class="form-group">
                        <label for="new_equipment[quantity]">Cantidad</label>
                        <input type="number" class="form-control" name="new_equipment[quantity]" required>
                    </div>
                </div>
                <div id="book_form">
                    <div class="form-group">
                        <label for="new_book[title]">Título</label>
                        <input type="text" class="form-control" name="new_book[title]" required>
                    </div>
                    <div class="form-group">
                        <label for="new_book[author]">Autor</label>
                        <input type="text" class="form-control" name="new_book[author]" required>
                    </div>
                    <div class="form-group">
                        <label for="new_book[edition]">Edición</label>
                        <input type="text" class="form-control" name="new_book[edition]" required>
                    </div>
                    <div class="form-group">
                        <label for="new_book[publisher]">Editorial</label>
                        <input type="text" class="form-control" name="new_book[publisher]" required>
                    </div>
                    <div class="form-group">
                        <label for="new_book[isbn]">ISBN</label>
                        <input type="text" class="form-control" name="new_book[isbn]" required>
                    </div>
                    <div class="form-group">
                        <label for="new_book[copies]"># copias</label>
                        <input type="number" class="form-control" name="new_book[copies]" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        <div class="row">
        <div class="col-md-7">
        <h3>Inventario Libros</h3>
        <table class="table">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Título</th>
            <th scope="col">Autor</th>
            <th scope="col">Edición</th>
            <th scope="col">Editorial</th>
            <th scope="col">ISBN</th>
            <th scope="col">Disponibles</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($books as $b): ?>
            <tr>
            <th scope="row"><?php echo $b->id; ?></th>
            <td><?php echo $b->title; ?></td>
            <td><?php echo $b->author; ?></td>
            <td><?php echo $b->edition; ?></td>
            <td><?php echo $b->publisher; ?></td>
            <td><?php echo $b->isbn; ?></td>
            <td><?php echo $b->copies; ?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
        </div>
        <div class="col-md-5">
        <h3>Inventario Equipos</h3>
        <table class="table">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Fabricante</th>
            <th scope="col">Serial</th>
            <th scope="col">cantidad</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($equipos as $e): ?>
            <tr>
            <th scope="row"><?php echo $e->id; ?></th>
            <td><?php echo $e->name; ?></td>
            <td><?php echo $e->maker; ?></td>
            <td><?php echo $e->serial_number; ?></td>
            <td><?php echo $e->quantity; ?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
        </div>
        </div>
        
    </main>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
<script>
    $('#book_form').hide();
    $('#equipment_form').show();
    $("[name^='new_book']").each(function(){
                $(this).removeAttr('required')
            })
    $('#kind').on('change', function() {
        if(this.value == '1'){
            $('#book_form').hide();
            $('#equipment_form').show();
            $("[name^='new_book']").each(function(){
                $(this).removeAttr('required')
            })
            
            $("[name^='new_equipment']").each(function(){
                $(this).attr("required", "true");
            })
        }
        if(this.value == '2') {
            $('#book_form').show();
            $('#equipment_form').hide();
            $("[name^='new_book']").each(function(){
                
                $(this).attr("required", "true");
                console.log(this);
            })
            $("[name^='new_equipment']").each(function(){
                $(this).removeAttr('required')
                
            })
        }
    });
</script>
  </body>
</html>