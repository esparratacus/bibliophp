<?php
require_once '../../includes/includes.php';

include_once ROOT_PATH . '/Model/Mapper/EquipmentMapper.php';

$em = new EquipmentMapper($con);

$cols_to_search = ['name', 'maker', 'quantity'];
if(isset($_REQUEST['search']) && !empty($_REQUEST['search']))
    foreach($cols_to_search as $col)
        $_REQUEST[$col] = $_REQUEST['search'];

$search = request_vars_to_search($cols_to_search, isset($_REQUEST['search']) ? "OR" : "AND");

$equipments = $em->find($search);

require_head();
?>

<main role="main" class="container">

    <div class="row">
        <?php include_once ROOT_PATH .'/views/layout/search_basic.php' ?>

        <div class="col-md-12">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Fabricante</th>
                    <th scope="col">Número serial</th>
                    <th scope="col">Unidades disponibles</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($equipments as $equipment): ?>
                    <tr>
                        <th scope="row"><?php echo $equipment->id; ?></th>
                        <td><?php echo $equipment->name; ?></td>
                        <td><?php echo $equipment->maker; ?></td>
                        <td><?php echo $equipment->serial_number; ?></td>
                        <td><?php echo $equipment->quantity; ?></td>
                    </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php require_foot() ?>
