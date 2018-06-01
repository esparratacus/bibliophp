<?php
require_once '../../includes/includes.php';

include_once ROOT_PATH . '/Model/Mapper/BookMapper.php';
include_once ROOT_PATH . '/Model/Mapper/UserMapper.php';
include_once ROOT_PATH . '/Model/Mapper/EquipmentMapper.php';
include_once ROOT_PATH . '/Model/User.php';

$bm = new BookMapper($con);
$em = new EquipmentMapper($con);

if(isset($_POST['element'])){
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
$um = new UserMapper($con);
$usuario = $um->findById(1);

require_head();
?>

<main role="main" class="container">

    <?php if(isset($_SESSION['current_user']) && $_SESSION['current_user']->admin ==1):?>

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
        <?php endif; ?>
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
<?php require_foot('/js/inventory.js'); ?>
