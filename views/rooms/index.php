<?php
require_once '../../includes/includes.php';

include_once ROOT_PATH . '/Model/Mapper/RoomMapper.php';

$rm = new RoomMapper($con);

if(isset($_POST['new_room'])){
    $room = new Room($_POST['new_room']);
    $rm->insert($room, $room);
}

$rooms = $rm->find('');

require_head();
?>

<main role="main" class="container">

    <?php if(isset($_SESSION['current_user']) && $_SESSION['current_user']->admin):?>
        <h3>Agregar</h3>
        <form action="index.php" method="POST">
            <div class="form-group">
                <label for="new_room[name]">Nombre</label>
                <input type="text" class="form-control" name="new_room[name]" required>
            </div>
            <div class="form-group">
                <label for="new_room[capacity]">Capacidad</label>
                <input type="number" class="form-control" name="new_room[capacity]" required>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
        <br>
    <?php endif; ?>

    <h3>Salas</h3>
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Capacidad</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($rooms as $room): ?>
                    <tr>
                        <th scope="row"><?php echo $room->id; ?></th>
                        <td><?php echo $room->name; ?></td>
												<td><?php echo $room->capacity; ?></td>
                        <?php if(isset($_SESSION['current_user']) && $_SESSION['current_user']->admin):?>
                            <td><a class="nav-link" href="<?php echo (nav_link("/views/rooms/edit.php")."?id=".$room->id); ?>">Editar</a></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>


</main>

<?php require_foot() ?>
