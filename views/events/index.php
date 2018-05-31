<?php
require_once '../../includes/includes.php';

include_once ROOT_PATH . '/Model/Mapper/EventMapper.php';

$em = new EventMapper($con);

if(isset($_POST['new_event'])){
    $event = new Event($_POST['new_event']);
    $em->insert($event, $event);
}

$events = $em->find('');

require_head('/lib/datetimepicker/css/bootstrap-datetimepicker.min.css');
?>

<main role="main" class="container">

    <?php if(isset($_SESSION['current_user']) && $_SESSION['current_user']->admin):?>
        <h3>Agregar</h3>
        <form action="index.php" method="POST">
            <div class="form-group">
                <label for="new_event[name]">Nombre</label>
                <input type="text" class="form-control" name="new_event[name]" required>
            </div>
            <div class="form-group">
                <label for="new_event[starts_at]">Inicio</label>
                <input type="text" readonly class="form_datetime form-control" name="new_event[starts_at]" value="<?php echo date("Y-m-d h:i");?>" required>
            </div>
            <div class="form-group">
                <label for="new_event[ends_at]">Fin</label>
                <input type="text" readonly class="form_datetime form-control" name="new_event[ends_at]" value="<?php echo date("Y-m-d h:i");?>" required>
            </div>
            <div class="form-group">
                <label for="new_event[location]">Ubicación</label>
                <input type="text" class="form-control" name="new_event[location]" required>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
        <br>
    <?php endif; ?>

    <h3>Eventos</h3>
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Inicio</th>
                    <th scope="col">Fin</th>
                    <th scope="col">Ubicación</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($events as $event): ?>
                    <tr>
                        <th scope="row"><?php echo $event->id; ?></th>
                        <td><?php echo $event->name; ?></td>
                        <td><?php echo $event->starts_at; ?></td>
                        <td><?php echo $event->ends_at; ?></td>
                        <td><?php echo $event->location; ?></td>
                        <?php if(isset($_SESSION['current_user']) && $_SESSION['current_user']->admin):?>
                            <td><a class="nav-link" href="<?php echo (nav_link("/views/events/edit.php")."?id=".$event->id); ?>">Editar</a></td>
                        <?php endif; ?>
                        <?php if(isset($_SESSION['current_user']) && !$_SESSION['current_user']->admin):?>
                            <td><a class="nav-link" href="<?php echo (nav_link("/views/events/subscribe.php")."?id=".$event->id); ?>">Inscribirse</a></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>


</main>

<?php require_foot(
    '/lib/datetimepicker/js/bootstrap-datetimepicker.js',
    '/js/datetime.js'
) ?>
